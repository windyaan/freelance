<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Order - SkillMatch')</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Iconify -->
    <script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            overflow-x: hidden;
        }

        /* Top Navigation Bar */
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
        }

        .navbar-left {
            display: flex;
            align-items: center;
            gap: 2rem;
            flex: 1;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 700;
            color: #38C1B9;
            text-decoration: none;
        }

        .navbar-brand span:last-child {
            color: #1e293b;
        }

        .navbar-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #64748b;
        }

        .navbar-center {
            flex: 2;
            display: flex;
            justify-content: center;
        }

        .search-container {
            position: relative;
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
        }

        .search-container:focus-within {
            border-color: #38C1B9;
            box-shadow: 0 4px 16px rgba(56, 193, 185, 0.15);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            color: #94a3b8;
            font-size: 1.1rem;
            z-index: 2;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: none;
            border-radius: 8px 0 0 8px;
            font-size: 0.9rem;
            background: transparent;
            outline: none;
            color: #334155;
        }

        .search-input::placeholder {
            color: #94a3b8;
        }

        .search-btn {
            background: #38C1B9;
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 0 6px 6px 0;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            margin: 4px 4px 4px 0;
            border-radius: 6px;
        }

        .search-btn:hover {
            background: #2da89f;
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
        }

        .navbar-profile:hover {
            border-color: #38C1B9;
        }

        .navbar-profile img {
            width: 100%;
            height: 100%;
            object-fit: cover;
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
        }

        .order-section {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title iconify-icon {
            font-size: 2rem;
            color: #38C1B9;
        }

        .filter-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #e2e8f0;
            background: white;
            color: #64748b;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .filter-btn:hover {
            border-color: #38C1B9;
            color: #38C1B9;
        }

        .filter-btn.active {
            background: #38C1B9;
            color: white;
            border-color: #38C1B9;
        }

        /* Order Cards */
        .order-grid {
            display: grid;
            gap: 1.5rem;
        }

        .order-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .order-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: #38C1B9;
        }

        .order-left {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex: 1;
        }

        .order-category {
            background: #e2e8f0;
            color: #64748b;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: lowercase;
            min-width: 100px;
            text-align: center;
        }

        .order-details {
            flex: 1;
        }

        .order-date {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.25rem;
        }

        .order-freelancer {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .order-title {
            font-size: 0.95rem;
            color: #334155;
            font-weight: 500;
        }

        .order-actions {
            display: flex;
            gap: 0.75rem;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-details {
            background: #64748b;
            color: white;
        }

        .btn-details:hover {
            background: #475569;
        }

        .btn-pay {
            background: #38C1B9;
            color: white;
        }

        .btn-pay:hover {
            background: #2da89f;
        }

        /* Mobile Responsiveness */
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
                padding: 1.5rem;
            }
            
            .navbar-center {
                flex: 1.5;
            }
        }

        @media (max-width: 768px) {
            .navbar-title {
                display: none;
            }
            
            .navbar-center {
                flex: 2;
            }
            
            .search-container {
                max-width: 280px;
            }
            
            .order-section {
                padding: 1.5rem;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .order-card {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }
            
            .order-left {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }
            
            .order-actions {
                justify-content: stretch;
            }
            
            .action-btn {
                flex: 1;
                text-align: center;
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
            
            .section-header {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }
            
            .filter-buttons {
                justify-content: flex-start;
                flex-wrap: wrap;
                gap: 0.25rem;
            }
            
            .filter-btn {
                font-size: 0.75rem;
                padding: 0.4rem 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <div class="top-navbar">
        <div class="navbar-left">
            <div class="sidebar-toggle" id="sidebarToggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <a href="{{ route('client.dashboard') }}" class="navbar-brand">
                Skill<span>Match</span>
            </a>
            <h1 class="navbar-title">Progress</h1>
        </div>
        <div class="navbar-center">
            <div class="search-container">
                <iconify-icon icon="material-symbols:search" class="search-icon"></iconify-icon>
                <input type="text" class="search-input" placeholder="Search here..." id="globalSearch">
                <button class="search-btn" id="searchBtn">Search</button>
            </div>
        </div>
        <div class="navbar-right">
            <div class="navbar-profile" onclick="goToProfile()">
                <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=40&h=40&fit=crop&crop=face" alt="Profile">
            </div>
            
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
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
            <a href="{{ route('client.dashboard') }}" class="nav-item {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                <div class="nav-icon">
                    <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
                </div>
                <span class="nav-text">Dashboard</span>
            </a>
            <a href="{{ route('client.chat') }}" class="nav-item {{ request()->routeIs('client.chat') ? 'active' : '' }}">
                <div class="nav-icon">
                    <iconify-icon icon="material-symbols:chat"></iconify-icon>
                </div>
                <span class="nav-text">Chat</span>
                <span class="nav-badge">3</span>
            </a>
    <a href="{{ route('client.order') }}" class="nav-item {{ request()->routeIs('client.order*') ? 'active' : '' }}">
    <div class="nav-icon">
        <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
    </div>
    <span class="nav-text">Order</span>
</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const searchInput = document.getElementById('globalSearch');
            const searchBtn = document.getElementById('searchBtn');
            
            // Sidebar functionality
            if (sidebarToggle && sidebar) {
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
            
            // Search functionality
            if (searchInput && searchBtn) {
                searchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const query = searchInput.value.trim();
                    if (query) {
                        console.log('Searching for:', query);
                        // Implement search logic here
                    }
                });
                
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const query = this.value.trim();
                        if (query) {
                            console.log('Searching for:', query);
                            // Implement search logic here
                        }
                    }
                });
            }
        });

        // Global functions
        function confirmLogout() {
            return confirm('Are you sure you want to log out?');
        }

        function goToProfile() {
            window.location.href = "{{ route('client.profile') ?? '/profile' }}";
        }

        function viewOrderDetails(orderId) {
            console.log('Viewing details for order:', orderId);
            // Navigate to order details page
            window.location.href = `/order/${orderId}`;
        }

        function makePayment(orderId) {
            console.log('Making payment for order:', orderId);
            if (confirm(`Proceed to payment for order ${orderId}?`)) {
                window.location.href = `/order/${orderId}/payment`;
            }
        }
    </script>

    @stack('scripts')
</body>
</html>