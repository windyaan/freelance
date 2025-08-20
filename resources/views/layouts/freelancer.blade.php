@extends('layouts.app')

@section('title', 'Freelancer Dashboard - SkillMatch')
@section('page-title', 'Dashboard')
@section('dashboard-route', route('freelancer.dashboard'))

@section('navbar-center')
    @component('components.search')
        @slot('placeholder', 'Search orders, clients...')
    @endcomponent
@endsection

@section('navigation')
    <a href="{{ route('freelancer.dashboard') }}" class="nav-item {{ request()->routeIs('freelancer.dashboard') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
        </div>
        <span class="nav-text">Dashboard</span>
    </a>
    
    <a href="{{ route('freelancer.chat') ?? '#' }}" class="nav-item {{ request()->routeIs('freelancer.chat*') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:chat"></iconify-icon>
        </div>
        <span class="nav-text">Chat</span>
        @if(isset($chatCount) && $chatCount > 0)
            <span class="nav-badge">{{ $chatCount }}</span>
        @endif
    </a>
    
    <a href="{{ route('freelancer.order') ?? '#' }}" class="nav-item {{ request()->routeIs('freelancer.order*') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
        </div>
        <span class="nav-text">Orders</span>
    </a>
    
    <a href="{{ route('freelancer.services') ?? '#' }}" class="nav-item {{ request()->routeIs('freelancer.services*') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:work"></iconify-icon>
        </div>
        <span class="nav-text">Services</span>
    </a>

@endsection

@push('styles')
<style>
    /* Freelancer-specific styles */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-light);
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: white;
    }

    .stat-icon.orders {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
    }

    .stat-icon.earnings {
        background: linear-gradient(135deg, var(--success-color), #059669);
    }

    .stat-icon.reviews {
        background: linear-gradient(135deg, var(--warning-color), #d97706);
    }

    .stat-icon.completed {
        background: linear-gradient(135deg, var(--secondary-color), var(--secondary-hover));
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.85rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .order-grid {
        display: grid;
        gap: 1.5rem;
    }

    .order-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: var(--primary-color);
    }

    .order-left {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex: 1;
    }

    .order-category {
        background: var(--bg-muted);
        color: var(--text-secondary);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: lowercase;
        min-width: 100px;
        text-align: center;
    }

    .order-details {
        flex: 1;
    }

    .order-date {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .order-client {
        font-size: 0.9rem;
        color: var(--text-secondary);
        margin-bottom: 0.25rem;
    }

    .order-title {
        font-size: 0.95rem;
        color: var(--text-primary);
        font-weight: 500;
    }

    .order-actions {
        display: flex;
        gap: 0.75rem;
    }

    .filter-buttons {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 0.5rem 1rem;
        border: 1px solid var(--border-color);
        background: var(--bg-primary);
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

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .order-card {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }

        .order-left {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }

        .order-actions {
            justify-content: stretch;
        }

        .order-actions .btn {
            flex: 1;
            text-align: center;
        }
    }

    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Freelancer-specific search function
        window.performSearch = function(query) {
            console.log('Searching orders:', query);
            
            const cards = document.querySelectorAll('.order-card');
            
            if (!query) {
                cards.forEach(card => {
                    card.style.display = 'flex';
                });
                return;
            }
            
            cards.forEach(card => {
                const title = card.querySelector('.order-title')?.textContent?.toLowerCase() || '';
                const client = card.querySelector('.order-client')?.textContent?.toLowerCase() || '';
                const category = card.querySelector('.order-category')?.textContent?.toLowerCase() || '';
                
                const searchText = (title + ' ' + client + ' ' + category).toLowerCase();
                
                if (searchText.includes(query.toLowerCase())) {
                    card.style.display = 'flex';
                    card.classList.add('fade-in');
                } else {
                    card.style.display = 'none';
                }
            });
        };
        
        // Clear search function
        window.clearSearch = function() {
            window.performSearch('');
        };
        
        // Filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                filterButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.textContent.toLowerCase();
                const cards = document.querySelectorAll('.order-card');
                
                cards.forEach(card => {
                    if (filter === 'all') {
                        card.style.display = 'flex';
                    } else {
                        const category = card.querySelector('.order-category')?.textContent?.toLowerCase() || '';
                        const shouldShow = category.includes(filter) || filter === 'all';
                        card.style.display = shouldShow ? 'flex' : 'none';
                    }
                });
            });
        });
        
        // Handle order card clicks
        document.addEventListener('click', function(e) {
            const card = e.target.closest('.order-card');
            if (card && !e.target.closest('.order-actions')) {
                const orderId = card.dataset.orderId;
                if (orderId) {
                    // Navigate to order details
                    console.log('Viewing order:', orderId);
                }
            }
        });
        
        console.log('Freelancer layout loaded');
    });
</script>
@endpush