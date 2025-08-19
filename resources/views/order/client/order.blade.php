@extends('layouts.app')

@section('page-title', 'Order')
@section('dashboard-route', route('client.dashboard'))

@section('navbar-center')
<div class="search-container">
    <iconify-icon icon="material-symbols:search" class="search-icon"></iconify-icon>
    <input type="text" class="search-input" placeholder="Search orders..." id="globalSearch">
    <button class="search-btn" id="searchBtn">Search</button>
</div>
@endsection

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
    <span class="nav-text">Order</span>
</a>
@endsection

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

<!-- Orders Section -->
<div class="card">
    <div class="card-header">
        <h1 class="card-title flex items-center gap-3">
            <iconify-icon icon="material-symbols:list-alt" style="font-size: 2rem; color: var(--primary-color);"></iconify-icon>
            My Orders
        </h1>
        <div class="filter-buttons flex gap-2">
            <button class="filter-btn active" data-filter="all">All</button>
            <button class="filter-btn" data-filter="pending">Pending</button>
            <button class="filter-btn" data-filter="in_progress">In Progress</button>
            <button class="filter-btn" data-filter="completed">Completed</button>
            <button class="filter-btn" data-filter="cancelled">Cancelled</button>
        </div>
    </div>

    <div class="order-grid" id="orderGrid">
        <!-- Sample Order Cards -->
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
                   <button class="action-btn btn-pay" onclick="makePayment(2)">Pay Now</button>
                </div>
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

    <!-- Empty State -->
    <div class="empty-state" id="emptyState" style="display: none;">
        <iconify-icon icon="material-symbols:inbox" style="font-size: 4rem; color: #cbd5e1; margin-bottom: 1rem;"></iconify-icon>
        <h3 style="font-size: 1.5rem; color: var(--text-primary); margin-bottom: 0.5rem;">No orders found</h3>
        <p style="font-size: 1rem; margin-bottom: 2rem; color: var(--text-secondary);">You don't have any orders matching the current filter.</p>
        <a href="{{ route('client.dashboard') }}" class="btn btn-primary">
            <iconify-icon icon="material-symbols:add"></iconify-icon>
            Browse Talents
        </a>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Order-specific styles only */
.filter-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.filter-btn {
    padding: 0.5rem 1rem;
    border: 1px solid var(--border-color);
    background: white;
    color: var(--text-secondary);
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.filter-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.filter-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.order-grid {
    display: grid;
    gap: 1.5rem;
}

.order-card {
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.order-card:hover {
    transform: translateY(-2px);
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
    background: var(--primary-color);
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
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.order-day {
    font-size: 0.85rem;
    color: var(--text-secondary);
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
    background: var(--primary-color);
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
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.order-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    line-height: 1.4;
    margin-bottom: 1rem;
}

.order-deadline {
    font-size: 0.8rem;
    color: var(--text-secondary);
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.order-deadline iconify-icon {
    font-size: 0.9rem;
}

.order-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.order-price {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--primary-color);
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
    background: var(--text-secondary);
    color: white;
}

.btn-details:hover {
    background: var(--secondary-color);
    transform: translateY(-1px);
}

.btn-pay {
    background: var(--primary-color);
    color: white;
}

.btn-pay:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

.btn-contact {
    background: var(--bg-muted);
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
}

.btn-contact:hover {
    background: var(--border-color);
    color: var(--secondary-color);
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .card-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .filter-buttons {
        width: 100%;
        justify-content: flex-start;
        flex-wrap: wrap;
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
    .filter-buttons {
        gap: 0.25rem;
    }
    
    .filter-btn {
        font-size: 0.75rem;
        padding: 0.4rem 0.8rem;
    }
    
    .order-card {
        padding: 1rem;
    }
}
</style>
@endpush

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
    const orderGrid = document.getElementById('orderGrid');
    const emptyState = document.getElementById('emptyState');
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    let currentFilter = 'all';
    
    // Filter functionality
    function filterOrders(status) {
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
    
    // Search functionality - integrates with global search
    window.performSearch = function(query) {
        if (!query || query.length < 2) {
            filterOrders(currentFilter);
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
    };
    
    // Clear search function
    window.clearSearch = function() {
        filterOrders(currentFilter);
    };
    
    // Event listeners for filter buttons
    filterButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const filter = this.getAttribute('data-filter');
            filterOrders(filter);
            
            // Clear search when filtering
            const searchInput = document.getElementById('globalSearch');
            if (searchInput) {
                searchInput.value = '';
            }
        });
    });
    
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
    
    // Number keys for quick filtering
    document.addEventListener('keydown', function(e) {
        if (e.key >= '1' && e.key <= '5' && !e.target.matches('input')) {
            e.preventDefault();
            const filters = ['all', 'pending', 'in_progress', 'completed', 'cancelled'];
            const filterIndex = parseInt(e.key) - 1;
            if (filters[filterIndex]) {
                filterOrders(filters[filterIndex]);
                const searchInput = document.getElementById('globalSearch');
                if (searchInput) {
                    searchInput.value = '';
                }
            }
        }
    });
    
    // Initialize page
    filterOrders('all');
    
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
</script>
@endpush