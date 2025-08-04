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

.search-container .search-btn:active {
    transform: translateY(0);
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

.search-result-item:last-child {
    border-bottom: none;
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
    overflow-x: hidden;
    position: relative;
}

/* New scrollable skills container */
.skills-scroll-container {
    overflow-x: auto;
    overflow-y: hidden;
    padding-bottom: 1rem;
    margin: -0.5rem;
    padding: 0.5rem;
    scroll-behavior: smooth;
}

/* Custom scrollbar styling */
.skills-scroll-container::-webkit-scrollbar {
    height: 8px;
}

.skills-scroll-container::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
    margin: 0 1rem;
}

.skills-scroll-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
    transition: background 0.2s ease;
}

.skills-scroll-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Updated skills grid to be horizontal scrollable */
.skills-grid {
    display: flex;
    gap: 1.5rem;
    min-width: fit-content;
    padding: 0.5rem 0;
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
    min-width: 120px;
    flex-shrink: 0;
}

.skill-card:hover {
    transform: translateY(-2px);
}

.skill-card.active {
    transform: translateY(-2px);
}

/* Video & Photography Skills */
.skill-card[data-skill="videographer"]:hover,
.skill-card[data-skill="videographer"].active,
.skill-card[data-skill="video editor"]:hover,
.skill-card[data-skill="video editor"].active,
.skill-card[data-skill="photographer"]:hover,
.skill-card[data-skill="photographer"].active {
    background: rgba(116, 204, 205, 0.1);
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

.talents-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    overflow-x: hidden;
}

.talent-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    max-width: 100%;
}

.talent-card {
    background: #f8fafc;
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    position: relative;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
}

.talent-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border-color: #38C1B9;
}

.talent-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin: 0 auto 1.5rem auto;
    border: 4px solid #ffffff;
    position: relative;
    overflow: hidden;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

.talent-avatar:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.talent-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.talent-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.talent-skills {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.skill-tag {
    background: white;
    color: #64748b;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.75rem;
    border: 1px solid #e2e8f0;
    font-weight: 500;
}

.chat-button {
    background: #475569;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.chat-button:hover {
    background: #334155;
    transform: translateY(-1px);
}

.profile-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 2000;
    backdrop-filter: blur(4px);
}

