<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'SkillMatch'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Iconify -->
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

    <style>
        /* Global Reset & Base Styles */
        *, *::before, *::after {
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
            line-height: 1.5;
        }

        /* Brand Colors */
        :root {
            --primary-color: #38C1B9;
            --primary-hover: #2da89f;
            --secondary-color: #475569;
            --secondary-hover: #334155;
            --danger-color: #ef4444;
            --danger-hover: #dc2626;
            --success-color: #10b981;
            --warning-color: #f59e0b;

            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;

            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-muted: #f1f5f9;

            --border-color: #e2e8f0;
            --border-light: #f1f5f9;

            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 8px 25px rgba(0, 0, 0, 0.15);

            --navbar-height: 70px;
            --sidebar-width: 240px;
        }

        /* Typography */
        .text-primary { color: var(--text-primary); }
        .text-secondary { color: var(--text-secondary); }
        .text-muted { color: var(--text-muted); }

        /* Layout Components */
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
            height: var(--navbar-height);
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            padding: 0 2rem;
            z-index: 1001;
            box-shadow: var(--shadow-sm);
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
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            white-space: nowrap;
        }

        .navbar-brand:hover {
            color: var(--primary-color);
            text-decoration: none;
        }

        .navbar-brand span:last-child {
            color: var(--text-primary);
        }

        .navbar-title {
            margin-left: 2rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
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

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            justify-content: flex-end;
        }

        /* Search Component */
        .search-container {
            position: relative;
            width: 100%;
            max-width: 450px;
            background: var(--bg-primary);
            border-radius: 8px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-color);
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .search-container:focus-within {
            box-shadow: 0 4px 16px rgba(56, 193, 185, 0.15);
            border-color: var(--primary-color);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            color: var(--text-muted);
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
            color: var(--text-primary);
            flex: 1;
        }

        .search-input::placeholder {
            color: var(--text-muted);
            font-weight: 400;
        }

        .search-btn {
            background: var(--primary-color);
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
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(56, 193, 185, 0.3);
        }

        /* Profile & Auth */
        .navbar-profile {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid var(--border-color);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-muted);
            color: var(--text-secondary);
            text-decoration: none;
        }

        .navbar-profile:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
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
            background: var(--danger-color);
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
            background: var(--danger-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
            color: white;
            text-decoration: none;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: var(--navbar-height);
            width: var(--sidebar-width);
            height: calc(100vh - var(--navbar-height));
            background: var(--bg-primary);
            border-right: 1px solid var(--border-color);
            z-index: 1000;
            padding: 1.5rem 0;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.08);
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            cursor: pointer;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
            border-radius: 0;
        }

        .nav-item:hover {
            background: var(--bg-secondary);
            color: var(--text-primary);
            text-decoration: none;
        }

        .nav-item.active {
            background: var(--secondary-color);
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
            background: var(--bg-muted);
            border-radius: 8px;
            color: var(--text-secondary);
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
            background: var(--primary-color);
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
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            min-height: calc(100vh - var(--navbar-height));
            padding: 2rem;
            background: var(--bg-secondary);
            max-width: calc(100vw - var(--sidebar-width));
            overflow-x: hidden;
            box-sizing: border-box;
        }

        /* Mobile Toggle */
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
            background: var(--text-secondary);
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* Button Styles */
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            box-shadow: 0 4px 12px rgba(56, 193, 185, 0.3);
        }

        .btn-secondary {
            background: var(--secondary-color);
            color: white;
        }

        .btn-secondary:hover {
            background: var(--secondary-hover);
            box-shadow: 0 4px 12px rgba(71, 85, 105, 0.3);
        }

        .btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background: var(--danger-hover);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* Card Styles */
        .card {
            background: var(--bg-primary);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-light);
            margin-bottom: 2rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-light);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            :root {
                --sidebar-width: 0px;
            }

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

            .card {
                padding: 1.5rem;
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

            .top-navbar {
                padding: 0 1rem;
            }
        }

        /* Sidebar Overlay for Mobile */
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

        /* Utility Classes */
        .hidden { display: none !important; }
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .justify-between { justify-content: space-between; }
        .gap-1 { gap: 0.25rem; }
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mt-4 { margin-top: 1rem; }
        .p-4 { padding: 1rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .rounded { border-radius: 8px; }
        .rounded-lg { border-radius: 12px; }
        .shadow { box-shadow: var(--shadow-sm); }
        .shadow-lg { box-shadow: var(--shadow-lg); }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .slide-up {
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    @vite(['resources/css/app.css','resources/js/app.js'])


    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    @yield('body')

    <!-- Global JavaScript -->
    <script>
        // Core functions available globally
        window.SkillMatch = {
            // Sidebar toggle functionality
            toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                if (sidebar && overlay) {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                }
            },

            // Close sidebar
            closeSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                if (sidebar && overlay) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                }
            },

            // Confirm logout
            confirmLogout() {
                return confirm('Are you sure you want to log out?');
            },

            // Initialize common functionality
            init() {
                console.log('SkillMatch core initialized');

                // Prevent horizontal scroll
                document.body.style.overflowX = 'hidden';
                document.documentElement.style.overflowX = 'hidden';

                // Sidebar toggle setup
                const sidebarToggle = document.getElementById('sidebarToggle');
                const sidebarOverlay = document.getElementById('sidebarOverlay');

                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', this.toggleSidebar);
                }

                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', this.closeSidebar);
                }

                // Close sidebar on window resize if desktop
                window.addEventListener('resize', () => {
                    if (window.innerWidth > 1024) {
                        this.closeSidebar();
                    }
                });

                // Global keyboard shortcuts
                document.addEventListener('keydown', (e) => {
                    // Escape to close sidebar or clear search
                    if (e.key === 'Escape') {
                        const searchInput = document.getElementById('globalSearch');
                        if (searchInput && searchInput.value) {
                            searchInput.value = '';
                            if (typeof window.clearSearch === 'function') {
                                window.clearSearch();
                            }
                        } else {
                            this.closeSidebar();
                        }
                    }

                    // Ctrl/Cmd + K to focus search
                    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                        e.preventDefault();
                        const searchInput = document.getElementById('globalSearch');
                        if (searchInput) {
                            searchInput.focus();
                            searchInput.select();
                        }
                    }
                });
            }
        };

        // Initialize when DOM is ready
        document.addEventListener('DOMContentLoaded', () => {
            window.SkillMatch.init();
        });
    </script>

    @stack('scripts')
</body>
</html>
