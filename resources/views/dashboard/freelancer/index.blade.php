@extends('layouts.app')

@section('title', 'Dashboard - SkillMatch')
@section('page-title', 'Dashboard')
@section('dashboard-route', route('freelancer.dashboard'))

@section('navbar-center')
    @component('components.search')
        @slot('placeholder', 'Search orders, clients, skills...')
    @endcomponent
@endsection

@section('navigation')
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

    <a href="{{ route('freelancer.order') }}" class="nav-item {{ request()->routeIs('freelancer.order*') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
        </div>
        <span class="nav-text">Order</span>
    </a>

     <a href="{{ route('freelancer.services') }}" class="nav-item {{ request()->routeIs('freelancer.services*') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:work"></iconify-icon>
        </div>
        <span class="nav-text">Service</span>
    </a>
@endsection

@section('content')
<!-- Orders Section -->
<div class="orders-section">
    <div class="orders-header">
        <h2 class="orders-title">Recent Orders</h2>
        <span class="orders-count" id="ordersCount">2 Orders</span>
    </div>

    <!-- Search Results Info -->
    <div class="search-results-info" id="searchResultsInfo">
        <span id="searchResultsText"></span>
        <button class="clear-search-btn" onclick="clearSearch()">Clear</button>
    </div>

    <div class="orders-list" id="ordersList">
        <!-- Order Card 1 -->
        <div class="order-card" data-client="denada f" data-skill="illustrator" data-description="buku cerita anak aku sayang nenek" data-date="thursday, 18 september 2025">
            <div class="order-skill">illustrator</div>
            <div class="order-info">
                <div class="order-date">Thursday, 18 September 2025</div>
                <div class="order-client">Client: Denada F</div>
                <div class="order-description">Buku cerita anak Aku Sayang Nenek</div>
            </div>
            <div class="order-actions">
                <button class="details-btn" onclick="showOrderDetails('Denada F', 'illustrator', 'Thursday, 18 September 2025', 'Buku cerita anak Aku Sayang Nenek')">Details</button>
            </div>
        </div>

        <!-- Order Card 2 -->
        <div class="order-card" data-client="ira maria" data-skill="graphic design" data-description="pembuatan design kaos barongsai" data-date="sunday, 21 september 2025">
            <div class="order-skill">graphic design</div>
            <div class="order-info">
                <div class="order-date">Sunday, 21 September 2025</div>
                <div class="order-client">Client: Ira Maria</div>
                <div class="order-description">Pembuatan design kaos Barongsai</div>
            </div>
            <div class="order-actions">
                <button class="details-btn" onclick="showOrderDetails('Ira Maria', 'graphic design', 'Sunday, 21 September 2025', 'Pembuatan design kaos Barongsai')">Details</button>
            </div>
        </div>
    </div>

    <!-- Empty State -->
    <div class="empty-state" id="emptyState">
        <div class="empty-state-icon">
            <iconify-icon icon="material-symbols:search-off"></iconify-icon>
        </div>
        <h3>No orders found</h3>
        <p>Try adjusting your search criteria or check back later for new orders.</p>
        <button onclick="clearSearch()" style="margin-top: 1rem; padding: 0.5rem 1rem; background: #38C1B9; color: white; border: none; border-radius: 6px; cursor: pointer;">Clear Search</button>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Orders Section Specific Styles */
.orders-section {
    background: var(--bg-primary);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
    width: 100%;
    max-width: 1000px;
    overflow: hidden;
    position: relative;
    margin: 0 auto;
}

.orders-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-light);
}

.orders-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
}

.orders-count {
    background: var(--primary-color);
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

/* Order Card */
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
    box-shadow: var(--shadow-md);
}

.order-card.hidden {
    display: none !important;
}

