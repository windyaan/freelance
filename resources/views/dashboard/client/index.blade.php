@extends('layouts.client')

@section('title', 'Dashboard - SkillMatch')

@section('content')
<style>
/* Prevent horizontal overflow globally */
html, body {
    overflow-x: hidden;
    max-width: 100vw;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background-color: #f8fafc;
    color: #334155;
}

.top-navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 70px;
    background: white;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    padding: 0 2rem;
    z-index: 1001;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    max-width: 100vw;
    overflow: hidden;
}

.navbar-left {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    min-width: 0;
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.5rem;
    font-weight: 700;
    color: #38C1B9;
    text-decoration: none;
    white-space: nowrap;
}

.navbar-title {
    margin-left: 2rem;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    white-space: nowrap;
}

.navbar-center {
    flex: 2;
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: 600px;
    margin: 0 auto;
}

.search-container {
    position: relative;
    width: 100%;
    max-width: 450px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.search-container:focus-within {
    box-shadow: 0 4px 16px rgba(56, 193, 185, 0.15);
    border-color: #38C1B9;
}

.search-input-wrapper {
    display: flex;
    align-items: center;
    width: 100%;
}

.search-container input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: none;
    border-radius: 8px;
    font-size: 0.9rem;
    background: transparent;
    outline: none;
    color: #334155;
    flex: 1;
}

.search-container input::placeholder {
    color: #94a3b8;
    font-weight: 400;
}

.search-container .search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 1.1rem;
    z-index: 2;
    pointer-events: none;
}

.search-container .search-btn {
    background: #38C1B9;
    color: white;
    border: none;
    padding: 0.6rem 1.5rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    margin: 4px;
    white-space: nowrap;
    min-width: 80px;
    flex-shrink: 0;
}

.search-container .search-btn:hover {
    background: #2da89f;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(56, 193, 185, 0.3);
}

/* Search Results Dropdown */
.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    border: 1px solid #e2e8f0;
    margin-top: 8px;
    max-height: 300px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
}

.search-results.show {
    display: block;
}

.search-result-item {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #f1f5f9;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.search-result-item:hover {
    background-color: #f8fafc;
}

.search-result-name {
    font-weight: 500;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.search-result-skills {
    font-size: 0.8rem;
    color: #64748b;
}

.navbar-right {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    justify-content: flex-end;
}

/* Updated logout button styling - now for form submission */
.navbar-logout-form {
    margin: 0;
    padding: 0;
}

.navbar-logout {
    background: #ef4444;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.navbar-logout:hover {
    background: #dc2626;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    color: white;
    text-decoration: none;
}

.navbar-profile {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid #e2e8f0;
    transition: all 0.2s ease;
}

.navbar-profile:hover {
    border-color: #38C1B9;
}

.navbar-profile img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.sidebar {
    position: fixed;
    left: 0;
    top: 70px;
    width: 240px;
    height: calc(100vh - 70px);
    background: #ffffff;
    border-right: 1px solid #e2e8f0;
    z-index: 1000;
    padding: 1.5rem 0;
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    color: #64748b;
    text-decoration: none;
    cursor: pointer;
    margin-bottom: 0.5rem;
    transition: all 0.2s ease;
    border-radius: 0;
}

.nav-item:hover {
    background: #f8fafc;
    color: #1e293b;
}

.nav-item.active {
    background: #475569;
    color: white;
    border-radius: 12px;
    margin: 0 1rem 0.5rem 1rem;
}

.nav-icon {
    width: 32px;
    height: 32px;
    margin-right: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    background: #f1f5f9;
    border-radius: 8px;
    color: #64748b;
}

.nav-item.active .nav-icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.nav-text {
    flex: 1;
    font-weight: 500;
    font-size: 0.95rem;
}

.nav-badge {
    background: #38C1B9;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
    margin-left: auto;
}

.main-content {
    margin-left: 240px;
    margin-top: 70px;
    min-height: calc(100vh - 70px);
    padding: 2rem;
    background: #f8fafc;
    max-width: calc(100vw - 240px);
    overflow-x: hidden;
    box-sizing: border-box;
}

.skills-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    overflow: hidden;
    position: relative;
}

/* Skills slider container */
.skills-slider-container {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
}

.skills-slider-wrapper {
    display: flex;
    transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    will-change: transform;
}

.skills-slide {
    min-width: 100%;
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 1.5rem;
    padding: 1rem 0;
}

