<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkillMatch - Freelance Dashboard')</title>
    
    <!-- Base Styles -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background-color: white;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.08);
            position: fixed;
            height: 100vh;
            z-index: 1000;
            padding: 2rem 0;
        }

        .logo {
            padding: 0 2rem 2rem 2rem;
            margin-bottom: 2rem;
        }

        .logo h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #38C1B9;
        }

        .logo span {
            color: #1e293b;
        }

        .nav-menu {
            list-style: none;
            padding: 0 1rem;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: #64748b;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
            font-weight: 500;
            position: relative;
        }

        .nav-link:hover {
            background-color: #f1f5f9;
            color: #1e293b;
        }

        .nav-link.active {
            background-color: #475569;
            color: white;
        }

        .nav-icon {
            width: 24px;
            height: 24px;
            margin-right: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
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

        /* Main Content - FIXED TO CENTER */
        .main-content {
            flex: 1;
            margin-left: 280px;
            background-color: #f8fafc;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: calc(100vw - 280px);
        }

        /* Header - FIXED WIDTH */
        .header {
            background-color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
            max-width: 1200px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            flex-shrink: 0;
        }

        .header-center {
            flex: 1;
            display: flex;
            justify-content: center;
            padding: 0 2rem;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-shrink: 0;
        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
            max-width: 400px;
        }

        .search-input {
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            width: 100%;
            font-size: 0.95rem;
            background-color: #f8fafc;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #38C1B9;
            background-color: white;
        }

        .search-input::placeholder {
            color: #94a3b8;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1.1rem;
        }

        .search-btn {
            background-color: #38C1B9;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .search-btn:hover {
            background-color: #2da89f;
        }

        .settings-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f1f5f9;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 1.2rem;
            color: #64748b;
            transition: all 0.2s ease;
        }

        .settings-btn:hover {
            background: #e2e8f0;
        }

        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e2e8f0;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 1.2rem;
            overflow: hidden;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Content Area - CENTERED */
        .content-area {
            padding: 2rem;
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

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100vw;
            }

            .sidebar-toggle {
                display: flex !important;
            }

            .header {
                max-width: none;
            }

            .content-area {
                max-width: none;
            }
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .header-center {
                order: 2;
                padding: 0;
                width: 100%;
            }

            .header-right {
                order: 1;
                align-self: flex-end;
            }

            .page-title {
                order: 0;
                align-self: flex-start;
                font-size: 1.5rem;
            }
            
            .search-container {
                max-width: none;
            }
            
            .content-area {
                padding: 1rem;
            }
        }

        @media (max-width: 640px) {
            .header-center {
                display: none;
            }

            .page-title {
                font-size: 1.25rem;
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

        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="logo">
                <h1>skill<span>Match</span></h1>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('freelance.dashboard') }}" class="nav-link {{ request()->routeIs('freelance.dashboard') ? 'active' : '' }}">
                        <div class="nav-icon">📊</div>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">💬</div>
                        Chat
                        <span class="nav-badge">3</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">📋</div>
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">💰</div>
                        Earnings
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">⭐</div>
                        Reviews
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <div class="nav-icon">👤</div>
                        Profile
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
               
                

            </header>

            <!-- Content Area -->
            <div class="content-area">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Base JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

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

            // Global search functionality
            const searchInput = document.getElementById('globalSearch');
            const searchBtn = document.getElementById('searchBtn');
            
            function performSearch() {
                const query = searchInput.value.trim();
                if (query) {
                    // Check if search function exists on dashboard
                    if (typeof window.searchOrders === 'function') {
                        window.searchOrders(query);
                    }
                } else {
                    if (typeof window.showAllOrders === 'function') {
                        window.showAllOrders();
                    }
                }
            }
            
            if (searchBtn) {
                searchBtn.addEventListener('click', performSearch);
            }
            
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        performSearch();
                    }
                });

                // Real-time search
                searchInput.addEventListener('input', function() {
                    const query = this.value.trim();
                    if (typeof window.searchOrders === 'function') {
                        if (query.length > 2) {
                            window.searchOrders(query);
                        } else if (query.length === 0) {
                            window.showAllOrders();
                        }
                    }
                });
            }

            // Close sidebar on window resize if desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 1024) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            });

            // Navigation active state
            const currentUrl = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentUrl) {
                    link.classList.add('active');
                }
            });
        });

        // Global functions for search
        window.showAllOrders = function() {
            const orderCards = document.querySelectorAll('.order-card');
            orderCards.forEach(card => {
                card.style.display = 'block';
            });
            
            // Remove no results message if exists
            const noResults = document.querySelector('.no-results');
            if (noResults) {
                noResults.remove();
            }
        };
    </script>

    @stack('scripts')
</body>
</html>