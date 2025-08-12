@extends('layouts.freelancer')

@section('title', 'Order - SkillMatch')

@section('content')
<!-- Embed sample orders data for demo purposes -->
<script id="order-data" type="application/json">
[
    {
        "id": 1,
        "title": "Buku cerita anak Aku Sayang Nenek",
        "freelancer": "Namira Enggar",
        "category": "Illustrator",
        "status": "completed",
        "price": 150000,
        "date": "2025-09-18",
        "deadline": "2025-09-25"
    },
    {
        "id": 2,
        "title": "Pembuatan design Kaos Barangsai",
        "freelancer": "Namira Enggar",
        "category": "Graphic Design",
        "status": "in_progress",
        "price": 250000,
        "date": "2025-09-21",
        "deadline": "2025-09-28"
    },
    {
        "id": 3,
        "title": "Buku mewarnai tema bermain di Pantai",
        "freelancer": "Nadia Ima",
        "category": "Illustrator",
        "status": "pending",
        "price": 200000,
        "date": "2025-09-24",
        "deadline": "2025-10-01"
    }
]
</script>

<style>
/* Previous CSS remains the same - keeping it short for space */
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

.orders-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    overflow: hidden;
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
    align-items: center;
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

.orders-grid {
    display: grid;
    gap: 1.5rem;
}

.order-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border-color: #38C1B9;
}

.order-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: #38C1B9;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.order-card:hover::before {
    opacity: 1;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.order-date {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.order-day {
    font-size: 0.85rem;
    color: #64748b;
}

.order-status {
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
}

.status-completed {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.status-in_progress {
    background: rgba(251, 191, 36, 0.1);
    color: #d97706;
    border: 1px solid rgba(251, 191, 36, 0.2);
}

.status-pending {
    background: rgba(156, 163, 175, 0.1);
    color: #6b7280;
    border: 1px solid rgba(156, 163, 175, 0.2);
}

.status-cancelled {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.order-content {
    margin-bottom: 1rem;
}

.order-category {
    display: inline-block;
    background: #38C1B9;
    color: white;
    padding: 0.3rem 0.6rem;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    text-transform: capitalize;
}

.order-freelancer {
    font-size: 0.9rem;
    color: #64748b;
    margin-bottom: 0.5rem;
}

.order-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    line-height: 1.4;
    margin-bottom: 1rem;
}

.order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.order-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: #38C1B9;
}

.order-actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    font-size: 0.8rem;
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
    transform: translateY(-1px);
}

.btn-pay {
    background: #38C1B9;
    color: white;
}

.btn-pay:hover {
    background: #2da89f;
    transform: translateY(-1px);
}

.btn-contact {
    background: #f1f5f9;
    color: #64748b;
    border: 1px solid #e2e8f0;
}

.btn-contact:hover {
    background: #e2e8f0;
    color: #475569;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #64748b;
}

.empty-state iconify-icon {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 1rem;
    margin-bottom: 2rem;
}

.empty-state .btn-primary {
    background: #38C1B9;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
}

.empty-state .btn-primary:hover {
    background: #2da89f;
    transform: translateY(-1px);
}

