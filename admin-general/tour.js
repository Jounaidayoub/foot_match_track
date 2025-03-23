
document.addEventListener('DOMContentLoaded', function() {
    // Navigation
    const navLinks = document.querySelectorAll('.nav-link');
    const panels = document.querySelectorAll('.panel');
    
    function setActivePanel(targetId) {
        // Hide all panels
        panels.forEach(panel => {
            panel.classList.remove('active');
        });
        
        // Remove active class from all nav links
        navLinks.forEach(link => {
            link.classList.remove('active');
        });
        
        // Show target panel
        document.getElementById(targetId).classList.add('active');
        
        // Set active nav link
        document.querySelector(`.nav-link[data-target="${targetId}"]`).classList.add('active');
    }
    
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            setActivePanel(targetId);
        });
    });
    
    // Create Tournament Button
    document.getElementById('create-tournament-btn').addEventListener('click', function() {
        setActivePanel('create-tournament');
    });
    
    // Cancel Tournament Button
    document.getElementById('cancel-tournament').addEventListener('click', function() {
        document.getElementById('tournament-form').reset();
        setActivePanel('dashboard');
    });
    
    // Team Selection
    const teamSelectionContainer = document.getElementById('team-selection-container');
    const teams = [
        'FC Barcelona', 'Real Madrid', 'Manchester United', 'Liverpool FC',
        'Bayern Munich', 'Paris Saint-Germain', 'Juventus', 'Manchester City',
        'Chelsea', 'Arsenal', 'Atletico Madrid', 'Borussia Dortmund',
        'AC Milan', 'Inter Milan', 'Ajax', 'Porto'
    ];
    
    // Populate team selection
    teams.forEach(team => {
        const teamItem = document.createElement('div');
        teamItem.className = 'team-item';
        teamItem.innerHTML = `
            <div class="team-checkbox"></div>
            <span class="team-name">${team}</span>
        `;
        teamSelectionContainer.appendChild(teamItem);
        
        teamItem.addEventListener('click', function() {
            this.classList.toggle('selected');
        });
    });
    
    // Tournament Form Submission
    document.getElementById('tournament-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const tournamentName = document.getElementById('tournament_name').value;
        const tournamentType = document.getElementById('tournament_type').value;
        const numTeams = document.getElementById('num_teams').value;
        
        // Get selected teams
        const selectedTeams = [];
        document.querySelectorAll('.team-item.selected').forEach(item => {
            selectedTeams.push(item.querySelector('.team-name').textContent);
        });
        
        if (selectedTeams.length < parseInt(numTeams)) {
            alert(`Please select ${numTeams} teams for this tournament.`);
            return;
        }
        
        // Generate bracket
        generateBracket(parseInt(numTeams), selectedTeams);
        
        // Show success message
        alert(`Tournament "${tournamentName}" created successfully!`);
        
        // Reset form and go to bracket view
        this.reset();
        setActivePanel('tournament-brackets');
    });
    
    // Generate Tournament Bracket
    function generateBracket(numTeams, teams) {
        const bracketContainer = document.getElementById('bracket-container');
        bracketContainer.innerHTML = '';
        
        // Calculate number of rounds
        const rounds = Math.log2(numTeams);
        
        // Create rounds
        for (let round = 1; round <= rounds; round++) {
            const roundColumn = document.createElement('div');
            roundColumn.className = 'round-column';
            
            // Set round title
            const roundTitle = document.createElement('div');
            roundTitle.className = 'round-title';
            
            if (round === 1) {
                roundTitle.textContent = 'First Round';
            } else if (round === 2) {
                roundTitle.textContent = 'Quarter Finals';
            } else if (round === 3) {
                roundTitle.textContent = 'Semi Finals';
            } else if (round === rounds) {
                roundTitle.textContent = 'Final';
            } else {
                roundTitle.textContent = `Round ${round}`;
            }
            
            roundColumn.appendChild(roundTitle);
            
            // Calculate matches in this round
            const matchesInRound = numTeams / Math.pow(2, round);
            
            // Create matches
            for (let match = 1; match <= matchesInRound; match++) {
                const matchWrapper = document.createElement('div');
                matchWrapper.className = 'match-wrapper';
                
                const matchCard = document.createElement('div');
                matchCard.className = round === rounds ? 'match-card final' : 'match-card';
                
                // Add teams to first round
                if (round === 1) {
                    const team1Index = (match - 1) * 2;
                    const team2Index = team1Index + 1;
                    
                    const team1 = teams[team1Index] || 'TBD';
                    const team2 = teams[team2Index] || 'TBD';
                    
                    matchCard.innerHTML = `
                        <div class="match-team">
                            <div class="team-info">
                                <div class="team-seed">${team1Index + 1}</div>
                                <div class="team-name">${team1}</div>
                            </div>
                            <div class="team-score">0</div>
                        </div>
                        <div class="match-team">
                            <div class="team-info">
                                <div class="team-seed">${team2Index + 1}</div>
                                <div class="team-name">${team2}</div>
                            </div>
                            <div class="team-score">0</div>
                        </div>
                        <div class="match-date">Dec 10, 2023</div>
                    `;
                } else {
                    // For later rounds, use TBD
                    matchCard.innerHTML = `
                        <div class="match-team">
                            <div class="team-info">
                                <div class="team-seed">-</div>
                                <div class="team-name">TBD</div>
                            </div>
                            <div class="team-score">-</div>
                        </div>
                        <div class="match-team">
                            <div class="team-info">
                                <div class="team-seed">-</div>
                                <div class="team-name">TBD</div>
                            </div>
                            <div class="team-score">-</div>
                        </div>
                        <div class="match-date">TBD</div>
                    `;
                }
                
                matchWrapper.appendChild(matchCard);
                
                // Add connector for all rounds except the final
                if (round < rounds) {
                    const connector = document.createElement('div');
                    connector.className = 'match-connector';
                    matchWrapper.appendChild(connector);
                }
                
                roundColumn.appendChild(matchWrapper);
            }
            
            bracketContainer.appendChild(roundColumn);
        }
        
        // Add champion card after the final
        if (rounds > 0) {
            const finalRound = bracketContainer.lastChild;
            
            const championCard = document.createElement('div');
            championCard.className = 'champion-card';
            championCard.innerHTML = `
                <div class="champion-trophy">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                        <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                        <path d="M4 22h16"></path>
                        <path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path>
                        <path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path>
                        <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                    </svg>
                </div>
                <div class="champion-label">Champion</div>
                <div class="champion-name">TBD</div>
            `;
            
            finalRound.appendChild(championCard);
        }
    }
    
    // Initialize with a sample bracket
    generateBracket(8, teams.slice(0, 8));
});
