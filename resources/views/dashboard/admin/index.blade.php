@extends('layouts.admin')

@section('title', 'Admin Dashboard - SkillMatch')

@section('content')
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
}

/* Top Navigation - Fixed Height */
.top-navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 50px; /* Further reduced from 60px */
    background: white;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 1.25rem; /* Reduced padding */
    z-index: 1001;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.navbar-left {
    display: flex;
    align-items: center;
    gap: 1.25rem; /* Reduced gap */
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 1.1rem; /* Further reduced from 1.25rem */
    font-weight: 700;
    color: #38C1B9;
    text-decoration: none;
}

.navbar-brand span {
    color: #1e293b;
}

.navbar-title {
    font-size: 1.1rem; /* Further reduced from 1.25rem */
    font-weight: 700;
    color: #1e293b;
}

.navbar-center {
    display: none; /* Hide search bar completely */
}

.search-container-nav {
    position: relative;
    width: 100%;
    max-width: 350px; /* Reduced from 400px */
}

.search-input-nav {
    width: 100%;
    padding: 0.5rem 1rem 0.5rem 2.25rem; /* Reduced padding */
    border: 1px solid #e2e8f0;
    border-radius: 20px; /* Reduced from 25px */
    font-size: 0.85rem; /* Reduced from 0.9rem */
    background: #f8fafc;
    transition: all 0.2s ease;
    color: #64748b;
    height: 36px; /* Fixed height */
}

.search-input-nav:focus {
    outline: none;
    border-color: #38C1B9;
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
    background: white;
}

.search-input-nav::placeholder {
    color: #94a3b8;
}

.search-icon-nav {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 1rem; /* Reduced from 1.1rem */
    pointer-events: none;
}

.search-btn-nav {
    position: absolute;
    right: 0.25rem;
    top: 50%;
    transform: translateY(-50%);
    background: #38C1B9;
    color: white;
    border: none;
    padding: 0.4rem 0.8rem; /* Reduced padding */
    border-radius: 16px; /* Reduced from 20px */
    font-size: 0.8rem; /* Reduced from 0.85rem */
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    height: 28px; /* Fixed height */
}

.search-btn-nav:hover {
    background: #2da89f;
    transform: translateY(-50%) translateY(-1px);
}

.navbar-right {
    display: flex;
    align-items: center;
    gap: 0.75rem; /* Reduced from 1rem */
}

.navbar-profile {
    width: 32px; /* Further reduced from 36px */
    height: 32px; /* Further reduced from 36px */
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
    background: #ff4757;
    color: white;
    border: none;
    padding: 0.35rem 0.7rem; /* Further reduced padding */
    border-radius: 6px; /* Reduced border radius */
    font-size: 0.75rem; /* Further reduced from 0.8rem */
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.3rem; /* Further reduced gap */
    height: 28px; /* Reduced height */
}

