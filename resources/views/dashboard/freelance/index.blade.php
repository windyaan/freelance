@extends('layouts.freelance')

@section('title', 'Dashboard - SkillMatch')

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

.search-container .search-btn:active {
    transform: translateY(0);
}

.navbar-right {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    justify-content: flex-end;
}

/* Updated logout button styling */
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

/* MAIN CONTENT - FIXED TO CENTER */
.main-content {
    margin-left: 240px;
    margin-top: 70px;
    min-height: calc(100vh - 70px);
    padding: 2rem;
    background: #f8fafc;
    display: flex;
    flex-direction: column;
    align-items: center;
    width: calc(100vw - 240px);
}

/* Orders Section - CENTERED */
.orders-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    width: 100%;
    max-width: 1000px;
}

.orders-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f5f9;
}

.orders-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
}

.orders-count {
    background: #38C1B9;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.orders-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    width: 100%;
}

/* Order Card - CENTERED */
.order-card {
    background: #d1d5db;
    border-radius: 12px;
    padding: 1.5rem;
    border: none;
    transition: all 0.3s ease;
    position: relative;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    width: 100%;
}

.order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.order-skill {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #38C1B9;;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    min-width: 140px;
    text-align: center;
    flex-shrink: 0;
}

.order-info {
    flex: 1;
}

.order-date {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.order-client {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.order-description {
    color: #475569;
    font-size: 0.9rem;
    line-height: 1.4;
}

.order-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    flex-shrink: 0;
}

.details-btn {
    background: #475569;
    color: white;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.details-btn:hover {
    background: #334155;
    transform: translateY(-1px);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #64748b;
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 1rem;
    line-height: 1.5;
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
        width: 100vw;
        padding: 1rem;
        padding-top: 2rem;
    }
    
    .order-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .order-actions {
        align-self: flex-end;
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
    
    .orders-section {
        padding: 1.5rem;
        max-width: 100%;
        margin: 0;
        width: 100%;
    }
    
    .order-card {
        max-width: 100%;
        margin: 0;
    }
    
    .order-card {
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
    
    .order-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .details-btn {
        width: 100%;
        text-align: center;
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
            <div class="logo" style="margin-top: 60px;">
                <h1>Skill<span>Match</span></h1>
            </div>
        </a>
        <h1 class="navbar-title">Dashboard</h1>
    </div>
    <div class="navbar-center">
        <div class="search-container">
            <span class="search-icon">🔍</span>
            <input type="text" class="search-input" placeholder="Search orders, clients..." id="globalSearch">
            <button class="search-btn" id="searchBtn">Search</button>
        </div>
    </div>
    <div class="navbar-right">
        <!-- Profile Button - Now comes first -->
        <div class="navbar-profile" onclick="goToProfile()">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face" alt="Profile">
        </div>
        
        <!-- Logout Button - Now comes after profile, replacing settings -->
        <a href="{{ route('landing') }}" class="navbar-logout" onclick="return confirmLogout()">
            <span>🚪</span>
            Log Out
        </a>
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
            <div class="nav-icon">💬</div>
            <span class="nav-text">Chat</span>
            <span class="nav-badge">3</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon">📋</div>
            <span class="nav-text">Orders</span>
        </a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Orders Section -->
    <div class="orders-section">
        <div class="orders-list">
            <!-- Order Card 1 -->
            <div class="order-card" data-client="Denada F" data-skill="illustrator">
                <div class="order-skill">illustrator</div>
                <div class="order-info">
                    <div class="order-date">Thursday, 18 September 2025</div>
                    <div class="order-client">Client : Denada F</div>
                    <div class="order-description">Buku cerita anak Aku Sayang Nenek</div>
                </div>
                <div class="order-actions">
                    <button class="details-btn">Details</button>
                </div>
            </div>

            <!-- Order Card 2 -->
            <div class="order-card" data-client="Ira Maria" data-skill="graphic design">
                <div class="order-skill">graphic design</div>
                <div class="order-info">
                    <div class="order-date">Sunday, 21 September 2025</div>
                    <div class="order-client">Client : Ira Maria</div>
                    <div class="order-description">Pembuatan design kaos Barongsai</div>
                </div>
                <div class="order-actions">
                    <button class="details-btn">Details</button>
                </div>
            </div>

            <!-- Order Card 3 -->
            <div class="order-card" data-client="Tito Hanum" data-skill="illustrator">
                <div class="order-skill">illustrator</div>
                <div class="order-info">
                    <div class="order-date">Wednesday, 24 September 2025</div>
                    <div class="order-client">Client : Tito Hanum</div>
                    <div class="order-description">Buku mewarnai tema bermain di Pantai</div>
                </div>
                <div class="order-actions">
                    <button class="details-btn">Details</button>
                </div>
            </div>

            <!-- Order Card 4 -->
            <div class="order-card" data-client="Sarah Kumar" data-skill="ui design">
                <div class="order-skill">ui design</div>
                <div class="order-info">
                    <div class="order-date">Friday, 26 September 2025</div>
                    <div class="order-client">Client : Sarah Kumar</div>
                    <div class="order-description">Design aplikasi mobile untuk e-commerce fashion</div>
                </div>
                <div class="order-actions">
                    <button class="details-btn">Details</button>
                </div>
            </div>

            <!-- Order Card 5 -->
            <div class="order-card" data-client="Ahmad Rizki" data-skill="content writing">
                <div class="order-skill">content writing</div>
                <div class="order-info">
                    <div class="order-date">Monday, 29 September 2025</div>
                    <div class="order-client">Client : Ahmad Rizki</div>
                    <div class="order-description">Artikel blog tentang teknologi blockchain untuk website startup</div>
                </div>
                <div class="order-actions">
                    <button class="details-btn">Details</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('globalSearch');
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
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var query = this.value.toLowerCase();
            searchOrders(query);
        });
        
        // Search button functionality
        document.querySelector('.search-btn').addEventListener('click', function() {
            var query = searchInput.value.toLowerCase();
            searchOrders(query);
        });
    }
    
    // Event delegation for all interactions
    document.addEventListener('click', function(e) {
        // Details button functionality
        if (e.target.classList.contains('details-btn')) {
            var orderCard = e.target.closest('.order-card');
            var client = orderCard.getAttribute('data-client');
            var skill = orderCard.getAttribute('data-skill');
            var date = orderCard.querySelector('.order-date').textContent;
            
            alert('Order Details:\nClient: ' + client + '\nSkill: ' + skill + '\nDate: ' + date);
            // Here you would typically redirect to order details page
        }
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
            
            // Here you would typically handle navigation
            var navText = this.querySelector('.nav-text').textContent;
            console.log('Navigating to: ' + navText);
        });
    });
});