.order-deadline {
    font-size: 0.8rem;
    color: #64748b;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.order-deadline iconify-icon {
    font-size: 0.9rem;
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
    
    .navbar-center {
        flex: 1.5;
        max-width: 350px;
    }
    
    .search-container {
        max-width: 320px;
    }
    
    .section-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .filter-buttons {
        width: 100%;
        justify-content: flex-start;
        flex-wrap: wrap;
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
    
    .orders-section {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .main-content {
        padding: 1rem;
    }
    
    .order-header {
        flex-direction: column;
        gap: 0.75rem;
        align-items: flex-start;
    }
    
    .order-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
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
    
    .order-card {
        padding: 1rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .filter-buttons {
        gap: 0.25rem;
    }
    
    .filter-btn {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
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
        <!-- Updated navbar brand with Laravel route -->
        <a href="{{ route('freelancer.dashboard') }}" class="navbar-brand">
            <div class="logo" style="margin-top: 60px;">
                <h1>Skill<span>Match</span></h1>
            </div>
        </a>
        <h1 class="navbar-title">Order</h1>
    </div>
    <div class="navbar-center">
        <div class="search-container">
            <iconify-icon icon="material-symbols:search" class="search-icon"></iconify-icon>
            <input type="text" class="search-input" placeholder="Search order..." id="globalSearch">
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
        <!-- Updated sidebar navigation with Laravel routes -->
        <a href="{{ route('freelancer.dashboard') }}" class="nav-item {{ request()->routeIs('freelancer.dashboard') ? 'active' : '' }}">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
            </div>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="{{ route('freelancer.chat') }}" class="nav-item {{ request()->routeIs('freelancer.chat') ? 'active' : '' }}">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:chat"></iconify-icon>
            </div>
            <span class="nav-text">Chat</span>
            <span class="nav-badge">3</span>
        </a>
        <a href="#" class="nav-item {{ request()->routeIs('freelancer.order') ? 'active' : '' }}">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
            </div>
            <span class="nav-text">Order</span>
        </a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Orders Section -->
    <div class="order-section">
        <div class="section-header">
            <h1 class="section-title">
                <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
                My Order
            </h1>
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="pending">Pending</button>
                <button class="filter-btn" data-filter="in_progress">In Progress</button>
                <button class="filter-btn" data-filter="completed">Completed</button>
                <button class="filter-btn" data-filter="cancelled">Cancelled</button>
            </div>
        </div>

        <div class="order-grid" id="orderGrid">
            <!-- Sample Order Cards - these would be populated from your database -->
            <div class="order-card" data-status="completed" data-order-id="1">
                <div class="order-header">
                    <div>
                        <div class="order-date">Thursday, 18 September 2025</div>
                        <div class="order-day">Sep 18, 2025</div>
                    </div>
                    <div class="order-status status-completed">Completed</div>
                </div>
                
                <div class="order-content">
                    <div class="order-category">illustrator</div>
                    <div class="order-freelancer">Freelancer: Namira Enggar</div>
                    <div class="order-title">Buku cerita anak Aku Sayang Nenek</div>
                    <div class="order-deadline">
                        <iconify-icon icon="material-symbols:schedule"></iconify-icon>
                        Deadline: Sep 25, 2025
                    </div>
                </div>
                
                <div class="order-footer">
                    <div class="order-price">Rp150.000</div>
                    <div class="order-actions">
                        <button class="action-btn btn-details" onclick="viewOrderDetails(1)">Details</button>
                        <button class="action-btn btn-contact" onclick="contactFreelancer('namira')">Contact</button>
                    </div>
                </div>
            </div>

            <div class="order-card" data-status="in_progress" data-order-id="2">
                <div class="order-header">
                    <div>
                        <div class="order-date">Sunday, 21 September 2025</div>
                        <div class="order-day">Sep 21, 2025</div>
                    </div>
                    <div class="order-status status-in_progress">In Progress</div>
                </div>
                
                <div class="order-content">
                    <div class="order-category">graphic design</div>
                    <div class="order-freelancer">Freelancer: Namira Enggar</div>
                    <div class="order-title">Pembuatan design Kaos Barangsai</div>
                    <div class="order-deadline">
                        <iconify-icon icon="material-symbols:schedule"></iconify-icon>
                        Deadline: Sep 28, 2025
                    </div>
                </div>
                
                <div class="order-footer">
                    <div class="order-price">Rp250.000</div>
                    <div class="order-actions">
                        <button class="action-btn btn-details" onclick="viewOrderDetails(2)">Details</button>
                        <button class="action-btn btn-pay" onclick="makePayment(2)">Pay Now</button>
                    </div>
                </div>
            </div>

            <div class="order-card" data-status="pending" data-order-id="3">
                <div class="order-header">
                    <div>
                        <div class="order-date">Wednesday, 24 September 2025</div>
                        <div class="order-day">Sep 24, 2025</div>
                    </div>
                    <div class="order-status status-pending">Pending</div>
                </div>
                
                <div class="order-content">
                    <div class="order-category">illustrator</div>
                    <div class="order-freelancer">Freelancer: Nadia Ima</div>
                    <div class="order-title">Buku mewarnai tema bermain di Pantai</div>
                    <div class="order-deadline">
                        <iconify-icon icon="material-symbols:schedule"></iconify-icon>
                        Deadline: Oct 1, 2025
                    </div>
                </div>
                
                <div class="order-footer">
                    <div class="order-price">Rp200.000</div>
                    <div class="order-actions">
                        <button class="action-btn btn-details" onclick="viewOrderDetails(3)">Details</button>
                        <button class="action-btn btn-pay" onclick="makePayment(3)">Pay Now</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Empty State (hidden by default, shown when no orders match filter) -->
        <div class="empty-state" id="emptyState" style="display: none;">
            <iconify-icon icon="material-symbols:inbox"></iconify-icon>
            <h3>No order found</h3>
            <p>You don't have any order matching the current filter.</p>
            <a href="{{ route('freelancer.dashboard') }}" class="btn-primary">
                <iconify-icon icon="material-symbols:add"></iconify-icon>
                Browse Talents
            </a>
        </div>
    </div>
</div>

<script>
// Orders page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Get orders data from the embedded JSON script
    let orderData = [];
    try {
        const orderScript = document.getElementById('order-data');
        if (orderScript && orderScript.textContent) {
            orderData = JSON.parse(orderScript.textContent);
        }
    } catch (error) {
        console.error('Failed to parse order data:', error);
        orderData = [];
    }
    
    // Cache DOM elements
    const searchInput = document.getElementById('globalSearch');
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const orderGrid = document.getElementById('orderGrid');
    const emptyState = document.getElementById('emptyState');
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    let currentFilter = 'all';
    
    // Prevent horizontal scroll
    if (document.body) {
        document.body.style.overflowX = 'hidden';
    }
    if (document.documentElement) {
        document.documentElement.style.overflowX = 'hidden';
    }
    
    // Filter functionality
    function filterOrder(status) {
        currentFilter = status;
        const orderCards = document.querySelectorAll('.order-card');
        let visibleCount = 0;
        
        orderCards.forEach(card => {
            const cardStatus = card.getAttribute('data-status');
            const shouldShow = status === 'all' || cardStatus === status;
            
            if (shouldShow) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide empty state
        if (visibleCount === 0) {
            orderGrid.style.display = 'none';
            emptyState.style.display = 'block';
        } else {
            orderGrid.style.display = 'block';
            emptyState.style.display = 'none';
        }
        
        // Update active filter button
        filterButtons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('data-filter') === status) {
                btn.classList.add('active');
            }
        });
    }
    
    // Search functionality
    function searchOrder(query) {
        if (!query || query.length < 2) {
            filterOrder(currentFilter);
            return;
        }
        
        const orderCards = document.querySelectorAll('.order-card');
        let visibleCount = 0;
        const searchTerm = query.toLowerCase();
        
        orderCards.forEach(card => {
            const title = card.querySelector('.order-title').textContent.toLowerCase();
            const freelancer = card.querySelector('.order-freelancer').textContent.toLowerCase();
            const category = card.querySelector('.order-category').textContent.toLowerCase();
            
            const matchesSearch = title.includes(searchTerm) || 
                                freelancer.includes(searchTerm) || 
                                category.includes(searchTerm);
            
            const matchesFilter = currentFilter === 'all' || 
                                card.getAttribute('data-status') === currentFilter;
            
            if (matchesSearch && matchesFilter) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide empty state
        if (visibleCount === 0) {
            orderGrid.style.display = 'none';
            emptyState.style.display = 'block';
        } else {
            orderGrid.style.display = 'block';
            emptyState.style.display = 'none';
        }
    }
    
    // Event listeners for filter buttons
    filterButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const filter = this.getAttribute('data-filter');
            filterOrder(filter);
            
            // Clear search when filtering
            if (searchInput) {
                searchInput.value = '';
            }
        });
    });
    
    // Search input event listeners
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            searchOrder(query);
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = this.value.trim();
                searchOrder(query);
            }
        });
    }
    
    // Search button functionality
    const searchBtn = document.getElementById('searchBtn');
    if (searchBtn) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (searchInput) {
                const query = searchInput.value.trim();
                searchOrder(query);
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
    
    // Order card click handling
    document.addEventListener('click', function(e) {
        const orderCard = e.target.closest('.order-card');
        if (orderCard && !e.target.closest('.action-btn')) {
            // Click on card but not on buttons - could show order details
            const orderId = orderCard.getAttribute('data-order-id');
            console.log('Order card clicked:', orderId);
            // You can add navigation to order details here
        }
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Escape to clear search
        if (e.key === 'Escape') {
            if (searchInput && searchInput.value) {
                searchInput.value = '';
                filterOrder(currentFilter);
            }
        }
        
        // Ctrl/Cmd + K to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
            }
        }
        
        // Number keys for quick filtering
        if (e.key >= '1' && e.key <= '5' && !e.target.matches('input')) {
            e.preventDefault();
            const filters = ['all', 'pending', 'in_progress', 'completed', 'cancelled'];
            const filterIndex = parseInt(e.key) - 1;
            if (filters[filterIndex]) {
                filterOrder(filters[filterIndex]);
                if (searchInput) {
                    searchInput.value = '';
                }
            }
        }
    });
    
    // Order hover effects
    const orderCards = document.querySelectorAll('.order-card');
    orderCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Initialize page
    filterOrder('all');
    
    console.log('Order page initialized successfully');
});

// Global functions for order actions
function viewOrderDetails(orderId) {
    console.log('Viewing details for order:', orderId);
    // Here you would navigate to the order details page
    // window.location.href = `/orders/${orderId}`;
    alert(`Viewing details for order ${orderId}`);
}

function makePayment(orderId) {
    console.log('Making payment for order:', orderId);
    // Here you would navigate to the payment page
    // window.location.href = `/orders/${orderId}/payment`;
    if (confirm(`Proceed to payment for order ${orderId}?`)) {
        alert(`Redirecting to payment for order ${orderId}`);
    }
}

function contactFreelancer(freelancerName) {
    console.log('Contacting freelancer:', freelancerName);
    // Here you would navigate to chat or contact page
    // window.location.href = `/chat/${freelancerName}`;
    alert(`Opening chat with ${freelancerName}`);
}

// Logout confirmation function
function confirmLogout() {
    return confirm('Are you sure you want to log out?');
}

// Profile navigation function
function goToProfile() {
    window.location.href = "/profile";
}
</script>
@endsection