.navbar-logout:hover {
    background: #ff3838;
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

/* Sidebar */
.sidebar {
    position: fixed;
    left: 0;
    top: 50px; /* Updated to match navbar height */
    width: 180px; /* Reduced from 200px */
    height: calc(100vh - 50px);
    background: #ffffff;
    border-right: 1px solid #e2e8f0;
    z-index: 1000;
    padding: 1.5rem 0; /* Reduced padding */
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 0.6rem 1rem; /* Reduced padding */
    color: #64748b;
    text-decoration: none;
    cursor: pointer;
    margin-bottom: 0.2rem; /* Reduced margin */
    transition: all 0.2s ease;
    font-weight: 500;
    font-size: 0.9rem; /* Added font size */
}

.nav-item:hover {
    background: #f8fafc;
    color: #1e293b;
    text-decoration: none;
}

.nav-item.active {
    background: #475569;
    color: white;
    border-radius: 8px; /* Reduced from 12px */
    margin: 0 0.75rem 0.2rem 0.75rem; /* Reduced margin */
}

.nav-icon {
    width: 28px; /* Reduced from 32px */
    height: 28px; /* Reduced from 32px */
    margin-right: 0.6rem; /* Reduced from 0.75rem */
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem; /* Reduced from 1.2rem */
    background: #f1f5f9;
    border-radius: 6px;
    color: #64748b;
}

.nav-item.active .nav-icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

/* Main Content */
.main-content {
    margin-left: 180px; /* Updated to match sidebar width */
    margin-top: 50px; /* Updated to match navbar height */
    min-height: calc(100vh - 50px);
    padding: 1.5rem; /* Reduced from 2rem */
    background: #f8fafc;
}

/* Stats Section */
.stats-container {
    display: flex;
    gap: 1.25rem; /* Reduced from 1.5rem */
    margin-bottom: 1.5rem; /* Reduced from 2rem */
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.25rem; /* Reduced from 1.5rem */
    flex: 1;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem; /* Reduced from 1.5rem */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    transition: all 0.2s ease;
    text-align: center;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 44px; /* Reduced from 48px */
    height: 44px; /* Reduced from 48px */
    margin: 0 auto 0.75rem; /* Reduced margin */
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem; /* Reduced from 1.5rem */
    color: white;
}

.stat-card.freelance .stat-icon {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
}

.stat-card.client .stat-icon {
    background: linear-gradient(135deg, #f59e0b, #f97316);
}

.stat-card.order .stat-icon {
    background: linear-gradient(135deg, #10b981, #059669);
}

.stat-title {
    font-size: 0.85rem; /* Reduced from 0.9rem */
    color: #64748b;
    font-weight: 500;
    margin-bottom: 0.4rem; /* Reduced margin */
}

.stat-number {
    font-size: 1.75rem; /* Reduced from 2rem */
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.2rem; /* Reduced margin */
}

.stat-label {
    font-size: 0.75rem; /* Reduced from 0.8rem */
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Profit Card */
.profit-card {
    background: linear-gradient(135deg, #38C1B9, #10b981);
    color: white;
    border-radius: 12px;
    padding: 1.5rem; /* Reduced from 2rem */
    min-width: 240px; /* Reduced from 280px */
    text-align: center;
    box-shadow: 0 4px 16px rgba(56, 193, 185, 0.3);
}

.profit-title {
    font-size: 0.85rem; /* Reduced from 0.9rem */
    opacity: 0.9;
    margin-bottom: 0.4rem; /* Reduced margin */
    font-weight: 500;
}

.profit-amount {
    font-size: 2.25rem; /* Reduced from 2.5rem */
    font-weight: 700;
    margin-bottom: 0.4rem; /* Reduced margin */
}

/* Users Section */
.users-section {
    background: white;
    border-radius: 12px;
    padding: 1.5rem; /* Reduced from 2rem */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
}

.users-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem; /* Reduced from 2rem */
}

.users-title {
    font-size: 1.125rem; /* Reduced from 1.25rem */
    font-weight: 700;
    color: #1e293b;
}

.search-container {
    display: flex;
    align-items: center;
    gap: 0.6rem; /* Reduced from 0.75rem */
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input {
    padding: 0.6rem 1rem 0.6rem 2.25rem; /* Reduced padding */
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.85rem; /* Reduced from 0.9rem */
    width: 240px; /* Reduced from 280px */
    background: #f8fafc;
    transition: all 0.2s ease;
    height: 36px; /* Fixed height */
}

.search-input:focus {
    outline: none;
    border-color: #38C1B9;
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
    background: white;
}

.search-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 1rem; /* Reduced from 1.1rem */
    pointer-events: none;
}

.search-btn {
    background: #38C1B9;
    color: white;
    border: none;
    padding: 0.6rem 1rem; /* Reduced padding */
    border-radius: 8px;
    font-size: 0.85rem; /* Reduced from 0.9rem */
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    height: 36px; /* Fixed height */
}

.search-btn:hover {
    background: #2da89f;
    transform: translateY(-1px);
}

.export-btn {
    background: #38C1B9;
    color: white;
    border: 1px solid #e2e8f0;
    padding: 0.6rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    height: 36px;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.export-btn:hover {
    background: #38C1B9;
    color: white;
    text-decoration: none;
}

/* Users Table */
.users-table-container {
    overflow-x: auto;
    border-radius: 8px;
    border: 1px solid #f1f5f9;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    font-size: 0.85rem; /* Reduced from 0.9rem */
}

.users-table th,
.users-table td {
    padding: 0.75rem 0.6rem; /* Reduced padding */
    text-align: left;
    border-bottom: 1px solid #f1f5f9;
}

.users-table th {
    background: #f8fafc;
    font-weight: 600;
    color: #475569;
    font-size: 0.75rem; /* Reduced from 0.8rem */
    text-transform: uppercase;
    letter-spacing: 0.5px;
    position: relative;
}

.users-table th.sortable {
    cursor: pointer;
    user-select: none;
}

.users-table th.sortable:hover {
    background: #f1f5f9;
}

.sort-arrows {
    display: inline-block;
    margin-left: 4px;
    font-size: 0.9rem;
    color: #94a3b8;
    opacity: 0.7;
}

.users-table th.sortable:hover .sort-arrows {
    opacity: 1;
}

.users-table tbody tr {
    transition: all 0.2s ease;
}

.users-table tbody tr:hover {
    background: #f8fafc;
}

.users-table tbody tr:last-child td {
    border-bottom: none;
}

/* User Role Badges */
.user-role {
    padding: 0.25rem 0.5rem; /* Reduced padding */
    border-radius: 6px;
    font-size: 0.7rem; /* Reduced from 0.75rem */
    font-weight: 600;
    text-transform: capitalize;
    display: inline-block;
}

.user-role.freelancer {
    background: #dbeafe;
    color: #1e40af;
}

.user-role.client {
    background: #fef3c7;
    color: #92400e;
}

.user-role.admin {
    background: #f3e8ff;
    color: #7c3aed;
}

/* Status Badges */
.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    display: inline-block;
}

.status-badge.active {
    background: #dcfce7;
    color: #15803d;
}

.status-badge.inactive {
    background: #fed7d7;
    color: #c53030;
}

/* Category/Skill Tags */
.skill-tag {
    background: #38C1B9;
    color: white;
    padding: 0.2rem 0.4rem; /* Reduced padding */
    border-radius: 4px;
    font-size: 0.65rem; /* Reduced from 0.7rem */
    font-weight: 500;
}

.skill-tag.illustrator {
    background: #6366f1;
}

.skill-tag.graphic-design {
    background: #10b981;
}

.skill-tag.fullstack {
    background: #f59e0b;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.4rem; /* Reduced from 0.5rem */
}

.edit-btn, .delete-btn {
    width: 28px; /* Reduced from 32px */
    height: 28px; /* Reduced from 32px */
    border: none;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    font-size: 0.9rem; /* Reduced from 1rem */
}

.edit-btn {
    background: #e0f2fe;
    color: #0369a1;
}

.edit-btn:hover {
    background: #0369a1;
    color: white;
    transform: translateY(-1px);
}

.delete-btn {
    background: #fef2f2;
    color: #dc2626;
}

.delete-btn:hover {
    background: #dc2626;
    color: white;
    transform: translateY(-1px);
}

/* Mobile menu toggle */
.sidebar-toggle {
    display: none;
    flex-direction: column;
    cursor: pointer;
    width: 20px; /* Reduced from 24px */
    height: 15px; /* Reduced from 18px */
    justify-content: space-between;
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

    .main-content {
        margin-left: 0;
    }

    .navbar-center {
        display: none;
    }

    .stats-container {
        flex-direction: column;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .sidebar-toggle {
        display: flex !important;
    }
}

@media (max-width: 768px) {
    .users-header {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .search-container {
        flex-direction: column;
        gap: 0.75rem;
    }

    .search-input {
        width: 100%;
    }

    .main-content {
        padding: 1rem;
    }

    .top-navbar {
        padding: 0 1rem;
    }

    .navbar-left {
        gap: 1rem;
    }

    .navbar-brand {
        font-size: 1rem;
    }

    .navbar-title {
        display: none;
    }
}
</style>

<!-- Load Iconify -->
<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

<!-- Top Navigation -->
<div class="top-navbar">
    <div class="navbar-left">
        <div class="sidebar-toggle" id="sidebarToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <a href="#" class="navbar-brand">
            <h1>Skill<span>Match</span></h1>
        </a>
        <h1 class="navbar-title">Dashboard</h1>
    </div>

    <div class="navbar-right">
        <div class="navbar-profile" onclick="goToProfile()">
            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=32&h=32&fit=crop&crop=face" alt="Admin Profile">
        </div>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
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
        <a href="#" class="nav-item active">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
            </div>
            <span>Dashboard</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
            </div>
            <span>Orders</span>
        </a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Stats Section -->
    <div class="stats-container">
        <div class="stats-grid">
            <div class="stat-card freelance">
                <div class="stat-icon">
                    <iconify-icon icon="material-symbols:person-check"></iconify-icon>
                </div>
                <div class="stat-title">Freelance</div>
                <div class="stat-number">{{ $totalFreelancers ?? 200 }}</div>
                <div class="stat-label">Person</div>
            </div>

            <div class="stat-card client">
                <div class="stat-icon">
                    <iconify-icon icon="material-symbols:groups"></iconify-icon>
                </div>
                <div class="stat-title">Client</div>
                <div class="stat-number">{{ $totalClients ?? 135 }}</div>
                <div class="stat-label">Person</div>
            </div>

            <div class="stat-card order">
                <div class="stat-icon">
                    <iconify-icon icon="material-symbols:shopping-bag"></iconify-icon>
                </div>
                <div class="stat-title">Order</div>
                <div class="stat-number">{{ $totalOrders ?? 120 }}</div>
                <div class="stat-label">Orders</div>
            </div>
        {{-- </div> --}}

        <div class="profit-card">
            <div class="profit-title">Profit</div>
            {{-- <div class="profit-amount">Rp4.300.000</div> --}}
             <div class="profit-amount">Rp{{ number_format($totalProfit, 0, ',', '.') }}
        </div>
    </div>
</div>
</div>

    <!-- Users Section -->
    <div class="users-section">
        <div class="users-header">
            <h2 class="users-title">Users</h2>
            <div class="search-container">
                <div class="search-input-wrapper">
                    <iconify-icon icon="material-symbols:search" class="search-icon"></iconify-icon>
                    <input type="text" class="search-input" placeholder="Search here..." id="userSearch">
                </div>
                <button class="search-btn" onclick="searchUsers()">
                    Search
                </button>
                <a href="{{ route('admin.exportUsersProfitPdf') }}" class="export-btn">EXPORT DATA</a>
            </div>
        </div>

        <div class="users-table-container">
            <table class="users-table">
                <thead>
                    <tr>
                        <th class="sortable" onclick="sortTable(0, this)">
                            User Role
                            <span class="sort-arrows">↕</span>
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th class="sortable" onclick="sortTable(3, this)">
                            Applied Date
                            <span class="sort-arrows">↕</span>
                        </th>
                        <th class="sortable" onclick="sortTable(4, this)">
                            Status
                            <span class="sort-arrows">↕</span>
                        </th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    <tr data-role="freelancer" data-name="Adam Johnson" data-email="adam@gmail.com">
                        <td><span class="user-role freelancer">Freelancer</span></td>
                        <td>Adam Johnson</td>
                        <td>adam@gmail.com</td>
                        <td>Sept 4, 2023</td>
                        <td><span class="status-badge active">Active</span></td>
                    </tr>
                    <tr data-role="freelancer" data-name="Charlie Brooke" data-email="charlie@gmail.com">
                        <td><span class="user-role freelancer">Freelancer</span></td>
                        <td>Charlie Brooke</td>
                        <td>charlie@gmail.com</td>
                        <td>Sept 2, 2023</td>
                        <td><span class="status-badge inactive">Inactive</span></td>
                    </tr>
                    <tr data-role="freelancer" data-name="Jacob Brown" data-email="jacob@gmail.com">
                        <td><span class="user-role freelancer">Freelancer</span></td>
                        <td>Jacob Brown</td>
                        <td>jacob@gmail.com</td>
                        <td>Aug 31, 2023</td>
                        <td><span class="status-badge active">Active</span></td>
                    </tr>
                    <tr data-role="client" data-name="Darrell Steward" data-email="steward23@gmail.com">
                        <td><span class="user-role client">Client</span></td>
                        <td>Darrell Steward</td>
                        <td>steward23@gmail.com</td>
                        <td>Aug 29, 2023</td>
                        <td><span class="status-badge active">Active</span></td>
                    </tr>
                    <tr data-role="freelancer" data-name="Eleanor Pena" data-email="eleanor@gmail.com">
                        <td><span class="user-role freelancer">Freelancer</span></td>
                        <td>Eleanor Pena</td>
                        <td>eleanor@gmail.com</td>
                        <td>Aug 26, 2023</td>
                        <td><span class="status-badge active">Active</span></td>
                    </tr>
                    <tr data-role="client" data-name="Courtney Henry" data-email="courtney@gmail.com">
                        <td><span class="user-role client">Client</span></td>
                        <td>Courtney Henry</td>
                        <td>courtney@gmail.com</td>
                        <td>Aug 23, 2023</td>
                        <td><span class="status-badge inactive">Inactive</span></td>
                    </tr>
                    <tr data-role="freelancer" data-name="Robert Fox" data-email="robertfox98@gmail.com">
                        <td><span class="user-role freelancer">Freelancer</span></td>
                        <td>Robert Fox</td>
                        <td>robertfox98@gmail.com</td>
                        <td>Aug 20, 2023</td>
                        <td><span class="status-badge active">Active</span></td>
                    </tr>
                    <tr data-role="client" data-name="Jenny Wilson" data-email="jennywilson21@gmail.com">
                        <td><span class="user-role client">Client</span></td>
                        <td>Jenny Wilson</td>
                        <td>jennywilson21@gmail.com</td>
                        <td>Aug 19, 2023</td>
                        <td><span class="status-badge active">Active</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');

    // Toggle sidebar on mobile
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });
    }

    // Search functionality for users table
    const searchInput = document.getElementById('userSearch');
    let searchTimeout;

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.toLowerCase();
            searchTimeout = setTimeout(function() {
                searchUsers(query);
            }, 300);
        });
    }

    // Navbar search functionality
    const navbarSearchInput = document.getElementById('navbarSearch');
    if (navbarSearchInput) {
        navbarSearchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performNavbarSearch();
            }
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 1024) {
            if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        }
    });
});

