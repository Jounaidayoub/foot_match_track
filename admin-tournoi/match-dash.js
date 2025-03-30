document.addEventListener("DOMContentLoaded", () => {
    // Match Dashboard - Match Card Click
    const matchCards = document.querySelectorAll(".match-card");
    const matchDetailsModal = document.getElementById("match-details-modal");
    const closeModalButtons = document.querySelectorAll(".close-modal");
    const cancelDetailsButton = document.getElementById("cancel-details");
    const saveDetailsButton = document.getElementById("save-details");

    matchCards.forEach(card => {
        card.addEventListener("click", function() {
            const matchId = this.getAttribute("data-match-id");
            document.getElementById("detail-match-id").value = matchId;
            
            // Set match details based on the selected match card
            const homeTeam = this.querySelector(".team-display:first-child .team-name") ? 
                            this.querySelector(".team-display:first-child .team-name").textContent :
                            this.querySelector(".team-display:first-child span").textContent;
            
            const awayTeam = this.querySelector(".team-display:last-child .team-name") ?
                            this.querySelector(".team-display:last-child .team-name").textContent :
                            this.querySelector(".team-display:last-child span").textContent;
            
            document.getElementById("detail-home-team").textContent = homeTeam;
            document.getElementById("detail-away-team").textContent = awayTeam;
            
            const matchDateText = this.querySelector(".match-date").textContent;
            const matchDateParts = matchDateText.split(" - ");
            const dateStr = matchDateParts[0];
            const timeStr = matchDateParts[1];
            
            document.getElementById("detail-match-date").value = formatDateForInput(dateStr);
            document.getElementById("detail-match-time").value = timeStr;
            
            const venueElement = this.querySelector(".match-venue");
            if (venueElement) {
                document.getElementById("detail-match-venue").value = venueElement.textContent;
            }
            
            const statusElement = this.querySelector(".match-status");
            if (statusElement) {
                const statusClass = Array.from(statusElement.classList)
                    .find(cls => cls !== "match-status");
                document.getElementById("detail-match-status").value = statusClass || "scheduled";
            }
            
            // Show the modal
            matchDetailsModal.classList.add("active");
            
            // Set the first tab as active
            const tabButtons = matchDetailsModal.querySelectorAll(".tab-btn");
            const tabContents = matchDetailsModal.querySelectorAll(".tab-content");
            
            tabButtons.forEach(btn => btn.classList.remove("active"));
            tabContents.forEach(content => content.classList.remove("active"));
            
            tabButtons[0].classList.add("active");
            tabContents[0].classList.add("active");
        });
    });

    // Helper function to format date for input field
    function formatDateForInput(dateStr) {
        try {
            const months = {
                "Jan": "01", "Feb": "02", "Mar": "03", "Apr": "04",
                "May": "05", "Jun": "06", "Jul": "07", "Aug": "08",
                "Sep": "09", "Oct": "10", "Nov": "11", "Dec": "12"
            };
            
            const parts = dateStr.split(" ");
            const month = months[parts[0]];
            const day = parts[1].replace(",", "").padStart(2, '0');
            const year = parts[2] || new Date().getFullYear();
            
            return `${year}-${month}-${day}`;
        } catch (e) {
            console.error("Error parsing date:", e);
            return "";
        }
    }

    // Close Modal
    function closeModal() {
        matchDetailsModal.classList.remove("active");
    }

    closeModalButtons.forEach(button => {
        button.addEventListener("click", closeModal);
    });

    cancelDetailsButton.addEventListener("click", closeModal);

    // Tab Navigation
    const tabButtons = document.querySelectorAll(".tab-btn");
    const tabContents = document.querySelectorAll(".tab-content");

    tabButtons.forEach(button => {
        button.addEventListener("click", () => {
            const target = button.getAttribute("data-tab");
            
            tabButtons.forEach(btn => btn.classList.remove("active"));
            tabContents.forEach(content => content.classList.remove("active"));
            
            button.classList.add("active");
            document.getElementById(target).classList.add("active");
        });
    });

    // Team Tabs for Lineups
    const teamTabs = document.querySelectorAll(".team-tab");
    const teamLineups = document.querySelectorAll(".team-lineup");

    teamTabs.forEach(tab => {
        tab.addEventListener("click", () => {
            const team = tab.getAttribute("data-team");
            
            teamTabs.forEach(t => t.classList.remove("active"));
            teamLineups.forEach(lineup => lineup.classList.remove("active"));
            
            tab.classList.add("active");
            document.getElementById(`${team}-lineup`).classList.add("active");
        });
    });

    // Add Player Button
    const addPlayerButtons = document.querySelectorAll(".add-player");

    addPlayerButtons.forEach(button => {
        button.addEventListener("click", () => {
            const team = button.getAttribute("data-team");
            const type = button.getAttribute("data-type");
            const container = document.getElementById(`${team}-${type}`);

            const playerItem = document.createElement("div");
            playerItem.className = "player-item";
            playerItem.innerHTML = `
                <div class="player-number">
                    <input type="number" min="1" max="99" placeholder="No.">
                </div>
                <div class="player-info">
                    <input type="text" placeholder="Player Name" class="player-name">
                    <select class="player-position">
                        <option value="GK">Goalkeeper</option>
                        <option value="DF">Defender</option>
                        <option value="MF">Midfielder</option>
                        <option value="FW">Forward</option>
                    </select>
                </div>
                <div class="player-rating">
                    <input type="number" min="1" max="10" step="0.1" placeholder="Rating">
                </div>
                <button type="button" class="remove-player">×</button>
            `;

            container.appendChild(playerItem);

            // Add event listener to remove button
            playerItem.querySelector(".remove-player").addEventListener("click", function() {
                this.closest(".player-item").remove();
            });
        });
    });

    // Remove Player Button - for existing buttons
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-player')) {
            event.target.closest(".player-item").remove();
        }
    });

    // Add Event Button
    const addEventButton = document.querySelector(".add-event");

    if (addEventButton) {
        addEventButton.addEventListener("click", () => {
            const eventList = document.getElementById("match-events");

            const eventItem = document.createElement("div");
            eventItem.className = "event-item";
            eventItem.innerHTML = `
                <div class="event-time">
                    <input type="number" min="1" max="120" placeholder="Min">
                </div>
                <div class="event-team">
                    <select>
                        <option value="home">Home Team</option>
                        <option value="away">Away Team</option>
                    </select>
                </div>
                <div class="event-type">
                    <select>
                        <option value="goal">Goal</option>
                        <option value="own-goal">Own Goal</option>
                        <option value="yellow">Yellow Card</option>
                        <option value="red">Red Card</option>
                        <option value="penalty">Penalty</option>
                        <option value="substitution">Substitution</option>
                    </select>
                </div>
                <div class="event-player">
                    <input type="text" placeholder="Player Name">
                </div>
                <div class="event-assist">
                    <input type="text" placeholder="Assist By (Optional)">
                </div>
                <button type="button" class="remove-event">×</button>
            `;

            eventList.appendChild(eventItem);

            // Add event listener to remove button
            eventItem.querySelector(".remove-event").addEventListener("click", function() {
                this.closest(".event-item").remove();
            });
        });
    }

    // Remove Event Button - for existing buttons
    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-event')) {
            event.target.closest(".event-item").remove();
        }
    });

    // Save Match Details
    saveDetailsButton.addEventListener("click", () => {
        const matchId = document.getElementById("detail-match-id").value;
        const homeScore = document.getElementById("detail-home-score").value;
        const awayScore = document.getElementById("detail-away-score").value;
        const matchDate = document.getElementById("detail-match-date").value;
        const matchTime = document.getElementById("detail-match-time").value;
        const matchVenue = document.getElementById("detail-match-venue").value;
        const matchStatus = document.getElementById("detail-match-status").value;
        
        // Get stats data
        const homePossession = document.getElementById("home-possession").value;
        const awayPossession = document.getElementById("away-possession").value;
        // Add more stats as needed
        
        // Collect lineup data
        const homeLineup = [];
        const awayLineup = [];
        
        document.querySelectorAll('#home-starting .player-item').forEach(player => {
            homeLineup.push({
                number: player.querySelector('.player-number input').value,
                name: player.querySelector('.player-name').value,
                position: player.querySelector('.player-position').value,
                rating: player.querySelector('.player-rating input').value
            });
        });
        
        document.querySelectorAll('#away-starting .player-item').forEach(player => {
            awayLineup.push({
                number: player.querySelector('.player-number input').value,
                name: player.querySelector('.player-name').value,
                position: player.querySelector('.player-position').value,
                rating: player.querySelector('.player-rating input').value
            });
        });
        
        // Collect events data
        const events = [];
        document.querySelectorAll('#match-events .event-item').forEach(event => {
            events.push({
                time: event.querySelector('.event-time input').value,
                team: event.querySelector('.event-team select').value,
                type: event.querySelector('.event-type select').value,
                player: event.querySelector('.event-player input').value,
                assist: event.querySelector('.event-assist input').value
            });
        });
        
        // Here you would typically save data to your database via AJAX
        console.log("Match ID:", matchId);
        console.log("Scores:", homeScore, "-", awayScore);
        console.log("Status:", matchStatus);
        console.log("Home lineup:", homeLineup);
        console.log("Away lineup:", awayLineup);
        console.log("Events:", events);
        
        // For demo purposes, show an alert
        alert(`Match ${matchId} details saved successfully!`);
        
        // Update the match card in the dashboard
        const matchCard = document.querySelector(`.match-card[data-match-id="${matchId}"]`);
        if (matchCard) {
            // Update status
            const statusElement = matchCard.querySelector(".match-status");
            if (statusElement) {
                statusElement.className = `match-status ${matchStatus}`;
                statusElement.textContent = matchStatus.charAt(0).toUpperCase() + matchStatus.slice(1);
            }
            
            // If match is completed, update the score
            if (matchStatus === "completed") {
                const vsElement = matchCard.querySelector(".vs");
                if (vsElement) {
                    vsElement.textContent = `${homeScore} - ${awayScore}`;
                }
            }
        }
        
        // Close modal
        closeModal();
    });
});