.order-skill {
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-color);
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
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.order-client {
    color: var(--text-secondary);
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.order-description {
    color: var(--text-primary);
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
    background: var(--secondary-color);
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
    background: var(--secondary-hover);
    transform: translateY(-1px);
}

/* Search Results */
.search-results-info {
    margin-bottom: 1rem;
    padding: 0.75rem 1rem;
    background: var(--bg-muted);
    border-radius: 8px;
    font-size: 0.9rem;
    color: var(--text-secondary);
    display: none;
}

.search-results-info.show {
    display: block;
}

.clear-search-btn {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 0.25rem 0.75rem;
    border-radius: 4px;
    font-size: 0.8rem;
    cursor: pointer;
    margin-left: 0.5rem;
}

.clear-search-btn:hover {
    background: var(--primary-hover);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
    display: none;
}

.empty-state.show {
    display: block;
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 1rem;
    line-height: 1.5;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .orders-section {
        padding: 1.5rem;
        max-width: 100%;
        margin: 0;
        width: 100%;
    }

    .order-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
        max-width: 100%;
        margin: 0;
        padding: 1rem;
    }

    .order-actions {
        align-self: flex-end;
        flex-direction: column;
        align-items: stretch;
    }

    .details-btn {
        width: 100%;
        text-align: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Define global variables first
let allOrderCards = [];
let currentSearchQuery = '';

// Cache DOM elements
let searchInput, searchBtn, ordersList, emptyState, searchResultsInfo, searchResultsText, ordersCount;

// Search function - defined globally first
function performSearch(query) {
    console.log('Performing search for:', query);
    
    currentSearchQuery = query.toLowerCase().trim();
    let hasResults = false;
    let matchCount = 0;

    if (currentSearchQuery === '') {
        // Show all orders
        allOrderCards.forEach(card => {
            card.classList.remove('hidden');
        });
        hasResults = true;
        hideSearchInfo();
        hideEmptyState();
    } else {
        // Filter orders
        allOrderCards.forEach(card => {
            const client = (card.getAttribute('data-client') || '').toLowerCase();
            const skill = (card.getAttribute('data-skill') || '').toLowerCase();
            const description = (card.getAttribute('data-description') || '').toLowerCase();
            const date = (card.getAttribute('data-date') || '').toLowerCase();

            const hasMatch = client.includes(currentSearchQuery) ||
                          skill.includes(currentSearchQuery) ||
                          description.includes(currentSearchQuery) ||
                          date.includes(currentSearchQuery);

            if (hasMatch) {
                card.classList.remove('hidden');
                hasResults = true;
                matchCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        // Show search results info
        if (hasResults) {
            showSearchInfo(matchCount, currentSearchQuery);
            hideEmptyState();
        } else {
            hideSearchInfo();
            showEmptyState();
        }
    }

    updateOrdersCount();
    console.log('Search completed. Results found:', hasResults);
}

// Clear search function - defined globally
function clearSearch() {
    if (searchInput) {
        searchInput.value = '';
    }
    performSearch('');
}

// Update orders count
function updateOrdersCount() {
    if (!ordersCount) return;
    const visibleOrders = allOrderCards.filter(card => !card.classList.contains('hidden'));
    const count = visibleOrders.length;
    ordersCount.textContent = `${count} Order${count !== 1 ? 's' : ''}`;
}

// Show search results info
function showSearchInfo(count, query) {
    if (searchResultsInfo && searchResultsText) {
        searchResultsText.textContent = `Found ${count} result${count !== 1 ? 's' : ''} for "${query}"`;
        searchResultsInfo.classList.add('show');
    }
}

// Hide search results info
function hideSearchInfo() {
    if (searchResultsInfo) {
        searchResultsInfo.classList.remove('show');
    }
}

// Show empty state
function showEmptyState() {
    if (emptyState) {
        emptyState.classList.add('show');
    }
    if (ordersList) {
        ordersList.style.display = 'none';
    }
}

// Hide empty state
function hideEmptyState() {
    if (emptyState) {
        emptyState.classList.remove('show');
    }
    if (ordersList) {
        ordersList.style.display = 'flex';
    }
}

// Initialize function
function initFreelancerDashboard() {
    // Cache DOM elements
    searchInput = document.getElementById('globalSearch');
    searchBtn = document.getElementById('searchBtn');
    ordersList = document.getElementById('ordersList');
    emptyState = document.getElementById('emptyState');
    searchResultsInfo = document.getElementById('searchResultsInfo');
    searchResultsText = document.getElementById('searchResultsText');
    ordersCount = document.getElementById('ordersCount');

    // Get all order cards
    allOrderCards = Array.from(document.querySelectorAll('.order-card'));
    updateOrdersCount();
    
    console.log('Found', allOrderCards.length, 'order cards');

    // Setup search event listeners
    if (searchInput) {
        // Real-time search as user types with debounce
        let searchTimeout;
        searchInput.addEventListener('input', function(e) {
            const query = e.target.value;
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                console.log('Search input changed:', query);
                performSearch(query);
            }, 300); // 300ms debounce
        });

        // Enter key search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = e.target.value;
                console.log('Search enter key pressed:', query);
                clearTimeout(searchTimeout);
                performSearch(query);
            }
        });
    }

    // Search button functionality
    if (searchBtn) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (searchInput) {
                const query = searchInput.value;
                console.log('Search button clicked:', query);
                performSearch(query);
            }
        });
    }

    console.log('Freelancer dashboard initialized successfully');
}

// Make functions available globally for layout compatibility
window.performSearch = performSearch;
window.clearSearch = clearSearch;

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initFreelancerDashboard();
    console.log('Freelancer dashboard loaded');
});

// Global utility functions
function showOrderDetails(client, skill, date, description) {
    const message = `Order Details:\n\nClient: ${client}\nSkill: ${skill}\nDate: ${date}\nDescription: ${description}`;
    alert(message);
    
    // In a real application, you would navigate to a detailed order page
    // window.location.href = `/freelancer/orders/${orderId}`;
}
</script>
@endpush