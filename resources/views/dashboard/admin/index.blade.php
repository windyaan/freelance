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
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    color: white;
    text-decoration: none;
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

.main-content {
    margin-left: 240px;
    margin-top: 70px;
    min-height: calc(100vh - 70px);
    padding: 2rem;
    background: #f8fafc;
}

/* Stats Cards - Modified */
.stats-section {
    display: flex;
    gap: 2rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    flex: 1;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
}

.stat-card.freelance::before {
    background: linear-gradient(90deg, #6366f1, #8b5cf6);
}

.stat-card.client::before {
    background: linear-gradient(90deg, #f59e0b, #f97316);
}

.stat-card.order::before {
    background: linear-gradient(90deg, #38C1B9, #10b981);
}

.stat-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    width: 100%;
    justify-content: center;
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: white;
}

.stat-card.freelance .stat-icon {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
}

.stat-card.client .stat-icon {
    background: linear-gradient(135deg, #f59e0b, #f97316);
}

.stat-card.order .stat-icon {
    background: linear-gradient(135deg, #38C1B9, #10b981);
}

.stat-title {
    font-size: 1rem;
    color: #64748b;
    font-weight: 600;
}

.stat-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    justify-content: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
}

.stat-label {
    font-size: 0.9rem;
    color: #94a3b8;
    font-weight: 500;
}

/* Users Section */
.users-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
}

.users-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.users-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
}

.search-container {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.search-input {
    padding: 0.5rem 1rem 0.5rem 2.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9rem;
    width: 300px;
    position: relative;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="%23a1a1aa"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>') no-repeat 0.75rem center;
    background-size: 1rem;
}

.search-input:focus {
    outline: none;
    border-color: #38C1B9;
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
}

.search-btn {
    background: #38C1B9;
    color: white;
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.search-btn:hover {
    background: #2da89f;
}

/* Users Table */
.users-table-container {
    overflow-x: auto;
}

.users-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.users-table th,
.users-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid #f1f5f9;
}

.users-table th {
    background: #f8fafc;
    font-weight: 600;
    color: #475569;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.users-table tr:hover {
    background: #f8fafc;
}

.user-role {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
}

.user-role.freelancer {
    background: #dbeafe;
    color: #1e40af;
}

.user-role.client {
    background: #fef3c7;
    color: #92400e;
}

.user-category {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    color: white;
}

.user-category.illustrator {
    background: #38C1B9;
}

.user-category.graphic-design {
    background: #10b981;
}

.user-category.fullstack {
    background: #1f2937;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.edit-btn, .delete-btn {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.edit-btn {
    background: #f3f4f6;
    color: #6b7280;
}

.edit-btn:hover {
    background: #e5e7eb;
    color: #374151;
}

.delete-btn {
    background: #fef2f2;
    color: #dc2626;
}

.delete-btn:hover {
    background: #fee2e2;
    color: #b91c1c;
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
    }

    .stats-section {
        flex-direction: column;
        gap: 1rem;
    }

    .search-container {
        flex-direction: column;
        align-items: stretch;
    }

    .search-input {
        width: 100%;
    }
}

@media (max-width: 768px) {
    .navbar-title {
        display: none;
    }

    .users-section {
        padding: 1rem;
    }

    .main-content {
        padding: 1rem;
    }

    .users-table {
        font-size: 0.85rem;
    }

    .users-table th,
    .users-table td {
        padding: 0.75rem 0.5rem;
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
            <div class="logo">
                <h1>skill<span>Match</span></h1>
            </div>
        </a>
        <h1 class="navbar-title">Dashboard</h1>
    </div>
    <div class="navbar-right">
        <div class="navbar-profile" onclick="goToProfile()">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face" alt="Admin Profile">
        </div>

        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
    @csrf
    <button type="submit" class="navbar-logout" onclick="return confirmLogout()" style="background: none; border: none; color: inherit; cursor: pointer;">
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
            <div class="nav-icon">📋</div>
            <span class="nav-text">Orders</span>
        </a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Stats Section -->
    <div class="stats-section">
        <div class="stat-card freelance">
            <div class="stat-header">
                <div class="stat-icon">👨‍💻</div>
                <div class="stat-title">Freelance</div>
            </div>
            <div class="stat-content">
                {{-- <div class="stat-number">200</div> --}}
                <div class="stat-number">{{ $totalFreelancers }}</div>
                <div class="stat-label">Person</div>
            </div>
        </div>

        <div class="stat-card client">
            <div class="stat-header">
                <div class="stat-icon">👥</div>
                <div class="stat-title">Client</div>
            </div>
            <div class="stat-content">
                {{-- <div class="stat-number">135</div> --}}
                <div class="stat-number">{{ $totalClients }}</div>
                <div class="stat-label">Person</div>
            </div>
        </div>

        <div class="stat-card order">
            <div class="stat-header">
                <div class="stat-icon">📦</div>
                <div class="stat-title">Order</div>
            </div>
            <div class="stat-content">
                {{-- <div class="stat-number">120</div> --}}
                <div class="stat-number">{{ $totalOrders }}</div>
                <div class="stat-label">Orders</div>
            </div>
        </div>
    </div>

    <!-- Users Section -->
    <div class="users-section">
        <div class="users-header">
            <h2 class="users-title">Users</h2>
            <div class="search-container">
                <input type="text" class="search-input" placeholder="Search here..." id="userSearch">
                <button class="search-btn" onclick="searchUsers()">Search</button>
            </div>
        </div>

        <div class="users-table-container">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>User Role</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Application</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    @foreach ($users as $user)
        <tr
            data-role="{{ $user->role }}"
            data-name="{{ $user->name }}"
            data-username="{{ $user->username }}"
            data-email="{{ $user->email }}"
        >
            <td>
                <span class="user-role {{ $user->role }}">{{ ucfirst($user->role) }}</span>
            </td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at->format('M d, Y') }}</td>
            <td>
                <button class="edit-btn" onclick="editUser(this)">✏️</button>
            </td>
            <td>
                <button class="delete-btn" onclick="deleteUser(this)">🗑️</button>
            </td>
        </tr>
    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

            var navText = this.querySelector('.nav-text').textContent;
            console.log('Navigating to: ' + navText);
        });
    });

    // Search functionality
    var searchInput = document.getElementById('userSearch');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var query = this.value.toLowerCase();
            searchUsers(query);
        });
    }
});

