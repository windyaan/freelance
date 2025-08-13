<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkillMatch - Freelancer Dashboard')</title>

    <!-- Iconify -->
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

    <!-- Base Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            overflow-x: hidden;
            max-width: 100vw;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Top Navigation */
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

        .navbar-brand:hover {
            color: #38C1B9;
            text-decoration: none;
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
            display: flex;
            align-items: center;
        }

        .search-container:focus-within {
            box-shadow: 0 4px 16px rgba(56, 193, 185, 0.15);
            border-color: #38C1B9;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            color: #94a3b8;
            font-size: 1.1rem;
            z-index: 2;
            pointer-events: none;
        }

        .search-input {
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

        .search-input::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        .search-btn {
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

        .search-btn:hover {
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

        .navbar-profile {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid #e2e8f0;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f1f5f9;
            color: #64748b;
            text-decoration: none;
        }

        .navbar-profile:hover {
            border-color: #38C1B9;
            color: #38C1B9;
            text-decoration: none;
        }

        .navbar-profile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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

        /* Sidebar */
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
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.08);
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
            text-decoration: none;
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

        /* Main Content */
        .main-content {
            margin-left: 240px;
            margin-top: 70px;
            min-height: calc(100vh - 70px);
            padding: 2rem;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: calc(100vw - 240px);
            overflow-x: hidden;
            box-sizing: border-box;
        }

        .content-area {
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Mobile Sidebar Toggle */
        .sidebar-toggle {
            display: none;
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
            }

            .main-content {
                margin-left: 0;
                max-width: 100vw;
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

            .search-input {
                font-size: 0.85rem;
                padding: 0.6rem 0.8rem 0.6rem 2.5rem;
            }

            .search-btn {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }

            .main-content {
                padding: 1rem;
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
        }

        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            backdrop-filter: blur(4px);
        }

        .sidebar-overlay.show {
            display: block;
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="container">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Top Navigation -->
        <div class="top-navbar">
            <div class="navbar-left">
                <div class="sidebar-toggle" id="sidebarToggle" style="display: none;">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
                <a href="{{ route('freelancer.dashboard') }}" class="navbar-brand">
                    Skill<span>Match</span>
                </a>
                <h1 class="navbar-title">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="navbar-center">
                <div class="search-container">
                    <iconify-icon icon="material-symbols:search" class="search-icon"></iconify-icon>
                    <input type="text" class="search-input" placeholder="Search orders, clients..." id="globalSearch" autocomplete="off">
                    <button class="search-btn" id="searchBtn">Search</button>
                </div>
            </div>
            <div class="navbar-right">
                <a href="{{ route('profile.edit') }}" class="navbar-profile">
                    @if(auth()->user()->profile_picture)
                        <img src="{{ Storage::url(auth()->user()->profile_picture) }}" alt="Profile">
                    @else
                        <iconify-icon icon="material-symbols:person"></iconify-icon>
                    @endif
                </a>

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
                <a href="{{ route('freelancer.dashboard') }}" class="nav-item {{ request()->routeIs('freelancer.dashboard') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
                    </div>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a href="{{ route('freelancer.chat') }}" class="nav-item {{ request()->routeIs('freelancer.chat*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <iconify-icon icon="material-symbols:chat"></iconify-icon>
                    </div>
                    <span class="nav-text">Chat</span>
                    <span class="nav-badge">3</span>
                </a>
                <a href="{{ route('freelancer.order') }}" class="nav-item {{ request()->routeIs('freelancer.order*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
                    </div>
                    <span class="nav-text">Orders</span>
                </a>
                <a href="#" class="nav-item">
                    <div class="nav-icon">
                        <iconify-icon icon="material-symbols:attach-money"></iconify-icon>
                    </div>
                    <span class="nav-text">Earnings</span>
                </a>
                <a href="#" class="nav-item">
                    <div class="nav-icon">
                        <iconify-icon icon="material-symbols:star"></iconify-icon>
                    </div>
                    <span class="nav-text">Reviews</span>
                </a>
                <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <iconify-icon icon="material-symbols:person"></iconify-icon>
                    </div>
                    <span class="nav-text">Profile</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-area">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Base JavaScript -->
    <script>
        // Wait for DOM to load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Layout script loading...');
            
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const searchInput = document.getElementById('globalSearch');
            const searchBtn = document.getElementById('searchBtn');

            // Prevent horizontal scroll
            if (document.body) {
                document.body.style.overflowX = 'hidden';
            }
            if (document.documentElement) {
                document.documentElement.style.overflowX = 'hidden';
            }

            // Mobile sidebar toggle
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                });
            }

            // Close sidebar when clicking overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });
            }

            // Close sidebar on window resize if desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 1024) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            });

            // Search functionality - wait for page-specific functions to load
            if (searchInput && searchBtn) {
                console.log('Search elements found, setting up listeners');
                
                // Set up search input listener
                searchInput.addEventListener('input', function(e) {
                    const query = e.target.value.trim();
                    console.log('Search input changed:', query);
                    
                    // Try to call page-specific search function
                    if (typeof window.performSearch === 'function') {
                        window.performSearch(query);
                    } else if (typeof window.searchOrders === 'function') {
                        window.searchOrders(query);
                    } else {
                        console.log('No search function available yet, will try again');
                    }
                });
                
                // Search button click
                searchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const query = searchInput.value.trim();
                    console.log('Search button clicked:', query);
                    
                    if (typeof window.performSearch === 'function') {
                        window.performSearch(query);
                    } else if (typeof window.searchOrders === 'function') {
                        window.searchOrders(query);
                    }
                });
                
                // Enter key search
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const query = e.target.value.trim();
                        console.log('Search enter key:', query);
                        
                        if (typeof window.performSearch === 'function') {
                            window.performSearch(query);
                        } else if (typeof window.searchOrders === 'function') {
                            window.searchOrders(query);
                        }
                    }
                });
            }

            // Global keyboard shortcuts
            document.addEventListener('keydown', function(e) {
                // Escape to clear search or close sidebar
                if (e.key === 'Escape') {
                    if (searchInput && searchInput.value) {
                        searchInput.value = '';
                        if (typeof window.showAllOrders === 'function') {
                            window.showAllOrders();
                        }
                    } else if (sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                        sidebarOverlay.classList.remove('show');
                    }
                }
                
                // Ctrl/Cmd + K to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }
            });

            console.log('Layout script loaded successfully');
        });

        // Utility functions
        function confirmLogout() {
            return confirm('Are you sure you want to log out?');
        }

        // Global search interface - these will be overridden by page-specific functions
        window.searchOrders = window.searchOrders || function(query) {
            console.log('Default searchOrders called with:', query);
        };

        window.showAllOrders = window.showAllOrders || function() {
            console.log('Default showAllOrders called');
            const searchInput = document.getElementById('globalSearch');
            if (searchInput) {
                searchInput.value = '';
            }
        };

        window.performSearch = window.performSearch || function(query) {
            console.log('Default performSearch called with:', query);
        };
    </script>

    @stack('scripts')
</body>
</html>