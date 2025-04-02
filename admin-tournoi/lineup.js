// Football field lineup functionality
document.addEventListener("DOMContentLoaded", () => {
    // Sample player data - in a real app, this would come from your database
    const samplePlayers = [
        { id: 1, name: "David De Gea", number: 1, position: "GK", rating: 7.5 },
        { id: 2, name: "Trent Alexander-Arnold", number: 2, position: "RB", rating: 8.1 },
        { id: 3, name: "Virgil van Dijk", number: 4, position: "CB", rating: 8.4 },
        { id: 4, name: "Raphael Varane", number: 5, position: "CB", rating: 7.9 },
        { id: 5, name: "Andrew Robertson", number: 3, position: "LB", rating: 8.0 },
        { id: 6, name: "Casemiro", number: 6, position: "CDM", rating: 7.8 },
        { id: 7, name: "Kevin De Bruyne", number: 7, position: "CM", rating: 8.7 },
        { id: 8, name: "Bruno Fernandes", number: 8, position: "CAM", rating: 8.2 },
        { id: 9, name: "Mohamed Salah", number: 11, position: "RW", rating: 8.9 },
        { id: 10, name: "Harry Kane", number: 9, position: "ST", rating: 8.5 },
        { id: 11, name: "Kylian Mbappé", number: 10, position: "LW", rating: 8.8 },
        { id: 12, name: "Ederson", number: 31, position: "GK", rating: 7.6 },
        { id: 13, name: "Kyle Walker", number: 2, position: "RB", rating: 7.7 },
        { id: 14, name: "Ruben Dias", number: 3, position: "CB", rating: 8.2 },
        { id: 15, name: "John Stones", number: 5, position: "CB", rating: 7.5 },
        { id: 16, name: "Joao Cancelo", number: 7, position: "LB", rating: 7.9 },
    ];

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
            { id: "lw", label: "LW", x: 20, y: 30, position: "LW" }
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
            { id: "lst", label: "ST", x: 35, y: 25, position: "ST" }
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
            { id: "st", label: "ST", x: 50, y: 20, position: "ST" }
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
            { id: "lst", label: "ST", x: 35, y: 25, position: "ST" }
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
            { id: "lst", label: "ST", x: 35, y: 25, position: "ST" }
        ]
    };

    // Initialize the football field
    function initFootballField() {
        const formationSelect = document.getElementById('formation-select');
        const homeField = document.querySelector('#home-lineup .football-field');
        const awayField = document.querySelector('#away-lineup .football-field');
        
        // Clear existing positions
        const existingPositions = document.querySelectorAll('.player-position');
        existingPositions.forEach(pos => pos.remove());
        
        // Get selected formation
        const formation = formationSelect.value;
        const positions = formations[formation];
        
        // Create positions for home team
        positions.forEach(pos => {
            const positionElement = document.createElement('div');
            positionElement.className = 'player-position';
            positionElement.dataset.position = pos.position;
            positionElement.dataset.positionId = pos.id;
            positionElement.dataset.team = 'home';
            positionElement.style.left = `${pos.x}%`;
            positionElement.style.top = `${pos.y}%`;
            positionElement.textContent = pos.label;
            
            positionElement.addEventListener('click', selectPosition);
            
            homeField.appendChild(positionElement);
        });
        
        // Create positions for away team (mirror the positions)
        positions.forEach(pos => {
            const positionElement = document.createElement('div');
            positionElement.className = 'player-position';
            positionElement.dataset.position = pos.position;
            positionElement.dataset.positionId = pos.id;
            positionElement.dataset.team = 'away';
            positionElement.style.left = `${pos.x}%`;
            // Mirror vertically for away team
            positionElement.style.top = `${100 - pos.y}%`;
            positionElement.textContent = pos.label;
            
            positionElement.addEventListener('click', selectPosition);
            
            awayField.appendChild(positionElement);
        });
    }

    // Handle position selection
    function selectPosition() {
        // Remove selected class from all positions
        document.querySelectorAll('.player-position').forEach(pos => {
            pos.classList.remove('selected');
        });
        
        // Add selected class to clicked position
        this.classList.add('selected');
        
        // Get position data
        const positionId = this.dataset.positionId;
        const positionType = this.dataset.position;
        const team = this.dataset.team;
        
        // Show player selector
        const selector = document.querySelector(`#${team}-lineup .player-selector`);
        selector.classList.add('active');
        
        // Filter players by position
        const filteredPlayers = samplePlayers.filter(player => {
            // Match exact position or similar positions
            if (player.position === positionType) return true;
            
            // Group similar positions
            if (positionType === 'CB' && ['CB', 'RCB', 'LCB'].includes(player.position)) return true;
            if (positionType === 'CM' && ['CM', 'RCM', 'LCM'].includes(player.position)) return true;
            if (positionType === 'CDM' && ['CDM', 'CM', 'DM'].includes(player.position)) return true;
            if (positionType === 'CAM' && ['CAM', 'AM', 'RAM', 'LAM'].includes(player.position)) return true;
            if (positionType === 'ST' && ['ST', 'CF', 'FW'].includes(player.position)) return true;
            
            return false;
        });
        
        // Populate player list
        const playerList = selector.querySelector('.player-list');
        playerList.innerHTML = '';
        
        filteredPlayers.forEach(player => {
            const playerItem = document.createElement('div');
            playerItem.className = 'player-list-item';
            playerItem.dataset.playerId = player.id;
            playerItem.innerHTML = `
                <div class="player-list-item-number">${player.number}</div>
                <div class="player-list-item-info">
                    <div class="player-list-item-name">${player.name}</div>
                    <div class="player-list-item-position">${player.position}</div>
                </div>
                <div class="player-list-item-rating">${player.rating}</div>
            `;
            
            playerItem.addEventListener('click', () => {
                assignPlayerToPosition(player, positionId, team);
                selector.classList.remove('active');
            });
            
            playerList.appendChild(playerItem);
        });
    }

    // Assign player to position
    function assignPlayerToPosition(player, positionId, team) {
        const position = document.querySelector(`#${team}-lineup .player-position[data-position-id="${positionId}"]`);
        
        // Mark position as filled
        position.classList.add('filled');
        position.classList.remove('selected');
        
        // Store player data
        position.dataset.playerId = player.id;
        position.dataset.playerName = player.name;
        position.dataset.playerNumber = player.number;
        position.dataset.playerRating = player.rating;
        
        // Update position display
        position.textContent = player.number;
        
        // Add player info
        const playerInfo = document.createElement('div');
        playerInfo.className = 'player-info';
        playerInfo.textContent = player.name;
        position.appendChild(playerInfo);
        
        // Add player rating
        const playerRating = document.createElement('div');
        playerRating.className = 'player-rating';
        playerRating.textContent = player.rating;
        position.appendChild(playerRating);
    }

    // Close player selector
    const closeSelectors = document.querySelectorAll('.close-selector');
    closeSelectors.forEach(button => {
        button.addEventListener('click', function() {
            const selector = this.closest('.player-selector');
            selector.classList.remove('active');
            
            // Remove selected class from all positions
            document.querySelectorAll('.player-position').forEach(pos => {
                pos.classList.remove('selected');
            });
        });
    });

    // Formation change handler
    const formationSelect = document.getElementById('formation-select');
    formationSelect.addEventListener('change', initFootballField);

    // Initialize the field with default formation
    initFootballField();
});