/**
 * Match Goals Management
 * Handles fetching, displaying, and saving goals for matches
 */

// Fetch goals for a specific match
function fetchGoals(matchId) {
    fetch(`get_goals.php?match_id=${matchId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayGoalsInTimeline(data.goals || [], matchId);
                calculateAndDisplayScore(matchId, data.goals || []);
            } else {
                console.error("Error fetching goals:", data.error);
            }
        })
        .catch(error => console.error("Error fetching goals:", error));
}

// Display goals in the match timeline
function displayGoalsInTimeline(goals, matchId) {
    const eventList = document.getElementById("match-events");
    
    // Clear existing goal events
    const existingGoalEvents = document.querySelectorAll(".event-item.goal-event");
    existingGoalEvents.forEach(event => event.remove());
    
    if (!goals.length) return;
    
    // Get match info for team IDs
    const matchCard = document.querySelector(`.match-card[data-match-id="${matchId}"]`);
    const homeTeamId = matchCard ? matchCard.getAttribute("data-home-team-id") : null;
    
    // Sort goals by time
    goals.sort((a, b) => a.goal_time - b.goal_time);
    
    // Add each goal to the timeline
    goals.forEach(goal => {
        const eventItem = document.createElement("div");
        eventItem.className = "event-item goal-event";
        eventItem.setAttribute("data-goal-id", goal.goal_id);
        
        // Determine if this is home or away team
        const isHomeTeam = parseInt(goal.team_id) === parseInt(homeTeamId);
        const teamValue = isHomeTeam ? "home" : "away";
        
        // Format goal type text
        let goalTypeText = "";
        switch(goal.goal_type) {
            case "penalty": goalTypeText = "(Penalty)"; break;
            case "own-goal": goalTypeText = "(Own Goal)"; break;
            case "free-kick": goalTypeText = "(Free Kick)"; break;
            case "header": goalTypeText = "(Header)"; break;
        }
        
        // Build the goal event HTML
        eventItem.innerHTML = `
            <div class="event-time">
                <input type="number" class="event-minute" value="${goal.goal_time}" readonly>
            </div>
            <div class="event-team">
                <select class="event-team-select" disabled>
                    <option value="${teamValue}" selected>${isHomeTeam ? document.getElementById("detail-home-team").textContent : document.getElementById("detail-away-team").textContent}</option>
                </select>
            </div>
            <div class="event-type">
                <select class="event-type-select" disabled>
                    <option value="goal" selected>Goal</option>
                </select>
            </div>
            <div class="event-player">
                <select class="player-select" disabled>
                    <option value="${goal.player_id}" selected>${goal.scorer_name || 'Unknown Player'}</option>
                </select>
            </div>
            <div class="event-details goal-details">
                <select class="goal-type" disabled>
                    <option value="${goal.goal_type}" selected>${goalTypeText || "Normal"}</option>
                </select>
            </div>
            <div class="event-assist" ${!goal.assist_player_id ? 'style="display: none;"' : ''}>
                <select class="assist-player-select" disabled>
                    <option value="${goal.assist_player_id}" selected>${goal.assist_name || "No assist"}</option>
                </select>
            </div>
            <button type="button" class="remove-goal" data-goal-id="${goal.goal_id}">×</button>
        `;
        
        eventList.appendChild(eventItem);
    });
    
    // Add event listeners for removing existing goals
    setupRemoveGoalListeners();
}

// Calculate and display score based on goals
function calculateAndDisplayScore(matchId, goals) {
    if (!goals || !goals.length) {
        // If no goals provided, fetch them
        fetch(`get_goals.php?match_id=${matchId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateScoreDisplay(matchId, data.goals || []);
                }
            })
            .catch(error => console.error("Error calculating score:", error));
    } else {
        // Use provided goals
        updateScoreDisplay(matchId, goals);
    }
}

