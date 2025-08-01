<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SkillMatch - Client Dashboard')</title>
    
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

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            background-color: #f8fafc;
        }

        /* Header */
        .header {
            background-color: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
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
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
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
            }
            
            .search-container {
                max-width: none;
            }
            
            .content-area {
                padding: 1rem;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo">
                <h1>Skill<span>Match</span></h1>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('client.dashboard') }}" class="nav-link active">
                        <div class="nav-icon">⊞</div>
                        Dashboard
                    </a>
                </li>
                <!-- Menu lain bisa ditambahkan nanti -->
            </ul>
        </nav>


            <!-- Content Area -->
            <div class="content-area">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Base JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Global search functionality
            const searchInput = document.getElementById('globalSearch');
            const searchBtn = document.getElementById('searchBtn');
            
            function performSearch() {
                const query = searchInput.value.trim();
                if (query) {
                    // Check if search function exists on dashboard
                    if (typeof window.searchTalents === 'function') {
                        window.searchTalents(query);
                    }
                } else {
                    if (typeof window.showAllTalents === 'function') {
                        window.showAllTalents();
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
                    if (typeof window.searchTalents === 'function') {
                        if (query.length > 2) {
                            window.searchTalents(query);
                        } else if (query.length === 0) {
                            window.showAllTalents();
                        }
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>