document.addEventListener("DOMContentLoaded", () => {
  function addOverlay(element) {
    const overlay = document.createElement("div");
    const overlayContent = document.createElement("div");
    overlay.className = "tab-content-overlay";
    overlayContent.className = "lock-message";
    overlayContent.innerHTML = `this will be locked until the match is started`;
    overlay.appendChild(overlayContent);
    element.style.position = "relative";
    element.insertBefore(overlay, element.firstChild);
  }

  function removeOverlay(element) {
    const overlay = element.querySelector(".tab-content-overlay");
    if (overlay) {
      element.removeChild(overlay);
    }
  }

  // Fetch and display matches from the database
  function fetchMatches(tournamentId = 1) {
    fetch(`fetch-matches.php?tournament_id=${tournamentId}`)
      .then((response) => response.json())
      .then((data) => {
        if (data.error) {
          console.error("Error fetching matches:", data.error);
          return;
        }

        // Clear any existing matches
        const matchDashboard =
          document.querySelector(".match-dashboard-grid") ||
          document.getElementById("match-dashboard-grid");
        if (matchDashboard) {
          matchDashboard.innerHTML = "";

          // Create match cards for each match
          data.forEach((match) => {
            const matchCard = document.createElement("div");
            matchCard.className = "match-card";
            matchCard.setAttribute("data-match-id", match.id_match);
            matchCard.setAttribute("data-", match.id_match);

            ///for home/away team id
            matchCard.setAttribute("data-away-team-id", match.away_team_id);
            matchCard.setAttribute("data-home-team-id", match.home_team_id);

            // New structure for match cards
            matchCard.innerHTML = `
                            <div class="match-card-header">
                                <div class="match-date">${formatDateDisplay(
                                  match.date_match
                                )} - ${match.time_match}</div>
                            </div>
                            <div class="match-card-body">
                                <div class="match-teams">
                                    <div class="team-display">
                                        <div class="team-logo">
                                        <img src="../assets/${
                                          match.home_team_logo
                                        }"  style="width: 32px;height: 32px;border-radius: 32px";alt="" >
                                        </div>
                                        <span>${match.home_team}</span>
                                    </div>
                                    <span class="vs">${
                                      match.status === "completed"
                                        ? `${match.home_score || 0} - ${
                                            match.away_score || 0
                                          }`
                                        : "vs"
                                    }</span>
                                    <div class="team-display">
                                        <div class="team-logo">
                                        <img src="../assets/${
                                          match.away_team_logo
                                        }"  style="width: 32px;height: 32px;border-radius: 32px";alt="" >
                                        </div>
                                        <span>${match.away_team}</span>
                                    </div>
                                </div>
                                <div class="match-venue">${
                                  match.staduim || "TBD"
                                }</div>
                                <div class="match-status ${match.status}">${
              match.status.charAt(0).toUpperCase() + match.status.slice(1)
            }</div>
                            </div>
                        `;

            matchDashboard.appendChild(matchCard);
          });

          // Add event listeners to the newly created match cards
          setupMatchCardListeners();
        }
      })
      .catch((error) => console.error("Error:", error));
  }

  // Format date for display (e.g., "Mar 21, 2025")
  function formatDateDisplay(dateStr) {
    if (!dateStr) return "TBD";

    const date = new Date(dateStr);
    const options = { month: "short", day: "numeric", year: "numeric" };
    return date.toLocaleDateString("en-US", options);
  }


  function updateMatchReferees(matchId) {
    const refereeData = {
      match_id: matchId,
      main_referee: document.getElementById("match-referee").value,
      assistant1: document.getElementById("match-assistant1").value,
      assistant2: document.getElementById("match-assistant2").value,
    };

    fetch("update_match_referees.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(refereeData),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Match referees updated successfully!");
        } else {
          alert(
            `Failed to update match referees: ${data.error || "Unknown error"}`
          );
        }
      })
      .catch((error) => console.error("Error updating referees:", error));
  }

  // Add event listeners to match cards
  function setupMatchCardListeners() {
    const matchCards = document.querySelectorAll(".match-card");
    const matchDetailsModal = document.getElementById("match-details-modal");

    matchCards.forEach((card) => {
      card.addEventListener("click", function () {
        const matchId = this.getAttribute("data-match-id");
        document.getElementById("detail-match-id").value = matchId;


        //this for save this tab button
        const saveThisTabButton = document.getElementById("save-tab");
        if (saveThisTabButton) {
          saveThisTabButton.addEventListener("click", () => {

            updateMatchReferees(matchId);

          })}


        // Set match details based on the selected match card
        const homeTeam = this.querySelector(
          ".team-display:first-child span"
        ).textContent;
        const awayTeam = this.querySelector(
          ".team-display:last-child span"
        ).textContent;

        document.getElementById("detail-home-team").textContent = homeTeam;
        document.getElementById("detail-away-team").textContent = awayTeam;

        //adding team id to home and away teams

        const matchDateText = this.querySelector(".match-date").textContent;
        const matchDateParts = matchDateText.split(" - ");
        const dateStr = matchDateParts[0];
        const timeStr = matchDateParts[1];

        document.getElementById("detail-match-date").value =
          formatDateForInput(dateStr);
        document.getElementById("detail-match-time").value = timeStr;

        const venueElement = this.querySelector(".match-venue");
        if (venueElement) {
          document.getElementById("detail-match-venue").value =
            venueElement.textContent;
        }

        const statusElement = this.querySelector(".match-status");
        if (statusElement) {
          const statusClass = Array.from(statusElement.classList).find(
            (cls) => cls !== "match-status"
          );
          document.getElementById("detail-match-status").value =
            statusClass || "scheduled";
        }

        // Fetch match stats
        fetchMatchStats(matchId);

        // Show the modal
        matchDetailsModal.classList.add("active");

        // Set the first tab as active
        const tabButtons = matchDetailsModal.querySelectorAll(".tab-btn");
        const tabContents = matchDetailsModal.querySelectorAll(".tab-content");

        tabButtons.forEach((btn) => btn.classList.remove("active"));
        tabContents.forEach((content) => content.classList.remove("active"));

        tabButtons[0].classList.add("active");
        tabContents[0].classList.add("active");
        // console.log(tabContents[2])

        // addOverlay(tabContents[2]);
        // Apply overlay based on match status

        const matchStatus = document.getElementById(
          "detail-match-status"
        ).value;
        console.log("Match Status:", matchStatus);
        if (matchStatus === "scheduled" || matchStatus === "upcoming") {
          if (tabContents[2]) {
            console.log(tabContents[2]);
            addOverlay(tabContents[2]);
          }
          if (tabContents[3]) {
            console.log(tabContents[3]);
            addOverlay(tabContents[3]);
          }
        } else {
          if (tabContents[2]) {
            removeOverlay(tabContents[2]);
          }
          if (tabContents[3]) {
            removeOverlay(tabContents[3]);
          }
        }
      });
    });
  }

  // Fetch match stats from the database
  function fetchMatchStats(matchId) {
    fetch(`get_stats.php?match_id=${matchId}`)
      .then((response) => response.json())
      .then((data) => {
        // Populate stats fields
        document.getElementById("home-possession").value =
          data.home_possession || 50;
        document.getElementById("away-possession").value =
          data.away_possession || 50;
        document.getElementById("home-shots").value = data.home_shots || 0;
        document.getElementById("away-shots").value = data.away_shots || 0;
        document.getElementById("home-shots-target").value =
          data.home_shots_target || 0;
        document.getElementById("away-shots-target").value =
          data.away_shots_target || 0;
        document.getElementById("home-corners").value = data.home_corners || 0;
        document.getElementById("away-corners").value = data.away_corners || 0;
        document.getElementById("home-fouls").value = data.home_fouls || 0;
        document.getElementById("away-fouls").value = data.away_fouls || 0;
        document.getElementById("home-passes").value = data.home_passes || 0;
        document.getElementById("away-passes").value = data.away_passes || 0;
      })
      .catch((error) => console.error("Error fetching match stats:", error));
  }

  // Update match stats in the database
  function updateMatchStats(matchId) {
    const statsData = {
      match_id: matchId,
      home_possession: document.getElementById("home-possession").value,
      away_possession: document.getElementById("away-possession").value,
      home_shots: document.getElementById("home-shots").value,
      away_shots: document.getElementById("away-shots").value,
      home_shots_target: document.getElementById("home-shots-target").value,
      away_shots_target: document.getElementById("away-shots-target").value,
      home_corners: document.getElementById("home-corners").value,
      away_corners: document.getElementById("away-corners").value,
      home_fouls: document.getElementById("home-fouls").value,
      away_fouls: document.getElementById("away-fouls").value,
      home_passes: document.getElementById("home-passes").value,
      away_passes: document.getElementById("away-passes").value,
    };

    fetch("set_stats.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(statsData),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Match stats updated successfully!");
        } else {
          alert(
            `Failed to update match stats: ${data.error || "Unknown error"}`
          );
        }
      })
      .catch((error) => console.error("Error updating stats:", error));
  }

  // Save Match Details (including stats)
  const saveDetailsButton = document.getElementById("save-details");
  if (saveDetailsButton) {
    saveDetailsButton.addEventListener("click", () => {
      const matchId = document.getElementById("detail-match-id").value;
      updateMatchStats(matchId);

      // Close modal
      document.getElementById("match-details-modal").classList.remove("active");
    });
  }

  // Initialize by fetching matches for default tournament (ID=1)
  fetchMatches(1);

  // Rest of your existing code (close modal, tab navigation, etc.)
  const matchDetailsModal = document.getElementById("match-details-modal");
  const closeModalButtons = document.querySelectorAll(".close-modal");
  const cancelDetailsButton = document.getElementById("cancel-details");

  function closeModal() {
    matchDetailsModal.classList.remove("active");
  }

  closeModalButtons.forEach((button) => {
    button.addEventListener("click", closeModal);
  });

  if (cancelDetailsButton) {
    cancelDetailsButton.addEventListener("click", closeModal);
  }

  // Helper function to format date for input field
  function formatDateForInput(dateStr) {
    try {
      const months = {
        Jan: "01",
        Feb: "02",
        Mar: "03",
        Apr: "04",
        May: "05",
        Jun: "06",
        Jul: "07",
        Aug: "08",
        Sep: "09",
        Oct: "10",
        Nov: "11",
        Dec: "12",
      };

      const parts = dateStr.split(" ");
      const month = months[parts[0]];
      const day = parts[1].replace(",", "").padStart(2, "0");
      const year = parts[2] || new Date().getFullYear();

      return `${year}-${month}-${day}`;
    } catch (e) {
      console.error("Error formatting date:", e);
      return "";
    }
  }
});

