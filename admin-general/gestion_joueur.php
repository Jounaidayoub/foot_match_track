

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Player</title>
    <link rel="stylesheet" href="../css/adminplayer.css">
    <style>
        
/* Menu horizontal */
.main-menu {
    display: flex;
    justify-content: space-between; /* Distribution des éléments à gauche et à droite */
    align-items: center;
    background-color: var(--bg-darker);
    padding: 15px 20px;  /* Ajoute du padding autour du menu */
    position: fixed;  /* Fixe le menu en haut de la page */
    top: 0;  /* Colle le menu au haut de la page */
    left: 0; /* Colle le menu au bord gauche */
    right: 0; /* Colle le menu au bord droit */
    z-index: 1000;  /* Place le menu au-dessus de tout autre contenu */
    margin: 0;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);  /* Ombre pour un effet de profondeur */
}

/* Conteneur pour l'icône du menu (à gauche) */
.main-menu .logo {
    display: flex;
    align-items: center;
    color: var(--text-light);
    font-size: 18px;
    font-weight: 600;
    text-transform: uppercase;
    text-decoration: none; /* Supprime le soulignement */
    color: inherit; /* Conserve la couleur du texte */
}

/* Menu principal (horizontal) */
.main-menu ul {
    display: flex;
    list-style-type: none;
    padding: 0;
    margin: 0;
    width: 100%;
    justify-content: center;  /* Centrer les éléments du menu */
}

.main-menu ul li {
    position: relative;
    padding: 12px 20px;
    margin: 0 15px;
    cursor: pointer;
    color: var(--text-light);
    font-weight: 500;
    text-transform: capitalize;
    transition: color 0.3s, background-color 0.3s;
}

/* Survol du menu */
.main-menu ul li:hover {
    color: var(--primary-color);
}

/* Menu "Player" avec sous-menu */
#player-menu {
    color: var(--text-muted);
}

#player-menu:hover {
    color: var(--primary-color);
}

/* Sous-menu pour "Player" */
#player-menu > ul {
    display: block;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: var(--bg-darker);
    border-radius: 4px;
    min-width: 200px;
    margin-top: 5px;
    z-index: 10;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    visibility: hidden;
    opacity: 0;
    transition: visibility 0s 0.3s, opacity 0.3s ease;
}

#player-menu:hover > ul {
    visibility: visible;
    opacity: 1;
    transition-delay: 0s;
}

/* Menu "Management" avec sous-menu */
#management-menu {
    color: var(--text-muted);
}

#management-menu:hover {
    color: var(--primary-color);
}

/* Sous-menu pour "Management" */
#management-menu > ul {
    display: block;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: var(--bg-darker);
    border-radius: 4px;
    min-width: 200px;
    margin-top: 5px;
    z-index: 10;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    visibility: hidden;
    opacity: 0;
    transition: visibility 0s 0.3s, opacity 0.3s ease;
}

#management-menu:hover > ul {
    visibility: visible;
    opacity: 1;
    transition-delay: 0s;
}

/* Menu "Tournament Admin" */
#tournament-admin-menu {
    color: var(--text-muted);
}

#tournament-admin-menu:hover {
    color: var(--text-muted); /* Pas de changement de couleur au survol */
    background-color: transparent; /* Pas de fond au survol */
}

#tournament-admin-menu.active {
    color: var(--text-muted); /* Pas de changement de couleur même lorsqu'il est actif */
}

/* Style pour le bouton de déconnexion */
#logout-btn {
    padding: 10px 20px;
    background-color: var(--primary-color);
    color: var(--bg-darker);
    border-radius: 5px;
    cursor: pointer;
    font-weight: 500;
    text-transform: capitalize;
    transition: background-color 0.3s;
}

#logout-btn:hover {
    background-color: var(--primary-hover);
}

#logout-btn a {
    text-decoration: none; /* Supprime le soulignement */
    color: inherit; /* Conserve la couleur du texte */
    display: inline-block; /* Assure un bon alignement */
}

/* Styles pour le lien de sous-menu */
.main-menu li a {
    color: var(--text-muted);
    text-decoration: none;
}

.main-menu li a:hover {
    color: var(--primary-color);
}

/* Responsivité pour petit écran */
@media (max-width: 768px) {
    .main-menu ul {
        flex-direction: column;
        align-items: center;
    }

    .main-menu ul li {
        margin-bottom: 10px;
        padding: 10px;
    }

    #player-menu ul,
    #management-menu ul {
        position: static;
        display: block;
        box-shadow: none;
    }

    #player-menu > ul,
    #management-menu > ul {
        margin-top: 0;
    }
}

    </style>
