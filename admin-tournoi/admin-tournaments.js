document.addEventListener("DOMContentLoaded", () => {


  





  const matchList = document.getElementById("match-list");
  const tournamentTitle = document.getElementById("tournament-title");

  // Fetch matches for the selected tournament
  function fetchMatches(tournamentId) {
    fetch(`fetch-matches.php?tournament_id=${tournamentId}`)
      .then((response) => response.json())
      .then((matches) => {
        matchList.innerHTML = ""; // Clear existing matches
        if (matches.error) {
          matchList.innerHTML = `<tr><td colspan="6">${matches.error}</td></tr>`;
          return;
        }

        matches.forEach((match) => {
          const row = document.createElement("tr");
          row.innerHTML = `
                        <td>${match.id_match}</td>
                        <td>
                            <div class="match-teams">
                                <div class="team">
                                    <span>${match.home_team}</span>
                                </div>
                                <span class="vs">vs</span>
                                <div class="team">
                                    <span>${match.away_team}</span>
                                </div>
                            </div>
                        </td>
                        <td>${match.date_match} ${match.time_match}</td>
                        <td>${match.Nom_match || "N/A"}</td>
                        <td>${match.Nombre_spectateur || "N/A"}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon edit-match" data-id="${
                                  match.id_match
                                }">Edit</button>
                                <button class="btn-icon delete-match" data-id="${
                                  match.id_match
                                }">Delete</button>
                            </div>
                        </td>
                    `;
          matchList.appendChild(row);
        });
      })
      .catch((error) => {
        console.error("Error fetching matches:", error);
        matchList.innerHTML = `<tr><td colspan="6">Failed to load matches.</td></tr>`;
      });
  }

  // Event listener for "Manage" button in tournaments
  document.querySelectorAll(".manage-tournament").forEach((button) => {
    button.addEventListener("click", () => {
      const tournamentId = button.getAttribute("data-id");
      const tournamentName = button
        .closest(".tournament-card")
        .querySelector(".card-title").textContent;

      tournamentTitle.textContent = `${tournamentName}+qw    -  Matches`;
      fetchMatches(tournamentId);
    });
  });

  document.getElementById("save-match").addEventListener("click", () => {
    const tournamentId = document.getElementById("tournament-title").dataset.id;
    const dateMatch = document.getElementById("match-date").value;
    const timeMatch = document.getElementById("match-time").value;
    const idEquipe1 = document.getElementById("match-home-team").value;
    const idEquipe2 = document.getElementById("match-away-team").value;
    const nomMatch = document.getElementById("match-venue").value;

    fetch("add_match.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        tournament_id: tournamentId,
        date_match: dateMatch,
        time_match: timeMatch,
        id_equipe1: idEquipe1,
        id_equipe2: idEquipe2,
        Nom_match: nomMatch,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Match added successfully!");
          fetchMatches(tournamentId); // Refresh the match list
        } else {
          alert("Error adding match: " + data.error);
        }
      });
  });

  document.getElementById("ayman").addEventListener("click", () => {
    alert("asdasd");
  });
  // Navigation
  const navLinks = document.querySelectorAll(".nav-link");
  const panels = document.querySelectorAll(".panel");

  function setActivePanel(targetId) {
    // Hide all panels
    panels.forEach((panel) => {
      panel.classList.remove("active");
    });

    // Remove active class from all nav links
    navLinks.forEach((link) => {
      link.classList.remove("active");
    });

    // Show target panel
    document.getElementById(targetId).classList.add("active");

    // Set active nav link
    document
      .querySelector(`.nav-link[data-target="${targetId}"]`)
      .classList.add("active");
  }

  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();
      const targetId = this.getAttribute("data-target");
      setActivePanel(targetId);
    });
  });

  // Manage Tournament Buttons
  const manageTournamentButtons =
    document.querySelectorAll(".manage-tournament");

  manageTournamentButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const tournamentId = this.getAttribute("data-id");
      const tournamentName =
        this.closest(".tournament-card").querySelector(
          ".card-title"
        ).textContent;

      // Set tournament title in the manage matches panel
      document.getElementById("tournament-title").textContent = tournamentName;

      // Show manage matches panel
      setActivePanel("manage-matches");

      // Here you would typically load matches for this tournament
      // loadTournamentMatches(tournamentId);
    });
  });

  // Back to Tournaments Button
  document
    .getElementById("back-to-tournaments")
    .addEventListener("click", () => {
      setActivePanel("my-tournaments");
    });

  // Match Actions
  const editMatchButtons = document.querySelectorAll(".edit-match");
  const postponeMatchButtons = document.querySelectorAll(".postpone-match");
  const cancelMatchButtons = document.querySelectorAll(".cancel-match");
  const rescheduleMatchButtons = document.querySelectorAll(".reschedule-match");

  // Edit Match Modal
  const editMatchModal = document.getElementById("edit-match-modal");
  const closeModalButton = document.querySelector(".close-modal");
  const cancelEditButton = document.getElementById("cancel-edit");
  const saveMatchButton = document.getElementById("save-match");
  const matchStatusSelect = document.getElementById("match-status");
  const scoreContainer = document.getElementById("score-container");

  // Show/hide score inputs based on match status
  matchStatusSelect.addEventListener("change", function () {
    if (this.value === "completed" || this.value === "in-progress") {
      scoreContainer.style.display = "flex";
    } else {
      scoreContainer.style.display = "none";
    }
  });

  // Open Edit Match Modal
  editMatchButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const matchId = this.getAttribute("data-id");
      document.getElementById("match-id").value = matchId;

      // Here you would typically load match details
      // loadMatchDetails(matchId);

      // For demo, we'll set some default values
      document.getElementById("match-date").value = "2023-12-12";
      document.getElementById("match-time").value = "20:00";
      document.getElementById("match-venue").value = "Camp Nou, Barcelona";
      document.getElementById("match-status").value = "scheduled";
      document.getElementById("home-score").value = "0";
      document.getElementById("away-score").value = "0";
      document.getElementById("match-notes").value = "";

      // Show/hide score inputs based on status
      if (
        matchStatusSelect.value === "completed" ||
        matchStatusSelect.value === "in-progress"
      ) {
        scoreContainer.style.display = "flex";
      } else {
        scoreContainer.style.display = "none";
      }

      // Show modal
      editMatchModal.classList.add("active");
    });
  });

  // Close Modal
  function closeModal() {
    editMatchModal.classList.remove("active");
  }

  closeModalButton.addEventListener("click", closeModal);
  cancelEditButton.addEventListener("click", closeModal);

  // Save Match Changes
  saveMatchButton.addEventListener("click", () => {
    const matchId = document.getElementById("match-id").value;
    const matchDate = document.getElementById("match-date").value;
    const matchTime = document.getElementById("match-time").value;
    const matchVenue = document.getElementById("match-venue").value;
    const matchStatus = document.getElementById("match-status").value;
    const homeScore = document.getElementById("home-score").value;
    const awayScore = document.getElementById("away-score").value;
    const matchNotes = document.getElementById("match-notes").value;

    // Here you would typically save the changes to the server
    // saveMatchChanges(matchId, { date, time, venue, status, homeScore, awayScore, notes });

    // For demo, we'll just show an alert
    alert(`Match ${matchId} updated successfully!`);

    // Close modal
    closeModal();

    // Update UI to reflect changes
    updateMatchUI(matchId, matchStatus);
  });

  // Postpone Match
  postponeMatchButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const matchId = this.getAttribute("data-id");

      // Confirm before postponing
      if (confirm("Are you sure you want to postpone this match?")) {
        // Here you would typically send a request to postpone the match
        // postponeMatch(matchId);

        // For demo, we'll just update the UI
        updateMatchUI(matchId, "postponed");

        alert(`Match ${matchId} has been postponed.`);
      }
    });
  });

  // Cancel Match
  cancelMatchButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const matchId = this.getAttribute("data-id");

      // Confirm before cancelling
      if (
        confirm(
          "Are you sure you want to cancel this match? This action cannot be undone."
        )
      ) {
        // Here you would typically send a request to cancel the match
        // cancelMatch(matchId);

        // For demo, we'll just update the UI
        updateMatchUI(matchId, "cancelled");

        alert(`Match ${matchId} has been cancelled.`);
      }
    });
  });

  // Reschedule Match
  rescheduleMatchButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const matchId = this.getAttribute("data-id");
      document.getElementById("match-id").value = matchId;

      // Here you would typically load match details
      // loadMatchDetails(matchId);

      // For demo, we'll set some default values
      document.getElementById("match-date").value = "2023-12-20";
      document.getElementById("match-time").value = "20:00";
      document.getElementById("match-venue").value = "Allianz Arena, Munich";
      document.getElementById("match-status").value = "scheduled";
      document.getElementById("home-score").value = "0";
      document.getElementById("away-score").value = "0";
      document.getElementById("match-notes").value = "Rescheduled from Dec 14";

      // Show/hide score inputs
      scoreContainer.style.display = "none";

      // Show modal
      editMatchModal.classList.add("active");
    });
  });

  // Update Match UI
  function updateMatchUI(matchId, status) {
    const matchRow = document
      .querySelector(`[data-id="${matchId}"]`)
      .closest("tr");
    const statusBadge = matchRow.querySelector(".status-badge");

    // Update status badge
    statusBadge.className = `status-badge ${status}`;
    statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);

    // Update action buttons based on status
    const actionButtons = matchRow.querySelector(".action-buttons");

    if (status === "completed") {
      actionButtons.innerHTML = `
                <button class="btn-icon view-match" data-id="${matchId}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
                <button class="btn-icon edit-result" data-id="${matchId}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                </button>
            `;
    } else if (status === "cancelled") {
      actionButtons.innerHTML = `
                <button class="btn-icon reschedule-match" data-id="${matchId}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </button>
            `;
    } else if (status === "postponed") {
      actionButtons.innerHTML = `
                <button class="btn-icon edit-match" data-id="${matchId}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                </button>
                <button class="btn-icon reschedule-match" data-id="${matchId}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </button>
            `;
    } else {
      actionButtons.innerHTML = `
                <button class="btn-icon edit-match" data-id="${matchId}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                </button>
                <button class="btn-icon postpone-match" data-id="${matchId}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="10" y1="15" x2="10" y2="9"></line>
                        <line x1="14" y1="15" x2="14" y2="9"></line>
                    </svg>
                </button>
                <button class="btn-icon cancel-match" data-id="${matchId}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="15" y1="9" x2="9" y2="15"></line>
                        <line x1="9" y1="9" x2="15" y2="15"></line>
                    </svg>
                </button>
            `;
    }

    // Re-attach event listeners to new buttons
    attachEventListeners();
  }

  // Attach event listeners to dynamically created buttons
  function attachEventListeners() {
    // Edit Match buttons
    document.querySelectorAll(".edit-match").forEach((button) => {
      button.addEventListener("click", function () {
        const matchId = this.getAttribute("data-id");
        document.getElementById("match-id").value = matchId;

        // Load match details and show modal
        editMatchModal.classList.add("active");
      });
    });

    // Postpone Match buttons
    document.querySelectorAll(".postpone-match").forEach((button) => {
      button.addEventListener("click", function () {
        const matchId = this.getAttribute("data-id");

        if (confirm("Are you sure you want to postpone this match?")) {
          updateMatchUI(matchId, "postponed");
          alert(`Match ${matchId} has been postponed.`);
        }
      });
    });

    // Cancel Match buttons
    document.querySelectorAll(".cancel-match").forEach((button) => {
      button.addEventListener("click", function () {
        const matchId = this.getAttribute("data-id");

        if (
          confirm(
            "Are you sure you want to cancel this match? This action cannot be undone."
          )
        ) {
          updateMatchUI(matchId, "cancelled");
          alert(`Match ${matchId} has been cancelled.`);
        }
      });
    });

    // Reschedule Match buttons
    document.querySelectorAll(".reschedule-match").forEach((button) => {
      button.addEventListener("click", function () {
        const matchId = this.getAttribute("data-id");
        document.getElementById("match-id").value = matchId;

        // Show modal for rescheduling
        editMatchModal.classList.add("active");
      });
    });
  }

  // Calendar Navigation
  const prevMonthBtn = document.getElementById("prev-month");
  const nextMonthBtn = document.getElementById("next-month");
  const currentMonthEl = document.getElementById("current-month");

  const currentDate = new Date();

  function updateCalendar() {
    currentMonthEl.textContent = new Intl.DateTimeFormat("en-US", {
      month: "long",
      year: "numeric",
    }).format(currentDate);
  }

  prevMonthBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    updateCalendar();
  });

  nextMonthBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalendar();
  });

  // Report Generation
  const generateReportBtn = document.getElementById("generate-report");

  generateReportBtn.addEventListener("click", () => {
    const tournamentId = document.getElementById("report-tournament").value;
    const reportType = document.getElementById("report-type").value;

    // Here you would typically generate the report based on the selected options
    // generateReport(tournamentId, reportType);

    // For demo, we'll just show an alert
    alert(`Generated ${reportType} report for tournament ID ${tournamentId}`);
  });

  // Add Match Button
  document.getElementById("add-match").addEventListener("click", () => {
    
    // Reset form fields
    
    document.getElementById("match-id").value = "";
    document.getElementById("match-home-team").value = "";
    document.getElementById("match-away-team").value = "";
    document.getElementById("match-date").value = "";
    document.getElementById("match-time").value = "";
    document.getElementById("match-venue").value = "";
    document.getElementById("match-status").value = "scheduled";
    document.getElementById("home-score").value = "0";
    document.getElementById("away-score").value = "0";
    document.getElementById("match-notes").value = "";


    // fetch the slecetion of the teams from the db fetch-teams.php
    fetch(`fetch_teams.php`)
      .then((response) => response.json())
      .then((teams) => {
        console.log(teams);
        const homeTeamSelect = document.getElementById("match-home-team");
        const awayTeamSelect = document.getElementById("match-away-team");

        homeTeamSelect.innerHTML = "";
        awayTeamSelect.innerHTML = "";

        teams.forEach((team) => {
          const option = document.createElement("option");
          option.value = team.id;
          option.textContent = team.team_name;
          homeTeamSelect.appendChild(option);
        });

        teams.forEach((team) => {
          const option = document.createElement("option");
          option.value = team.id;
          option.textContent = team.team_name;
          awayTeamSelect.appendChild(option);
        });
      })
      .catch((error) => {
        console.error("Error fetching teams:", error);
        alert("Failed to load teams.");
      });

    // Hide score inputs
    scoreContainer.style.display = "none";

    // Show modal
    editMatchModal.classList.add("active");
    console.log("asdbjadhasd");
  });

  // Initialize
  updateCalendar();
  attachEventListeners();
});
