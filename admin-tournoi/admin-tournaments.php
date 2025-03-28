<?php
session_start();
require_once '../includes/db.php';

// $admin_id = $_SESSION['admin_id'];

// Fetch tournaments managed by the logged-in admin
$sql = "SELECT * FROM tournaments";

$stmt = $bd->prepare($sql);
$stmt->execute();
$tournaments = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($tournaments);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Admin Dashboard</title>
    <link rel="stylesheet" href="admin-tournaments.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"> -->
</head>

<body>
    <div class="container">
        <header class="header">
            <div class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
            </div>
            <h1>Tournament Admin</h1>
        </header>

        <div class="main-content">
            <aside class="sidebar">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" data-target="my-tournaments">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            My Tournaments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-target="manage-matches">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                            </svg>
                            Manage Matches
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-target="match-schedule">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            Match Schedule
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link" data-target="reports">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            Reports
                        </a>
                    </li>
                </ul>
            </aside>

            <main class="content-area">
                <!-- My Tournaments Panel -->
                <section class="panel active" id="my-tournaments">
                    <div class="panel-header">
                        <h2 class="panel-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            Tournaments You Manage
                        </h2>
                    </div>

                    <div class="tournament-grid">
                        <?php foreach ($tournaments as $tournament): ?>
                            <div class="tournament-card">
                                <div class="card-header">
                                    <h3 class="card-title"><?= htmlspecialchars($tournament['tournament_name']) ?></h3>
                                    <span class="card-subtitle"><?= htmlspecialchars($tournament['format']) ?></span>
                                </div>
                                <div class="card-body">
                                    <ul class="info-list">
                                        <li><span>Start Date:</span> <?= htmlspecialchars($tournament['start_date']) ?></li>
                                        <li><span>End Date:</span> <?= htmlspecialchars($tournament['end_date']) ?></li>
                                        <li><span>Location:</span> <?= htmlspecialchars($tournament['location']) ?></li>
                                    </ul>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary manage-tournament" data-id="<?= $tournament['id'] ?>">Manage</button>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </section>

                <!-- Manage Matches Panel -->
                <section class="panel" id="manage-matches">
                    <div class="panel-header">
                        <h2 class="panel-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                            </svg>
                            <span id="tournament-title">Champions League 2023</span> - Matches
                        </h2>
                        <div class="btn-group">
                            <button class="btn btn-secondary" id="back-to-tournaments">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="19" y1="12" x2="5" y2="12"></line>
                                    <polyline points="12 19 5 12 12 5"></polyline>
                                </svg>
                                Back
                            </button>
                            <button class="btn btn-primary" id="add-match">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                </svg>
                                Add Match
                            </button>
                            <button class="btn btn-primary" id="ayman">
                                hello
                            </button>
                        </div>
                    </div>

                    <div class="filter-controls">
                        <div class="search-container">
                            <input type="text" id="match-search" placeholder="Search matches...">
                            <button class="search-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </button>
                        </div>

                        <div class="filter-group">
                            <label for="status-filter">Status:</label>
                            <select id="status-filter">
                                <option value="all">All</option>
                                <option value="scheduled">Scheduled</option>
                                <option value="in-progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="postponed">Postponed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="match-table">
                            <thead>
                                <tr>
                                    <th>Match ID</th>
                                    <th>Teams</th>
                                    <th>Date & Time</th>
                                    <th>Venue</th>
                                    <th>Fans</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="match-list">

                            </tbody>
                        </table>
                    </div>
                </section>

                <!-- Match Schedule Panel -->
                <section class="panel" id="match-schedule">
                    <div class="panel-header">
                        <h2 class="panel-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            Match Schedule
                        </h2>
                        <div class="btn-group">
                            <button class="btn btn-primary" id="print-schedule">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                    <rect x="6" y="14" width="12" height="8"></rect>
                                </svg>
                                Print
                            </button>
                        </div>
                    </div>

                    <div class="calendar-view">
                        <div class="calendar-header">
                            <button class="btn-icon" id="prev-month">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="15 18 9 12 15 6"></polyline>
                                </svg>
                            </button>
                            <h3 id="current-month">December 2023</h3>
                            <button class="btn-icon" id="next-month">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6"></polyline>
                                </svg>
                            </button>
                        </div>

                        <div class="calendar-grid">
                            <div class="calendar-day-header">Sun</div>
                            <div class="calendar-day-header">Mon</div>
                            <div class="calendar-day-header">Tue</div>
                            <div class="calendar-day-header">Wed</div>
                            <div class="calendar-day-header">Thu</div>
                            <div class="calendar-day-header">Fri</div>
                            <div class="calendar-day-header">Sat</div>

                            <!-- Calendar days will be dynamically generated -->
                            <div class="calendar-day empty"></div>
                            <div class="calendar-day empty"></div>
                            <div class="calendar-day empty"></div>
                            <div class="calendar-day empty"></div>
                            <div class="calendar-day empty"></div>
                            <div class="calendar-day">
                                <div class="day-number">1</div>
                            </div>
                            <div class="calendar-day">
                                <div class="day-number">2</div>
                            </div>

                            <!-- More days... -->
                            <div class="calendar-day has-events">
                                <div class="day-number">11</div>
                                <div class="day-event completed">Juventus vs Man City</div>
                            </div>
                            <div class="calendar-day has-events">
                                <div class="day-number">12</div>
                                <div class="day-event">Barcelona vs Real Madrid</div>
                            </div>
                            <div class="calendar-day has-events">
                                <div class="day-number">13</div>
                                <div class="day-event">Man United vs Liverpool</div>
                            </div>
                            <div class="calendar-day has-events">
                                <div class="day-number">14</div>
                                <div class="day-event postponed">Bayern vs PSG</div>
                            </div>
                            <div class="calendar-day has-events">
                                <div class="day-number">15</div>
                                <div class="day-event cancelled">Chelsea vs Arsenal</div>
                            </div>
                            <div class="calendar-day">
                                <div class="day-number">16</div>
                            </div>
                            <div class="calendar-day">
                                <div class="day-number">17</div>
                            </div>
                            <!-- More calendar days would go here -->
                        </div>
                    </div>
                </section>

                <!-- Reports Panel -->
                <section class="panel" id="reports">
                    <div class="panel-header">
                        <h2 class="panel-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                <polyline points="14 2 14 8 20 8"></polyline>
                                <line x1="16" y1="13" x2="8" y2="13"></line>
                                <line x1="16" y1="17" x2="8" y2="17"></line>
                                <polyline points="10 9 9 9 8 9"></polyline>
                            </svg>
                            Tournament Reports
                        </h2>
                    </div>

                    <div class="report-filters">
                        <div class="form-group">
                            <label for="report-tournament">Tournament:</label>
                            <select id="report-tournament">
                                <option value="1">Champions League 2023</option>
                                <option value="2">Summer Cup 2023</option>
                                <option value="3">Youth League 2023</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="report-type">Report Type:</label>
                            <select id="report-type">
                                <option value="match-summary">Match Summary</option>
                                <option value="team-performance">Team Performance</option>
                                <option value="attendance">Attendance</option>
                            </select>
                        </div>

                        <button class="btn btn-primary" id="generate-report">Generate Report</button>
                    </div>

                    <div class="report-container">
                        <div class="report-header">
                            <h3>Champions League 2023 - Match Summary</h3>
                            <p>Generated on: December 15, 2023</p>
                        </div>

                        <div class="report-stats">
                            <div class="stat-card">
                                <div class="stat-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                    </svg>
                                </div>
                                <div class="stat-value">15</div>
                                <div class="stat-label">Total Matches</div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-value">8</div>
                                <div class="stat-label">Completed</div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-value">2</div>
                                <div class="stat-label">Postponed</div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-value">1</div>
                                <div class="stat-label">Cancelled</div>
                            </div>
                        </div>

                        <div class="report-table">
                            <h4>Recent Match Results</h4>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Match</th>
                                        <th>Score</th>
                                        <th>Venue</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dec 11</td>
                                        <td>Juventus vs Manchester City</td>
                                        <td>2 - 1</td>
                                        <td>Allianz Stadium</td>
                                    </tr>
                                    <tr>
                                        <td>Dec 10</td>
                                        <td>Atletico Madrid vs Dortmund</td>
                                        <td>3 - 2</td>
                                        <td>Wanda Metropolitano</td>
                                    </tr>
                                    <tr>
                                        <td>Dec 9</td>
                                        <td>AC Milan vs Inter Milan</td>
                                        <td>1 - 1</td>
                                        <td>San Siro</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <!-- Edit Match Modal -->
   

    <!-- Edit Match Modal -->
    <div class="modal" id="edit-match-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title">Add Match</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="edit-match-form">
                    <input type="hidden" id="match-id">

                    <div class="form-row">
                        <div class="form-group">
                            <label for="match-home-team">Home Team</label>
                            <select id="match-home-team" required>
                                <!-- Teams will be loaded dynamically -->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="match-away-team">Away Team</label>
                            <select id="match-away-team" required>
                                <!-- Teams will be loaded dynamically -->
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="match-date">Date</label>
                            <input type="date" id="match-date" required>
                        </div>

                        <div class="form-group">
                            <label for="match-time">Time</label>
                            <input type="time" id="match-time" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="match-venue">Venue/Stadium</label>
                            <input type="text" id="match-venue" required>
                        </div>

                        <div class="form-group">
                            <label for="match-spectators">Number of Spectators</label>
                            <input type="number" id="match-spectators" min="0" value="0">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="match-name">Match Name (Optional)</label>
                            <input type="text" id="match-name">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="cancel-edit">Cancel</button>
                <button class="btn btn-primary" id="save-match">Save Match</button>
            </div>
        </div>
    </div>

</body>
<script src="admin-tournaments.js"></script>

</html>