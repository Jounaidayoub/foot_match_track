document.addEventListener("DOMContentLoaded", () => {
  // Tab Navigation (keep existing functionality)
  const tabButtons = document.querySelectorAll(".tab-btn");
  const tabContents = document.querySelectorAll(".tab-content");

  tabButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const target = button.getAttribute("data-tab");

      // Remove active class from all buttons and contents
      tabButtons.forEach((btn) => btn.classList.remove("active"));
      tabContents.forEach((content) => content.classList.remove("active"));

      // Add active class to clicked button and corresponding content
      button.classList.add("active");
      document.getElementById(target).classList.add("active");
    });
  });

  // Team Tabs for Lineups (keep existing functionality)
  const teamTabs = document.querySelectorAll(".team-tab");
  const teamLineups = document.querySelectorAll(".team-lineup");

  teamTabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      const team = tab.getAttribute("data-team");

      // Remove active class from all tabs and lineups
      teamTabs.forEach((t) => t.classList.remove("active"));
      teamLineups.forEach((lineup) => lineup.classList.remove("active"));

      // Add active class to clicked tab and corresponding lineup
      tab.classList.add("active");
      document.querySelector(`.team-lineup[data-team="${team}"]`).classList.add("active");
    });
  });

  // NEW CODE: Fetch and display match data
  loadMatchData();
});

/**
 * Extracts URL parameters
 * @returns {Object} Object containing URL parameters
 */
function getUrlParams() {
  const params = {};
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  
  for (const [key, value] of urlParams.entries()) {
    params[key] = value;
  }
  
  return params;
}

/**
 * Format a date and time for display
 * @param {string} dateStr - Date string in YYYY-MM-DD format
 * @param {string} timeStr - Time string in HH:MM:SS format
 * @returns {string} Formatted date string
 */
function formatMatchDate(dateStr, timeStr) {
  const options = { weekday: 'short', month: 'long', day: 'numeric' };
  const date = new Date(`${dateStr}T${timeStr}`);
  
  const dayMonth = date.toLocaleDateString('en-US', options);
  const time = date.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
  
  return `${dayMonth}, ${time}`;
}

/**
 * Main function to load all match data
 */
async function loadMatchData() {
  const params = getUrlParams();
  const matchId = params.match_id;
  
  if (!matchId) {
    console.error("No match ID provided");
    return;
  }

  try {
    // Fetch all matches to get the basic match data
    const matchesResponse = await fetch('../admin-tournoi/fetch-matches.php?tournament_id=1');
    if (!matchesResponse.ok) throw new Error('Error fetching matches');
    const matches = await matchesResponse.json();
    
    // Find the specific match by ID
    const match = matches.find(m => m.id_match === matchId || m.id_match === parseInt(matchId));
    if (!match) {
      console.error(`Match with ID ${matchId} not found`);
      return;
    }

    // Fetch additional match data
    const [referees, goals, stats] = await Promise.all([
      fetchReferees(matchId),
      fetchGoals(matchId),
      fetchStats(matchId)
    ]);

    // Update the UI with the fetched data
    updateMatchHeader(match);
    updateMatchInfo(match, referees);
    updateMatchScore(match);
    updateMatchGoals(goals);
    updateMatchStats(stats);
    updateSidebarMatches(matches, matchId);

  } catch (error) {
    console.error("Error loading match data:", error);
  }
}

/**
 * Fetch match referees
 * @param {number} matchId - Match ID
 * @returns {Promise<Object>} - Match referees data
 */
async function fetchReferees(matchId) {
  try {
    const response = await fetch(`../admin-tournoi/get_match_referees.php?match_id=${matchId}`);
    if (!response.ok) throw new Error('Error fetching referees');
    return await response.json();
  } catch (error) {
    console.error("Error fetching referees:", error);
    return { referees: { main_referee: 'N/A', assistant1: 'N/A', assistant2: 'N/A' } };
  }
}

/**
 * Fetch match goals
 * @param {number} matchId - Match ID
 * @returns {Promise<Object>} - Match goals data
 */
async function fetchGoals(matchId) {
  try {
    const response = await fetch(`../admin-tournoi/get_goals.php?match_id=${matchId}`);
    if (!response.ok) throw new Error('Error fetching goals');
    return await response.json();
  } catch (error) {
    console.error("Error fetching goals:", error);
    return { home: [], away: [] };
  }
}

/**
 * Fetch match stats
 * @param {number} matchId - Match ID
 * @returns {Promise<Object>} - Match stats data
 */
