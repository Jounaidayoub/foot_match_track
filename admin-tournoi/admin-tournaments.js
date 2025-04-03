document.addEventListener("DOMContentLoaded", () => {
  // DOM elements
  const matchList = document.getElementById("match-list");
  const tournamentTitle = document.getElementById("tournament-title");
  const editMatchModal = document.getElementById("edit-match-modal");
  const addMatchBtn = document.getElementById("add-match");
  const saveMatchBtn = document.getElementById("save-match");
  const cancelEditBtn = document.getElementById("cancel-edit");
  const closeModalBtn = document.querySelector(".close-modal");

  // Modal form elements
  const matchIdInput = document.getElementById("match-id");
  const homeTeamSelect = document.getElementById("match-home-team");
  const awayTeamSelect = document.getElementById("match-away-team");
  const matchDateInput = document.getElementById("match-date");
  const matchTimeInput = document.getElementById("match-time");
  const matchVenueInput = document.getElementById("match-venue");
  const matchSpectatorsInput = document.getElementById("match-spectators");
  const matchNameInput = document.getElementById("match-name");
  const modalTitle = document.getElementById("modal-title");

  // Function to fetch matches for the selected tournament
  function fetchMatches(tournamentId) {
    fetch(`fetch-matches.php?tournament_id=${tournamentId}`)
      .then((response) => response.json())
      .then((matches) => {
        matchList.innerHTML = ""; // Clear existing matches

        if (matches.length === 0) {
          matchList.innerHTML = "<tr><td colspan='7'>No matches found</td></tr>";
          return;
        }

        matches.forEach((match) => {
          matchList.innerHTML += `
                        <tr>
                            <td>${match.id_match}</td>
                            <td>
                                <div class="match-teams">
                                    <img src="../assets/${match.home_team_logo}"  style="width: 32px;height: 32px;border-radius: 32px";alt="" >
                                    <div class="team"><span>${match.home_team}</span></div>
                                    <span class="vs">vs</span>
                                    <div class="team"><span>${match.away_team}</span></div>
                                    <img src="../assets/${match.away_team_logo}"  style="width: 32px;height: 32px;border-radius: 32px";alt="" >
                                </div>
                            </td>
                            <td>${match.date_match} ${match.time_match}</td>
                            <td>${match.staduim || "N/A"}</td>
                            <td>${match.Nombre_spectateur || "0"}</td>
                            <td><span class="status-badge ${match.status}">${match.status}</span></td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon edit-match" data-id="${match.id_match}">
                                        Edit
                                    </button>
                                    <button class="btn-icon delete-match" data-id="${match.id_match}">
                                    <img src="https://img.icons8.com/ios/50/000000/delete-sign.png" width="20" height="20" color="red" alt="Delete" title="Delete" /> 
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
        });

        // Add event listeners to the edit and delete buttons
        attachMatchActionListeners();
      })
      .catch((error) => {
        console.error("Error fetching matches:", error);
        matchList.innerHTML = "<tr><td colspan='7'>Error loading matches</td></tr>";
      });
  }

  // Function to fetch teams
  function fetchTeams() {
    fetch(`fetch_teams.php`)
      .then((response) => response.json())
      .then((teams) => {
        homeTeamSelect.innerHTML = "";
        awayTeamSelect.innerHTML = "";

        teams.forEach((team) => {
          homeTeamSelect.innerHTML += `<option value="${team.id}">${team.team_name}</option>`;
          awayTeamSelect.innerHTML += `<option value="${team.id}">${team.team_name}</option>`;
        });
      })
      .catch((error) => {
        console.error("Error fetching teams:", error);
      });
  }

  // Function to reset the form
  function resetForm() {
    matchIdInput.value = "";
    homeTeamSelect.value = "";
    awayTeamSelect.value = "";
    matchDateInput.value = new Date().toISOString().split('T')[0]; // Today's date
    matchTimeInput.value = "";
    matchVenueInput.value = "";
    matchSpectatorsInput.value = "0";
    matchNameInput.value = "";
  }

  // Function to close the modal
  function closeModal() {
    editMatchModal.classList.remove("active");
  }

  // Function to attach event listeners to match action buttons
  function attachMatchActionListeners() {
    // Edit match buttons
    document.querySelectorAll(".edit-match").forEach((button) => {
      button.addEventListener("click", function () {
        const matchId = this.getAttribute("data-id");
        // Fetch match details and populate the form
        // In a real implementation, you would fetch the match details from the server
        modalTitle.textContent = "Edit Match";
        matchIdInput.value = matchId;
        editMatchModal.classList.add("active");
      });
    });

    // Delete match buttons
    document.querySelectorAll(".delete-match").forEach((button) => {
      button.addEventListener("click", function () {
        const matchId = this.getAttribute("data-id");
        if (confirm("Are you sure you want to delete this match?")) {
          // Delete the match by id 
          const matchId = this.getAttribute("data-id");

          const requestData = {match_id: matchId}
          fetch("delete-match.php", {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify(requestData)
          })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                alert("Match deleted successfully!");
                closeModal();
                // fetchMatches(tournamentId);
              } else {
                alert("Error deleting match: " + (data.error || "Unknown error"));
              }
            })
          console.log(`Delete match ${matchId}`);
          const tournamentId = tournamentTitle.getAttribute("data-id");
          console.log(tournamentId);
          fetchMatches(tournamentId);
        }
      });
    });
  }

  // Event listener for the "Add Match" button
  if (addMatchBtn) {
    addMatchBtn.addEventListener("click", () => {
      modalTitle.textContent = "Add Match";
      resetForm();
      fetchTeams();
      editMatchModal.classList.add("active");
    });
  }

  // Event listener for the "Save Match" button
  if (saveMatchBtn) {
    saveMatchBtn.addEventListener("click", () => {
      // Get form values
      const matchId = matchIdInput.value;
      const homeTeam = homeTeamSelect.value;
      const awayTeam = awayTeamSelect.value;
      const matchDate = matchDateInput.value;
      const matchTime = matchTimeInput.value;
      const matchVenue = matchVenueInput.options[matchVenueInput.selectedIndex].text;
      const matchSpectators = matchSpectatorsInput.value;
      const matchName = matchNameInput.value;

      // Get tournament ID from the tournament title
      const tournamentId = tournamentTitle.getAttribute("data-id");

      // Basic validation
      if (!homeTeam || !awayTeam || !matchDate || !matchTime || !matchVenue) {
        alert("Please fill in all required fields");
        return;
      }

      if (homeTeam === awayTeam) {
        alert("Home team and away team cannot be the same");
        return;
      }

      
      const requestData = {
        tournament_id: tournamentId,
        id_equipe1: homeTeam,
        id_equipe2: awayTeam,
        date_match: matchDate,
        time_match: matchTime,
        staduim: matchVenue,
        Nombre_spectateur: matchSpectators,
        Nom_match: matchName
      };

      // If matchId is not empty, we're updating an existing match
      if (matchId) {
        requestData.id_match = matchId;
        // Update match
        // This would be implemented in a real application
        alert("Match update functionality not implemented yet");
        closeModal();
      } else {
        // Add new match
        fetch("add-match.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(requestData)
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert("Match added successfully!");
              closeModal();
              fetchMatches(tournamentId);
            } else {
              alert("Error adding match: " + (data.error || "Unknown error"));
            }
          })
          .catch(error => {
            console.error("Error:", error);
            alert("Failed to add match. Please try again.");
          });
      }
    });
  }

  // Event listeners for closing the modal
  if (cancelEditBtn) {
    cancelEditBtn.addEventListener("click", closeModal);
  }

  if (closeModalBtn) {
    closeModalBtn.addEventListener("click", closeModal);
  }

  // Event listener for "Manage" button in tournaments
  document.querySelectorAll(".manage-tournament").forEach((button) => {
    button.addEventListener("click", () => {
      const tournamentId = button.getAttribute("data-id");
      const tournamentName = button.closest(".tournament-card").querySelector(".card-title").textContent;

      // Set the tournament title and store the tournament ID
      tournamentTitle.textContent = tournamentName;
      tournamentTitle.setAttribute("data-id", tournamentId);

      // Show the manage matches panel
      setActivePanel("manage-matches");

      // Fetch matches for this tournament
      fetchMatches(tournamentId);
    });
  });

  // Navigation
  const navLinks = document.querySelectorAll(".nav-link");
  const panels = document.querySelectorAll(".panel");

  function setActivePanel(targetId) {
    panels.forEach(panel => {
      panel.classList.remove("active");
    });
    document.getElementById(targetId).classList.add("active");

    navLinks.forEach(link => {
      link.classList.remove("active");
    });
    document.querySelector(`.nav-link[data-target="${targetId}"]`).classList.add("active");
  }

  navLinks.forEach(link => {
    link.addEventListener("click", function () {
      const targetId = this.getAttribute("data-target");
      setActivePanel(targetId);
    });
  });

  // Back to tournaments button
  document.getElementById("back-to-tournaments").addEventListener("click", () => {
    setActivePanel("my-tournaments");
  });

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

  // Initialize
  updateCalendar();
  attachMatchActionListeners();
});
