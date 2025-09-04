@extends('layouts.app')

@section('title', 'Order - SkillMatch')

@section('page-title', 'Order')

@section('navigation')
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
<a href="#" class="nav-item {{ request()->routeIs('client.order') ? 'active' : '' }}">
    <div class="nav-icon">
        <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
    </div>
    <span class="nav-text">Orders</span>
</a>
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

    .status-failed,
    .status-unpaid {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .status-completed {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.2);
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
        text-decoration: none;
        display: inline-block;
    }

    .btn-details {
        background: #64748b;
        color: white;
    }

    .btn-details:hover {
        background: #475569;
        transform: translateY(-1px);
        color: white;
    }

    .btn-pay {
        background: #38C1B9;
        color: white;
    }

    .btn-pay:hover {
        background: #2da89f;
        transform: translateY(-1px);
        color: white;
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

@section('content')
<!-- Orders Section -->
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
            <button class="filter-btn" data-filter="completed">Completed</button>
        </div>
    </div>

    <div class="orders-grid" id="orderGrid">
        @forelse($orders as $orderItem)
            <div class="order-card" data-status="{{ $orderItem->status }}" data-order-id="{{ $orderItem->id }}">
                <div class="order-header">
                    <div>
                        <div class="order-date">{{ $orderItem->created_at->format('l, d F Y') }}</div>
                        <div class="order-day">{{ $orderItem->created_at->format('M d, Y') }}</div>
                    </div>
                    <div class="order-status status-{{ $orderItem->status }}">{{ ucfirst($orderItem->status) }}</div>
                </div>

                <div class="order-content">
                    <div class="order-category">
                        @if(is_object($orderItem->offer->job->category))
                            {{ $orderItem->offer->job->category->Name ?? 'General' }}
                        @elseif(is_string($orderItem->offer->job->category))
                            {{ $orderItem->offer->job->category }}
                        @else
                            General
                        @endif
                    </div>
                    <div class="order-freelancer">
                        Freelancer: {{ $orderItem->offer->job->freelancer->name ?? 'N/A' }}
                    </div>
                    <div class="order-title">
                        {{ $orderItem->offer->title ?? 'No Title' }}
                    </div>

                   <p class="order-description">
        {{ Str::limit($orderItem->offer->description ?? 'No description available', 120) }}
    </p>

                    @if($orderItem->offer->deadline)
                        <div class="order-deadline">
                            <iconify-icon icon="material-symbols:schedule"></iconify-icon>
                            Deadline: {{ \Carbon\Carbon::parse($orderItem->offer->deadline)->format('M d, Y') }}
                        </div>
                    @endif
                </div>

                <div class="order-footer">
                    <div class="order-price">
                        Rp{{ number_format($orderItem->amount, 0, ',', '.') }}
                        @if($orderItem->amount_paid > 0 && $orderItem->amount_paid < $orderItem->amount)
                            <small style="display: block; font-size: 0.8rem; color: #64748b;">
                                Paid: Rp{{ number_format($orderItem->amount_paid, 0, ',', '.') }}
                            </small>
                        @endif
                    </div>
                    <div class="order-actions">
                       <a href="{{ route('milestones.showByOrder', $orderItem->id) }}" class="action-btn btn-details">
                           Details
                       </a>
                        
                        @php
                            $remainingAmount = $orderItem->amount - $orderItem->amount_paid;
                        @endphp

                        @if(in_array($orderItem->status, ['failed', 'dp']) || $remainingAmount > 0)
                            <a href="{{ route('order.showPayment', $orderItem->id) }}" class="action-btn btn-pay">
                                @if($orderItem->status === 'dp' && $remainingAmount > 0)
                                    Pay Remaining (Rp{{ number_format($remainingAmount, 0, ',', '.') }})
                                @else
                                    Pay Now
                                @endif
                            </a>
                        @endif
                        
                        @if($orderItem->offer->job->freelancer ?? null)
                            <button class="action-btn btn-contact" 
                                    onclick="contactFreelancer('{{ $orderItem->offer->job->freelancer->name }}')">
                                Contact
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State -->
            <div class="empty-state" id="emptyState">
                <iconify-icon icon="material-symbols:inbox"></iconify-icon>
                <h3>No orders found</h3>
                <p>You don't have any orders yet.</p>
                <a href="{{ route('client.dashboard') }}" class="btn-primary">
                    <iconify-icon icon="material-symbols:add"></iconify-icon>
                    Browse Talents
                </a>
            </div>
        @endforelse
    </div>

    <!-- Empty State for filtered results -->
    <div class="empty-state" id="filteredEmptyState" style="display: none;">
        <iconify-icon icon="material-symbols:search-off"></iconify-icon>
        <h3>No orders found</h3>
        <p>No orders match the current filter or search criteria.</p>
        <button onclick="clearFilters()" class="btn-primary">
            <iconify-icon icon="material-symbols:refresh"></iconify-icon>
            Clear Filters
        </button>
    </div>
</div>

<script>
// Filter functionality - Pure JavaScript, no JSON
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const orderCards = document.querySelectorAll('.order-card');
    const orderGrid = document.getElementById('orderGrid');
    const emptyState = document.getElementById('emptyState');
    const filteredEmptyState = document.getElementById('filteredEmptyState');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add active class to clicked button
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            filterOrders(filter);
        });
    });

    function filterOrders(filter) {
        let visibleCount = 0;
        
        orderCards.forEach(card => {
            const status = card.getAttribute('data-status');
            
            if (filter === 'all' || status === filter) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Show/hide empty states
        if (visibleCount === 0 && orderCards.length > 0) {
            filteredEmptyState.style.display = 'block';
            emptyState.style.display = 'none';
        } else {
            filteredEmptyState.style.display = 'none';
            if (orderCards.length === 0) {
                emptyState.style.display = 'block';
            } else {
                emptyState.style.display = 'none';
            }
        }
    }
});

