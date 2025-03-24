  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }
    
    /* body {
      background-color: #121212;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding: 40px 20px;
    } */
    
    .search-container {
      position: relative;
      width: 100%;
      max-width: 500px;
    }
    
    .search-bar {
      width: 100%;
      height: 50px;
      background-color: #222;
      border-radius: 25px;
      display: flex;
      align-items: center;
      padding: 0 15px;
      cursor: pointer;
      transition: all 0.3s ease;
      border: 1px solid #333;
      position: relative;
      z-index: 2;
    }
    
    .search-bar.active {
      border-radius: 20px 20px 0 0;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .search-icon {
      width: 24px;
      height: 24px;
      margin-right: 10px;
      opacity: 0.7;
    }
    
    .search-input {
      flex: 1;
      background-color: transparent;
      border: none;
      color: #fff;
      font-size: 16px;
      outline: none;
      caret-color: #fff;
    }
    
    .search-input::placeholder {
      color: #888;
    }
    
    .clear-button {
      width: 20px;
      height: 20px;
      opacity: 0;
      cursor: pointer;
      transition: opacity 0.2s ease;
      background: none;
      border: none;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .clear-button.visible {
      opacity: 0.7;
    }
    
    .clear-button:hover {
      opacity: 1;
    }
    
    .search-results {
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      background-color: #222;
      border-radius: 0 0 20px 20px;
      overflow: hidden;
      max-height: 0;
      transition: max-height 0.3s ease, opacity 0.3s ease;
      opacity: 0;
      z-index: 1;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      border: 1px solid #333;
      border-top: none;
    }
    
    .search-results.visible {
      max-height: 500px;
      opacity: 1;
    }
    
    .filter-section {
      display: flex;
      overflow-x: auto;
      padding: 15px;
      gap: 8px;
      border-bottom: 1px solid #333;
      scrollbar-width: none;
    }
    
    .filter-section::-webkit-scrollbar {
      display: none;
    }
    
    .filter-button {
      padding: 8px 16px;
      border-radius: 100px;
      font-size: 14px;
      cursor: pointer;
      white-space: nowrap;
      transition: all 0.2s ease;
      border: none;
      background-color: #333;
      color: #fff;
    }
    
    .filter-button.active {
      background-color: #fff;
      color: #000;
    }
    
    .results-section {
      padding: 10px 0;
      max-height: 400px;
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: #555 #222;
    }
    
    .results-section::-webkit-scrollbar {
      width: 6px;
    }
    
    .results-section::-webkit-scrollbar-track {
      background: #222;
    }
    
    .results-section::-webkit-scrollbar-thumb {
      background-color: #555;
      border-radius: 6px;
    }
    
    .result-item {
      display: flex;
      align-items: center;
      padding: 12px 15px;
      cursor: pointer;
      transition: background-color 0.2s ease;
      text-decoration: none;
    }
    
    .result-item:hover {
      background-color: #333;
    }
    
    .result-icon {
      width: 36px;
      height: 36px;
      background-color: #444;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      overflow: hidden;
    }
    
    .result-icon img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    .result-info {
      flex: 1;
    }
    
    .result-title {
      font-size: 16px;
      margin-bottom: 2px;
      color: #fff;
    }
    
    .result-subtitle {
      font-size: 13px;
      color: #888;
    }
    
    .no-results {
      padding: 20px;
      text-align: center;
      color: #888;
      font-size: 14px;
    }
    
    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .result-item {
      animation: fadeIn 0.3s ease forwards;
      opacity: 0;
    }
    
    .result-item:nth-child(1) { animation-delay: 0.05s; }
    .result-item:nth-child(2) { animation-delay: 0.1s; }
    .result-item:nth-child(3) { animation-delay: 0.15s; }
    .result-item:nth-child(4) { animation-delay: 0.2s; }
    .result-item:nth-child(5) { animation-delay: 0.25s; }
    .result-item:nth-child(6) { animation-delay: 0.3s; }
    .result-item:nth-child(7) { animation-delay: 0.35s; }
  </style>

  <div class="search-container">
    <div class="search-bar">
      <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="11" cy="11" r="8"></circle>
        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
      </svg>
      <input type="text" class="search-input" placeholder="Search for teams, players, matches...">
      <button class="clear-button">
        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>
    
    <div class="search-results">
      <div class="filter-section">
        <button class="filter-button active">All</button>
        <button class="filter-button">Teams</button>
        <button class="filter-button">Leagues</button>
        <button class="filter-button">Players</button>
        <button class="filter-button">Matches</button>
      </div>
      
      <div class="results-section">
        <!-- Results will be loaded here by JavaScript -->
      </div>
    </div>
  </div>
    <script type="module" src="/foot_match_track/includes/search-script.js"></script>


