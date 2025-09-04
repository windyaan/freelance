@extends('layouts.app')

@section('title', 'Dashboard - SkillMatch')
@section('page-title', 'Dashboard')
@section('dashboard-route', route('freelancer.dashboard'))

@section('navbar-center')
    @component('components.search')
      
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

     <a href="{{ route('freelancer.services') }}" class="nav-item {{ request()->routeIs('freelancer.services*') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:work"></iconify-icon>
        </div>
        <span class="nav-text">Service</span>
    </a>
@endsection

@section('content')
<!-- Embed sample orders data for demo purposes -->
<script id="client-order-data" type="application/json">
[
    {
        "id": 1,
        "title": "Buku cerita anak Aku Sayang Nenek",
        "client": "Denada F",
        "client_avatar": "https://ui-avatars.com/api/?name=Denada+F&background=38C1B9&color=fff&size=50",
        "category": "Illustrator",
        "status": "new",
        "budget": "150000-200000",
        "description": "Saya membutuhkan ilustrasi untuk buku cerita anak dengan tema keluarga. Buku ini akan terdiri dari 20 halaman dengan gaya kartun yang menarik untuk anak usia 4-8 tahun.",
        "date": "2025-08-25",
        "deadline": "2025-09-01",
        "requirements": ["Adobe Illustrator", "Character Design", "Children Book Style"],
        "priority": "medium"
    },
    {
        "id": 2,
        "title": "Pembuatan design Kaos Barongsai",
        "client": "Ira Maria",
        "client_avatar": "https://ui-avatars.com/api/?name=Ira+Maria&background=FF6B6B&color=fff&size=50",
        "category": "Graphic Design",
        "status": "urgent",
        "budget": "300000-500000",
        "description": "Membutuhkan design kaos untuk acara festival Barongsai. Design harus mencerminkan budaya Tionghoa dengan warna yang cerah dan menarik.",
        "date": "2025-08-25",
        "deadline": "2025-08-28",
        "requirements": ["Vector Design", "Cultural Design", "Print Ready"],
        "priority": "high"
    },
    {
        "id": 3,
        "title": "Logo Design untuk Startup Teknologi",
        "client": "Ahmad Rizki",
        "client_avatar": "https://ui-avatars.com/api/?name=Ahmad+Rizki&background=4ECDC4&color=fff&size=50",
        "category": "Graphic Design",
        "status": "new",
        "budget": "500000-750000",
        "description": "Startup teknologi membutuhkan logo yang modern, clean, dan profesional. Logo akan digunakan untuk berbagai media digital dan print.",
        "date": "2025-08-24",
        "deadline": "2025-09-05",
        "requirements": ["Logo Design", "Brand Identity", "Vector Format"],
        "priority": "medium"
    },
    {
        "id": 4,
        "title": "Website Design untuk Toko Online",
        "client": "Sarah Putri",
        "client_avatar": "https://ui-avatars.com/api/?name=Sarah+Putri&background=95E1D3&color=fff&size=50",
        "category": "Web Design",
        "status": "new",
        "budget": "1000000-1500000",
        "description": "Membutuhkan design website e-commerce untuk produk fashion wanita. Design harus responsive dan user-friendly dengan aesthetic yang modern.",
        "date": "2025-08-23",
        "deadline": "2025-09-10",
        "requirements": ["UI/UX Design", "Responsive Design", "E-commerce"],
        "priority": "medium"
    },
    {
        "id": 5,
        "title": "Animasi Video Promosi Produk",
        "client": "Budi Santoso",
        "client_avatar": "https://ui-avatars.com/api/?name=Budi+Santoso&background=F38BA8&color=fff&size=50",
        "category": "Animation",
        "status": "urgent",
        "budget": "800000-1200000",
        "description": "Video animasi 2D untuk promosi produk makanan. Durasi 30-60 detik dengan style yang fun dan engaging untuk target market remaja.",
        "date": "2025-08-25",
        "deadline": "2025-08-30",
        "requirements": ["2D Animation", "After Effects", "Motion Graphics"],
        "priority": "high"
    }
]
</script>