// Update score display based on goals
function updateScoreDisplay(matchId, goals) {
    const matchCard = document.querySelector(`.match-card[data-match-id="${matchId}"]`);
    const homeTeamId = matchCard ? parseInt(matchCard.getAttribute("data-home-team-id")) : null;
    const awayTeamId = matchCard ? parseInt(matchCard.getAttribute("data-away-team-id")) : null;
    
    if (!homeTeamId || !awayTeamId) return;
    
    // Calculate scores
    let homeScore = 0;
    let awayScore = 0;
    
    goals.forEach(goal => {
        const goalTeamId = parseInt(goal.team_id);
        
        if (goal.goal_type === 'own-goal') {
            // Own goals count for the opposite team
            if (goalTeamId === homeTeamId) {
                awayScore++;
            } else if (goalTeamId === awayTeamId) {
                homeScore++;
            }
        } else {
            // Regular goals
            if (goalTeamId === homeTeamId) {
                homeScore++;
            } else if (goalTeamId === awayTeamId) {
                awayScore++;
            }
        }
    });
    
    // Update score display in the modal
    const homeScoreElement = document.getElementById("detail-home-score");
    const awayScoreElement = document.getElementById("detail-away-score");
    
    if (homeScoreElement && awayScoreElement) {
        homeScoreElement.textContent = homeScore;
        awayScoreElement.textContent = awayScore;
    }
    
    // Update score in match card if match is completed
    const matchStatus = document.getElementById("detail-match-status")?.value || "";
    if (matchStatus === "completed" && matchCard) {
        const vsElement = matchCard.querySelector(".vs");
        if (vsElement) {
            vsElement.textContent = `${homeScore} - ${awayScore}`;
        }
    }
}

// Save new goals to the database
function saveNewGoals(matchId) {
    // Get all goal events that aren't already saved
    const newGoalEvents = Array.from(document.querySelectorAll("#match-events .event-item"))
        .filter(item => 
            item.querySelector(".event-type-select").value === "goal" && 
            !item.hasAttribute("data-goal-id")
        );
    
    if (!newGoalEvents.length) return Promise.resolve(true);
    
    const savePromises = newGoalEvents.map(eventItem => {
        const teamSelect = eventItem.querySelector(".event-team-select");
        const teamType = teamSelect.value; // "home" or "away"
        
        // Get the actual team ID from the match card
        const matchCard = document.querySelector(`.match-card[data-match-id="${matchId}"]`);
        const teamId = teamType === "home" 
            ? matchCard.getAttribute("data-home-team-id")
            : matchCard.getAttribute("data-away-team-id");
        
        // Get goal details
        const playerId = eventItem.querySelector(".player-select").value;
        const assistPlayerId = eventItem.querySelector(".assist-player-select").value || null;
        const goalTime = eventItem.querySelector(".event-minute").value;
        const goalType = eventItem.querySelector(".goal-type").value;
        
        // Validate required fields
        if (!playerId || !goalTime) {
            alert("Please fill in all required goal information");
            return Promise.reject("Missing goal information");
        }
        
        // Create goal data object
        const goalData = {
            match_id: matchId,
            team_id: teamId,
            player_id: playerId,
            assist_player_id: assistPlayerId,
            goal_time: goalTime,
            goal_type: goalType
        };
        
        // Send to server
        return fetch("set_goals.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(goalData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mark this goal as saved
                eventItem.setAttribute("data-goal-id", data.goal_id);
                return true;
            } else {
                console.error("Error saving goal:", data.error);
                return false;
            }
        });
    });
    
    return Promise.all(savePromises)
        .then(results => results.every(result => result === true));
}

// Delete a goal from the database
function deleteGoal(goalId) {
    return fetch(`delete_goal.php?goal_id=${goalId}`, {
        method: "DELETE"
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            return true;
        } else {
            console.error("Error deleting goal:", data.error);
            return false;
        }
    })
    .catch(error => {
        console.error("Error:", error);
        return false;
    });
}

// Set up listeners for goal removal
function setupRemoveGoalListeners() {
    document.querySelectorAll(".remove-goal").forEach(button => {
        button.addEventListener("click", function() {
            const goalId = this.getAttribute("data-goal-id");
            const matchId = document.getElementById("detail-match-id").value;
            
            if (confirm("Are you sure you want to remove this goal?")) {
                deleteGoal(goalId).then(success => {
                    if (success) {
                        this.closest(".event-item").remove();
                        // Recalculate score
                        calculateAndDisplayScore(matchId);
                    }
                });
            }
        });
    });
}