// Logout confirmation function
function confirmLogout() {
    return confirm('Are you sure you want to log out?');
}

// Profile navigation function
function goToProfile() {
    window.location.href = "{{ route('profile.edit') }}";
}

// Search users function
function searchUsers(query = null) {
    if (query === null) {
        query = document.getElementById('userSearch').value.toLowerCase();
    }

    var rows = document.querySelectorAll('#usersTableBody tr');
    var hasResults = false;

    rows.forEach(function(row) {
        var role = row.getAttribute('data-role').toLowerCase();
        var name = row.getAttribute('data-name').toLowerCase();
        var username = row.getAttribute('data-username').toLowerCase();
        var email = row.getAttribute('data-email').toLowerCase();

        var hasMatch = role.includes(query) ||
                      name.includes(query) ||
                      username.includes(query) ||
                      email.includes(query);

        if (hasMatch || query === '') {
            row.style.display = 'table-row';
            hasResults = true;
        } else {
            row.style.display = 'none';
        }
    });

    // Show/hide no results message
    showNoResultsMessage(!hasResults && query !== '');
}

// Show no results message
function showNoResultsMessage(show) {
    var existingMessage = document.querySelector('.no-results');

    if (show && !existingMessage) {
        var noResultsRow = document.createElement('tr');
        noResultsRow.className = 'no-results';
        noResultsRow.innerHTML = `
            <td colspan="8" style="text-align: center; padding: 2rem; color: #64748b;">
                <div style="font-size: 2rem; margin-bottom: 1rem;">👥</div>
                <h3 style="margin-bottom: 0.5rem; color: #1e293b;">No users found</h3>
                <p>Try adjusting your search criteria</p>
            </td>
        `;
        document.querySelector('#usersTableBody').appendChild(noResultsRow);
    } else if (!show && existingMessage) {
        existingMessage.remove();
    }
}

// Edit user function
function editUser(button) {
    var row = button.closest('tr');
    var name = row.getAttribute('data-name');
    var role = row.getAttribute('data-role');

    alert('Edit User: ' + name + ' (' + role + ')');
    // Here you would typically open an edit modal or redirect to edit page
}