<!-- Client Orders Section -->
<div class="client-orders-section">
    <div class="section-header">
        <div class="header-left">
            <h2 class="section-title">
                <iconify-icon icon="material-symbols:work-outline" class="title-icon"></iconify-icon>
                Client Orders Available
            </h2>
            <p class="section-subtitle">Find and apply to projects that match your skills</p>
        </div>
        <div class="header-right">
            <span class="orders-count" id="ordersCount">5 Orders Available</span>
            <div class="view-toggle">
                <button class="toggle-btn active" data-view="cards" id="cardView">
                    <iconify-icon icon="material-symbols:grid-view"></iconify-icon>
                </button>
                <button class="toggle-btn" data-view="list" id="listView">
                    <iconify-icon icon="material-symbols:list"></iconify-icon>
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">
                <iconify-icon icon="material-symbols:select-all"></iconify-icon>
                All Orders
            </button>
            <button class="filter-btn" data-filter="new">
                <iconify-icon icon="material-symbols:new-releases"></iconify-icon>
                New
            </button>
            <button class="filter-btn" data-filter="urgent">
                <iconify-icon icon="material-symbols:priority-high"></iconify-icon>
                Urgent
            </button>
        </div>
        <div class="sort-dropdown">
            <select id="sortSelect" class="sort-select">
                <option value="date">Sort by Date</option>
                <option value="budget">Sort by Budget</option>
                <option value="deadline">Sort by Deadline</option>
                <option value="priority">Sort by Priority</option>
            </select>
        </div>
    </div>

    <!-- Search Results Info -->
    <div class="search-results-info" id="searchResultsInfo">
        <span id="searchResultsText"></span>
        <button class="clear-search-btn" onclick="clearSearch()">
            <iconify-icon icon="material-symbols:close"></iconify-icon>
            Clear
        </button>
    </div>

    <!-- Orders Grid/List -->
    <div class="orders-container" id="ordersContainer">
        <!-- Orders will be populated by JavaScript -->
    </div>

    <!-- Empty State -->
    <div class="empty-state" id="emptyState">
        <div class="empty-state-icon">
            <iconify-icon icon="material-symbols:search-off"></iconify-icon>
        </div>
        <h3>No orders found</h3>
        <p>Try adjusting your search criteria or filters to find more projects.</p>
        <button onclick="clearSearch()" class="btn btn-primary">
            <iconify-icon icon="material-symbols:refresh"></iconify-icon>
            Clear Filters
        </button>
    </div>

    <!-- Loading State -->
    <div class="loading-state" id="loadingState">
        <div class="loading-spinner"></div>
        <p>Loading orders...</p>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Client Orders Section Styles */
.client-orders-section {
    background: var(--bg-primary);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

/* Section Header */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid var(--border-light);
}

.header-left {
    flex: 1;
}

.section-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.title-icon {
    font-size: 2rem;
    color: var(--primary-color);
}

.section-subtitle {
    color: var(--text-secondary);
    font-size: 1rem;
    margin: 0;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.orders-count {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 0.6rem 1.2rem;
    border-radius: 25px;
    font-size: 0.9rem;
    font-weight: 600;
    box-shadow: var(--shadow-sm);
}

.view-toggle {
    display: flex;
    background: var(--bg-muted);
    border-radius: 8px;
    padding: 0.25rem;
}

.toggle-btn {
    padding: 0.5rem;
    border: none;
    background: transparent;
    color: var(--text-secondary);
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.toggle-btn.active {
    background: var(--primary-color);
    color: white;
}

.toggle-btn:hover:not(.active) {
    background: var(--border-color);
}

/* Filter Section */
.filter-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    gap: 1rem;
}

.filter-buttons {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.filter-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    border: 2px solid var(--border-color);
    background: white;
    color: var(--text-secondary);
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    transform: translateY(-1px);
}

.filter-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    box-shadow: var(--shadow-md);
}

.sort-dropdown {
    position: relative;
}

.sort-select {
    padding: 0.6rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    background: white;
    color: var(--text-primary);
    font-size: 0.9rem;
    cursor: pointer;
    outline: none;
    transition: border-color 0.3s ease;
    min-width: 160px;
}

.sort-select:focus {
    border-color: var(--primary-color);
}

/* Search Results Info */
.search-results-info {
    margin-bottom: 1.5rem;
    padding: 1rem 1.5rem;
    background: linear-gradient(135deg, rgba(56, 193, 185, 0.1), rgba(126, 142, 241, 0.1));
    border-radius: 12px;
    font-size: 0.9rem;
    color: var(--text-primary);
    display: none;
    align-items: center;
    justify-content: space-between;
    border: 1px solid rgba(56, 193, 185, 0.2);
}