/* Navigation buttons */
.slider-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid #e2e8f0;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #64748b;
    font-size: 1.2rem;
    font-weight: bold;
    z-index: 10;
    backdrop-filter: blur(8px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.slider-nav:hover {
    background: #38C1B9;
    color: white;
    border-color: #38C1B9;
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(56, 193, 185, 0.3);
}

.slider-nav.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

.slider-nav.prev {
    left: -22px;
}

.slider-nav.next {
    right: -22px;
}

/* Slide indicators */
.slide-indicators {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1.5rem;
    padding: 0 1rem;
}

.slide-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #cbd5e1;
    cursor: pointer;
    transition: all 0.3s ease;
}

.slide-indicator.active {
    background: #38C1B9;
    transform: scale(1.2);
    box-shadow: 0 2px 8px rgba(56, 193, 185, 0.4);
}

.slide-indicator:hover {
    background: #94a3b8;
    transform: scale(1.1);
}

.skill-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
    padding: 1.5rem 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    text-align: center;
    background: #f8fafc;
    border: 1px solid #f1f5f9;
}

.skill-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.skill-card.active {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Video & Photography Skills */
.skill-card[data-skill="videographer"]:hover,
.skill-card[data-skill="videographer"].active,
.skill-card[data-skill="video editor"]:hover,
.skill-card[data-skill="video editor"].active,
.skill-card[data-skill="photographer"]:hover,
.skill-card[data-skill="photographer"].active {
    background: rgba(116, 204, 205, 0.1);
    border-color: rgba(116, 204, 205, 0.3);
}

.skill-card[data-skill="videographer"] .skill-icon,
.skill-card[data-skill="video editor"] .skill-icon,
.skill-card[data-skill="photographer"] .skill-icon {
    background: linear-gradient(135deg, #74CCCD, #5fb4b5);
    box-shadow: 0 4px 12px rgba(116, 204, 205, 0.3);
}

/* Writing & Translation Skills */
.skill-card[data-skill="content writing"]:hover,
.skill-card[data-skill="content writing"].active,
.skill-card[data-skill="copywriting"]:hover,
.skill-card[data-skill="copywriting"].active,
.skill-card[data-skill="translator"]:hover,
.skill-card[data-skill="translator"].active {
    background: rgba(40, 160, 148, 0.1);
    border-color: rgba(40, 160, 148, 0.3);
}

.skill-card[data-skill="content writing"] .skill-icon,
.skill-card[data-skill="copywriting"] .skill-icon,
.skill-card[data-skill="translator"] .skill-icon {
    background: linear-gradient(135deg, #28A094, #1f8a7e);
    box-shadow: 0 4px 12px rgba(40, 160, 148, 0.3);
}

/* UI & Development Skills */
.skill-card[data-skill="ui design"]:hover,
.skill-card[data-skill="ui design"].active,
.skill-card[data-skill="front-end"]:hover,
.skill-card[data-skill="front-end"].active,
.skill-card[data-skill="back-end"]:hover,
.skill-card[data-skill="back-end"].active,
.skill-card[data-skill="fullstack"]:hover,
.skill-card[data-skill="fullstack"].active {
    background: rgba(31, 112, 102, 0.1);
    border-color: rgba(31, 112, 102, 0.3);
}

.skill-card[data-skill="ui design"] .skill-icon,
.skill-card[data-skill="front-end"] .skill-icon,
.skill-card[data-skill="back-end"] .skill-icon,
.skill-card[data-skill="fullstack"] .skill-icon {
    background: linear-gradient(135deg, #1F7066, #196e63);
    box-shadow: 0 4px 12px rgba(31, 112, 102, 0.3);
}

/* Graphic Design & Illustration Skills */
.skill-card[data-skill="graphic design"]:hover,
.skill-card[data-skill="graphic design"].active,
.skill-card[data-skill="illustrator"]:hover,
.skill-card[data-skill="illustrator"].active {
    background: rgba(27, 98, 91, 0.1);
    border-color: rgba(27, 98, 91, 0.3);
}

.skill-card[data-skill="graphic design"] .skill-icon,
.skill-card[data-skill="illustrator"] .skill-icon {
    background: linear-gradient(135deg, #1B625B, #155751);
    box-shadow: 0 4px 12px rgba(27, 98, 91, 0.3);
}

.skill-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.skill-name {
    font-weight: 500;
    color: #64748b;
    font-size: 0.8rem;
    text-align: center;
    line-height: 1.3;
}

/* Updated Talents Section - Modified Card Design */
.talents-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    overflow-x: hidden;
}

.talent-slider-container {
    position: relative;
    overflow: hidden;
}

.talent-slider-wrapper {
    display: flex;
    transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    will-change: transform;
}

.talent-slide {
    min-width: 100%;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.talent-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    position: relative;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    display: flex;
    flex-direction: column;
    min-height: 320px;
    height: 100%;
}

.talent-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border-color: #38C1B9;
}

/* Modified talent header layout */
.talent-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.talent-skill-badge {
    background: #38C1B9;
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
}

/* Position name in top right */
.talent-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    text-align: right;
    line-height: 1.2;
}

.talent-description {
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
    flex-grow: 1;
    min-height: 60px;
    display: flex;
    align-items: flex-start;
}

.talent-project-link {
    color: #38C1B9;
    font-size: 0.85rem;
    text-decoration: none;
    font-weight: 500;
    margin-bottom: 1rem;
    display: block;
    word-break: break-all;
    min-height: 40px;
    display: flex;
    align-items: center;
}

.talent-project-link:hover {
    text-decoration: underline;
}

/* Modified talent price positioning - above profile button on the right */
.talent-price {
    color: #38C1B9;
    font-size: 0.9rem;
    font-weight: 700;
    text-align: right;
    white-space: nowrap;
    margin-bottom: 1rem;
    margin-top: auto;
    min-height: 24px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.talent-profile-btn {
    background: #64748b;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    width: 100%;
}

.talent-profile-btn:hover {
    background: #475569;
    transform: translateY(-1px);
}

/* REMOVED: Talent Navigation - Hide talent arrows */
.talent-nav {
    display: none !important;
}

/* Talent Pagination */
.talent-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-top: 2rem;
}

.talent-pagination button {
    width: 40px;
    height: 40px;
    border: 1px solid #e2e8f0;
    background: white;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    color: #64748b;
    transition: all 0.2s ease;
}

.talent-pagination button:hover {
    border-color: #38C1B9;
    color: #38C1B9;
}

.talent-pagination button.active {
    background: #38C1B9;
    color: white;
    border-color: #38C1B9;
}

.talent-pagination button:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

/* No results message */
.no-results {
    text-align: center;
    padding: 3rem;
    color: #64748b;
    font-size: 1.1rem;
    grid-column: 1 / -1;
}

/* Mobile Responsiveness */
@media (max-width: 1024px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
    
    .sidebar-toggle {
        display: flex !important;
        flex-direction: column;
        cursor: pointer;
        width: 24px;
        height: 18px;
        justify-content: space-between;
        margin-right: 1rem;
    }
    
    .sidebar-toggle span {
        width: 100%;
        height: 2px;
        background: #64748b;
        border-radius: 2px;
        transition: all 0.3s ease;
    }
    
    .main-content {
        margin-left: 0;
        max-width: 100vw;
        padding: 1.5rem;
    }
    
    .talent-slide {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    
    .skills-slide {
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }
    
    .navbar-center {
        flex: 1.5;
        max-width: 350px;
    }
    
    .search-container {
        max-width: 320px;
    }
}

@media (max-width: 768px) {
    .navbar-title {
        display: none;
    }
    
    .navbar-center {
        flex: 2;
        max-width: 280px;
    }
    
    .search-container {
        max-width: 250px;
    }
    
    .search-container input {
        font-size: 0.85rem;
        padding: 0.6rem 0.8rem 0.6rem 2.5rem;
    }
    
    .search-container .search-btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
    }
    
    .skills-section,
    .talents-section {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .main-content {
        padding: 1rem;
    }
    
    .talent-slide {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .skills-slide {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.8rem;
    }
    
    .skill-card {
        padding: 1rem 0.5rem;
    }
    
    .talent-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
    }
    
    .talent-price {
        text-align: center;
    }
    
    .talent-profile-btn {
        max-width: none;
    }
}

@media (max-width: 640px) {
    .navbar-brand span:last-child {
        display: none;
    }
    
    .navbar-center {
        display: none;
    }
    
    .main-content {
        padding: 0.8rem;
    }
    
    .skill-card {
        padding: 0.8rem 0.4rem;
    }
    
    .skill-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .talent-slide {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .skills-slide {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.6rem;
    }
}

.logo h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #38C1B9;
}

.logo span {
    color: #1e293b;
}
</style>

<!-- Top Navigation -->
<div class="top-navbar">
    <div class="navbar-left">
        <div class="sidebar-toggle" id="sidebarToggle" style="display: none;">
            <span></span>
            <span></span>
            <span></span>
        </div>
       <a href="#" class="navbar-brand">
    <div class="logo" style="margin-top: 60px;">
        <h1>skill<span>Match</span></h1>
    </div>
</a>
        <h1 class="navbar-title">Dashboard</h1>
    </div>
    <div class="navbar-center">
        <div class="search-container">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-input" placeholder="Search talents, skills..." id="globalSearch">
            <button class="search-btn" id="searchBtn">Search</button>
            <div class="search-results" id="searchResults"></div>
        </div>
    </div>
    <div class="navbar-right">
        <!-- Profile Button -->
        <div class="navbar-profile" onclick="goToProfile()">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face" alt="Profile">
        </div>
        
        <!-- Logout Form -->
        <form method="POST" action="{{ route('logout') }}" class="navbar-logout-form">
            @csrf
            <button type="submit" class="navbar-logout" onclick="return confirmLogout()">
                <span>🚪</span>
                Log Out
            </button>
        </form>
    </div>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <nav>
        <a href="#" class="nav-item active">
            <div class="nav-icon">📊</div>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon">💬</div>
            <span class="nav-text">Chat</span>
            <span class="nav-badge">3</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon">📋</div>
            <span class="nav-text">Orders</span>
        </a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Skills Grid -->
    <div class="skills-section">
        <div class="skills-slider-container">
            <!-- Navigation buttons -->
            <button class="slider-nav prev" id="prevSlide">‹</button>
            <button class="slider-nav next" id="nextSlide">›</button>
            
            <div class="skills-slider-wrapper" id="skillsSlider">
                <!-- Slide 1 -->
                <div class="skills-slide">
                    <div class="skill-card" data-skill="videographer">
                        <div class="skill-icon">📹</div>
                        <div class="skill-name">video<br>grapher</div>
                    </div>
                    <div class="skill-card" data-skill="video editor">
                        <div class="skill-icon">▶️</div>
                        <div class="skill-name">video<br>editor</div>
                    </div>
                    <div class="skill-card" data-skill="photographer">
                        <div class="skill-icon">📷</div>
                        <div class="skill-name">photo<br>grapher</div>
                    </div>
                    <div class="skill-card" data-skill="content writing">
                        <div class="skill-icon">✍️</div>
                        <div class="skill-name">content<br>writing</div>
                    </div>
                    <div class="skill-card" data-skill="copywriting">
                        <div class="skill-icon">📝</div>
                        <div class="skill-name">copy<br>writing</div>
                    </div>
                    <div class="skill-card" data-skill="translator">
                        <div class="skill-icon">🌐</div>
                        <div class="skill-name">translator</div>
                    </div>
                </div>
                
                <!-- Slide 2 -->
                <div class="skills-slide">
                    <div class="skill-card" data-skill="ui design">
                        <div class="skill-icon">🎨</div>
                        <div class="skill-name">UI<br>design</div>
                    </div>
                    <div class="skill-card" data-skill="front-end">
                        <div class="skill-icon">💻</div>
                        <div class="skill-name">front-end</div>
                    </div>
                    <div class="skill-card" data-skill="back-end">
                        <div class="skill-icon">🗄️</div>
                        <div class="skill-name">back-end</div>
                    </div>
                    <div class="skill-card" data-skill="fullstack">
                        <div class="skill-icon">⚡</div>
                        <div class="skill-name">fullstack</div>
                    </div>
                    <div class="skill-card" data-skill="graphic design">
                        <div class="skill-icon">🎯</div>
                        <div class="skill-name">graphic<br>design</div>
                    </div>
                    <div class="skill-card" data-skill="illustrator">
                        <div class="skill-icon">🖼️</div>
                        <div class="skill-name">illustrator</div>
                    </div>
                </div>
            </div>
            
            <!-- Slide indicators -->
            <div class="slide-indicators">
                <div class="slide-indicator active" data-slide="0"></div>
                <div class="slide-indicator" data-slide="1"></div>
            </div>
        </div>
    </div>

    <!-- Talent Grid with Modified Card Design (NO ARROWS) -->
    <div class="talents-section">
        <div class="talent-slider-container">
            <!-- REMOVED: Navigation buttons for talents -->
            
            <div class="talent-slider-wrapper" id="talentSlider">
                <!-- Slide 1 -->
                <div class="talent-slide">
                    <div class="talent-card" data-name="Samantha William" data-skills="ui design">
                        <div class="talent-header">
                            <div class="talent-skill-badge">UI design</div>
                            <h3 class="talent-name">Samantha William</h3>
                        </div>
                        <p class="talent-description">Pembuatan prototype menggunakan figma dan sketch.</p>
                        <a href="#" class="talent-project-link">contoh project : https://link-project-prototype-figma</a>
                        <div class="talent-price">Rp400.000-Rp600.000</div>
                        <button class="talent-profile-btn">profile</button>
                    </div>

                    <div class="talent-card" data-name="Dea Nisa" data-skills="fullstack">
                        <div class="talent-header">
                            <div class="talent-skill-badge">Fullstack</div>
                            <h3 class="talent-name">Dea Nisa</h3>
                        </div>
                        <p class="talent-description">Pembuatan website KOMINFO JOGJA</p>
                        <a href="#" class="talent-project-link">contoh project : https://link-project-web</a>
                        <div class="talent-price">Rp800.000-Rp1.000.000</div>
                        <button class="talent-profile-btn">profile</button>
                    </div>

                    <div class="talent-card" data-name="Eko Kurniawan" data-skills="back-end">
                        <div class="talent-header">
                            <div class="talent-skill-badge">Back-end</div>
                            <h3 class="talent-name">Eko Kurniawan</h3>
                        </div>
                        <p class="talent-description">Pembuatan database RS.</p>
                        <a href="#" class="talent-project-link">contoh project : https://link-project-db</a>
                        <div class="talent-price">Rp1.000.000-Rp2.000.000</div>
                        <button class="talent-profile-btn">profile</button>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="talent-slide">
                    <div class="talent-card" data-name="Joseph Kareem" data-skills="ui design">
                        <div class="talent-header">
                            <div class="talent-skill-badge">UI design</div>
                            <h3 class="talent-name">Joseph Kareem</h3>
                        </div>
                        <p class="talent-description">Pembuatan prototype menggunakan figma dan sketch.</p>
                        <a href="#" class="talent-project-link">contoh project : https://link-project-prototype-figma</a>
                        <div class="talent-price">Rp400.000-Rp600.000</div>
                        <button class="talent-profile-btn">profile</button>
                    </div>

                    <div class="talent-card" data-name="Fitri Daiva" data-skills="ui design">
                        <div class="talent-header">
                            <div class="talent-skill-badge">UI design</div>
                            <h3 class="talent-name">Fitri Daiva</h3>
                        </div>
                        <p class="talent-description">Pembuatan prototype menggunakan figma dan sketch.</p>
                        <a href="#" class="talent-project-link">contoh project : https://link-project-prototype-figma</a>
                        <div class="talent-price">Rp400.000-Rp600.000</div>
                        <button class="talent-profile-btn">profile</button>
                    </div>

                    <div class="talent-card" data-name="Tiara Hasna" data-skills="translator">
                        <div class="talent-header">
                            <div class="talent-skill-badge">Translator</div>
                            <h3 class="talent-name">Tiara Hasna</h3>
                        </div>
                        <p class="talent-description">Alih bahasa buku anak</p>
                        <a href="#" class="talent-project-link">contoh project : https://link-project-baru</a>
                        <div class="talent-price">Rp400.000-Rp600.000</div>
                        <button class="talent-profile-btn">profile</button>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="talent-slide">
                    <div class="talent-card" data-name="Ihwan Ahsan" data-skills="videographer">
                        <div class="talent-header">
                            <div class="talent-skill-badge">Videographer</div>
                            <h3 class="talent-name">Ihwan Ahsan</h3>
                        </div>
                        <p class="talent-description">Pembuatan video cinematic graduation SMA</p>
                        <a href="#" class="talent-project-link">contoh project : https://link-video-yt</a>
                        <div class="talent-price">Rp400.000-Rp600.000</div>
                        <button class="talent-profile-btn">profile</button>
                    </div>

                    <div class="talent-card" data-name="Hanin Anug" data-skills="model">
                        <div class="talent-header">
                            <div class="talent-skill-badge">Model</div>
                            <h3 class="talent-name">Hanin Anug</h3>
                        </div>
                        <p class="talent-description">Foto model busana</p>
                        <a href="#" class="talent-project-link">contoh project : https://link-portfolio</a>
                        <div class="talent-price">Rp400.000-Rp600.000</div>
                        <button class="talent-profile-btn">profile</button>
                    </div>

                    <div class="talent-card" data-name="Hazla Hanza" data-skills="fullstack">
                        <div class="talent-header">
                            <div class="talent-skill-badge">Fullstack</div>
                            <h3 class="talent-name">Hazla Hanza</h3>
                        </div>
                        <p class="talent-description">Pembuatan website toko pakaian</p>
                        <a href="#" class="talent-project-link">contoh project : https://link-project-toko</a>
                        <div class="talent-price">Rp400.000-Rp600.000</div>
                        <button class="talent-profile-btn">profile</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Talent Pagination -->
        <div class="talent-pagination">
            <button id="prevPageBtn">‹</button>
            <button class="active" data-page="0">1</button>
            <button data-page="1">2</button>
            <button data-page="2">3</button>
            <button id="nextPageBtn">›</button>
        </div>
    </div>
</div>

<script>
// Data struktur untuk talents
const talentsData = [
    {
        name: "Samantha William",
        skills: ["ui design", "ux design"],
        description: "Pembuatan prototype menggunakan figma dan sketch.",
        project: "https://link-project-prototype-figma",
        price: "Rp400.000-Rp600.000",
        category: "UI design"
    },
    {
        name: "Dea Nisa",
        skills: ["fullstack", "web development"],
        description: "Pembuatan website KOMINFO JOGJA",
        project: "https://link-project-web",
        price: "Rp800.000-Rp1.000.000",
        category: "Fullstack"
    },
    {
        name: "Eko Kurniawan",
        skills: ["back-end", "database"],
        description: "Pembuatan database RS.",
        project: "https://link-project-db",
        price: "Rp1.000.000-Rp2.000.000",
        category: "Back-end"
    },
    {
        name: "Joseph Kareem",
        skills: ["ui design", "figma"],
        description: "Pembuatan prototype menggunakan figma dan sketch.",
        project: "https://link-project-prototype-figma",
        price: "Rp400.000-Rp600.000",
        category: "UI design"
    },
    {
        name: "Fitri Daiva",
        skills: ["ui design", "sketch"],
        description: "Pembuatan prototype menggunakan figma dan sketch.",
        project: "https://link-project-prototype-figma",
        price: "Rp400.000-Rp600.000",
        category: "UI design"
    },
    {
        name: "Tiara Hasna",
        skills: ["translator", "language"],
        description: "Alih bahasa buku anak",
        project: "https://link-project-baru",
        price: "Rp400.000-Rp600.000",
        category: "Translator"
    },
    {
        name: "Ihwan Ahsan",
        skills: ["videographer", "cinematography"],
        description: "Pembuatan video cinematic graduation SMA",
        project: "https://link-video-yt",
        price: "Rp400.000-Rp600.000",
        category: "Videographer"
    },
    {
        name: "Hanin Anug",
        skills: ["model", "photography"],
        description: "Foto model busana",
        project: "https://link-portfolio",
        price: "Rp400.000-Rp600.000",
        category: "Model"
    },
    {
        name: "Hazla Hanza",
        skills: ["fullstack", "e-commerce"],
        description: "Pembuatan website toko pakaian",
        project: "https://link-project-toko",
        price: "Rp400.000-Rp600.000",
        category: "Fullstack"
    }
];

document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('globalSearch');
    var searchResults = document.getElementById('searchResults');
    var sidebar = document.getElementById('sidebar');
    var sidebarToggle = document.getElementById('sidebarToggle');
    
    // Skills slider functionality
    var currentSlide = 0;
    var totalSlides = document.querySelectorAll('.skills-slide').length;
    var skillsSlider = document.getElementById('skillsSlider');
    var prevBtn = document.getElementById('prevSlide');
    var nextBtn = document.getElementById('nextSlide');
    var indicators = document.querySelectorAll('.slide-indicator');
    
    // Talent slider functionality
    var currentTalentSlide = 0;
    var totalTalentSlides = document.querySelectorAll('.talent-slide').length;
    var talentSlider = document.getElementById('talentSlider');
    // REMOVED: Talent navigation buttons
    
    // Prevent horizontal scroll
    document.body.style.overflowX = 'hidden';
    document.documentElement.style.overflowX = 'hidden';
    
    // Skills slider functions
    function updateSkillsSlider() {
        const translateX = -currentSlide * 100;
        skillsSlider.style.transform = `translateX(${translateX}%)`;
        
        prevBtn.classList.toggle('disabled', currentSlide === 0);
        nextBtn.classList.toggle('disabled', currentSlide === totalSlides - 1);
        
        indicators.forEach((indicator, index) => {
            indicator.classList.toggle('active', index === currentSlide);
        });
    }
    
    function nextSkillsSlide() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            updateSkillsSlider();
        }
    }
    
    function prevSkillsSlide() {
        if (currentSlide > 0) {
            currentSlide--;
            updateSkillsSlider();
        }
    }
    
    // fr functions
    function updateTalentSlider() {
        const translateX = -currentTalentSlide * 100;
        talentSlider.style.transform = `translateX(${translateX}%)`;
        
        // Update pagination buttons
        document.querySelectorAll('.talent-pagination button[data-page]').forEach((btn, index) => {
            btn.classList.toggle('active', index === currentTalentSlide);
        });
        
        document.getElementById('prevPageBtn').disabled = currentTalentSlide === 0;
        document.getElementById('nextPageBtn').disabled = currentTalentSlide === totalTalentSlides - 1;
    }
    
    function nextTalentSlide() {
        if (currentTalentSlide < totalTalentSlides - 1) {
            currentTalentSlide++;
            updateTalentSlider();
        }
    }
    
    function prevTalentSlide() {
        if (currentTalentSlide > 0) {
            currentTalentSlide--;
            updateTalentSlider();
        }
    }
    
    function goToTalentSlide(slideIndex) {
        currentTalentSlide = slideIndex;
        updateTalentSlider();
    }
    
    // Event listeners for skills slider
    nextBtn.addEventListener('click', nextSkillsSlide);
    prevBtn.addEventListener('click', prevSkillsSlide);
    
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            currentSlide = index;
            updateSkillsSlider();
        });
    });
    
    // REMOVED: Event listeners for talent slider arrows
    
    // Pagination event listeners (ONLY pagination buttons remain)
    document.querySelectorAll('.talent-pagination button[data-page]').forEach(btn => {
        btn.addEventListener('click', () => {
            const page = parseInt(btn.getAttribute('data-page'));
            goToTalentSlide(page);
        });
    });
    
    document.getElementById('prevPageBtn').addEventListener('click', prevTalentSlide);
    document.getElementById('nextPageBtn').addEventListener('click', nextTalentSlide);
    
    // Search functionality with live results
    function performSearch(query) {
        if (query.length < 2) {
            searchResults.classList.remove('show');
            return;
        }
        
        const filtered = talentsData.filter(talent => {
            return talent.name.toLowerCase().includes(query.toLowerCase()) ||
                   talent.skills.some(skill => skill.toLowerCase().includes(query.toLowerCase())) ||
                   talent.category.toLowerCase().includes(query.toLowerCase());
        });
        
        displaySearchResults(filtered);
    }
    
    function displaySearchResults(results) {
        if (results.length === 0) {
            searchResults.innerHTML = '<div class="search-result-item">No results found</div>';
        } else {
            searchResults.innerHTML = results.map(talent => `
                <div class="search-result-item" onclick="selectSearchResult('${talent.name}')">
                    <div class="search-result-name">${talent.name}</div>
                    <div class="search-result-skills">${talent.skills.join(', ')}</div>
                </div>
            `).join('');
        }
        searchResults.classList.add('show');
    }
    
    // Search event listeners
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            performSearch(query);
        });
        
        searchInput.addEventListener('focus', function() {
            if (this.value.trim().length >= 2) {
                performSearch(this.value.trim());
            }
        });
        
        // Hide search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-container')) {
                searchResults.classList.remove('show');
            }
        });
        
        // Search button functionality
        document.querySelector('.search-btn').addEventListener('click', function() {
            const query = searchInput.value.trim();
            if (query) {
                filterTalentsBySearch(query);
                searchResults.classList.remove('show');
            }
        });
        
        // Enter key search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query) {
                    filterTalentsBySearch(query);
                    searchResults.classList.remove('show');
                }
            }
        });
    }
    
    // Filter talents by search query
    function filterTalentsBySearch(query) {
        const cards = document.querySelectorAll('.talent-card');
        let hasResults = false;
        
        cards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            const skills = card.getAttribute('data-skills').toLowerCase();
            const hasMatch = name.includes(query.toLowerCase()) || skills.includes(query.toLowerCase());
            
            if (hasMatch || query === '') {
                card.style.display = 'block';
                hasResults = true;
            } else {
                card.style.display = 'none';
            }
        });
        
        showNoResultsMessage(!hasResults && query !== '');
    }
    
    // Select search result
    window.selectSearchResult = function(name) {
        searchInput.value = name;
        filterTalentsBySearch(name);
        searchResults.classList.remove('show');
    }
    
    // Skill card filtering
    document.addEventListener('click', function(e) {
        if (e.target.closest('.skill-card')) {
            const skillCard = e.target.closest('.skill-card');
            const skillName = skillCard.getAttribute('data-skill');
            
            // Remove active class from all skill cards
            document.querySelectorAll('.skill-card').forEach(card => {
                card.classList.remove('active');
            });
            
            // Add active state to clicked card
            skillCard.classList.add('active');
            
            // Filter talents by skill
            filterTalentsBySkill(skillName);
        }
        
        // Profile button functionality
        if (e.target.classList.contains('talent-profile-btn')) {
            const card = e.target.closest('.talent-card');
            const name = card.getAttribute('data-name');
            alert('Opening profile for ' + name + '...');
            // Here you would typically redirect to profile page
        }
    });
    
    // Filter talents by skill
    function filterTalentsBySkill(skillName) {
        const cards = document.querySelectorAll('.talent-card');
        let hasResults = false;
        
        cards.forEach(card => {
            const cardSkills = card.getAttribute('data-skills').toLowerCase();
            const hasSkill = cardSkills.includes(skillName.toLowerCase());
            
            if (hasSkill) {
                card.style.display = 'block';
                hasResults = true;
            } else {
                card.style.display = 'none';
            }
        });
        
        showNoResultsMessage(!hasResults);
    }
    
    // Show no results message
    function showNoResultsMessage(show) {
        let existingMessage = document.querySelector('.no-results');
        
        if (show && !existingMessage) {
            const noResultsDiv = document.createElement('div');
            noResultsDiv.className = 'no-results';
            noResultsDiv.innerHTML = `
                <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                <h3 style="margin-bottom: 0.5rem; color: #1e293b;">No talents found</h3>
                <p>Try adjusting your search or filter criteria</p>
                <button onclick="clearAllFilters()" style="margin-top: 1rem; padding: 0.5rem 1rem; background: #38C1B9; color: white; border: none; border-radius: 6px; cursor: pointer;">Clear Filters</button>
            `;
            document.querySelector('.talent-slider-container').appendChild(noResultsDiv);
        } else if (!show && existingMessage) {
            existingMessage.remove();
        }
    }
    
    // Clear all filters
    window.clearAllFilters = function() {
        // Remove active state from skill cards
        document.querySelectorAll('.skill-card').forEach(card => {
            card.classList.remove('active');
        });
        
        // Show all talent cards
        document.querySelectorAll('.talent-card').forEach(card => {
            card.style.display = 'block';
        });
        
        // Clear search input
        if (searchInput) {
            searchInput.value = '';
        }
        
        // Remove no results message
        showNoResultsMessage(false);
    }
    
    // Sidebar functionality
    if (sidebarToggle) {
        const sidebarOverlay = document.createElement('div');
        sidebarOverlay.style.cssText = `
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            backdrop-filter: blur(4px);
        `;
        document.body.appendChild(sidebarOverlay);
        
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            sidebarOverlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
        });
        
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.style.display = 'none';
        });
    }
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Arrow keys for skills slider
        if (e.target.closest('.skills-section')) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                prevSkillsSlide();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                nextSkillsSlide();
            }
        }
        
        // Escape to clear search
        if (e.key === 'Escape') {
            searchResults.classList.remove('show');
            if (searchInput.value) {
                searchInput.value = '';
                clearAllFilters();
            }
        }
        
        // Ctrl/Cmd + K to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
            }
        }
    });
    
    // Initialize sliders
    updateSkillsSlider();
    updateTalentSlider();
});

// Logout confirmation
function confirmLogout() {
    return confirm('Are you sure you want to log out?');
}

// Profile navigation
function goToProfile() {
    window.location.href = "{{ route('profile.edit') }}";
}
</script>
@endsection