// Delete user function
function deleteUser(button) {
    var row = button.closest('tr');
    var name = row.getAttribute('data-name');

    if (confirm('Are you sure you want to delete user: ' + name + '?')) {
        // Add loading state
        button.disabled = true;
        button.innerHTML = '⏳';

        // Simulate API call
        setTimeout(function() {
            row.remove();
            alert('User deleted successfully!');
        }, 1000);

        // Here you would typically make an API call to delete the user
    }
}

// Sort table functionality
function sortTable(columnIndex, ascending = true) {
    var table = document.querySelector('.users-table tbody');
    var rows = Array.from(table.querySelectorAll('tr:not(.no-results)'));

    rows.sort(function(a, b) {
        var aText = a.cells[columnIndex].textContent.trim();
        var bText = b.cells[columnIndex].textContent.trim();

        if (ascending) {
            return aText.localeCompare(bText);
        } else {
            return bText.localeCompare(aText);
        }
    });

    // Re-append sorted rows
    rows.forEach(function(row) {
        table.appendChild(row);
    });
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        var searchInput = document.getElementById('userSearch');
        if (searchInput) {
            searchInput.focus();
        }
    }

    // Escape key to clear search
    if (e.key === 'Escape') {
        var searchInput = document.getElementById('userSearch');
        if (searchInput && searchInput.value) {
            searchInput.value = '';
            searchUsers('');
        }
    }
});

// Update stats dynamically
function updateStats() {
    var freelancerCount = document.querySelectorAll('[data-role="freelancer"]').length;
    var clientCount = document.querySelectorAll('[data-role="client"]').length;
    var totalUsers = freelancerCount + clientCount;

    // Update the numbers (you would typically get these from your backend)
    document.querySelector('.stat-card.freelance .stat-number').textContent = freelancerCount;
    document.querySelector('.stat-card.client .stat-number').textContent = clientCount;
    // Order count would come from your orders data
}

// Export users data (optional feature)
function exportUsers() {
    var users = [];
    var rows = document.querySelectorAll('#usersTableBody tr:not(.no-results)');

    rows.forEach(function(row) {
        if (row.style.display !== 'none') {
            users.push({
                role: row.getAttribute('data-role'),
                name: row.getAttribute('data-name'),
                username: row.getAttribute('data-username'),
                email: row.getAttribute('data-email')
            });
        }
    });

    console.log('Exported users:', users);
    // Here you would typically generate and download a CSV or Excel file
}

// Initialize tooltips and other features
function initializeFeatures() {
    // Add tooltips to action buttons
    document.querySelectorAll('.edit-btn').forEach(function(btn) {
        btn.title = 'Edit user';
    });

    document.querySelectorAll('.delete-btn').forEach(function(btn) {
        btn.title = 'Delete user';
    });

    // Add click handlers for sortable headers
    document.querySelectorAll('.users-table th').forEach(function(th, index) {
        if (th.textContent.includes('↑')) {
            th.style.cursor = 'pointer';
            th.addEventListener('click', function() {
                sortTable(index);
            });
        }
    });
}

// Initialize features on page load
initializeFeatures();

// Auto-refresh stats every 30 seconds (optional)
setInterval(function() {
    updateStats();
}, 30000);

// Add smooth animations for better UX
function addLoadingState(button) {
    button.style.opacity = '0.5';
    button.style.pointerEvents = 'none';
}

function removeLoadingState(button) {
    button.style.opacity = '1';
    button.style.pointerEvents = 'auto';
}

// Advanced search filters (optional enhancement)
function filterByRole(role) {
    var rows = document.querySelectorAll('#usersTableBody tr:not(.no-results)');
    var hasResults = false;

    rows.forEach(function(row) {
        var userRole = row.getAttribute('data-role');

        if (role === 'all' || userRole === role) {
            row.style.display = 'table-row';
            hasResults = true;
        } else {
            row.style.display = 'none';
        }
    });

    showNoResultsMessage(!hasResults && role !== 'all');
}

// Bulk actions (optional enhancement)
function selectAllUsers() {
    // This would be implemented if you add checkboxes to each row
    console.log('Select all users functionality');
}

function bulkDelete() {
    // This would be implemented for bulk operations
    console.log('Bulk delete functionality');
}
</script>

@endsection