.search-results-info.show {
    display: flex;
}

.clear-search-btn {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 0.4rem 0.8rem;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.clear-search-btn:hover {
    background: var(--primary-hover);
}

/* Orders Container */
.orders-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
    min-height: 200px;
}

.orders-container.list-view {
    grid-template-columns: 1fr;
    gap: 1rem;
}

/* Order Card */
.order-card {
    background: white;
    border: 2px solid var(--border-light);
    border-radius: 16px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.order-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary-color);
}

.order-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, var(--primary-color), var(--secondary-color));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.order-card:hover::before {
    opacity: 1;
}

.order-card.hidden {
    display: none;
}

/* Order Card Header */
.order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.client-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.client-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--border-light);
}

.client-details h4 {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.25rem 0;
}

.client-details p {
    font-size: 0.75rem;
    color: var(--text-secondary);
    margin: 0;
}

.order-status {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
    position: relative;
    overflow: hidden;
}

.status-new {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.1));
    color: #16a34a;
    border: 1px solid rgba(34, 197, 94, 0.3);
}

.status-urgent {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(239, 68, 68, 0.1));
    color: #dc2626;
    border: 1px solid rgba(239, 68, 68, 0.3);
    animation: pulse-urgent 2s infinite;
}

@keyframes pulse-urgent {
    0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
    50% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
}

/* Order Content */
.order-category {
    display: inline-block;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 1rem;
    text-transform: capitalize;
}

.order-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1.4;
    margin-bottom: 0.75rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.order-description {
    font-size: 0.9rem;
    color: var(--text-secondary);
    line-height: 1.5;
    margin-bottom: 1rem;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.order-requirements {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.requirement-tag {
    background: var(--bg-muted);
    color: var(--text-secondary);
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.7rem;
    font-weight: 500;
}

/* Order Footer */
.order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid var(--border-light);
}

.order-budget {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary-color);
}