// Clear filters function
function clearFilters() {
    document.querySelector('.filter-btn[data-filter="all"]').click();
}

// Contact freelancer function
function contactFreelancer(freelancerName) {
    // Implement your contact logic here
    alert('Contacting ' + freelancerName + '...');
    // You can replace this with a modal, redirect to chat, etc.
}
</script>
@endsection

@push('scripts')
<script>
// Orders page JavaScript with database integration
document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const searchInput = document.getElementById('globalSearch');
    const orderGrid = document.getElementById('orderGrid');
    const emptyState = document.getElementById('filteredEmptyState');
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

        // Show/hide empty state for filtered results
        if (visibleCount === 0 && orderCards.length > 0) {
            emptyState.style.display = 'block';
        } else {
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
            emptyState.style.display = 'block';
        } else {
            emptyState.style.display = 'none';
        }
    }

    // Clear filters function
    window.clearFilters = function() {
        currentFilter = 'all';
        if (searchInput) {
            searchInput.value = '';
        }
        filterOrder('all');
    };

    // Make search functions available globally
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
            window.location.href = `/order/${orderId}`;
        }
    });

    // Keyboard shortcuts for filtering
    document.addEventListener('keydown', function(e) {
        // Number keys for quick filtering (1-5)
        if (e.key >= '1' && e.key <= '5' && !e.target.matches('input')) {
            e.preventDefault();
            const filters = ['all', 'paid', 'dp', 'failed', 'completed'];
            const filterIndex = parseInt(e.key) - 1;
            if (filters[filterIndex]) {
                filterOrder(filters[filterIndex]);
                if (searchInput) {
                    searchInput.value = '';
                }
            }
        }
    });

    // Initialize page
    filterOrder('all');

    console.log('Order page initialized successfully with database integration');
});

// Global functions for order actions
function contactFreelancer(freelancerName) {
    console.log('Contacting freelancer:', freelancerName);
    // Navigate to chat or send message
    alert(`Opening chat with ${freelancerName}`);
}

// Navigate to order details function
function navigateToOrder(orderId) {
    console.log('Navigating to order:', orderId);
    window.location.href = `/order/${orderId}`;
}
</script>
@endpush