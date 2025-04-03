// Football field lineup functionality
addEventListener("DOMContentLoaded", function () {
  let homeTeamId_1 = 1; // Replace with actual home team ID
  let awayTeamId_1 = 2; // Replace with actual away team ID

  let homeTeamPlayers = [];
  let awayTeamPlayers = [];

  let selectedHomePlayers = [];
  let selectedAwayPlayers = [];

  // Function to fetch players for a team
  async function fetchPlayersForTeam(teamId) {
    try {
      const response = await fetch(`get_team_players.php?team_id=${teamId}`);
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      const players = await response.json();
      return players;
    } catch (error) {
      console.error("Could not fetch players:", error);
      return [];
    }
  }
  // fetchPlayersForTeam(8);

  function showPlayerSelectionModal(homeTeamId, awayTeamId) {

    homeTeamId_1=homeTeamId
    awayTeamId_1=awayTeamId

    // Initialize the field with default formation
    initializeTeamPlayers(homeTeamId, awayTeamId).then(() => {
      initFootballField();
    });

    // Create modal
    const modal = document.createElement("div");
    modal.className = "player-selection-modal modal active";

    // Create modal content
    modal.innerHTML = `
      <div class="modal-content">
        <div class="modal-header">
          <h3>Select Players for Match</h3>
          <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="team-tabs">
            <button type="button" class="team-tab active" data-team="home">Home Team</button>
            <button type="button" class="team-tab" data-team="away">Away Team</button>
          </div>
          
          <div class="team-players active" id="home-players-list">
            <div class="player-selection-list">
              ${homeTeamPlayers
                .map(
                  (player) => `
                <div class="player-selection-item">
                  <input type="checkbox" id="home-player-${player.id}" data-player-id="${player.id}" checked>
                  <label for="home-player-${player.id}">
                    <span class="player-number">${player.number}</span>
                    <span class="player-name">${player.full_name}</span>
                    <span class="player-position">${player.position}</span>
                  </label>
                </div>
              `
                )
                .join("")}
            </div>
          </div>
          
          <div class="team-players" id="away-players-list">
            <div class="player-selection-list">
              ${awayTeamPlayers
                .map(
                  (player) => `
                <div class="player-selection-item">
                  <input type="checkbox" id="away-player-${player.id}" data-player-id="${player.id}" checked>
                  <label for="away-player-${player.id}">
                    <span class="player-number">${player.number}</span>
                    <span class="player-name">${player.full_name}</span>
                    <span class="player-position">${player.position}</span>
                  </label>
                </div>
              `
                )
                .join("")}
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" id="confirm-player-selection">Confirm Selection</button>
        </div>
      </div>
    `;

    document.body.appendChild(modal);

    // Add event listeners
    modal.querySelector(".close-modal").addEventListener("click", () => {
      modal.remove();
    });

    // Team tabs functionality
    const teamTabs = modal.querySelectorAll(".team-tab");
    teamTabs.forEach((tab) => {
      tab.addEventListener("click", () => {
        // Remove active class from all tabs
        teamTabs.forEach((t) => t.classList.remove("active"));
        // Add active class to clicked tab
        tab.classList.add("active");

        // Hide all player lists
        modal.querySelectorAll(".team-players").forEach((list) => {
          list.classList.remove("active");
        });

        // Show the selected team's player list
        const team = tab.dataset.team;
        modal.querySelector(`#${team}-players-list`).classList.add("active");
      });
    });

    // Confirm button functionality
    modal
      .querySelector("#confirm-player-selection")
      .addEventListener("click", () => {
        // Get selected home players
        selectedHomePlayers = [];
        modal
          .querySelectorAll("#home-players-list input:checked")
          .forEach((checkbox) => {
            const playerId = checkbox.dataset.playerId;
            const player = homeTeamPlayers.find((p) => p.id == playerId);
            if (player) {
              selectedHomePlayers.push(player);
            }
          });

        // Get selected away players
        selectedAwayPlayers = [];
        modal
          .querySelectorAll("#away-players-list input:checked")
          .forEach((checkbox) => {
            const playerId = checkbox.dataset.playerId;
            const player = awayTeamPlayers.find((p) => p.id == playerId);
            if (player) {
              selectedAwayPlayers.push(player);
            }
          });

        // Close modal
        modal.remove();

        // Initialize football field
        initFootballField();
      });
  }

  window.showPlayerSelectionModal = showPlayerSelectionModal;

  //   const matchCards = document.querySelectorAll(".match-card");
  //     matchCards.forEach((card) => {

  //     })

  // module.exports = {
  //   fun: showPlayerSelectionModal,
  // };

  // Initialize team players
  async function initializeTeamPlayers(homeTeamId, awayTeamId) {
    // Replace '1' and '2' with the actual team IDs you want to fetch
    homeTeamPlayers = await fetchPlayersForTeam(homeTeamId);
    awayTeamPlayers = await fetchPlayersForTeam(awayTeamId);

    selectedAwayPlayers = [...awayTeamPlayers];
    selectedHomePlayers = [...homeTeamPlayers];

    console.log("Home Team Players:", homeTeamPlayers);
    console.log("Away Team Players:", awayTeamPlayers);

    // showPlayerSelectionModal();
    // console.log(homeTeamPlayers[0].full_name);
  }

  //   const matchCards = document.querySelectorAll(".match-card");
  //   //   console.log("aw")
  //   console.log("macth cards" + matchCards);
  //   matchCards.forEach((card) => {
  //     const matchId = card.getAttribute("data-match-id");
  //     console.log("match iasddddddddd" + matchId);
  //     console.log("card" + card);
  //   })
  const matchCards = document.querySelectorAll(".match-card");
  matchCards.forEach((card) => {
    console.log(card);
  });
  // Formation positions
  const formations = {
    "4-3-3": [
      { id: "gk", label: "GK", x: 50, y: 90, position: "GK" },
      { id: "rb", label: "RB", x: 80, y: 75, position: "RB" },
      { id: "rcb", label: "CB", x: 65, y: 75, position: "CB" },
      { id: "lcb", label: "CB", x: 35, y: 75, position: "CB" },
      { id: "lb", label: "LB", x: 20, y: 75, position: "LB" },
      { id: "rcm", label: "CM", x: 65, y: 55, position: "CM" },
      { id: "cdm", label: "CDM", x: 50, y: 55, position: "CDM" },
      { id: "lcm", label: "CM", x: 35, y: 55, position: "CM" },
      { id: "rw", label: "RW", x: 80, y: 30, position: "RW" },
      { id: "st", label: "ST", x: 50, y: 30, position: "ST" },
      { id: "lw", label: "LW", x: 20, y: 30, position: "LW" },
    ],
    "4-4-2": [
      { id: "gk", label: "GK", x: 50, y: 90, position: "GK" },
      { id: "rb", label: "RB", x: 80, y: 75, position: "RB" },
      { id: "rcb", label: "CB", x: 65, y: 75, position: "CB" },
      { id: "lcb", label: "CB", x: 35, y: 75, position: "CB" },
      { id: "lb", label: "LB", x: 20, y: 75, position: "LB" },
      { id: "rm", label: "RM", x: 80, y: 50, position: "RM" },
      { id: "rcm", label: "CM", x: 65, y: 50, position: "CM" },
      { id: "lcm", label: "CM", x: 35, y: 50, position: "CM" },
      { id: "lm", label: "LM", x: 20, y: 50, position: "LM" },
      { id: "rst", label: "ST", x: 65, y: 25, position: "ST" },
      { id: "lst", label: "ST", x: 35, y: 25, position: "ST" },
    ],
    "4-2-3-1": [
      { id: "gk", label: "GK", x: 50, y: 90, position: "GK" },
      { id: "rb", label: "RB", x: 80, y: 75, position: "RB" },
      { id: "rcb", label: "CB", x: 65, y: 75, position: "CB" },
      { id: "lcb", label: "CB", x: 35, y: 75, position: "CB" },
      { id: "lb", label: "LB", x: 20, y: 75, position: "LB" },
      { id: "rcdm", label: "CDM", x: 65, y: 60, position: "CDM" },
      { id: "lcdm", label: "CDM", x: 35, y: 60, position: "CDM" },
      { id: "ram", label: "RAM", x: 75, y: 40, position: "CAM" },
      { id: "cam", label: "CAM", x: 50, y: 40, position: "CAM" },
      { id: "lam", label: "LAM", x: 25, y: 40, position: "CAM" },
      { id: "st", label: "ST", x: 50, y: 20, position: "ST" },
    ],
    "3-5-2": [
      { id: "gk", label: "GK", x: 50, y: 90, position: "GK" },
      { id: "rcb", label: "CB", x: 70, y: 75, position: "CB" },
      { id: "cb", label: "CB", x: 50, y: 75, position: "CB" },
      { id: "lcb", label: "CB", x: 30, y: 75, position: "CB" },
      { id: "rwb", label: "RWB", x: 85, y: 60, position: "RWB" },
      { id: "rcm", label: "CM", x: 65, y: 55, position: "CM" },
      { id: "cdm", label: "CDM", x: 50, y: 55, position: "CDM" },
      { id: "lcm", label: "CM", x: 35, y: 55, position: "CM" },
      { id: "lwb", label: "LWB", x: 15, y: 60, position: "LWB" },
      { id: "rst", label: "ST", x: 65, y: 25, position: "ST" },
      { id: "lst", label: "ST", x: 35, y: 25, position: "ST" },
    ],
    "5-3-2": [
      { id: "gk", label: "GK", x: 50, y: 90, position: "GK" },
      { id: "rwb", label: "RWB", x: 85, y: 70, position: "RWB" },
      { id: "rcb", label: "CB", x: 70, y: 75, position: "CB" },
      { id: "cb", label: "CB", x: 50, y: 75, position: "CB" },
      { id: "lcb", label: "CB", x: 30, y: 75, position: "CB" },
      { id: "lwb", label: "LWB", x: 15, y: 70, position: "LWB" },
      { id: "rcm", label: "CM", x: 65, y: 50, position: "CM" },
      { id: "cdm", label: "CDM", x: 50, y: 50, position: "CDM" },
      { id: "lcm", label: "CM", x: 35, y: 50, position: "CM" },
      { id: "rst", label: "ST", x: 65, y: 25, position: "ST" },
      { id: "lst", label: "ST", x: 35, y: 25, position: "ST" },
    ],
  };

  // Initialize the football field
  function initFootballField() {
    const formationSelect = document.getElementById("formation-select");
    const homeField = document.querySelector("#home-lineup .football-field");
    const awayField = document.querySelector("#away-lineup .football-field");

    // Clear existing positions
    const existingPositions = document.querySelectorAll(".player-position");
    existingPositions.forEach((pos) => pos.remove());

    // Get selected formation
    const formation = formationSelect.value;
    const positions = formations[formation];

    // Create positions for home team
    positions.forEach((pos) => {
      const positionElement = document.createElement("div");
      positionElement.className = "player-position";
      positionElement.dataset.position = pos.position;
      positionElement.dataset.positionId = pos.id;
      positionElement.dataset.team = "home";
      positionElement.style.left = `${pos.x}%`;
      positionElement.style.top = `${pos.y}%`;
      positionElement.textContent = pos.label;

      positionElement.addEventListener("click", selectPosition);

      homeField.appendChild(positionElement);
    });

    // Create positions for away team (mirror the positions)
    positions.forEach((pos) => {
      const positionElement = document.createElement("div");
      positionElement.className = "player-position";
      positionElement.dataset.position = pos.position;
      positionElement.dataset.positionId = pos.id;
      positionElement.dataset.team = "away";
      positionElement.style.left = `${pos.x}%`;
      // Mirror vertically for away team
      positionElement.style.top = `${100 - pos.y}%`;
      positionElement.textContent = pos.label;

      positionElement.addEventListener("click", selectPosition);

      awayField.appendChild(positionElement);
    });
  }

  // Handle position selection
  function selectPosition() {
    console.log("Position selected:", this.dataset.positionId);
    // Remove selected class from all positions
    document.querySelectorAll(".player-position").forEach((pos) => {
      pos.classList.remove("selected");
    });

    // Add selected class to clicked position
    this.classList.add("selected");

    // Get position data
    const positionId = this.dataset.positionId;
    const positionType = this.dataset.position;
    const team = this.dataset.team;

    // Show player selector
    const selector = document.querySelector(`#${team}-lineup .player-selector`);
    selector.classList.add("active");

    // Filter players by position
    const players = team === "home" ? selectedHomePlayers : selectedAwayPlayers;
    players.forEach((player) => {
      console.log(player.full_name + " " + player.position + " ");
    });
    const filteredPlayers = players.filter((player) => {
      // Map API positions to formation positions
      let apiPosition = player.position;
      let formationPosition = positionType;

      // Handle GK
      if (formationPosition === "GK" && apiPosition === "Goalkeeper")
        return true;

      // Handle Defenders
      if (
        ["RB", "CB", "LB", "RWB", "LWB"].includes(formationPosition) &&
        apiPosition === "Defender"
      )
        return true;

      // Handle Midfielders
      if (
        ["CM", "CDM", "CAM", "RM", "LM"].includes(formationPosition) &&
        apiPosition === "Midfielder"
      )
        return true;

      // Handle Attackers
      if (
        ["ST", "RW", "LW", "CF"].includes(formationPosition) &&
        apiPosition === "Attacker"
      )
        return true;

      return false;
    });

    // Populate player list
    const playerList = selector.querySelector(".player-list");
    playerList.innerHTML = "";

    filteredPlayers.forEach((player) => {
      console.log("this is " + player);
      const playerItem = document.createElement("div");
      playerItem.className = "player-list-item";
      playerItem.dataset.playerId = player.id;
      playerItem.innerHTML = `
                <div class="player-list-item-number">${player.number}</div>
                <div class="player-list-item-info">
                    <div class="player-list-item-name">${player.full_name}</div>
                    <div class="player-list-item-position">${player.position}</div>
                </div>
                <div class="player-list-item-rating">${player.rating}</div>
            `;

      playerItem.addEventListener("click", () => {
        assignPlayerToPosition(player, positionId, team);
        selector.classList.remove("active");
      });

      playerList.appendChild(playerItem);
    });
  }

  // Assign player to position
  function assignPlayerToPosition(player, positionId, team) {
    const position = document.querySelector(
      `#${team}-lineup .player-position[data-position-id="${positionId}"]`
    );

    // Mark position as filled
    position.classList.add("filled");
    position.classList.remove("selected");

    // Store player data
    position.dataset.playerId = player.id;
    position.dataset.playerName = player.name;
    position.dataset.playerNumber = player.number;
    position.dataset.playerRating = player.rating;

    // Update position display
    position.textContent = player.number;

    // Add player info
    const playerInfo = document.createElement("div");
    playerInfo.className = "player-info";
    playerInfo.textContent = player.name;
    position.appendChild(playerInfo);

    // Add player rating
    const playerRating = document.createElement("div");
    playerRating.className = "player-rating";
    playerRating.textContent = player.rating;
    position.appendChild(playerRating);
  }

  // Close player selector
  const closeSelectors = document.querySelectorAll(".close-selector");
  closeSelectors.forEach((button) => {
    button.addEventListener("click", function () {
      const selector = this.closest(".player-selector");
      selector.classList.remove("active");

      // Remove selected class from all positions
      document.querySelectorAll(".player-position").forEach((pos) => {
        pos.classList.remove("selected");
      });
    });
  });

  // Formation change handler
  const formationSelect = document.getElementById("formation-select");
  formationSelect.addEventListener("change", initFootballField);

  // Initialize the field with default formation
  // initializeTeamPlayers().then(() => {
  //   initFootballField();
  // });

  // Add this near the bottom of your DOMContentLoaded event listener

  // Save Lineup functionality
  document
    .getElementById("save-lineup-btn")
    ?.addEventListener("click", function () {
      // Get the match details from the modal
      const matchDetailsModal = document.getElementById("match-details-modal");
      const matchId =
        matchDetailsModal.dataset.matchId ||
        document.getElementById("detail-match-id").value;
      const homeTeamId = matchDetailsModal.dataset.homeTeamId;
      const awayTeamId = matchDetailsModal.dataset.awayTeamId;

      // Get the selected formation
      const formationSelect = document.getElementById("formation-select");
      const formation = formationSelect.value;

      // Collect home lineup data
      const homeLineup = {};
      document
        .querySelectorAll("#home-lineup .player-position.filled")
        .forEach((position) => {
          const positionId = position.dataset.positionId;
          const playerId = position.dataset.playerId;
          if (positionId && playerId) {
            homeLineup[positionId] = playerId;
          }
        });

      // Collect away lineup data
      const awayLineup = {};
      document
        .querySelectorAll("#away-lineup .player-position.filled")
        .forEach((position) => {
          const positionId = position.dataset.positionId;
          const playerId = position.dataset.playerId;
          if (positionId && playerId) {
            awayLineup[positionId] = playerId;
          }
        });

      // Check if lineups are complete
      // if (Object.keys(homeLineup).length === 0 || Object.keys(awayLineup).length === 0) {
      //   alert("Please complete both team lineups before saving.");
      //   return;
      // }

      // Prepare data for submission
      const data = {
        match_id: matchId,
        home_team_id: homeTeamId_1,
        away_team_id: awayTeamId_1,
        formation: formation,
        home_lineup: homeLineup,
        away_lineup: awayLineup,
      };

      console.log("Saving lineup data:", data);

      // Send data to server
      fetch("save_lineup.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      })
        .then((response) => response.json())
        .then((result) => {
          if (result.success) {
            alert("Lineup saved successfully!");
          } else {
            alert("Error saving lineup: " + result.message);
          }
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("An error occurred while saving the lineup.");
        });
    });
});