function confirmLogout() {
    return confirm('Are you sure you want to log out?');
}

function goToProfile() {
    window.location.href = "{{ route('profile.edit') ?? '#' }}";
}

function performNavbarSearch() {
    const searchQuery = document.getElementById('navbarSearch').value;
    if (searchQuery.trim()) {
        // Implement your navbar search functionality here
        console.log('Searching for:', searchQuery);

        // Option 1: Filter current users table (immediate feedback)
        searchUsers(searchQuery.toLowerCase());

        // Option 2: Redirect to search page with results
        // window.location.href = "/search?q=" + encodeURIComponent(searchQuery);
    }
}

function searchUsers(query = null) {
    if (query === null) {
        query = document.getElementById('userSearch').value.toLowerCase();
    }

    const rows = document.querySelectorAll('#usersTableBody tr');
    let visibleCount = 0;

    rows.forEach(function(row) {
        const role = (row.getAttribute('data-role') || '').toLowerCase();
        const name = (row.getAttribute('data-name') || '').toLowerCase();
        const email = (row.getAttribute('data-email') || '').toLowerCase();
        const text = row.textContent.toLowerCase();

        const hasMatch = role.includes(query) ||
                        name.includes(query) ||
                        email.includes(query) ||
                        text.includes(query);

        if (hasMatch || query === '') {
            row.style.display = 'table-row';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    // Optional: Show message if no results found
    if (visibleCount === 0 && query !== '') {
        console.log('No users found matching: ' + query);
    }
}

function editUser(button) {
    const row = button.closest('tr');
    const name = row.getAttribute('data-name');
    const role = row.getAttribute('data-role');
    const email = row.getAttribute('data-email');

    alert(`Edit user: ${name} (${role})\nEmail: ${email}`);
    // Implement your edit functionality here
    // Example: window.location.href = `/admin/users/edit/${userId}`;
}

function deleteUser(button) {
    const row = button.closest('tr');
    const name = row.getAttribute('data-name');

    if (confirm(`Are you sure you want to delete user "${name}"?`)) {
        // Add loading state
        button.disabled = true;
        button.innerHTML = '<iconify-icon icon="material-symbols:hourglass-empty"></iconify-icon>';

        // Simulate API call - replace with actual delete request
        setTimeout(function() {
            row.remove();
            // Show success message
            console.log(`User "${name}" deleted successfully`);

            // In real implementation, make AJAX call to delete endpoint
            // fetch(`/admin/users/delete/${userId}`, { method: 'DELETE' })
            //     .then(response => response.json())
            //     .then(data => {
            //         if (data.success) {
            //             row.remove();
            //         }
            //     });
        }, 1000);
    }
}

function exportData() {
    // Implement export functionality
    alert('Exporting user data...');

    // Example: Generate CSV or redirect to export endpoint
    // window.location.href = '/admin/users/export';
}

// Add smooth scrolling for better UX
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Add keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.getElementById('userSearch') || document.getElementById('navbarSearch');
        if (searchInput) {
            searchInput.focus();
        }
    }

    // Escape to close mobile sidebar
    if (e.key === 'Escape') {
        const sidebar = document.getElementById('sidebar');
        if (sidebar && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
        }
    }
});