.order-deadline {
    font-size: 0.8rem;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.deadline-urgent {
    color: #dc2626;
    font-weight: 600;
}

.order-actions {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    margin-top: 1rem;
}

.action-btn {
    padding: 0.6rem 1.2rem;
    border: none;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-details {
    background: var(--primary-color);
    color: white;
    min-width: 120px;
    justify-content: center;
}

.btn-details:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

.btn-details:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

/* List View Styles */
.orders-container.list-view .order-card {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1rem 1.5rem;
}

.orders-container.list-view .order-content {
    flex: 1;
}

.orders-container.list-view .order-title {
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.orders-container.list-view .order-description {
    -webkit-line-clamp: 1;
    margin-bottom: 0.5rem;
}

.orders-container.list-view .order-requirements {
    margin-bottom: 0;
}

.orders-container.list-view .order-actions {
    margin-top: 0;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
    display: none;
    grid-column: 1 / -1;
}

.empty-state.show {
    display: block;
}

.empty-state-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
    opacity: 0.5;
    color: var(--primary-color);
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 1rem;
    line-height: 1.5;
    margin-bottom: 2rem;
}

/* Loading State */
.loading-state {
    display: none;
    text-align: center;
    padding: 4rem 2rem;
    grid-column: 1 / -1;
}

.loading-state.show {
    display: block;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid var(--border-color);
    border-top: 4px solid var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 1rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Button Loading Animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.btn {
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: none;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

.btn-secondary {
    background: var(--bg-muted);
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
}

.btn-secondary:hover {
    background: var(--border-color);
    color: var(--text-primary);
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .client-orders-section {
        padding: 1rem;
        margin: 0;
    }

    .section-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .header-right {
        width: 100%;
        justify-content: space-between;
    }

    .filter-section {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .filter-buttons {
        justify-content: flex-start;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }

    .orders-container {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .orders-container.list-view .order-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}

@media (max-width: 480px) {
    .section-title {
        font-size: 1.5rem;
    }

    .filter-btn {
        font-size: 0.8rem;
        padding: 0.5rem 0.8rem;
    }

    .order-card {
        padding: 1rem;
    }

    .order-title {
        font-size: 1rem;
    }

    .order-actions {
        width: 100%;
    }

    .action-btn {
        flex: 1;
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Global variables
var clientOrderData = [];
var allOrderCards = [];
var currentSearchQuery = '';
var currentFilter = 'all';
var currentSort = 'date';
var currentView = 'cards';

// Cache DOM elements
var searchInput, searchBtn, ordersContainer, emptyState, loadingState;
var searchResultsInfo, searchResultsText, ordersCount;
var filterButtons, sortSelect, viewToggleButtons;

// Initialize function
function initFreelancerDashboard() {
    console.log('Initializing freelancer dashboard...');
    
    // Cache DOM elements
    cacheElements();
    
    // Load order data
    loadOrderData();
    
    // Setup event listeners
    setupEventListeners();
    
    // Initial render
    renderOrders();
    
    console.log('Freelancer dashboard initialized successfully');
}

function cacheElements() {
    searchInput = document.getElementById('globalSearch');
    searchBtn = document.getElementById('searchBtn');
    ordersContainer = document.getElementById('ordersContainer');
    emptyState = document.getElementById('emptyState');
    loadingState = document.getElementById('loadingState');
    searchResultsInfo = document.getElementById('searchResultsInfo');
    searchResultsText = document.getElementById('searchResultsText');
    ordersCount = document.getElementById('ordersCount');
    filterButtons = document.querySelectorAll('.filter-btn');
    sortSelect = document.getElementById('sortSelect');
    viewToggleButtons = document.querySelectorAll('.toggle-btn');
}

function loadOrderData() {
    try {
        var orderScript = document.getElementById('client-order-data');
        if (orderScript && orderScript.textContent) {
            clientOrderData = JSON.parse(orderScript.textContent);
            console.log('Loaded', clientOrderData.length, 'client orders');
        }
    } catch (error) {
        console.error('Failed to parse client order data:', error);
        clientOrderData = [];
    }
}

function setupEventListeners() {
    // Search functionality
    if (searchInput) {
        var searchTimeout;
        searchInput.addEventListener('input', function(e) {
            var query = e.target.value;
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function() {
                performSearch(query);
            }, 300);
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(searchTimeout);
                performSearch(e.target.value);
            }
        });
    }

    if (searchBtn) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (searchInput) {
                performSearch(searchInput.value);
            }
        });
    }

    // Filter buttons
    for (var i = 0; i < filterButtons.length; i++) {
        filterButtons[i].addEventListener('click', function(e) {
            e.preventDefault();
            var filter = this.getAttribute('data-filter');
            setActiveFilter(filter);
            renderOrders();
        });
    }

    // Sort dropdown
    if (sortSelect) {
        sortSelect.addEventListener('change', function(e) {
            currentSort = e.target.value;
            renderOrders();
        });
    }

    // View toggle buttons
    for (var j = 0; j < viewToggleButtons.length; j++) {
        viewToggleButtons[j].addEventListener('click', function(e) {
            e.preventDefault();
            var view = this.getAttribute('data-view');
            setActiveView(view);
            renderOrders();
        });
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Number keys for quick filtering (1-3)
        if (e.key >= '1' && e.key <= '3' && !e.target.matches('input, select, textarea')) {
            e.preventDefault();
            var filters = ['all', 'new', 'urgent'];
            var filterIndex = parseInt(e.key) - 1;
            if (filters[filterIndex]) {
                setActiveFilter(filters[filterIndex]);
                renderOrders();
            }
        }
    });
}

function setActiveFilter(filter) {
    currentFilter = filter;
    for (var i = 0; i < filterButtons.length; i++) {
        filterButtons[i].classList.remove('active');
        if (filterButtons[i].getAttribute('data-filter') === filter) {
            filterButtons[i].classList.add('active');
        }
    }
}

function setActiveView(view) {
    currentView = view;
    for (var i = 0; i < viewToggleButtons.length; i++) {
        viewToggleButtons[i].classList.remove('active');
        if (viewToggleButtons[i].getAttribute('data-view') === view) {
            viewToggleButtons[i].classList.add('active');
        }
    }
    
    // Update container class
    if (ordersContainer) {
        ordersContainer.className = 'orders-container' + (view === 'list' ? ' list-view' : '');
    }
}

function performSearch(query) {
    currentSearchQuery = query.toLowerCase().trim();
    renderOrders();
}

function clearSearch() {
    if (searchInput) {
        searchInput.value = '';
    }
    currentSearchQuery = '';
    renderOrders();
}

function filterOrders() {
    var filteredOrders = [];
    
    for (var i = 0; i < clientOrderData.length; i++) {
        var order = clientOrderData[i];
        var shouldInclude = true;
        
        // Filter by search query
        if (currentSearchQuery) {
            var searchableText = [
                order.title,
                order.client,
                order.category,
                order.description
            ].concat(order.requirements).join(' ').toLowerCase();
            
            if (searchableText.indexOf(currentSearchQuery) === -1) {
                shouldInclude = false;
            }
        }
        
        // Filter by status
        if (currentFilter !== 'all' && order.status !== currentFilter) {
            shouldInclude = false;
        }
        
        if (shouldInclude) {
            filteredOrders.push(order);
        }
    }
    
    return filteredOrders;
}

function sortOrders(orders) {
    var sortedOrders = orders.slice(); // Create copy
    
    sortedOrders.sort(function(a, b) {
        switch (currentSort) {
            case 'budget':
                var budgetA = parseInt(a.budget.split('-')[1]) || 0;
                var budgetB = parseInt(b.budget.split('-')[1]) || 0;
                return budgetB - budgetA;
                
            case 'deadline':
                return new Date(a.deadline) - new Date(b.deadline);
                
            case 'priority':
                var priorityOrder = { high: 3, medium: 2, low: 1 };
                return (priorityOrder[b.priority] || 0) - (priorityOrder[a.priority] || 0);
                
            case 'date':
            default:
                return new Date(b.date) - new Date(a.date);
        }
    });
    
    return sortedOrders;
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
}

function formatBudgetRange(budgetString) {
    var parts = budgetString.split('-');
    var min = parseInt(parts[0]);
    var max = parseInt(parts[1]);
    return formatCurrency(min) + ' - ' + formatCurrency(max);
}

function formatDate(dateString) {
    var date = new Date(dateString);
    return date.toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function getTimeUntilDeadline(deadlineString) {
    var deadline = new Date(deadlineString);
    var now = new Date();
    var timeDiff = deadline - now;
    var daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
    
    if (daysDiff < 0) return 'Overdue';
    if (daysDiff === 0) return 'Today';
    if (daysDiff === 1) return 'Tomorrow';
    if (daysDiff <= 3) return daysDiff + ' days';
    return daysDiff + ' days';
}

function isDeadlineUrgent(deadlineString) {
    var deadline = new Date(deadlineString);
    var now = new Date();
    var timeDiff = deadline - now;
    var daysDiff = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
    return daysDiff <= 3;
}

// Navigate to milestone page function
function navigateToMilestone(orderId) {
    // Show loading state on the button
    var button = window.event ? window.event.target.closest('.btn-details') : null;
    if (button) {
        var originalContent = button.innerHTML;
        button.innerHTML = '<div style="display: flex; align-items: center; gap: 0.5rem;">' +
            '<div style="width: 12px; height: 12px; border: 2px solid rgba(255,255,255,0.3); border-top: 2px solid white; border-radius: 50%; animation: spin 0.8s linear infinite;"></div>' +
            'Loading...' +
            '</div>';
        button.disabled = true;
    }
    
    // Optional: Store order data for the milestone page
    try {
        var order = clientOrderData.find(function(o) { return o.id === orderId; });
        if (order) {
            sessionStorage.setItem('selectedOrder', JSON.stringify(order));
        }
    } catch (e) {
        console.warn('Could not store order data:', e);
    }
    
    // Navigate to milestone page after short delay for UX
    setTimeout(function() {
        // Using the existing route from web.php
        // Assuming orderId represents the offer ID
        window.location.href = '/freelancer/offer/' + orderId + '/milestones';
        
        // If you need a simple milestone index page, you can add this route:
        // window.location.href = '/freelancer/milestones/index';
    }, 500);
}

// Updated createOrderCard function with milestone navigation
function createOrderCard(order) {
    var deadlineText = getTimeUntilDeadline(order.deadline);
    var isUrgent = isDeadlineUrgent(order.deadline);
    
    var requirementTags = '';
    for (var i = 0; i < order.requirements.length; i++) {
        requirementTags += '<span class="requirement-tag">' + order.requirements[i] + '</span>';
    }
    
    return '<div class="order-card" data-order-id="' + order.id + '" data-status="' + order.status + '">' +
        '<div class="order-header">' +
            '<div class="client-info">' +
                '<img src="' + order.client_avatar + '" alt="' + order.client + '" class="client-avatar">' +
                '<div class="client-details">' +
                    '<h4>' + order.client + '</h4>' +
                    '<p>' + formatDate(order.date) + '</p>' +
                '</div>' +
            '</div>' +
            '<div class="order-status status-' + order.status + '">' +
                order.status +
            '</div>' +
        '</div>' +
        '<div class="order-content">' +
            '<div class="order-category">' + order.category + '</div>' +
            '<h3 class="order-title">' + order.title + '</h3>' +
            '<p class="order-description">' + order.description + '</p>' +
            '<div class="order-requirements">' +
                requirementTags +
            '</div>' +
        '</div>' +
        '<div class="order-footer">' +
            '<div class="order-budget">' +
                formatBudgetRange(order.budget) +
            '</div>' +
            '<div class="order-deadline' + (isUrgent ? ' deadline-urgent' : '') + '">' +
                '<iconify-icon icon="material-symbols:schedule"></iconify-icon>' +
                deadlineText +
            '</div>' +
        '</div>' +
        '<div class="order-actions">' +
            '<button class="action-btn btn-details" onclick="navigateToMilestone(' + order.id + ')">' +
                '<iconify-icon icon="material-symbols:info"></iconify-icon>' +
                'View Details' +
            '</button>' +
        '</div>' +
    '</div>';
}

function renderOrders() {
    if (!ordersContainer) return;
    
    // Show loading state
    showLoadingState();
    
    setTimeout(function() {
        var filteredOrders = filterOrders();
        var sortedOrders = sortOrders(filteredOrders);
        
        // Update orders count
        updateOrdersCount(sortedOrders.length);
        
        // Show search results info
        updateSearchResultsInfo(sortedOrders.length);
        
        // Render orders or empty state
        if (sortedOrders.length === 0) {
            showEmptyState();
        } else {
            hideEmptyState();
            hideLoadingState();
            
            var ordersHTML = '';
            for (var i = 0; i < sortedOrders.length; i++) {
                ordersHTML += createOrderCard(sortedOrders[i]);
            }
            ordersContainer.innerHTML = ordersHTML;
            
            // Update cached cards
            allOrderCards = Array.from(document.querySelectorAll('.order-card'));
        }
    }, 500); // Simulate loading time
}

function updateOrdersCount(count) {
    if (ordersCount) {
        var text = count === 1 ? 'Order Available' : 'Orders Available';
        ordersCount.textContent = count + ' ' + text;
    }
}

function updateSearchResultsInfo(count) {
    if (currentSearchQuery && searchResultsInfo && searchResultsText) {
        var text = count === 1 ? 'result' : 'results';
        searchResultsText.textContent = 'Found ' + count + ' ' + text + ' for "' + currentSearchQuery + '"';
        searchResultsInfo.classList.add('show');
    } else if (searchResultsInfo) {
        searchResultsInfo.classList.remove('show');
    }
}

function showLoadingState() {
    if (loadingState) {
        loadingState.classList.add('show');
    }
    if (ordersContainer) {
        ordersContainer.style.display = 'none';
    }
    hideEmptyState();
}

function hideLoadingState() {
    if (loadingState) {
        loadingState.classList.remove('show');
    }
    if (ordersContainer) {
        ordersContainer.style.display = 'grid';
    }
}

function showEmptyState() {
    hideLoadingState();
    if (emptyState) {
        emptyState.classList.add('show');
    }
    if (ordersContainer) {
        ordersContainer.style.display = 'none';
    }
}

function hideEmptyState() {
    if (emptyState) {
        emptyState.classList.remove('show');
    }
}

// Global functions for compatibility
window.performSearch = performSearch;
window.clearSearch = clearSearch;
window.navigateToMilestone = navigateToMilestone;

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Small delay to ensure all elements are rendered
    setTimeout(function() {
        initFreelancerDashboard();
    }, 100);
});

// Handle window resize for responsive behavior
window.addEventListener('resize', function() {
    if (window.innerWidth <= 768 && currentView === 'cards') {
        // Auto-switch to list view on mobile for better UX
        setActiveView('list');
        if (ordersContainer) {
            ordersContainer.className = 'orders-container list-view';
        }
    }
});
</script>
@endpush