.profile-modal.active {
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-modal-content {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    position: relative;
    max-width: 400px;
    width: 90%;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.profile-avatar-large {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    margin: 0 auto 1.5rem auto;
    overflow: hidden;
    border: 4px solid #e2e8f0;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.profile-avatar-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-name-large {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.profile-skills-large {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    justify-content: center;
    margin-bottom: 2rem;
}

.profile-chat-button {
    background: #475569;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    font-size: 1rem;
    transition: all 0.2s ease;
}

.profile-chat-button:hover {
    background: #334155;
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

    .talent-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .skills-grid {
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
    
    .skills-grid {
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
    }
    
    .skills-section,
    .talents-section {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .main-content {
        padding: 1rem;
    }

    .talent-grid {
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
    }
}

@media (max-width: 640px) {
    .navbar-brand span:last-child {
        display: none;
    }

    .navbar-center {
        display: none;
    }
    
    .skills-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 0.8rem;
    }

    .skill-card {
        min-width: 80px;
        padding: 0.8rem 0.4rem;
    }

    .skill-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
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
        </div>
    </div>
    <div class="navbar-right">
        <!-- Profile Button - Now comes first -->
        <div class="navbar-profile" onclick="goToProfile()">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face" alt="Profile">
        </div>

        <!-- Logout Form - Using Laravel's proper logout method -->
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

<!-- Profile Modal -->
<div class="profile-modal" id="profileModal">
    <div class="profile-modal-content">
        <div class="profile-avatar-large">
            <img id="modalAvatar" src="" alt="Profile">
        </div>
        <h3 id="modalName" class="profile-name-large">Loading...</h3>
        <div id="modalSkills" class="profile-skills-large"></div>
        <button class="profile-chat-button" id="modalChatButton">Chat</button>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Skills Grid - Updated with scrollable container -->
    <div class="skills-section">
        <div class="skills-scroll-container">
            <div class="skills-grid">
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
    </div>

    <!-- Talent Grid -->
    <div class="talents-section">
        <div class="talent-grid">
            <div class="talent-card" data-skills="translator,copywriting">
                <div class="talent-avatar">
                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face" alt="Samantha William">
                </div>
                <h3 class="talent-name">Samantha William</h3>
                <div class="talent-skills">
                    <span class="skill-tag">translator</span>
                    <span class="skill-tag">copywriting</span>
                </div>
                <button class="chat-button">Chat</button>
            </div>

            <div class="talent-card" data-skills="ui design,front-end">
                <div class="talent-avatar">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&h=150&fit=crop&crop=face" alt="Nadia Ima">
                </div>
                <h3 class="talent-name">Nadia Ima</h3>
                <div class="talent-skills">
                    <span class="skill-tag">UI design</span>
                    <span class="skill-tag">front-end</span>
                </div>
                <button class="chat-button">Chat</button>
            </div>

            <div class="talent-card" data-skills="fullstack">
                <div class="talent-avatar">
                    <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?w=150&h=150&fit=crop&crop=face" alt="Eka Widya">
                </div>
                <h3 class="talent-name">Eka Widya</h3>
                <div class="talent-skills">
                    <span class="skill-tag">fullstack</span>
                </div>
                <button class="chat-button">Chat</button>
            </div>

            <div class="talent-card" data-skills="model,content writing,photographer">
                <div class="talent-avatar">
                    <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=150&h=150&fit=crop&crop=face" alt="Safea Nirmala">
                </div>
                <h3 class="talent-name">Safea Nirmala Hanung</h3>
                <div class="talent-skills">
                    <span class="skill-tag">model</span>
                    <span class="skill-tag">content writing</span>
                    <span class="skill-tag">photographer</span>
                </div>
                <button class="chat-button">Chat</button>
            </div>

            <div class="talent-card" data-skills="back-end,fullstack">
                <div class="talent-avatar">
                    <img src="https://images.unsplash.com/photo-1489424731084-a5d8b219a5bb?w=150&h=150&fit=crop&crop=face" alt="Ika Pertiwi">
                </div>
                <h3 class="talent-name">Ika Pertiwi</h3>
                <div class="talent-skills">
                    <span class="skill-tag">back-end</span>
                    <span class="skill-tag">fullstack</span>
                </div>
                <button class="chat-button">Chat</button>
            </div>

            <div class="talent-card" data-skills="graphic design,illustrator">
                <div class="talent-avatar">
                    <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=150&h=150&fit=crop&crop=face" alt="Hanin Dhea">
                </div>
                <h3 class="talent-name">Hanin Dhea</h3>
                <div class="talent-skills">
                    <span class="skill-tag">graphic design</span>
                    <span class="skill-tag">illustrator</span>
                </div>
                <button class="chat-button">Chat</button>
            </div>

            <div class="talent-card" data-skills="illustrator,video editor">
                <div class="talent-avatar">
                    <img src="https://images.unsplash.com/photo-1521119989659-a83eee488004?w=150&h=150&fit=crop&crop=face" alt="Erma Nadila">
                </div>
                <h3 class="talent-name">Erma Nadila</h3>
                <div class="talent-skills">
                    <span class="skill-tag">illustrator</span>
                    <span class="skill-tag">video editor</span>
                </div>
                <button class="chat-button">Chat</button>
            </div>

            <div class="talent-card" data-skills="back-end,fullstack">
                <div class="talent-avatar">
                    <img src="https://images.unsplash.com/photo-1488426862026-3ee34a7d66df?w=150&h=150&fit=crop&crop=face" alt="Tiara Hasna">
                </div>
                <h3 class="talent-name">Tiara Hasna</h3>
                <div class="talent-skills">
                    <span class="skill-tag">back-end</span>
                    <span class="skill-tag">fullstack</span>
                </div>
                <button class="chat-button">Chat</button>
            </div>

            <div class="talent-card" data-skills="graphic design,illustrator">
                <div class="talent-avatar">
                    <img src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?w=150&h=150&fit=crop&crop=face" alt="Karina Carlo">
                </div>
                <h3 class="talent-name">Karina Carlo</h3>
                <div class="talent-skills">
                    <span class="skill-tag">graphic design</span>
                    <span class="skill-tag">illustrator</span>
                </div>
                <button class="chat-button">Chat</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('globalSearch');
    var profileModal = document.getElementById('profileModal');
    var sidebar = document.getElementById('sidebar');
    var sidebarToggle = document.getElementById('sidebarToggle');
    
    // Create sidebar overlay for mobile
    var sidebarOverlay = document.createElement('div');
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

    // Toggle sidebar on mobile
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            sidebarOverlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
        });
    }

    // Close sidebar when clicking overlay
    sidebarOverlay.addEventListener('click', function() {
        sidebar.classList.remove('show');
        sidebarOverlay.style.display = 'none';
    });

    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var query = this.value.toLowerCase();
            searchTalents(query);
        });

        // Search button functionality
        document.querySelector('.search-btn').addEventListener('click', function() {
            var query = searchInput.value.toLowerCase();
            searchTalents(query);
        });
    }

    // Profile modal functionality - close when clicking outside
    profileModal.addEventListener('click', function(e) {
        if (e.target === profileModal) {
            profileModal.classList.remove('active');
        }
    });

    // Event delegation for all interactions
    document.addEventListener('click', function(e) {
        // Chat button functionality
        if (e.target.classList.contains('chat-button') || e.target.classList.contains('profile-chat-button')) {
            var name = '';
            if (e.target.classList.contains('chat-button')) {
                name = e.target.closest('.talent-card').querySelector('.talent-name').textContent;
            } else {
                name = document.getElementById('modalName').textContent;
            }
            alert('Starting chat with ' + name + '...');
            // Here you would typically redirect to chat page or open chat interface
        }

        // Talent avatar click - open modal
        if (e.target.closest('.talent-avatar')) {
            var card = e.target.closest('.talent-card');
            var name = card.querySelector('.talent-name').textContent;
            var img = card.querySelector('.talent-avatar img').src;

            document.getElementById('modalName').textContent = name;
            document.getElementById('modalAvatar').src = img;

            var skills = card.querySelectorAll('.skill-tag');
            var modalSkills = document.getElementById('modalSkills');
            modalSkills.innerHTML = '';

            skills.forEach(function(skill) {
                var skillTag = document.createElement('span');
                skillTag.className = 'skill-tag';
                skillTag.textContent = skill.textContent;
                modalSkills.appendChild(skillTag);
            });

            profileModal.classList.add('active');
        }

        // Skill card filtering
        if (e.target.closest('.skill-card')) {
            var skillCard = e.target.closest('.skill-card');
            var skillName = skillCard.getAttribute('data-skill');

            // Remove active class from all skill cards
            document.querySelectorAll('.skill-card').forEach(function(card) {
                card.classList.remove('active');
            });

            // Add active state to clicked card
            skillCard.classList.add('active');

            // Filter talents by skill
            filterTalentsBySkill(skillName);
        }
    });

    // Navigation functionality
    document.querySelectorAll('.nav-item').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();

            // Remove active class from all nav items
            document.querySelectorAll('.nav-item').forEach(function(navItem) {
                navItem.classList.remove('active');
            });

            // Add active class to clicked item
            this.classList.add('active');

            // Here you would typically handle navigation
            var navText = this.querySelector('.nav-text').textContent;
            console.log('Navigating to: ' + navText);
        });
    });
});