// Add sorting functionality
let sortOrder = {};

function sortTable(columnIndex, headerElement) {
    const table = document.querySelector('.users-table tbody');
    const rows = Array.from(table.querySelectorAll('tr'));
    const isAscending = !sortOrder[columnIndex];

    // Update sort order
    sortOrder[columnIndex] = isAscending;

    // Reset all arrows
    document.querySelectorAll('.sort-arrows').forEach(arrow => {
        arrow.textContent = '↕';
        arrow.style.color = '#94a3b8';
    });

    // Update current arrow
    const arrow = headerElement.querySelector('.sort-arrows');
    arrow.textContent = isAscending ? '↑' : '↓';
    arrow.style.color = '#38C1B9';

    // Sort rows
    rows.sort((a, b) => {
        let aValue = a.cells[columnIndex].textContent.trim();
        let bValue = b.cells[columnIndex].textContent.trim();

        // Special handling for different column types
        if (columnIndex === 3) { // Applied Date column
            // Parse dates for proper sorting
            const dateA = parseDate(aValue);
            const dateB = parseDate(bValue);

            if (isAscending) {
                // Panah atas = terbaru dulu (newest first)
                return dateB - dateA;
            } else {
                // Panah bawah = terlama dulu (oldest first)
                return dateA - dateB;
            }
        } else if (columnIndex === 0) { // User Role column
            // Sort by role priority: Admin > Client > Freelancer
            const roleOrder = { 'admin': 3, 'client': 2, 'freelancer': 1 };
            const roleA = aValue.toLowerCase();
            const roleB = bValue.toLowerCase();

            if (isAscending) {
                return (roleOrder[roleB] || 0) - (roleOrder[roleA] || 0);
            } else {
                return (roleOrder[roleA] || 0) - (roleOrder[roleB] || 0);
            }
        } else if (columnIndex === 4) { // Status column
            // Sort by status: Active > Inactive
            const statusOrder = { 'active': 2, 'inactive': 1 };
            const statusA = aValue.toLowerCase();
            const statusB = bValue.toLowerCase();

            if (isAscending) {
                return (statusOrder[statusB] || 0) - (statusOrder[statusA] || 0);
            } else {
                return (statusOrder[statusA] || 0) - (statusOrder[statusB] || 0);
            }
        } else {
            // Regular text sorting for Name and Email
            aValue = aValue.toLowerCase();
            bValue = bValue.toLowerCase();

            if (isAscending) {
                // Panah atas = A-Z
                if (aValue < bValue) return -1;
                if (aValue > bValue) return 1;
                return 0;
            } else {
                // Panah bawah = Z-A
                if (aValue > bValue) return -1;
                if (aValue < bValue) return 1;
                return 0;
            }
        }
    });

    // Re-append sorted rows
    rows.forEach(row => table.appendChild(row));

    // Add visual feedback
    headerElement.style.backgroundColor = '#f1f5f9';
    setTimeout(() => {
        headerElement.style.backgroundColor = '#f8fafc';
    }, 200);
}

