@extends('layouts.client')

@section('title', 'Chat - SkillMatch')

@section('content')
<style>
/* Base styles */
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

.navbar-right {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    justify-content: flex-end;
}

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
    padding: 0;
    background: #f8fafc;
    max-width: calc(100vw - 240px);
    overflow-x: hidden;
    box-sizing: border-box;
}

/* Chat specific styles */
.chat-container {
    display: flex;
    height: calc(100vh - 70px);
    background: white;
}

.chat-sidebar {
    width: 320px;
    background: white;
    border-right: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
}

.chat-sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: #f8fafc;
}

.chat-sidebar-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.chat-sidebar-subtitle {
    font-size: 0.85rem;
    color: #64748b;
}

.chat-list {
    flex: 1;
    overflow-y: auto;
    padding: 1rem 0;
}

.chat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    border-bottom: 1px solid #f1f5f9;
}

.chat-item:hover {
    background: #f8fafc;
}

.chat-item.active {
    background: #f0fdfc;
    border-right: 3px solid #38C1B9;
}

.chat-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    border: 2px solid #f1f5f9;
}

.chat-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.chat-info {
    flex: 1;
    min-width: 0;
}

.chat-name {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
    font-size: 0.95rem;
}

.chat-preview {
    font-size: 0.8rem;
    color: #64748b;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.chat-skills {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.chat-skill-tag {
    background: #38C1B9;
    color: white;
    padding: 0.2rem 0.5rem;
    border-radius: 10px;
    font-size: 0.65rem;
    font-weight: 500;
}

.chat-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: white;
    position: relative;
}

.chat-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: white;
    display: flex;
    align-items: center;
    gap: 1rem;
    z-index: 10;
}

.chat-header-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #e2e8f0;
}

.chat-header-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.chat-header-info {
    flex: 1;
}

.chat-header-name {
    font-weight: 600;
    color: #1e293b;
    font-size: 1rem;
}

.chat-header-status {
    font-size: 0.8rem;
    color: #64748b;
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 1rem 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    background: #f8fafc;
}

.message {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    max-width: 70%;
}

.message.sent {
    align-self: flex-end;
    flex-direction: row-reverse;
}

.message.received {
    align-self: flex-start;
}

.message-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    border: 1px solid #e2e8f0;
}

.message-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.message-content {
    background: white;
    padding: 0.75rem 1rem;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid #f1f5f9;
    position: relative;
    word-wrap: break-word;
    line-height: 1.4;
}

.message.sent .message-content {
    background: #38C1B9;
    color: white;
}

.message.received .message-content {
    background: white;
    color: #1e293b;
}

.message-time {
    font-size: 0.7rem;
    color: #94a3b8;
    margin-top: 0.25rem;
    text-align: center;
}

.message.sent .message-time {
    color: rgba(255, 255, 255, 0.8);
}

.chat-input-container {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e2e8f0;
    background: white;
}

.chat-input-wrapper {
    display: flex;
    align-items: flex-end;
    gap: 0.75rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.5rem;
}

.chat-input-wrapper:focus-within {
    border-color: #38C1B9;
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
}

.chat-input {
    flex: 1;
    border: none;
    background: transparent;
    padding: 0.5rem;
    font-size: 0.9rem;
    color: #1e293b;
    resize: none;
    outline: none;
    min-height: 40px;
    max-height: 120px;
    line-height: 1.4;
}

.chat-input::placeholder {
    color: #94a3b8;
}

.chat-send-btn {
    background: #38C1B9;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    flex-shrink: 0;
}

.chat-send-btn:hover {
    background: #2da89f;
    transform: scale(1.05);
}

.chat-send-btn:disabled {
    background: #cbd5e1;
    cursor: not-allowed;
    transform: none;
}

.chat-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #64748b;
    text-align: center;
    padding: 2rem;
}

.chat-empty-icon {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}

.chat-empty-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.chat-empty-subtitle {
    color: #64748b;
    line-height: 1.5;
}