// Function to load players for a team
function loadPlayersForTeam(teamType, playerSelectElement, assistSelectElement) {
    const matchId = document.getElementById("detail-match-id").value;
    
    // Clear existing options
    playerSelectElement.innerHTML = '<option value="">Select player</option>';
    if (assistSelectElement) {
        assistSelectElement.innerHTML = '<option value="">Assist by (optional)</option>';
    }
    
    // Get team ID based on home/away selection
    const matchCard = document.querySelector(`.match-card[data-match-id="${matchId}"]`);
    if (!matchCard) return;
    
    const teamId = teamType === "home"
        ? matchCard.getAttribute("data-home-team-id")
        : matchCard.getAttribute("data-away-team-id");
    
    // Fetch team players
    fetch(`get_team_players.php?team_id=${teamId}`)
        .then(response => response.json())
        .then(players => {
            players.forEach(player => {
                const option = document.createElement("option");
                option.value = player.id;
                option.textContent = `${player.number} - ${player.full_name}`;
                
                playerSelectElement.appendChild(option.cloneNode(true));
                if (assistSelectElement) {
                    assistSelectElement.appendChild(option);
                }
            });
        })
        .catch(error => console.error("Error loading players:", error));
}

// Initialize goal functionality
document.addEventListener("DOMContentLoaded", () => {
    // Add Event Button
    const addEventButton = document.querySelector(".add-event");
    
    if (addEventButton) {
        addEventButton.addEventListener("click", () => {
            addNewGoalEvent();
        });
    }
    
    // Update the save details button to also save goals
    const saveDetailsButton = document.getElementById("save-details");
    if (saveDetailsButton) {
        const originalClickHandler = saveDetailsButton.onclick;
        
        saveDetailsButton.addEventListener("click", function(e) {
            const matchId = document.getElementById("detail-match-id").value;
            
            // Save new goals first
            saveNewGoals(matchId)
                .then(success => {
                    if (success) {
                        // Refresh goals display
                        fetchGoals(matchId);
                    }
                    
                    // Let the original handler run or close the modal
                    if (originalClickHandler) {
                        originalClickHandler.call(this, e);
                    }
                });
        });
    }
});

// Add a new goal event to the timeline
function addNewGoalEvent() {
    const eventList = document.getElementById("match-events");
    if (!eventList) return;
    
    const eventItem = document.createElement("div");
    eventItem.className = "event-item";
    eventItem.innerHTML = `
        <div class="event-time">
            <input type="number" class="event-minute" min="1" max="120" placeholder="Min">
        </div>
        <div class="event-team">
            <select class="event-team-select">
                <option value="home">Home Team</option>
                <option value="away">Away Team</option>
            </select>
        </div>
        <div class="event-type">
            <select class="event-type-select">
                <option value="goal">Goal</option>
            </select>
        </div>
        <div class="event-player">
            <select class="player-select"><option value="">Select player</option></select>
        </div>
        <div class="event-details goal-details">
            <select class="goal-type">
                <option value="normal">Normal</option>
                <option value="penalty">Penalty</option>
                <option value="own-goal">Own Goal</option>
                <option value="free-kick">Free Kick</option>
                <option value="header">Header</option>
            </select>
        </div>
        <div class="event-assist">
            <select class="assist-player-select"><option value="">Assist by (optional)</option></select>
        </div>
        <button type="button" class="remove-event">×</button>
    `;
    
    eventList.appendChild(eventItem);
    
    // Set up event handlers
    const teamSelect = eventItem.querySelector(".event-team-select");
    const playerSelect = eventItem.querySelector(".player-select");
    const assistSelect = eventItem.querySelector(".assist-player-select");
    
    // Load players when team changes
    teamSelect.addEventListener("change", () => {
        loadPlayersForTeam(teamSelect.value, playerSelect, assistSelect);
    });
    
    // Initial player load
    loadPlayersForTeam(teamSelect.value, playerSelect, assistSelect);
    
    // Remove event handler
    eventItem.querySelector(".remove-event").addEventListener("click", function() {
        this.closest(".event-item").remove();
    });
}

// Function to integrate with match-dash.js - call this when a match is selected
function initializeGoalsForMatch(matchId) {
    // Fetch existing goals for the match
    fetchGoals(matchId);
}