// Logout confirmation function
function confirmLogout() {
    return confirm('Are you sure you want to log out?');
}

// Profile navigation function
function goToProfile() {
    // Redirect to profile page
    window.location.href = "{{ route('profile.edit') }}";
}

// Search talents function
function searchTalents(query) {
    var cards = document.querySelectorAll('.talent-card');
    var hasResults = false;

    cards.forEach(function(card) {
        var name = card.querySelector('.talent-name').textContent.toLowerCase();
        var skills = card.querySelectorAll('.skill-tag');
        var hasMatch = name.includes(query);

        if (!hasMatch) {
            skills.forEach(function(skill) {
                if (skill.textContent.toLowerCase().includes(query)) {
                    hasMatch = true;
                }
            });
        }

        if (hasMatch || query === '') {
            card.style.display = 'block';
            hasResults = true;
        } else {
            card.style.display = 'none';
        }
    });

    // Show/hide no results message
    showNoResultsMessage(!hasResults && query !== '');
}

// Filter talents by skill function
function filterTalentsBySkill(skillName) {
    var cards = document.querySelectorAll('.talent-card');
    var hasResults = false;

    cards.forEach(function(card) {
        var cardSkills = card.getAttribute('data-skills').toLowerCase();
        var hasSkill = cardSkills.includes(skillName.toLowerCase());

        if (hasSkill) {
            card.style.display = 'block';
            hasResults = true;
        } else {
            card.style.display = 'none';
        }
    });

    // Show/hide no results message
    showNoResultsMessage(!hasResults);
}

