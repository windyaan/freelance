@extends('layouts.app')

@section('page-title', 'Admin Dashboard')

@section('navigation')
    <a href="#" class="nav-item active">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
        </div>
        <span class="nav-text">Dashboard</span>
    </a>
    <a href="#" class="nav-item">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
        </div>
        <span class="nav-text">Orders</span>
    </a>
@endsection

@push('styles')
<style>
/* Admin-specific styles */
.admin-layout .navbar-brand {
    color: var(--primary-color);
}

.admin-layout .nav-item.active {
    background: var(--secondary-color);
    color: white;
}

/* Stats Section */
.stats-container {
    display: flex;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    flex: 1;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
    transition: all 0.2s ease;
    text-align: center;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.stat-icon {
    width: 48px;
    height: 48px;
    margin: 0 auto 1rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
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
    font-size: 0.9rem;
    color: var(--text-secondary);
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.8rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Profit Card */
.profit-card {
    background: linear-gradient(135deg, var(--primary-color), var(--success-color));
    color: white;
    border-radius: 12px;
    padding: 2rem;
    min-width: 280px;
    text-align: center;
    box-shadow: 0 4px 16px rgba(56, 193, 185, 0.3);
}

.profit-title {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.profit-amount {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

/* Users Section */
.users-section {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
}

.users-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.users-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
}

.search-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-input {
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.9rem;
    width: 280px;
    background: var(--bg-secondary);
    transition: all 0.2s ease;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
    background: white;
}

.search-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 1.1rem;
    pointer-events: none;
}

.export-btn {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.export-btn:hover {
    background: var(--primary-hover);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(56, 193, 185, 0.3);
}

/* Users Table */
.users-table-container {
    overflow-x: auto;
    border-radius: 8px;
    border: 1px solid var(--border-light);
}

.users-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    font-size: 0.9rem;
}

.users-table th,
.users-table td {
    padding: 1rem 0.75rem;
    text-align: left;
    border-bottom: 1px solid var(--border-light);
}

.users-table th {
    background: var(--bg-secondary);
    font-weight: 600;
    color: var(--text-secondary);
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.users-table th.sortable {
    cursor: pointer;
    user-select: none;
}

.users-table th.sortable:hover {
    background: var(--bg-muted);
}

.sort-arrows {
    display: inline-block;
    margin-left: 4px;
    font-size: 0.9rem;
    color: var(--text-muted);
    opacity: 0.7;
}

.users-table tbody tr {
    transition: all 0.2s ease;
}

.users-table tbody tr:hover {
    background: var(--bg-secondary);
}

/* User Role Badges */
.user-role {
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
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

/* Responsive Design */
@media (max-width: 1024px) {
    .stats-container {
        flex-direction: column;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
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
}
</style>
@endpush

@section('content')
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
    </div>

    <div class="profit-card">
        <div class="profit-title">Profit</div>
        <div class="profit-amount">Rp{{ number_format($totalProfit ?? 4300000, 0, ',', '.') }}</div>
    </div>
</div>

<!-- Users Section -->
<div class="users-section">
    <div class="users-header">
        <h2 class="users-title">Users</h2>
        <div class="search-container">
            <div class="search-input-wrapper">
                <iconify-icon icon="material-symbols:search" class="search-icon"></iconify-icon>
                <input type="text" class="search-input" placeholder="Search users..." id="userSearch">
            </div>
            <button class="btn btn-primary" onclick="performSearch()">
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
                    <th>Name</th>
                    <th>Email</th>
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
@endsection

@push('scripts')
<script>
// Admin dashboard specific functions
window.performSearch = function(query = null) {
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

    if (visibleCount === 0 && query !== '') {
        console.log('No users found matching: ' + query);
    }
};

// Sorting functionality
let sortOrder = {};

window.sortTable = function(columnIndex, headerElement) {
    const table = document.querySelector('.users-table tbody');
    const rows = Array.from(table.querySelectorAll('tr'));
    const isAscending = !sortOrder[columnIndex];

    sortOrder[columnIndex] = isAscending;

    // Reset all arrows
    document.querySelectorAll('.sort-arrows').forEach(arrow => {
        arrow.textContent = '↕';
        arrow.style.color = 'var(--text-muted)';
    });

    // Update current arrow
    const arrow = headerElement.querySelector('.sort-arrows');
    arrow.textContent = isAscending ? '↑' : '↓';
    arrow.style.color = 'var(--primary-color)';

    // Sort rows
    rows.sort((a, b) => {
        let aValue = a.cells[columnIndex].textContent.trim();
        let bValue = b.cells[columnIndex].textContent.trim();

        if (columnIndex === 3) { // Applied Date column
            const dateA = parseDate(aValue);
            const dateB = parseDate(bValue);
            return isAscending ? dateB - dateA : dateA - dateB;
        } else if (columnIndex === 0) { // User Role column
            const roleOrder = { 'admin': 3, 'client': 2, 'freelancer': 1 };
            const roleA = aValue.toLowerCase();
            const roleB = bValue.toLowerCase();
            return isAscending ? 
                (roleOrder[roleB] || 0) - (roleOrder[roleA] || 0) :
                (roleOrder[roleA] || 0) - (roleOrder[roleB] || 0);
        } else if (columnIndex === 4) { // Status column
            const statusOrder = { 'active': 2, 'inactive': 1 };
            const statusA = aValue.toLowerCase();
            const statusB = bValue.toLowerCase();
            return isAscending ? 
                (statusOrder[statusB] || 0) - (statusOrder[statusA] || 0) :
                (statusOrder[statusA] || 0) - (statusOrder[statusB] || 0);
        } else {
            aValue = aValue.toLowerCase();
            bValue = bValue.toLowerCase();
            if (isAscending) {
                return aValue < bValue ? -1 : aValue > bValue ? 1 : 0;
            } else {
                return aValue > bValue ? -1 : aValue < bValue ? 1 : 0;
            }
        }
    });

    rows.forEach(row => table.appendChild(row));

    // Visual feedback
    headerElement.style.backgroundColor = 'var(--bg-muted)';
    setTimeout(() => {
        headerElement.style.backgroundColor = 'var(--bg-secondary)';
    }, 200);
};

// Helper function to parse dates
function parseDate(dateString) {
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

// Initialize admin dashboard
document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin dashboard loaded');
    
    // Set up search input listener
    const searchInput = document.getElementById('userSearch');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.toLowerCase();
            searchTimeout = setTimeout(() => performSearch(query), 300);
        });
    }
});
</script>
@endpush