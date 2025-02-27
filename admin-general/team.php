<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "football_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = "";
$errorMessage = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_team'])) {
    // Team Info
    $team_name = $_POST['team_name'];
    $founded_year = $_POST['founded_year'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $primary_color = $_POST['primary_color'];
    $secondary_color = $_POST['secondary_color'];
    
    // Stadium Info
    $home_stadium = $_POST['home_stadium'];
    $stadium_capacity = $_POST['stadium_capacity'];
    
    // Contact Info
    $website = $_POST['website'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    // Staff Info
    $head_coach = $_POST['head_coach'];
    $assistant_coach = $_POST['assistant_coach'];
    $team_manager = $_POST['team_manager'];
    $physiotherapist = $_POST['physiotherapist'];
    
    // Additional Info
    $history = $_POST['history'];
    
    // Handle logo upload
    $logo_path = "";
    if(isset($_FILES['team_logo']) && $_FILES['team_logo']['error'] == 0) {
        $target_dir = "uploads/teams/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["team_logo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check if image file is a actual image
        $check = getimagesize($_FILES["team_logo"]["tmp_name"]);
        if($check !== false) {
            // Generate unique filename
            $logo_path = $target_dir . uniqid() . "." . $imageFileType;
            if (move_uploaded_file($_FILES["team_logo"]["tmp_name"], $logo_path)) {
                // File uploaded successfully
            } else {
                $errorMessage = "Sorry, there was an error uploading your file.";
            }
        } else {
            $errorMessage = "File is not an image.";
        }
    }
    
    // Insert data into database
    $sql = "INSERT INTO teams (team_name, founded_year, country, city, logo_path, primary_color, 
            secondary_color, home_stadium, stadium_capacity, website, email, phone, address, 
            head_coach, assistant_coach, team_manager, physiotherapist, history) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssssiissssssss", 
        $team_name, $founded_year, $country, $city, $logo_path, $primary_color, 
        $secondary_color, $home_stadium, $stadium_capacity, $website, $email, $phone, $address, 
        $head_coach, $assistant_coach, $team_manager, $physiotherapist, $history);
    
    if ($stmt->execute()) {
        $successMessage = "New team added successfully";
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }
    
    $stmt->close();
    
    // Process team players if any
    if (isset($_POST['player_name']) && is_array($_POST['player_name'])) {
        $team_id = $conn->insert_id;
        $player_names = $_POST['player_name'];
        $player_positions = $_POST['player_position'];
        $player_numbers = $_POST['player_number'];
        $player_nationalities = $_POST['player_nationality'];
        
        $player_sql = "INSERT INTO team_players (team_id, player_name, position, jersey_number, nationality) 
                      VALUES (?, ?, ?, ?, ?)";
        
        $player_stmt = $conn->prepare($player_sql);
        
        for ($i = 0; $i < count($player_names); $i++) {
            if (!empty($player_names[$i])) {
                $player_stmt->bind_param("issis", 
                    $team_id, 
                    $player_names[$i], 
                    $player_positions[$i], 
                    $player_numbers[$i], 
                    $player_nationalities[$i]
                );
                $player_stmt->execute();
            }
        }
        
        $player_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Team</title>
    <style>
        :root {
            --primary-color: #f0b941;
            --primary-hover: #d9a73a;
            --bg-dark: #1a1a1a;
            --bg-darker: #121212;
            --text-light: #f5f5f5;
            --text-muted: #a0a0a0;
            --border-color: #333;
            --input-bg: #2a2a2a;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .header .icon {
            width: 40px;
            height: 40px;
            background-color: #2563eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        
        .header h1 {
            color: var(--primary-color);
            font-size: 24px;
            font-weight: 600;
        }
        
        .tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 30px;
        }
        
        .tab {
            padding: 12px 20px;
            cursor: pointer;
            color: var(--text-muted);
            position: relative;
            transition: color 0.3s;
        }
        
        .tab.active {
            color: var(--primary-color);
        }
        
        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary-color);
        }
        
        .tab-content {
            display: none;
        }
        
        .tab-content.active {
            display: block;
        }
        
        .form-section {
            margin-bottom: 30px;
        }
        
        .form-section h2 {
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--primary-color);
        }
        
        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px 20px;
        }
        
        .form-group {
            flex: 1 0 calc(50% - 20px);
            margin: 0 10px 20px;
            min-width: 250px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: var(--text-light);
        }
        
        label.required::after {
            content: '*';
            color: #e11d48;
            margin-left: 4px;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        input[type="tel"],
        input[type="url"],
        input[type="color"],
        select,
        textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background-color: var(--input-bg);
            color: var(--text-light);
            font-size: 14px;
        }
        
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
        }
        
        textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        .logo-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .logo-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: var(--input-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            overflow: hidden;
            border: 2px dashed var(--border-color);
        }
        
        .logo-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .logo-preview .icon {
            color: var(--primary-color);
            font-size: 40px;
        }
        
        .upload-btn {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .upload-btn:hover {
            background-color: var(--primary-color);
            color: var(--bg-darker);
        }
        
        .actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: var(--bg-darker);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-hover);
        }
        
        .btn-secondary {
            background-color: transparent;
            border: 1px solid var(--border-color);
            color: var(--text-light);
            margin-right: 10px;
        }
        
        .btn-secondary:hover {
            background-color: var(--border-color);
        }
        
        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background-color: rgba(16, 185, 129, 0.2);
            border: 1px solid #10b981;
            color: #10b981;
        }
        
        .alert-error {
            background-color: rgba(239, 68, 68, 0.2);
            border: 1px solid #ef4444;
            color: #ef4444;
        }
        
        .color-preview {
            display: inline-block;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-left: 10px;
            border: 1px solid var(--border-color);
            vertical-align: middle;
        }
        
        .player-list {
            margin-top: 20px;
        }
        
        .player-item {
            background-color: var(--input-bg);
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 15px;
            position: relative;
        }
        
        .remove-player {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #ef4444;
            cursor: pointer;
            font-size: 18px;
        }
        
        .add-player-btn {
            display: flex;
            align-items: center;
            background-color: transparent;
            border: 1px dashed var(--border-color);
            color: var(--primary-color);
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            width: 100%;
            justify-content: center;
            margin-top: 15px;
            transition: all 0.3s;
        }
        
        .add-player-btn:hover {
            background-color: rgba(240, 185, 65, 0.1);
        }
        
        .add-player-btn svg {
            margin-right: 8px;
        }
        
        @media (max-width: 768px) {
            .tabs {
                flex-wrap: wrap;
            }
            
            .tab {
                flex: 1 0 auto;
                text-align: center;
                padding: 10px;
                font-size: 14px;
            }
            
            .form-group {
                flex: 1 0 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if($successMessage): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        
        <?php if($errorMessage): ?>
            <div class="alert alert-error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
        
        <div class="header">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
            </div>
            <h1>Add New Team</h1>
        </div>
        
        <form action="add_team.php" method="POST" enctype="multipart/form-data">
            <div class="tabs">
                <div class="tab active" data-tab="team-info">Team Info</div>
                <div class="tab" data-tab="stadium">Stadium</div>
                <div class="tab" data-tab="contact">Contact</div>
                <div class="tab" data-tab="staff">Staff</div>
                <div class="tab" data-tab="players">Players</div>
                <div class="tab" data-tab="review">Review</div>
            </div>
            
            <!-- Team Info Tab -->
            <div class="tab-content active" id="team-info">
                <div class="form-section">
                    <h2>Team Information</h2>
                    
                    <div class="logo-upload">
                        <div class="logo-preview">
                            <img id="preview-img" src="/placeholder.svg" style="display: none;">
                            <div class="icon" id="icon-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </div>
                        </div>
                        <label for="team_logo" class="upload-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px; vertical-align: middle;">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            Upload Logo
                        </label>
                        <input type="file" id="team_logo" name="team_logo" accept="image/*" style="display: none;">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="team_name" class="required">Team Name</label>
                            <input type="text" id="team_name" name="team_name" placeholder="Enter team name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="founded_year">Founded Year</label>
                            <input type="number" id="founded_year" name="founded_year" min="1800" max="<?php echo date('Y'); ?>" placeholder="Enter founded year">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" id="country" name="country" placeholder="Enter country">
                        </div>
                        
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" id="city" name="city" placeholder="Enter city">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="primary_color">Primary Color</label>
                            <div style="display: flex; align-items: center;">
                                <input type="color" id="primary_color" name="primary_color" value="#f0b941" style="width: 50px; height: 40px; padding: 0;">
                                <div id="primary-color-preview" class="color-preview" style="background-color: #f0b941;"></div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="secondary_color">Secondary Color</label>
                            <div style="display: flex; align-items: center;">
                                <input type="color" id="secondary_color" name="secondary_color" value="#2563eb" style="width: 50px; height: 40px; padding: 0;">
                                <div id="secondary-color-preview" class="color-preview" style="background-color: #2563eb;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="actions">
                    <button type="button" class="btn btn-primary" id="team-info-next">Next</button>
                </div>
            </div>
            
            <!-- Stadium Tab -->
            <div class="tab-content" id="stadium">
                <div class="form-section">
                    <h2>Stadium Information</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="home_stadium">Home Stadium</label>
                            <input type="text" id="home_stadium" name="home_stadium" placeholder="Enter home stadium name">
                        </div>
                        
                        <div class="form-group">
                            <label for="stadium_capacity">Stadium Capacity</label>
                            <input type="number" id="stadium_capacity" name="stadium_capacity" min="0" placeholder="Enter stadium capacity">
                        </div>
                    </div>
                </div>
                
                <div class="actions">
                    <button type="button" class="btn btn-secondary" id="stadium-prev">Previous</button>
                    <button type="button" class="btn btn-primary" id="stadium-next">Next</button>
                </div>
            </div>
            
            <!-- Contact Tab -->
            <div class="tab-content" id="contact">
                <div class="form-section">
                    <h2>Contact Information</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="website">Website</label>
                            <input type="url" id="website" name="website" placeholder="Enter website URL">
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter email address">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="Enter phone number">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group" style="flex: 1 0 100%;">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" placeholder="Enter full address"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="actions">
                    <button type="button" class="btn btn-secondary" id="contact-prev">Previous</button>
                    <button type="button" class="btn btn-primary" id="contact-next">Next</button>
                </div>
            </div>
            
            <!-- Staff Tab -->
            <div class="tab-content" id="staff">
                <div class="form-section">
                    <h2>Staff Information</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="head_coach">Head Coach</label>
                            <input type="text" id="head_coach" name="head_coach" placeholder="Enter head coach name">
                        </div>
                        
                        <div class="form-group">
                            <label for="assistant_coach">Assistant Coach</label>
                            <input type="text" id="assistant_coach" name="assistant_coach" placeholder="Enter assistant coach name">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="team_manager">Team Manager</label>
                            <input type="text" id="team_manager" name="team_manager" placeholder="Enter team manager name">
                        </div>
                        
                        <div class="form-group">
                            <label for="physiotherapist">Physiotherapist</label>
                            <input type="text" id="physiotherapist" name="physiotherapist" placeholder="Enter physiotherapist name">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group" style="flex: 1 0 100%;">
                            <label for="history">Team History</label>
                            <textarea id="history" name="history" placeholder="Enter team history and achievements"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="actions">
                    <button type="button" class="btn btn-secondary" id="staff-prev">Previous</button>
                    <button type="button" class="btn btn-primary" id="staff-next">Next</button>
                </div>
            </div>
            
            <!-- Players Tab -->
            <div class="tab-content" id="players">
                <div class="form-section">
                    <h2>Team Players</h2>
                    
                    <div id="player-list" class="player-list">
                        <!-- Player items will be added here -->
                    </div>
                    
                    <button type="button" id="add-player" class="add-player-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        Add Player
                    </button>
                </div>
                
                <div class="actions">
                    <button type="button" class="btn btn-secondary" id="players-prev">Previous</button>
                    <button type="button" class="btn btn-primary" id="players-next">Next</button>
                </div>
            </div>
            
            <!-- Review Tab -->
            <div class="tab-content" id="review">
                <div class="form-section">
                    <h2>Review Team Information</h2>
                    
                    <div id="review-content" style="margin-bottom: 30px;">
                        <!-- This will be filled by JavaScript -->
                    </div>
                </div>
                
                <div class="actions">
                    <button type="button" class="btn btn-secondary" id="review-prev">Previous</button>
                    <button type="submit" name="submit_team" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tab Navigation
            const tabs = document.querySelectorAll('.tab');
            const tabContents = document.querySelectorAll('.tab-content');
            
            function setActiveTab(tabId) {
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.remove('active');
                });
                
                // Remove active class from all tabs
                tabs.forEach(tab => {
                    tab.classList.remove('active');
                });
                
                // Set active tab and content
                document.getElementById(tabId).classList.add('active');
                document.querySelector(`.tab[data-tab="${tabId}"]`).classList.add('active');
            }
            
            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const tabId = this.getAttribute('data-tab');
                    setActiveTab(tabId);
                });
            });
            
            // Next and Previous buttons
            document.getElementById('team-info-next').addEventListener('click', () => setActiveTab('stadium'));
            document.getElementById('stadium-prev').addEventListener('click', () => setActiveTab('team-info'));
            document.getElementById('stadium-next').addEventListener('click', () => setActiveTab('contact'));
            document.getElementById('contact-prev').addEventListener('click', () => setActiveTab('stadium'));
            document.getElementById('contact-next').addEventListener('click', () => setActiveTab('staff'));
            document.getElementById('staff-prev').addEventListener('click', () => setActiveTab('contact'));
            document.getElementById('staff-next').addEventListener('click', () => setActiveTab('players'));
            document.getElementById('players-prev').addEventListener('click', () => setActiveTab('staff'));
            document.getElementById('players-next').addEventListener('click', () => {
                // Generate review content
                generateReview();
                setActiveTab('review');
            });
            document.getElementById('review-prev').addEventListener('click', () => setActiveTab('players'));
            
            // Logo upload preview
            const logoInput = document.getElementById('team_logo');
            const previewImg = document.getElementById('preview-img');
            const iconPlaceholder = document.getElementById('icon-placeholder');
            
            logoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        previewImg.style.display = 'block';
                        iconPlaceholder.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                }
            });
            
            // Color preview
            const primaryColorInput = document.getElementById('primary_color');
            const secondaryColorInput = document.getElementById('secondary_color');
            const primaryColorPreview = document.getElementById('primary-color-preview');
            const secondaryColorPreview = document.getElementById('secondary-color-preview');
            
            primaryColorInput.addEventListener('input', function() {
                primaryColorPreview.style.backgroundColor = this.value;
            });
            
            secondaryColorInput.addEventListener('input', function() {
                secondaryColorPreview.style.backgroundColor = this.value;
            });
            
            // Player management
            let playerCount = 0;
            const playerList = document.getElementById('player-list');
            const addPlayerBtn = document.getElementById('add-player');
            
            function addPlayer() {
                const playerItem = document.createElement('div');
                playerItem.className = 'player-item';
                playerItem.dataset.id = playerCount;
                
                playerItem.innerHTML = `
                    <button type="button" class="remove-player" data-id="${playerCount}">×</button>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="player_name_${playerCount}">Player Name</label>
                            <input type="text" id="player_name_${playerCount}" name="player_name[]" placeholder="Enter player name">
                        </div>
                        
                        <div class="form-group">
                            <label for="player_position_${playerCount}">Position</label>
                            <select id="player_position_${playerCount}" name="player_position[]">
                                <option value="">Select position</option>
                                <option value="Goalkeeper">Goalkeeper</option>
                                <option value="Defender">Defender</option>
                                <option value="Midfielder">Midfielder</option>
                                <option value="Forward">Forward</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="player_number_${playerCount}">Jersey Number</label>
                            <input type="number" id="player_number_${playerCount}" name="player_number[]" min="1" max="99" placeholder="Enter jersey number">
                        </div>
                        
                        <div class="form-group">
                            <label for="player_nationality_${playerCount}">Nationality</label>
                            <input type="text" id="player_nationality_${playerCount}" name="player_nationality[]" placeholder="Enter nationality">
                        </div>
                    </div>
                `;
                
                playerList.appendChild(playerItem);
                
                // Add event listener to remove button
                const removeBtn = playerItem.querySelector('.remove-player');
                removeBtn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const playerToRemove = document.querySelector(`.player-item[data-id="${id}"]`);
                    playerList.removeChild(playerToRemove);
                });
                
                playerCount++;
            }
            
            addPlayerBtn.addEventListener('click', addPlayer);
            
            // Add initial player
            addPlayer();
            
            // Generate Review Content
            function generateReview() {
                const reviewContent = document.getElementById('review-content');
                
                // Get all form values
                const teamName = document.getElementById('team_name').value || 'Not provided';
                const foundedYear = document.getElementById('founded_year').value || 'Not provided';
                const country = document.getElementById('country').value || 'Not provided';
                const city = document.getElementById('city').value || 'Not provided';
                const homeStadium = document.getElementById('home_stadium').value || 'Not provided';
                const headCoach = document.getElementById('head_coach').value || 'Not provided';
                
                // Get players
                const playerNames = document.querySelectorAll('input[name="player_name[]"]');
                const playerPositions = document.querySelectorAll('select[name="player_position[]"]');
                let playersHTML = '';
                
                for (let i = 0; i < playerNames.length; i++) {
                    if (playerNames[i].value) {
                        const position = playerPositions[i].value || 'Not specified';
                        playersHTML += `<li>${playerNames[i].value} - ${position}</li>`;
                    }
                }
                
                if (!playersHTML) {
                    playersHTML = '<li>No players added</li>';
                }
                
                // Create review HTML
                let reviewHTML = `
                    <div style="background-color: var(--input-bg); padding: 20px; border-radius: 8px;">
                        <h3 style="margin-bottom: 15px; color: var(--primary-color);">${teamName}</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                            <div>
                                <p><strong>Founded:</strong> ${foundedYear}</p>
                                <p><strong>Location:</strong> ${city}, ${country}</p>
                                <p><strong>Home Stadium:</strong> ${homeStadium}</p>
                                <p><strong>Head Coach:</strong> ${headCoach}</p>
                            </div>
                            <div>
                                <p><strong>Team Players:</strong></p>
                                <ul style="list-style-type: disc; padding-left: 20px;">
                                    ${playersHTML}
                                </ul>
                            </div>
                        </div>
                        <p style="margin-top: 20px; color: var(--text-muted);">Please review all information before submitting. Once submitted, you can still edit the team information later.</p>
                    </div>
                `;
                
                reviewContent.innerHTML = reviewHTML;
            }
        });
    </script>
</body>
</html>