// Logout confirmation function
function confirmLogout() {
    return confirm('Are you sure you want to log out?');
}

// Profile navigation function
function goToProfile() {
    // Redirect to profile page
    window.location.href = "{{ route('profile.edit') }}";
}

// Search orders function
function searchOrders(query) {
    var cards = document.querySelectorAll('.order-card');
    var hasResults = false;
    
    cards.forEach(function(card) {
        var client = card.getAttribute('data-client').toLowerCase();
        var skill = card.getAttribute('data-skill').toLowerCase();
        var date = card.querySelector('.order-date').textContent.toLowerCase();
        var description = card.querySelector('.order-description').textContent.toLowerCase();
        
        var hasMatch = client.includes(query) || 
                      skill.includes(query) || 
                      date.includes(query) || 
                      description.includes(query);
        
        if (hasMatch || query === '') {
            card.style.display = 'flex';
            hasResults = true;
        } else {
            card.style.display = 'none';
        }
    });
    
    // Show/hide no results message
    showNoResultsMessage(!hasResults && query !== '');
}

// Show no results message
function showNoResultsMessage(show) {
    var existingMessage = document.querySelector('.no-results');
    
    if (show && !existingMessage) {
        var noResultsDiv = document.createElement('div');
        noResultsDiv.className = 'no-results empty-state';
        noResultsDiv.innerHTML = `
            <div class="empty-state-icon">📋</div>
            <h3>No orders found</h3>
            <p>Try adjusting your search criteria</p>
        `;
        document.querySelector('.orders-list').appendChild(noResultsDiv);
    } else if (!show && existingMessage) {
        existingMessage.remove();
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K to focus search
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        var searchInput = document.getElementById('globalSearch');
        if (searchInput) {
            searchInput.focus();
        }
    }
});

// Add loading states for better UX
function showLoading(element) {
    element.style.opacity = '0.5';
    element.style.pointerEvents = 'none';
}

function hideLoading(element) {
    element.style.opacity = '1';
    element.style.pointerEvents = 'auto';
}

// Initialize tooltips
function initializeTooltips() {
    // Add tooltips to details buttons
    document.querySelectorAll('.details-btn').forEach(function(btn) {
        btn.title = 'View order details';
    });
}

// Initialize on page load
initializeTooltips();

// Make search and show all orders available globally
window.searchOrders = searchOrders;
window.showAllOrders = function() {
    var orderCards = document.querySelectorAll('.order-card');
    orderCards.forEach(function(card) {
        card.style.display = 'flex';
    });
    
    // Remove no results message if exists
    var noResults = document.querySelector('.no-results');
    if (noResults) {
        noResults.remove();
    }
};
</script>

@endsection