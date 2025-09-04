@extends('layouts.app')

@section('title', 'Order - SkillMatch')

@section('page-title', 'Order')

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
    <a href="#" class="nav-item {{ request()->routeIs('freelancer.order') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
        </div>
        <span class="nav-text">Orders</span>
    </a>
    <a href="{{ route('freelancer.services') }}" class="nav-item {{ request()->routeIs('freelancer.services*') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:work"></iconify-icon>
        </div>
        <span class="nav-text">Service</span>
    </a>
@endsection

@section('navbar-center')
    <div class="search-container">
        <iconify-icon icon="material-symbols:search" class="search-icon"></iconify-icon>
        <input type="text" class="search-input" placeholder="Search order..." id="globalSearch">
        <button class="search-btn" id="searchBtn">Search</button>
    </div>
@endsection

@push('styles')
<style>
    /* Order-specific styles */
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

    .status-paid {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .status-dp {
        background: rgba(251, 191, 36, 0.1);
        color: #d97706;
        border: 1px solid rgba(251, 191, 36, 0.2);
    }

    .status-failed {
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

    /* Mobile responsive adjustments */
    @media (max-width: 768px) {
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

        .orders-section {
            padding: 1.5rem;
            margin-bottom: 1.5rem;
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
</style>
@endpush

{{-- @section('content')
<!-- Embed sample orders data for demo purposes -->
<script id="order-data" type="application/json">
[
    {
        "id": 1,
        "title": "Buku cerita anak Aku Sayang Nenek",
        "freelancer": "Namira Enggar",
        "category": "Illustrator",
        "status": "paid",
        "price": 150000,
        "date": "2025-09-18",
        "deadline": "2025-09-25"
    },
    {
        "id": 2,
        "title": "Pembuatan design Kaos Barangsai",
        "freelancer": "Namira Enggar",
        "category": "Graphic Design",
        "status": "dp",
        "price": 250000,
        "date": "2025-09-21",
        "deadline": "2025-09-28"
    },
    {
        "id": 3,
        "title": "Buku mewarnai tema bermain di Pantai",
        "freelancer": "Nadia Ima",
        "category": "Illustrator",
        "status": "failed",
        "price": 200000,
        "date": "2025-09-24",
        "deadline": "2025-10-01"
    },
    {
        "id": 4,
        "title": "Logo Design untuk Startup",
        "freelancer": "Ahmad Rizki",
        "category": "Graphic Design",
        "status": "paid",
        "price": 300000,
        "date": "2025-09-22",
        "deadline": "2025-09-30"
    }
]
</script>

<!-- Orders Section -->
<div class="orders-section">
    <div class="section-header">
        <h1 class="section-title">
            <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
            My Order
        </h1>
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="paid">Paid</button>
            <button class="filter-btn" data-filter="dp">DP</button>
            <button class="filter-btn" data-filter="failed">Failed</button>
        </div>
    </div>

    <div class="orders-grid" id="orderGrid">
        <!-- Sample Order Cards - these would be populated from your database -->
        <div class="order-card" data-status="paid" data-order-id="1">
            <div class="order-header">
                <div>
                    <div class="order-date">Thursday, 18 September 2025</div>
                    <div class="order-day">Sep 18, 2025</div>
                </div>
                <div class="order-status status-paid">Paid</div>
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
                    <button class="action-btn btn-contact" onclick="contactFreelancer('Namira Enggar')">Pay</button>
                </div>
            </div>
        </div>

        <div class="order-card" data-status="dp" data-order-id="2">
            <div class="order-header">
                <div>
                    <div class="order-date">Sunday, 21 September 2025</div>
                    <div class="order-day">Sep 21, 2025</div>
                </div>
                <div class="order-status status-dp">DP</div>
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
                    <button class="action-btn btn-pay" onclick="makePayment(2)">Pay Remaining</button>
                </div>
            </div>
        </div>

        <div class="order-card" data-status="failed" data-order-id="3">
            <div class="order-header">
                <div>
                    <div class="order-date">Wednesday, 24 September 2025</div>
                    <div class="order-day">Sep 24, 2025</div>
                </div>
                <div class="order-status status-failed">Failed</div>
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
                    <button class="action-btn btn-contact" onclick="contactFreelancer('Nadia Ima')">Pay</button>
                </div>
            </div>
        </div>

        <div class="order-card" data-status="paid" data-order-id="4">
            <div class="order-header">
                <div>
                    <div class="order-date">Friday, 22 September 2025</div>
                    <div class="order-day">Sep 22, 2025</div>
                </div>
                <div class="order-status status-paid">Paid</div>
            </div>

            <div class="order-content">
                <div class="order-category">graphic design</div>
                <div class="order-freelancer">Freelancer: Ahmad Rizki</div>
                <div class="order-title">Logo Design untuk Startup</div>
                <div class="order-deadline">
                    <iconify-icon icon="material-symbols:schedule"></iconify-icon>
                    Deadline: Sep 30, 2025
                </div>
            </div>

            <div class="order-footer">
                <div class="order-price">Rp300.000</div>
                <div class="order-actions">
                    <button class="action-btn btn-details" onclick="viewOrderDetails(4)">Details</button>
                    <button class="action-btn btn-contact" onclick="contactFreelancer('Ahmad Rizki')">Pay</button>
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
@endsection --}}

<div class="orders-section">
    <div class="section-header">
        <h1 class="section-title">
            <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
            My Orders
        </h1>
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="paid">Paid</button>
            <button class="filter-btn" data-filter="dp">DP</button>
            <button class="filter-btn" data-filter="failed">Failed</button>
        </div>
    </div>

    <div class="orders-grid" id="orderGrid">
        @forelse($orders as $order)
            <div class="order-card" data-status="{{ strtolower($order->status) }}" data-order-id="{{ $order->id }}">
                <div class="order-header">
                    <div>
                        <div class="order-date">{{ $order->created_at->format('l, d F Y') }}</div>
                        <div class="order-day">{{ $order->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="order-status status-{{ strtolower($order->status) }}">
                        {{ ucfirst($order->status) }}
                    </div>
                </div>

                <div class="order-content">
                    <div class="order-category">{{ strtolower($order->offer->job->category->name ?? '-') }}</div>
                    <div class="order-freelancer">Client: {{ $order->offer->client->name }}</div>
                    <div class="order-title">{{ $order->offer->job->title }}</div>
                    <div class="order-deadline">
                        <iconify-icon icon="material-symbols:schedule"></iconify-icon>
                        Deadline: {{ \Carbon\Carbon::parse($order->offer->deadline)->format('M d, Y') }}
                    </div>
                </div>

                <div class="order-footer">
                    <div class="order-price">Rp{{ number_format($order->amount, 0, ',', '.') }}</div>
                    <div class="order-actions">
                        <a href="{{ route('freelancer.orders.show', $order->id) }}" class="action-btn btn-details">Details</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state" id="emptyState">
                <iconify-icon icon="material-symbols:inbox"></iconify-icon>
                <h3>No order found</h3>
                <p>You don't have any orders yet.</p>
                <a href="{{ route('freelancer.dashboard') }}" class="btn-primary">
                    <iconify-icon icon="material-symbols:add"></iconify-icon>
                    Browse Jobs
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection


@push('scripts')
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
    const orderGrid = document.getElementById('orderGrid');
    const emptyState = document.getElementById('emptyState');
    const filterButtons = document.querySelectorAll('.filter-btn');

    let currentFilter = 'all';

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

    // Make search function available globally for app.blade.php
    window.performSearch = searchOrder;
    window.clearSearch = () => filterOrder(currentFilter);

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

    // Keyboard shortcuts for filtering
    document.addEventListener('keydown', function(e) {
        // Number keys for quick filtering
        if (e.key >= '1' && e.key <= '4' && !e.target.matches('input')) {
            e.preventDefault();
            const filters = ['all', 'paid', 'dp', 'failed'];
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
    if (confirm(`Proceed to remaining payment for order ${orderId}?`)) {
        alert(`Redirecting to payment for order ${orderId}`);
    }
}

function contactFreelancer(freelancerName) {
    console.log('Contacting freelancer:', freelancerName);
    // Here you would navigate to chat or contact page
    // window.location.href = `/chat/${freelancerName}`;
    alert(`Opening chat with ${freelancerName}`);
}
</script>
@endpush
