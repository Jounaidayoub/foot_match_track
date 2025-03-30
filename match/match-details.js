document.addEventListener("DOMContentLoaded", () => {
  // Tab Navigation
  const tabButtons = document.querySelectorAll(".tab-btn")
  const tabContents = document.querySelectorAll(".tab-content")

  tabButtons.forEach((button) => {
    button.addEventListener("click", () => {
      const target = button.getAttribute("data-tab")

      // Remove active class from all buttons and contents
      tabButtons.forEach((btn) => btn.classList.remove("active"))
      tabContents.forEach((content) => content.classList.remove("active"))

      // Add active class to clicked button and corresponding content
      button.classList.add("active")
      document.getElementById(target).classList.add("active")
    })
  })

  // Team Tabs for Lineups
  const teamTabs = document.querySelectorAll(".team-tab")
  const teamLineups = document.querySelectorAll(".team-lineup")

  teamTabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      const team = tab.getAttribute("data-team")

      // Remove active class from all tabs and lineups
      teamTabs.forEach((t) => t.classList.remove("active"))
      teamLineups.forEach((lineup) => lineup.classList.remove("active"))

      // Add active class to clicked tab and corresponding lineup
      tab.classList.add("active")
      document.getElementById(`${team}-lineup-view`).classList.add("active")
    })
  })
})

document.addEventListener("DOMContentLoaded", () => {
  // Add smooth entrance animations to elements
  const animateElements = [
    ".match-header-card",
    ".match-info-card",
    ".match-score-card",
    ".goal-scorers-card",
    ".match-navigation-card",
    ".stats-card",
    ".sidebar-card",
    ".match-item",
  ]

  animateElements.forEach((selector, index) => {
    const elements = document.querySelectorAll(selector)
    elements.forEach((el, i) => {
      el.style.opacity = "0"
      el.style.transform = "translateY(20px)"
      el.style.transition = "opacity 0.5s ease, transform 0.5s ease"

      setTimeout(
        () => {
          el.style.opacity = "1"
          el.style.transform = "translateY(0)"
        },
        100 + index * 100 + i * 50,
      )
    })
  })

  // Animate stat bars on load
  const statBars = document.querySelectorAll(".home-bar, .away-bar")
  statBars.forEach((bar) => {
    const width = bar.style.width
    bar.style.width = "0"

    setTimeout(() => {
      bar.style.width = width
    }, 500)
  })

  // Navigation tabs functionality
  const navItems = document.querySelectorAll(".nav-item")

  navItems.forEach((item) => {
    item.addEventListener("click", function () {
      // Remove active class from all items
      navItems.forEach((nav) => nav.classList.remove("active"))

      // Add active class to clicked item
      this.classList.add("active")

      // Add subtle animation
      this.style.transform = "scale(1.05)"
      setTimeout(() => {
        this.style.transform = "scale(1)"
      }, 200)

      // Here you would typically show/hide content based on the selected tab
      // For example: showContent(this.textContent.toLowerCase());
    })
  })

  // Back button functionality with smooth animation
  const backButton = document.querySelector(".back-button")
  if (backButton) {
    backButton.addEventListener("click", () => {
      // Animate page exit
      document.body.style.opacity = "0"
      document.body.style.transform = "translateY(-10px)"
      document.body.style.transition = "opacity 0.3s ease, transform 0.3s ease"

      setTimeout(() => {
        // Navigate back or to matches page
        history.back()
        // window.location.href = 'matches.html';
      }, 300)
    })
  }

  // Follow button functionality with elegant animation
  const followButton = document.querySelector(".follow-button button")
  if (followButton) {
    followButton.addEventListener("click", function () {
      // Add pulse animation
      this.classList.add("pulse-animation")

      // Toggle following state
      if (this.textContent === "Follow") {
        this.textContent = "Following"
        this.style.backgroundColor = "rgba(240, 185, 65, 0.1)"
        this.style.borderColor = "var(--primary-color)"
        this.style.color = "var(--primary-color)"
      } else {
        this.textContent = "Follow"
        this.style.backgroundColor = "transparent"
        this.style.borderColor = "var(--border-color)"
        this.style.color = "var(--text-light)"
      }

      // Remove animation class after animation completes
      setTimeout(() => {
        this.classList.remove("pulse-animation")
      }, 1000)
    })
  }

  // Add hover effects to match items
  const matchItems = document.querySelectorAll(".match-item")
  matchItems.forEach((item) => {
    item.addEventListener("mouseenter", function () {
      if (!this.classList.contains("highlighted")) {
        this.style.transform = "translateX(5px)"
      }
    })

    item.addEventListener("mouseleave", function () {
      if (!this.classList.contains("highlighted")) {
        this.style.transform = "translateX(0)"
      }
    })
  })

  // Add subtle parallax effect to the match score container
  const scoreContainer = document.querySelector(".match-score-card .card-body")
  if (scoreContainer) {
    document.addEventListener("mousemove", (e) => {
      const moveX = (e.clientX - window.innerWidth / 2) * 0.01
      const moveY = (e.clientY - window.innerHeight / 2) * 0.01

      scoreContainer.style.transform = `translate(${moveX}px, ${moveY}px)`
    })
  }

  // Card hover effects
  const cards = document.querySelectorAll(".card")
  cards.forEach((card) => {
    card.addEventListener("mouseenter", function () {
      this.style.transform = "translateY(-4px)"
      this.style.boxShadow = "var(--shadow-lg)"
      this.style.borderColor = "rgba(240, 185, 65, 0.2)"
    })

    card.addEventListener("mouseleave", function () {
      this.style.transform = "translateY(0)"
      this.style.boxShadow = "var(--shadow-md)"
      this.style.borderColor = "var(--border-color)"
    })
  })
})