/* Responsive Design */
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
    }
    
    .chat-sidebar {
        width: 280px;
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
    
    .chat-container {
        flex-direction: column;
        height: calc(100vh - 70px);
    }
    
    .chat-sidebar {
        width: 100%;
        height: 200px;
        border-right: none;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .chat-list {
        padding: 0.5rem 0;
    }
    
    .chat-item {
        padding: 0.75rem 1rem;
    }
    
    .chat-main {
        height: calc(100% - 200px);
    }
    
    .message {
        max-width: 85%;
    }
}

@media (max-width: 640px) {
    .navbar-brand span:last-child {
        display: none;
    }
    
    .navbar-center {
        display: none;
    }
    
    .chat-sidebar {
        height: 180px;
    }
    
    .chat-sidebar-header {
        padding: 1rem;
    }
    
    .chat-main {
        height: calc(100% - 180px);
    }
    
    .chat-messages {
        padding: 1rem;
    }
    
    .chat-input-container {
        padding: 1rem;
    }
    
    .message {
        max-width: 90%;
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

<!-- Load Iconify -->
<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

<!-- Top Navigation -->
<div class="top-navbar">
    <div class="navbar-left">
        <div class="sidebar-toggle" id="sidebarToggle" style="display: none;">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <div class="logo" style="margin-top: 60px;">
                <h1>Skill<span>Match</span></h1>
            </div>
        </a>
        <h1 class="navbar-title">Chat</h1>
    </div>
    <div class="navbar-center">
        <div class="search-container">
            <iconify-icon icon="material-symbols:search" class="search-icon"></iconify-icon>
            <input type="text" class="search-input" placeholder="Search conversations..." id="globalSearch">
            <button class="search-btn" id="searchBtn">Search</button>
        </div>
    </div>
    <div class="navbar-right">
        <div class="navbar-profile" onclick="goToProfile()">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face" alt="Profile">
        </div>
        
        <form method="POST" action="{{ route('logout') }}" class="navbar-logout-form">
            @csrf
            <button type="submit" class="navbar-logout" onclick="return confirmLogout()">
                <iconify-icon icon="material-symbols:logout"></iconify-icon>
                Log Out
            </button>
        </form>
    </div>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <nav>
        <a href="{{ route('dashboard') }}" class="nav-item">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
            </div>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="{{ route('chat') }}" class="nav-item active">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:chat"></iconify-icon>
            </div>
            <span class="nav-text">Chat</span>
            <span class="nav-badge">3</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
            </div>
            <span class="nav-text">Orders</span>
        </a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="chat-container">
        <!-- Chat Sidebar -->
        <div class="chat-sidebar">
            <div class="chat-sidebar-header">
                <h2 class="chat-sidebar-title">Messages</h2>
                <p class="chat-sidebar-subtitle">Recent conversations</p>
            </div>
            
            <div class="chat-list" id="chatList">
                <!-- Chat Item 1 -->
                <div class="chat-item active" data-chat-id="1" data-user-name="Nadia Irma">
                    <div class="chat-avatar">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=48&h=48&fit=crop&crop=face" alt="Nadia Irma">
                    </div>
                    <div class="chat-info">
                        <div class="chat-name">Nadia Irma</div>
                        <div class="chat-preview">Baik Ibu, saya menghendaki 1 bulan untuk desainnya, sekaligus saya buatkan form penawarannya</div>
                        <div class="chat-skills">
                            <span class="chat-skill-tag">UI Design</span>
                            <span class="chat-skill-tag">Front-End</span>
                        </div>
                    </div>
                </div>
                
                <!-- Chat Item 2 -->
                <div class="chat-item" data-chat-id="2" data-user-name="Tiara Hasna">
                    <div class="chat-avatar">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=48&h=48&fit=crop&crop=face" alt="Tiara Hasna">
                    </div>
                    <div class="chat-info">
                        <div class="chat-name">Tiara Hasna</div>
                        <div class="chat-preview">Bisa Bu, untuk jasa fullstacknya saya tawarkan diskon 10%</div>
                        <div class="chat-skills">
                            <span class="chat-skill-tag">Back-End</span>
                            <span class="chat-skill-tag">Fullstack</span>
                        </div>
                    </div>
                </div>
                
                <!-- Chat Item 3 -->
                <div class="chat-item" data-chat-id="3" data-user-name="Karina Carlo">
                    <div class="chat-avatar">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=48&h=48&fit=crop&crop=face" alt="Karina Carlo">
                    </div>
                    <div class="chat-info">
                        <div class="chat-name">Karina Carlo</div>
                        <div class="chat-preview">Ini nih Bu untuk logo cafe dan toko pakaiannnya</div>
                        <div class="chat-skills">
                            <span class="chat-skill-tag">Graphic Design</span>
                            <span class="chat-skill-tag">Illustrator</span>
                        </div>
                    </div>
                </div>
                
                <!-- Chat Item 4 -->
                <div class="chat-item" data-chat-id="4" data-user-name="Erma Nadila">
                    <div class="chat-avatar">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=48&h=48&fit=crop&crop=face" alt="Erma Nadila">
                    </div>
                    <div class="chat-info">
                        <div class="chat-name">Erma Nadila</div>
                        <div class="chat-preview">saya mau editannya nuansa ungu ya mbak</div>
                        <div class="chat-skills">
                            <span class="chat-skill-tag">Illustrator</span>
                            <span class="chat-skill-tag">Video Editor</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Chat Main Area -->
        <div class="chat-main">
            <!-- Active Chat Header -->
            <div class="chat-header" id="chatHeader">
                <div class="chat-header-avatar">
                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=40&h=40&fit=crop&crop=face" alt="Nadia Irma" id="headerAvatar">
                </div>
                <div class="chat-header-info">
                    <div class="chat-header-name" id="headerName">Nadia Irma</div>
                    <div class="chat-header-status" id="headerStatus">Online • UI Design, Front-End</div>
                </div>
            </div>
            
            <!-- Chat Messages -->
            <div class="chat-messages" id="chatMessages">
                <!-- Sample messages for Nadia Irma -->
                <div class="message received">
                    <div class="message-avatar">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=32&h=32&fit=crop&crop=face" alt="Nadia Irma">
                    </div>
                    <div class="message-content">
                        Halo Bu, terima kasih sudah menghubungi saya untuk proyek UI Design website cafe. 
                        <div class="message-time">10:30 AM</div>
                    </div>
                </div>
                
                <div class="message sent">
                    <div class="message-avatar">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face" alt="You">
                    </div>
                    <div class="message-content">
                        Halo Nadia, saya perlu desain untuk website cafe dan juga toko pakaian. Kira-kira berapa lama pengerjaannya?
                        <div class="message-time">10:32 AM</div>
                    </div>
                </div>
                
                <div class="message received">
                    <div class="message-avatar">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=32&h=32&fit=crop&crop=face" alt="Nadia Irma">
                    </div>
                    <div class="message-content">
                        Baik Ibu, saya menghendaki 1 bulan untuk desainnya, sekaligus saya buatkan form penawarannya. Untuk 2 website, saya tawarkan harga Rp 8.500.000
                        <div class="message-time">10:35 AM</div>
                    </div>
                </div>
                
                <div class="message sent">
                    <div class="message-avatar">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face" alt="You">
                    </div>
                    <div class="message-content">
                        Oke, bisa tolong kirimkan portfolionya dulu?
                        <div class="message-time">10:36 AM</div>
                    </div>
                </div>
            </div>
            
            <!-- Chat Input -->
            <div class="chat-input-container">
                <div class="chat-input-wrapper">
                    <textarea class="chat-input" id="messageInput" placeholder="Type your message..." rows="1"></textarea>
                    <button class="chat-send-btn" id="sendBtn">
                        <iconify-icon icon="material-symbols:send"></iconify-icon>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Chat functionality
document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const chatItems = document.querySelectorAll('.chat-item');
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const sendBtn = document.getElementById('sendBtn');
    const headerName = document.getElementById('headerName');
    const headerStatus = document.getElementById('headerStatus');
    const headerAvatar = document.getElementById('headerAvatar');
    const searchInput = document.getElementById('globalSearch');
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    // Sample chat data
    const chatData = {
        1: {
            name: "Nadia Irma",
            status: "Online • UI Design, Front-End",
            avatar: "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=40&h=40&fit=crop&crop=face",
            messages: [
                {
                    type: 'received',
                    content: 'Halo Bu, terima kasih sudah menghubungi saya untuk proyek UI Design website cafe.',
                    time: '10:30 AM',
                    avatar: 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=32&h=32&fit=crop&crop=face'
                },
                {
                    type: 'sent',
                    content: 'Halo Nadia, saya perlu desain untuk website cafe dan juga toko pakaian. Kira-kira berapa lama pengerjaannya?',
                    time: '10:32 AM',
                    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face'
                },
                {
                    type: 'received',
                    content: 'Baik Ibu, saya menghendaki 1 bulan untuk desainnya, sekaligus saya buatkan form penawarannya. Untuk 2 website, saya tawarkan harga Rp 8.500.000',
                    time: '10:35 AM',
                    avatar: 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=32&h=32&fit=crop&crop=face'
                },
                {
                    type: 'sent',
                    content: 'Oke, bisa tolong kirimkan portfolionya dulu?',
                    time: '10:36 AM',
                    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face'
                }
            ]
        },
        2: {
            name: "Tiara Hasna",
            status: "Online • Back-End, Fullstack",
            avatar: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=40&h=40&fit=crop&crop=face",
            messages: [
                {
                    type: 'received',
                    content: 'Selamat siang Bu, saya lihat Ibu membutuhkan developer fullstack untuk proyek e-commerce?',
                    time: '2:15 PM',
                    avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=32&h=32&fit=crop&crop=face'
                },
                {
                    type: 'sent',
                    content: 'Iya betul, saya butuh website e-commerce lengkap dengan sistem pembayaran. Berapa estimasi biayanya?',
                    time: '2:18 PM',
                    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face'
                },
                {
                    type: 'received',
                    content: 'Bisa Bu, untuk jasa fullstacknya saya tawarkan diskon 10%. Total menjadi Rp 15.000.000 untuk fitur lengkap',
                    time: '2:20 PM',
                    avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=32&h=32&fit=crop&crop=face'
                }
            ]
        },
        3: {
            name: "Karina Carlo",
            status: "Online • Graphic Design, Illustrator",
            avatar: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=40&h=40&fit=crop&crop=face",
            messages: [
                {
                    type: 'received',
                    content: 'Halo Bu, saya sudah selesai buat beberapa konsep logo untuk cafe dan toko pakaiannya.',
                    time: '4:45 PM',
                    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=32&h=32&fit=crop&crop=face'
                },
                {
                    type: 'sent',
                    content: 'Wah cepat sekali! Boleh saya lihat hasil konsepnya?',
                    time: '4:47 PM',
                    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face'
                },
                {
                    type: 'received',
                    content: 'Ini nih Bu untuk logo cafe dan toko pakaiannnya. Saya buat 3 variasi untuk masing-masing bisnis.',
                    time: '4:50 PM',
                    avatar: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=32&h=32&fit=crop&crop=face'
                }
            ]
        },
        4: {
            name: "Erma Nadila",
            status: "Online • Illustrator, Video Editor",
            avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face",
            messages: [
                {
                    type: 'sent',
                    content: 'Halo Erma, saya butuh video promosi untuk cafe baru saya. Durasinya sekitar 2-3 menit.',
                    time: '11:20 AM',
                    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face'
                },
                {
                    type: 'received',
                    content: 'Siap Bu! Untuk tema warnanya ada preferensi khusus tidak?',
                    time: '11:25 AM',
                    avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=32&h=32&fit=crop&crop=face'
                },
                {
                    type: 'sent',
                    content: 'saya mau editannya nuansa ungu ya mbak, sesuai dengan branding cafe saya',
                    time: '11:27 AM',
                    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face'
                }
            ]
        }
    };
    
    // Function to load chat messages
    function loadChatMessages(chatId) {
        const chat = chatData[chatId];
        if (!chat) return;
        
        // Update header
        if (headerName) headerName.textContent = chat.name;
        if (headerStatus) headerStatus.textContent = chat.status;
        if (headerAvatar) headerAvatar.src = chat.avatar;
        
        // Clear messages
        if (chatMessages) {
            chatMessages.innerHTML = '';
            
            // Add messages
            chat.messages.forEach(message => {
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${message.type}`;
                messageDiv.innerHTML = `
                    <div class="message-avatar">
                        <img src="${message.avatar}" alt="Avatar">
                    </div>
                    <div class="message-content">
                        ${message.content}
                        <div class="message-time">${message.time}</div>
                    </div>
                `;
                chatMessages.appendChild(messageDiv);
            });
            
            // Scroll to bottom
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }
    
    // Function to send message
    function sendMessage() {
        if (!messageInput || !messageInput.value.trim()) return;
        
        const messageText = messageInput.value.trim();
        const currentTime = new Date().toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
        
        // Create message element
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message sent';
        messageDiv.innerHTML = `
            <div class="message-avatar">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face" alt="You">
            </div>
            <div class="message-content">
                ${messageText}
                <div class="message-time">${currentTime}</div>
            </div>
        `;
        
        // Add to chat
        if (chatMessages) {
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
        
        // Clear input
        messageInput.value = '';
        autoResizeTextarea();
        
        // Simulate typing indicator and response (optional)
        setTimeout(() => {
            simulateTypingResponse();
        }, 1000);
    }
    
    // Simulate typing response
    function simulateTypingResponse() {
        const responses = [
            "Terima kasih atas pesannya, saya akan segera membalas.",
            "Baik Bu, saya cek dulu detailnya ya.",
            "Oke, nanti saya kirimkan proposal lengkapnya.",
            "Siap Bu, akan saya kerjakan sesuai timeline yang disepakati."
        ];
        
        const randomResponse = responses[Math.floor(Math.random() * responses.length)];
        const currentTime = new Date().toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        });
        
        // Get current active chat avatar
        const activeChat = document.querySelector('.chat-item.active');
        const activeAvatar = activeChat ? activeChat.querySelector('.chat-avatar img').src : '';
        
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message received';
        messageDiv.innerHTML = `
            <div class="message-avatar">
                <img src="${activeAvatar}" alt="Contact">
            </div>
            <div class="message-content">
                ${randomResponse}
                <div class="message-time">${currentTime}</div>
            </div>
        `;
        
        if (chatMessages) {
            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    }
    
    // Auto resize textarea
    function autoResizeTextarea() {
        if (messageInput) {
            messageInput.style.height = 'auto';
            messageInput.style.height = Math.min(messageInput.scrollHeight, 120) + 'px';
        }
    }
    
    // Search functionality
    function searchChats(query) {
        chatItems.forEach(item => {
            const name = item.querySelector('.chat-name').textContent.toLowerCase();
            const preview = item.querySelector('.chat-preview').textContent.toLowerCase();
            const searchTerm = query.toLowerCase();
            
            if (name.includes(searchTerm) || preview.includes(searchTerm) || query === '') {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }
    
    // Event listeners
    
    // Chat item selection
    chatItems.forEach(item => {
        item.addEventListener('click', function() {
            // Remove active from all items
            chatItems.forEach(i => i.classList.remove('active'));
            
            // Add active to clicked item
            this.classList.add('active');
            
            // Load chat messages
            const chatId = this.getAttribute('data-chat-id');
            loadChatMessages(chatId);
        });
    });
    
    // Send button
    if (sendBtn) {
        sendBtn.addEventListener('click', function(e) {
            e.preventDefault();
            sendMessage();
        });
    }
    
    // Enter key to send
    if (messageInput) {
        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
        
        // Auto resize on input
        messageInput.addEventListener('input', autoResizeTextarea);
    }
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            searchChats(query);
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = this.value.trim();
                searchChats(query);
            }
        });
    }
    
    // Search button
    const searchBtn = document.getElementById('searchBtn');
    if (searchBtn) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (searchInput) {
                const query = searchInput.value.trim();
                searchChats(query);
            }
        });
    }
    
    // Sidebar functionality
    if (sidebarToggle && sidebar) {
        // Create overlay
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
        
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('show');
            sidebarOverlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
        });
        
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.style.display = 'none';
        });
    }
    
    // Initialize first chat
    loadChatMessages('1');
    
    console.log('Chat page initialized successfully');
});

// Global functions
function confirmLogout() {
    return confirm('Are you sure you want to log out?');
}

function goToProfile() {
    window.location.href = "/profile";
}
</script>
@endsection