document.addEventListener("DOMContentLoaded", () => {
  // Match Dashboard - Match Card Click
  const matchCards = document.querySelectorAll(".match-card");
  const matchDetailsModal = document.getElementById("match-details-modal");
  const closeModalButtons = document.querySelectorAll(".close-modal");
  const cancelDetailsButton = document.getElementById("cancel-details");
  const saveDetailsButton = document.getElementById("save-details");

  matchCards.forEach((card) => {
    card.addEventListener("click", function () {
      const matchId = this.getAttribute("data-match-id");
      document.getElementById("detail-match-id").value = matchId;

      // Set match details based on the selected match card
      const homeTeam = this.querySelector(
        ".team-display:first-child .team-name"
      )
        ? this.querySelector(".team-display:first-child .team-name").textContent
        : this.querySelector(".team-display:first-child span").textContent;

      const awayTeam = this.querySelector(".team-display:last-child .team-name")
        ? this.querySelector(".team-display:last-child .team-name").textContent
        : this.querySelector(".team-display:last-child span").textContent;

      document.getElementById("detail-home-team").textContent = homeTeam;
      document.getElementById("detail-away-team").textContent = awayTeam;

      const matchDateText = this.querySelector(".match-date").textContent;
      const matchDateParts = matchDateText.split(" - ");
      const dateStr = matchDateParts[0];
      const timeStr = matchDateParts[1];

      document.getElementById("detail-match-date").value =
        formatDateForInput(dateStr);
      document.getElementById("detail-match-time").value = timeStr;

      const venueElement = this.querySelector(".match-venue");
      if (venueElement) {
        document.getElementById("detail-match-venue").value =
          venueElement.textContent;
      }

      const statusElement = this.querySelector(".match-status");
      if (statusElement) {
        const statusClass = Array.from(statusElement.classList).find(
          (cls) => cls !== "match-status"
        );
        document.getElementById("detail-match-status").value =
          statusClass || "scheduled";
      }

      // Show the modal
      matchDetailsModal.classList.add("active");

      // Set the first tab as active
      const tabButtons = matchDetailsModal.querySelectorAll(".tab-btn");
      const tabContents = matchDetailsModal.querySelectorAll(".tab-content");

      tabButtons.forEach((btn) => btn.classList.remove("active"));
      tabContents.forEach((content) => content.classList.remove("active"));

      tabButtons[0].classList.add("active");
      tabContents[0].classList.add("active");
    });
  });

  // Helper function to format date for input field
  function formatDateForInput(dateStr) {
    try {
      const months = {
        Jan: "01",
        Feb: "02",
        Mar: "03",
        Apr: "04",
        May: "05",
        Jun: "06",
        Jul: "07",
        Aug: "08",
        Sep: "09",
        Oct: "10",
        Nov: "11",
        Dec: "12",
      };

      const parts = dateStr.split(" ");
      const month = months[parts[0]];
      const day = parts[1].replace(",", "").padStart(2, "0");
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

  closeModalButtons.forEach((button) => {
    button.addEventListener("click", closeModal);
  });

  cancelDetailsButton.addEventListener("click", closeModal);

  // Tab Navigation
  const tabButtons = document.querySelectorAll(".tab-btn");
  const tabContents = document.querySelectorAll(".tab-content");

  tabButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const target = button.getAttribute("data-tab");

      tabButtons.forEach((btn) => btn.classList.remove("active"));
      tabContents.forEach((content) => content.classList.remove("active"));

      button.classList.add("active");
      document.getElementById(target).classList.add("active");
    });
  });

  // Team Tabs for Lineups
  const teamTabs = document.querySelectorAll(".team-tab");
  const teamLineups = document.querySelectorAll(".team-lineup");

  teamTabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      const team = tab.getAttribute("data-team");

      teamTabs.forEach((t) => t.classList.remove("active"));
      teamLineups.forEach((lineup) => lineup.classList.remove("active"));

      tab.classList.add("active");
      document.getElementById(`${team}-lineup`).classList.add("active");
    });
  });

  // Add Player Button
  const addPlayerButtons = document.querySelectorAll(".add-player");

  addPlayerButtons.forEach((button) => {
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
      playerItem
        .querySelector(".remove-player")
        .addEventListener("click", function () {
          this.closest(".player-item").remove();
        });
    });
  });

  // Remove Player Button - for existing buttons
  document.addEventListener("click", function (event) {
    if (event.target && event.target.classList.contains("remove-player")) {
      event.target.closest(".player-item").remove();
    }
  });

  // Add Event Button
  const addEventButton = document.querySelector(".add-event");

  // Helper function to update event fields based on event type
  function updateEventFields(eventTypeSelect, goalDetailsElement) {
    const eventType = eventTypeSelect.value;

    if (eventType === "goal") {
      goalDetailsElement.style.display = "block";
      goalDetailsElement
        .closest(".event-item")
        .querySelector(".event-assist").style.display = "block";
    } else {
      goalDetailsElement.style.display = "none";
      goalDetailsElement
        .closest(".event-item")
        .querySelector(".event-assist").style.display =
        eventType === "substitution" ? "block" : "none";
    }
  }

  // Function to load players for a team
  function loadPlayersForTeam(
    teamType,
    playerSelectElement,
    assistSelectElement
  ) {
    const matchId = document.getElementById("detail-match-id").value;

    // Clear existing options
    playerSelectElement.innerHTML = '<option value="">Select player</option>';
    assistSelectElement.innerHTML =
      '<option value="">Assist by (optional)</option>';

    // Get team ID based on home/away selection
    let teamId;
    if (teamType === "home") {
      teamId = document
        .querySelector(`.match-card[data-match-id="${matchId}"]`)
        .getAttribute("data-home-team-id");
    } else {
      teamId = document
        .querySelector(`.match-card[data-match-id="${matchId}"]`)
        .getAttribute("data-away-team-id");
    }

    // Fetch team players
    fetch(`get_team_players.php?team_id=${teamId}`)
      .then((response) => response.json())
      .then((players) => {
        players.forEach((player) => {
          const option = document.createElement("option");
          option.value = player.id;
          option.textContent = `${player.number} - ${player.full_name}`;

          playerSelectElement.appendChild(option.cloneNode(true));
          assistSelectElement.appendChild(option);
        });
      })
      .catch((error) => console.error("Error loading players:", error));
  }

  //   if (addEventButton) {
  //     addEventButton.addEventListener("click", () => {
  //       const eventList = document.getElementById("match-events");

  //       const eventItem = document.createElement("div");
  //       eventItem.className = "event-item";
  //       eventItem.innerHTML = `
  //         <div class="event-time">
  //           <input type="number" class="event-minute" min="1" max="120" placeholder="Min">
  //         </div>
  //         <div class="event-team">
  //           <select class="event-team-select">
  //             <option value="home">Home Team</option>
  //             <option value="away">Away Team</option>
  //           </select>
  //         </div>
  //         <div class="event-type">
  //           <select class="event-type-select">
  //             <option value="goal">Goal</option>
  //             <option value="yellow">Yellow Card</option>
  //             <option value="red">Red Card</option>
  //             <option value="substitution">Substitution</option>
  //           </select>
  //         </div>
  //         <div class="event-player">
  //           <select class="player-select"><option>Select player</option></select>
  //         </div>
  //         <div class="event-details goal-details">
  //           <select class="goal-type">
  //             <option value="normal">Normal</option>
  //             <option value="penalty">Penalty</option>
  //             <option value="own-goal">Own Goal</option>
  //             <option value="free-kick">Free Kick</option>
  //             <option value="header">Header</option>
  //           </select>
  //         </div>
  //         <div class="event-assist">
  //           <select class="assist-player-select"><option>Assist by (optional)</option></select>
  //         </div>
  //         <button type="button" class="remove-event">×</button>
  //       `;

  //       eventList.appendChild(eventItem);

  //       // Load players for the selected team
  //       const teamSelect = eventItem.querySelector(".event-team-select");
  //       const eventTypeSelect = eventItem.querySelector(".event-type-select");
  //       const goalDetails = eventItem.querySelector(".goal-details");

  //       // Initially hide/show fields based on selected event type
  //       updateEventFields(eventTypeSelect, goalDetails);

  //       // Add event listeners for dynamic behavior
  //       teamSelect.addEventListener("change", () =>
  //         loadPlayersForTeam(
  //           teamSelect.value,
  //           eventItem.querySelector(".player-select"),
  //           eventItem.querySelector(".assist-player-select")
  //         )
  //       );

  //       eventTypeSelect.addEventListener("change", () => {
  //         updateEventFields(eventTypeSelect, goalDetails);
  //       });

  //       // Load players for initial team selection
  //       loadPlayersForTeam(
  //         teamSelect.value,
  //         eventItem.querySelector(".player-select"),
  //         eventItem.querySelector(".assist-player-select")
  //       );

  //       // Add event listener to remove button
  //       eventItem
  //         .querySelector(".remove-event")
  //         .addEventListener("click", function () {
  //           this.closest(".event-item").remove();
  //         });
  //     });
  //   }

  // Remove Event Button - for existing buttons
  document.addEventListener("click", function (event) {
    if (event.target && event.target.classList.contains("remove-event")) {
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

    document
      .querySelectorAll("#home-starting .player-item")
      .forEach((player) => {
        homeLineup.push({
          number: player.querySelector(".player-number input").value,
          name: player.querySelector(".player-name").value,
          position: player.querySelector(".player-position").value,
          rating: player.querySelector(".player-rating input").value,
        });
      });

    document
      .querySelectorAll("#away-starting .player-item")
      .forEach((player) => {
        awayLineup.push({
          number: player.querySelector(".player-number input").value,
          name: player.querySelector(".player-name").value,
          position: player.querySelector(".player-position").value,
          rating: player.querySelector(".player-rating input").value,
        });
      });

    // Collect events data
    const events = [];
    document.querySelectorAll("#match-events .event-item").forEach((event) => {
      events.push({
        time: event.querySelector(".event-time input").value,
        team: event.querySelector(".event-team select").value,
        type: event.querySelector(".event-type select").value,
        player: event.querySelector(".event-player input").value,
        assist: event.querySelector(".event-assist input").value,
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
    const matchCard = document.querySelector(
      `.match-card[data-match-id="${matchId}"]`
    );
    if (matchCard) {
      // Update status
      const statusElement = matchCard.querySelector(".match-status");
      if (statusElement) {
        statusElement.className = `match-status ${matchStatus}`;
        statusElement.textContent =
          matchStatus.charAt(0).toUpperCase() + matchStatus.slice(1);
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