async function fetchStats(matchId) {
  try {
    const response = await fetch(`../admin-tournoi/get_stats.php?match_id=${matchId}`);
    if (!response.ok) throw new Error('Error fetching stats');
    return await response.json();
  } catch (error) {
    console.error("Error fetching stats:", error);
    return {
      home_possession: 50, away_possession: 50,
      home_shots: 0, away_shots: 0,
      home_shots_on_target: 0, away_shots_on_target: 0,
      home_corners: 0, away_corners: 0,
      home_fouls: 0, away_fouls: 0
    };
  }
}

/**
 * Update the match header section with tournament info
 * @param {Object} match - Match data
 */
function updateMatchHeader(match) {
  const competitionName = document.querySelector(".competition span");
  competitionName.textContent = `${match.Nom_match || 'Tournament'} Round ${match.round || ''}`;
  
  // You could also update the logo if available
  // const competitionLogo = document.querySelector(".competition-logo img");
  // if (match.tournament_logo) competitionLogo.src = match.tournament_logo;
}

/**
 * Update the match info section with date, venue, etc.
 * @param {Object} match - Match data
 * @param {Object} referees - Referees data
 */
function updateMatchInfo(match, refereesData) {
  const details = document.querySelectorAll('.match-details .detail');
  
  // Date
  if (details[0]) {
    const dateElement = details[0].querySelector('span');
    dateElement.textContent = formatMatchDate(match.date_match, match.time_match);
  }
  
  // Venue
  if (details[1]) {
    const venueElement = details[1].querySelector('span');
    venueElement.textContent = match.staduim || 'TBD';
  }
  
  // Referee
  if (details[2] && refereesData.referees) {
    const refereeElement = details[2].querySelector('span');
    refereeElement.textContent = refereesData.referees.main_referee || 'TBD';
  }
  
  // Spectator count
  if (details[3]) {
    const spectatorElement = details[3].querySelector('span');
    spectatorElement.textContent = match.Nombre_spectateur || '0';
  }
}

/**
 * Update the match score section with team names, logos, and score
 * @param {Object} match - Match data
 */
function updateMatchScore(match) {
  // Home team
  const homeTeamName = document.querySelector('.home-team .team-name');
  const homeTeamLogo = document.querySelector('.home-team .team-logo img');
  homeTeamName.textContent = match.home_team || 'Home Team';
  if (match.home_team_logo) homeTeamLogo.src = `../assets/${match.home_team_logo}`;
  
  // Away team
  const awayTeamName = document.querySelector('.away-team .team-name');
  const awayTeamLogo = document.querySelector('.away-team .team-logo img');
  awayTeamName.textContent = match.away_team || 'Away Team';
  if (match.away_team_logo) awayTeamLogo.src = `../assets/${match.away_team_logo}`;
  
  // Score and status
  const scoreElement = document.querySelector('.score-display .score');
  const statusElement = document.querySelector('.score-display .match-status');
  
  // For completed matches, show actual score; for others show vs
  if (match.status === 'completed') {
    scoreElement.textContent = `${match.home_score || 0} - ${match.away_score || 0}`;
    statusElement.textContent = 'Full time';
  } else if (match.status === 'in-progress') {
    scoreElement.textContent = `${match.home_score || 0} - ${match.away_score || 0}`;
    statusElement.textContent = 'Live';
  } else {
    scoreElement.textContent = 'vs';
    statusElement.textContent = 'Upcoming';
  }
}

/**
 * Update the goal scorers section
 * @param {Object} goals - Goals data with home and away arrays
 */
function updateMatchGoals(goals) {
  const homeScorersElement = document.querySelector('.home-scorers');
  const awayScorersElement = document.querySelector('.away-scorers');
  
  // Clear existing scorers
  homeScorersElement.innerHTML = '';
  awayScorersElement.innerHTML = '';
  
  // Add home team scorers
  if (goals.home && goals.home.length > 0) {
    goals.home.forEach(goal => {
      const scorerElement = document.createElement('div');
      scorerElement.className = 'scorer';
      
      const goalTypeText = goal.goal_type ? ` (${goal.goal_type})` : '';
      scorerElement.innerHTML = `<span class="player">${goal.scorer_name} ${goal.goal_time}'${goalTypeText}</span>`;
      
      homeScorersElement.appendChild(scorerElement);
    });
  }
  
  // Add away team scorers
  if (goals.away && goals.away.length > 0) {
    goals.away.forEach(goal => {
      const scorerElement = document.createElement('div');
      scorerElement.className = 'scorer';
      
      const goalTypeText = goal.goal_type ? ` (${goal.goal_type})` : '';
      scorerElement.innerHTML = `<span class="player">${goal.scorer_name} ${goal.goal_time}'${goalTypeText}</span>`;
      
      awayScorersElement.appendChild(scorerElement);
    });
  }
}