</head>
<body>
<div class="main-menu">
    <a href="index.php" class="logo"> <!-- Ajout de la balise <a> -->
        <img src="../includes/icon.png" alt="logo">
        <span>OneFootball</span>
    </a>

    <ul>
        <li id="player-menu">
            Player
            <ul>
                <li><a href="gestion_joueur.php">Add Player</a></li>
                <li><a href="gestion_supp_player.php">Delete Player</a></li>
                <li><a href="gestion_modification_joueur.php">Edit Player</a></li>
            </ul>
        </li>
        <li id="management-menu">
            Management
            <ul>
                <li><a href="gestion_stade.php">Stadium</a></li>
                <li><a href="gestion_arbitre.php">Referee</a></li>
                <li><a href="gestion_teams.php">Teams</a></li>
                <li><a href="gestion_staff.php">Staffs</a></li>
            </ul>
        </li>
        <li id="tournament-admin-menu">
            <a href="gestion_admin_tournoi.php">  Tournament Admin </a>
        </li>
    </ul>

    <!-- Bouton de déconnexion -->
    <button id="logout-btn"> <a href="deconnexion.php">Logout</a></button>
</div>

    <div class="container">
        <!--  -->
        <br>
        <br>
        <br>
        <br>
        <div class="header">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <h1>Add New Player</h1>
        </div>
        
        <form action="add_player.php" method="POST" enctype="multipart/form-data" id="playerForm">
            <div class="tabs">
                <div class="tab active" data-tab="personal">Personal Info</div>
                <div class="tab" data-tab="football">Football Info</div>
                <div class="tab" data-tab="physical">Physical Stats</div>
                <div class="tab" data-tab="contract">Contract</div>
                <div class="tab" data-tab="review">Review</div>
            </div>
            
            <!-- Personal Info Tab -->
            <div class="tab-content active" id="personal">
                <div class="form-section">
                    <h2>Personal Information</h2>
                    
                    <div class="photo-upload">
                        <div class="photo-preview">
                            <img id="preview-img" src="/placeholder.svg" style="display: none;">
                            <div class="icon" id="icon-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                        </div>
                        <label for="player_photo" class="upload-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 5px; vertical-align: middle;">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                            Upload Photo
                        </label>
                        <input type="file" id="player_photo" name="player_photo" accept="image/*" style="display: none;">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first_name" class="required">First Name</label>
                            <input type="text" id="first_name" name="first_name" placeholder="Enter first name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="last_name" class="required">Last Name</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Enter last name" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="birth_date" class="required">Date of Birth</label>
                            <input type="date" id="birth_date" name="birth_date" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="nationality" class="required">Nationality</label>
                            <input type="text" id="nationality" name="nationality" placeholder="Enter nationality" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="birth_place">Place of Birth</label>
                            <input type="text" id="birth_place" name="birth_place" placeholder="Enter place of birth">
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
                        
                        <div class="form-group">
                            <label for="social_media">Social Media Handle</label>
                            <input type="text" id="social_media" name="social_media" placeholder="e.g. @playername">
                        </div>
                    </div>
                </div>
                
                <div class="actions">
                    <button type="button" class="btn btn-primary" id="personal-next">Next</button>
                </div>
            </div>
            
            <!-- Football Info Tab -->
            <div class="tab-content" id="football">
                <div class="form-section">
                    <h2>Football Information</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="position" class="required">Position</label>
                            <select id="position" name="position" required>
                                <option value="">Select position</option>
                                <option value="Goalkeeper">Goalkeeper</option>
                                <option value="Defender">Defender</option>
                                <option value="Midfielder">Midfielder</option>
                                <option value="Forward">Forward</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="secondary_position">Secondary Position</label>
                            <select id="secondary_position" name="secondary_position">
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
                            <label for="jersey_number">Jersey Number</label>
                            <input type="number" id="jersey_number" name="jersey_number" min="1" max="99" placeholder="Enter jersey number">
                        </div>
                        
                        <div class="form-group">
                            <label for="preferred_foot">Preferred Foot</label>
                            <select id="preferred_foot" name="preferred_foot">
                                <option value="">Select foot</option>
                                <option value="Right">Right</option>
                                <option value="Left">Left</option>
                                <option value="Both">Both</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="team">Current Team</label>
                            <input type="text" id="team" name="team" placeholder="Enter current team">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="goals">Goals</label>
                            <input type="number" id="goals" name="goals" min="0" value="0">
                        </div>
                        
                        <div class="form-group">
                            <label for="assists">Assists</label>
                            <input type="number" id="assists" name="assists" min="0" value="0">
                        </div>
                        
                        <div class="form-group">
                            <label for="appearances">Appearances</label>
                            <input type="number" id="appearances" name="appearances" min="0" value="0">
                        </div>
                    </div>
                </div>
                
                <div class="actions">
                    <button type="button" class="btn btn-secondary" id="football-prev">Previous</button>
                    <button type="button" class="btn btn-primary" id="football-next">Next</button>
                </div>
            </div>
            
            <!-- Physical Stats Tab -->
            <div class="tab-content" id="physical">
                <div class="form-section">
                    <h2>Physical Statistics</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="height">Height (cm)</label>
                            <input type="number" id="height" name="height" min="0" step="0.01" placeholder="Enter height in cm">
                        </div>
                        
                        <div class="form-group">
                            <label for="weight">Weight (kg)</label>
                            <input type="number" id="weight" name="weight" min="0" step="0.01" placeholder="Enter weight in kg">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="bmi">BMI</label>
                            <input type="number" id="bmi" name="bmi" min="0" step="0.01" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label for="fitness_level">Fitness Level (1-10)</label>
                            <input type="number" id="fitness_level" name="fitness_level" min="1" max="10" placeholder="Enter fitness level">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group" style="flex: 1 0 100%;">
                            <label for="medical_conditions">Medical Conditions</label>
                            <textarea id="medical_conditions" name="medical_conditions" placeholder="Enter any medical conditions or injuries"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="actions">
                    <button type="button" class="btn btn-secondary" id="physical-prev">Previous</button>
                    <button type="button" class="btn btn-primary" id="physical-next">Next</button>
                </div>
            </div>
            
            <!-- Contract Tab -->
            <div class="tab-content" id="contract">
                <div class="form-section">
                    <h2>Contract Details</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contract_start">Contract Start Date</label>
                            <input type="date" id="contract_start" name="contract_start">
                        </div>
                        
                        <div class="form-group">
                            <label for="contract_end">Contract End Date</label>
                            <input type="date" id="contract_end" name="contract_end">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="agent_name">Agent Name</label>
                            <input type="text" id="agent_name" name="agent_name" placeholder="Enter agent name">
                        </div>
                        
                        <div class="form-group">
                            <label for="agent_contact">Agent Contact</label>
                            <input type="text" id="agent_contact" name="agent_contact" placeholder="Enter agent contact">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="release_clause">Release Clause (€)</label>
                            <input type="number" id="release_clause" name="release_clause" min="0" step="0.01" placeholder="Enter release clause amount">
                        </div>
                        
                        <div class="form-group">
                            <label for="market_value">Market Value (€)</label>
                            <input type="number" id="market_value" name="market_value" min="0" step="0.01" placeholder="Enter market value">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group" style="flex: 1 0 100%;">
                            <label for="contract_notes">Contract Notes</label>
                            <textarea id="contract_notes" name="contract_notes" placeholder="Enter any additional contract details"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="actions">
                    <button type="button" class="btn btn-secondary" id="contract-prev">Previous</button>
                    <button type="button" class="btn btn-primary" id="contract-next">Next</button>
                </div>
            </div>
            
            <!-- Review Tab -->
            <div class="tab-content" id="review">
                <div class="form-section">
                    <h2>Review Player Information</h2>
                    
                    <div id="review-content" style="margin-bottom: 30px;">
                        <!-- This will be filled by JavaScript -->
                    </div>
                </div>
                
                <div class="actions">
                    <button type="button" class="btn btn-secondary" id="review-prev">Previous</button>
                    <button type="submit" name="submit_player" class="btn btn-primary" id="submit-btn">Submit</button>
                </div>
            </div>
        </form>
        
        <?php if(!empty($debug) && isset($_GET['debug'])): ?>
        <div class="debug-panel">
            <h3>Debug Information</h3>
            <pre><?php print_r($debug); ?></pre>
        </div>
        <?php endif; ?>
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
            document.getElementById('personal-next').addEventListener('click', () => setActiveTab('football'));
            document.getElementById('football-prev').addEventListener('click', () => setActiveTab('personal'));
            document.getElementById('football-next').addEventListener('click', () => setActiveTab('physical'));
            document.getElementById('physical-prev').addEventListener('click', () => setActiveTab('football'));
            document.getElementById('physical-next').addEventListener('click', () => setActiveTab('contract'));
            document.getElementById('contract-prev').addEventListener('click', () => setActiveTab('physical'));
            document.getElementById('contract-next').addEventListener('click', () => {
                // Generate review content
                generateReview();
                setActiveTab('review');
            });
            document.getElementById('review-prev').addEventListener('click', () => setActiveTab('contract'));
            
            // Fix for form submission
            document.getElementById('submit-btn').addEventListener('click', function(e) {
                // Remove any event handlers that might prevent submission
                e.stopPropagation();
                
                // Ensure all required fields are filled
                const requiredFields = document.querySelectorAll('input[required], select[required]');
                let formValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value) {
                        formValid = false;
                        field.style.borderColor = 'red';
                    } else {
                        field.style.borderColor = '';
                    }
                });
                
                if (!formValid) {
                    e.preventDefault();
                    alert('Please fill all required fields');
                    setActiveTab('personal');
                    return;
                }
                
                // Submit the form
                document.getElementById('playerForm').submit();
            });

            // Photo upload preview
            const photoInput = document.getElementById('player_photo');
            const previewImg = document.getElementById('preview-img');
            const iconPlaceholder = document.getElementById('icon-placeholder');
            
            photoInput.addEventListener('change', function() {
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
            
            // BMI Calculation
            const heightInput = document.getElementById('height');
            const weightInput = document.getElementById('weight');
            const bmiInput = document.getElementById('bmi');
            
            function calculateBMI() {
                const height = parseFloat(heightInput.value) / 100; // convert cm to m
                const weight = parseFloat(weightInput.value);
                
                if (height > 0 && weight > 0) {
                    const bmi = weight / (height * height);
                    bmiInput.value = bmi.toFixed(2);
                } else {
                    bmiInput.value = '';
                }
            }
            
            heightInput.addEventListener('input', calculateBMI);
            weightInput.addEventListener('input', calculateBMI);
            
            // Generate Review Content
            function generateReview() {
                const reviewContent = document.getElementById('review-content');
                
                // Get all form values
                const firstName = document.getElementById('first_name').value || 'Not provided';
                const lastName = document.getElementById('last_name').value || 'Not provided';
                const birthDate = document.getElementById('birth_date').value || 'Not provided';
                const nationality = document.getElementById('nationality').value || 'Not provided';
                const position = document.getElementById('position').value || 'Not provided';
                const team = document.getElementById('team').value || 'Not provided';
                
                // Create review HTML
                let reviewHTML = `
                    <div style="background-color: var(--input-bg); padding: 20px; border-radius: 8px;">
                        <h3 style="margin-bottom: 15px; color: var(--primary-color);">${firstName} ${lastName}</h3>
                        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                            <div>
                                <p><strong>Date of Birth:</strong> ${birthDate}</p>
                                <p><strong>Nationality:</strong> ${nationality}</p>
                                <p><strong>Position:</strong> ${position}</p>
                                <p><strong>Team:</strong> ${team}</p>
                            </div>
                            <div>
                                <p><strong>Height:</strong> ${document.getElementById('height').value || 'Not provided'} cm</p>
                                <p><strong>Weight:</strong> ${document.getElementById('weight').value || 'Not provided'} kg</p>
                                <p><strong>Contract Period:</strong> ${document.getElementById('contract_start').value || 'Not provided'} to ${document.getElementById('contract_end').value || 'Not provided'}</p>
                            </div>
                        </div>
                        <p style="margin-top: 20px; color: var(--text-muted);">Please review all information before submitting. Once submitted, you can still edit the player information later.</p>
                    </div>
                `;
                
                reviewContent.innerHTML = reviewHTML;
            }
            
            // Success Popup Handler
            const successPopup = document.getElementById('successPopup');
            const closePopup = document.getElementById('closePopup');
            const closeSuccessBtn = document.getElementById('closeSuccessBtn');
            
            if (closePopup) {
                closePopup.addEventListener('click', function() {
                    successPopup.classList.remove('active');
                });
            }
            
            if (closeSuccessBtn) {
                closeSuccessBtn.addEventListener('click', function() {
                    successPopup.classList.remove('active');
                });
            }
            
            // Fix for form submission
            document.getElementById('submit-btn').addEventListener('click', function(e) {
                // Remove any event handlers that might prevent submission
                e.stopPropagation();
                
                // Show a loading indicator
                this.innerHTML = 'Submitting...';
                this.disabled = true;
                
                // Ensure all required fields are filled
                const requiredFields = document.querySelectorAll('input[required], select[required]');
                let formValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value) {
                        formValid = false;
                        field.style.borderColor = 'red';
                    } else {
                        field.style.borderColor = '';
                    }
                });
                
                if (!formValid) {
                    e.preventDefault();
                    alert('Please fill all required fields');
                    setActiveTab('personal');
                    this.innerHTML = 'Submit';
                    this.disabled = false;
                    return;
                }
                
                // Submit the form
                document.getElementById('playerForm').submit();
            });
        });
    </script>
</body>
</html>