// Show no results message
function showNoResultsMessage(show) {
    var existingMessage = document.querySelector('.no-results');

    if (show && !existingMessage) {
        var noResultsDiv = document.createElement('div');
        noResultsDiv.className = 'no-results';
        noResultsDiv.style.cssText = `
            text-align: center;
            padding: 3rem;
            color: #64748b;
            font-size: 1.1rem;
            grid-column: 1 / -1;
        `;
        noResultsDiv.innerHTML = `
            <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
            <h3 style="margin-bottom: 0.5rem; color: #1e293b;">No talents found</h3>
            <p>Try adjusting your search or filter criteria</p>
        `;
        document.querySelector('.talent-grid').appendChild(noResultsDiv);
    } else if (!show && existingMessage) {
        existingMessage.remove();
    }
}

// Clear all filters function
function clearAllFilters() {
    // Remove active state from skill cards
    document.querySelectorAll('.skill-card').forEach(function(card) {
        card.classList.remove('active');
    });

    // Show all talent cards
    document.querySelectorAll('.talent-card').forEach(function(card) {
        card.style.display = 'block';
    });

    // Clear search input
    var searchInput = document.getElementById('globalSearch');
    if (searchInput) {
        searchInput.value = '';
    }

    // Remove no results message
    showNoResultsMessage(false);
}

// Add double-click to clear filters
document.addEventListener('dblclick', function(e) {
    if (e.target.closest('.skills-section')) {
        clearAllFilters();
    }
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Escape key to close modal
    if (e.key === 'Escape') {
        var modal = document.getElementById('profileModal');
        if (modal.classList.contains('active')) {
            modal.classList.remove('active');
        }
    }

    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        var searchInput = document.getElementById('globalSearch');
        if (searchInput) {
            searchInput.focus();
        }
    }
});

// Smooth scrolling for better UX
function smoothScrollTo(element) {
    element.scrollIntoView({
        behavior: 'smooth',
        block: 'center'
    });
}

// Add loading states for better UX
function showLoading(element) {
    element.style.opacity = '0.5';
    element.style.pointerEvents = 'none';
}

function hideLoading(element) {
    element.style.opacity = '1';
    element.style.pointerEvents = 'auto';
}

// Initialize tooltips or other features if needed
function initializeTooltips() {
    // Add tooltips to skill cards
    document.querySelectorAll('.skill-card').forEach(function(card) {
        card.title = 'Click to filter talents by ' + card.querySelector('.skill-name').textContent;
    });
}

// Initialize tooltips on page load
initializeTooltips();
</script>
@endsection