/**
 * Update the match stats section
 * @param {Object} stats - Match statistics
 */
function updateMatchStats(stats) {
  // Possession
  const possessionHomeBar = document.querySelector('.stat-item:nth-child(1) .home-bar');
  const possessionHomeValue = possessionHomeBar.querySelector('.stat-value');
  const possessionAwayBar = document.querySelector('.stat-item:nth-child(1) .away-bar');
  const possessionAwayValue = possessionAwayBar.querySelector('.stat-value');
  
  possessionHomeBar.style.width = `${stats.home_possession || 50}%`;
  possessionHomeValue.textContent = `${stats.home_possession || 50}%`;
  possessionAwayBar.style.width = `${stats.away_possession || 50}%`;
  possessionAwayValue.textContent = `${stats.away_possession || 50}%`;
  
  // Expected goals
  const xgHomeValue = document.querySelector('.stat-item:nth-child(2) .home-value');
  const xgAwayValue = document.querySelector('.stat-item:nth-child(2) .away-value');
  
  xgHomeValue.textContent = stats.home_xg || '0.00';
  xgAwayValue.textContent = stats.away_xg || '0.00';
  
  // Total shots
  const shotsHomeValue = document.querySelector('.stat-item:nth-child(3) .home-value');
  const shotsAwayValue = document.querySelector('.stat-item:nth-child(3) .away-value');
  
  shotsHomeValue.textContent = stats.home_shots || '0';
  shotsAwayValue.textContent = stats.away_shots || '0';
  
  // Big chances
  const chancesHomeValue = document.querySelector('.stat-item:nth-child(4) .home-value');
  const chancesAwayValue = document.querySelector('.stat-item:nth-child(4) .away-value');
  
  chancesHomeValue.textContent = stats.home_big_chances || '0';
  chancesAwayValue.textContent = stats.away_big_chances || '0';
}

/**
 * Update the sidebar with other matches from the tournament
 * @param {Array} matches - All matches data
 * @param {number} currentMatchId - Current match ID to highlight
 */
function updateSidebarMatches(matches, currentMatchId) {
  const matchList = document.querySelector('.sidebar .match-list');
  if (!matchList) return;
  
  // Clear existing matches
  matchList.innerHTML = '';
  
  // Add matches to the sidebar
  matches.forEach(match => {
    const isCurrentMatch = match.id_match === parseInt(currentMatchId);
    const matchItem = document.createElement('div');
    matchItem.className = `match-item${isCurrentMatch ? ' highlighted' : ''}`;
    
    if (match.status === 'scheduled' || match.status === 'upcoming') {
      // Upcoming match
      matchItem.classList.add('upcoming');
      matchItem.innerHTML = `
        <div class="match-teams">
            <div class="team">
                <img src="../assets/${match.home_team_logo}" alt="${match.home_team}">
                <span>${match.home_team}</span>
            </div>
        </div>
        <div class="match-teams">
            <div class="team">
                <img src="../assets/${match.away_team_logo}" alt="${match.away_team}">
                <span>${match.away_team}</span>
            </div>
        </div>
        <div class="match-time">
            <div>${new Date(match.date_match).toLocaleDateString('en-US', {month: 'short', day: 'numeric'})}</div>
            <div>${new Date(`2000-01-01T${match.time_match}`).toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit'})}</div>
        </div>
      `;
    } else {
      // Completed or in-progress match
      matchItem.innerHTML = `
        <div class="match-teams">
            <div class="team">
                <img src="../assets/${match.home_team_logo}" alt="${match.home_team}">
                <span>${match.home_team}</span>
            </div>
            <div class="match-result">
                <span>${match.home_score || 0}</span>
            </div>
        </div>
        <div class="match-teams">
            <div class="team">
                <img src="../assets/${match.away_team_logo}" alt="${match.away_team}">
                <span>${match.away_team}</span>
            </div>
            <div class="match-result">
                <span>${match.away_score || 0}</span>
            </div>
        </div>
        <div class="match-status">${match.status === 'in-progress' ? 'LIVE' : 'FT'}</div>
      `;
    }
    
    // Make each match item clickable to navigate to that match
    matchItem.style.cursor = 'pointer';
    matchItem.addEventListener('click', () => {
      if (match.id_match !== parseInt(currentMatchId)) {
        window.location.href = `match-details.php?match_id=${match.id_match}`;
      }
    });
    
    matchList.appendChild(matchItem);
  });
}