// Helper function to parse dates
function parseDate(dateString) {
    // Handle different date formats: "Sept 4, 2023", "Aug 31, 2023", etc.
    const months = {
        'jan': 0, 'feb': 1, 'mar': 2, 'apr': 3, 'may': 4, 'jun': 5,
        'jul': 6, 'aug': 7, 'sep': 8, 'sept': 8, 'oct': 9, 'nov': 10, 'dec': 11
    };

    const parts = dateString.toLowerCase().split(/[\s,]+/);
    if (parts.length >= 3) {
        const month = months[parts[0]] !== undefined ? months[parts[0]] : 0;
        const day = parseInt(parts[1]) || 1;
        const year = parseInt(parts[2]) || new Date().getFullYear();
        return new Date(year, month, day);
    }

    return new Date(dateString);
}
function showLoading(element) {
    const originalContent = element.innerHTML;
    element.innerHTML = '<iconify-icon icon="material-symbols:hourglass-empty"></iconify-icon>';
    element.disabled = true;

    return function hideLoading() {
        element.innerHTML = originalContent;
        element.disabled = false;
    };
}

// Auto-refresh data periodically (optional)
setInterval(function() {
    // Only refresh if page is visible
    if (!document.hidden) {
        // Implement auto-refresh logic here if needed
        // fetchUpdatedStats();
    }
}, 300000); // 5 minutes
</script>

@endsection
