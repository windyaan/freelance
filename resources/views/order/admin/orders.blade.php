@extends('layouts.app')

@section('title', 'Orders - SkillMatch Admin')

@section('navigation')
    <a href="/admin-dashboard" class="nav-item">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
        </div>
        <span class="nav-text">Dashboard</span>
    </a>
    <a href="/admin/orders" class="nav-item active">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
        </div>
        <span class="nav-text">Orders</span>
    </a>
@endsection

@push('styles')
<style>
/* Orders-specific styles following admin dashboard pattern */
.orders-section {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
}

.orders-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.orders-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
}

.filter-controls {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.filter-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: white;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.filter-btn:hover {
    background: var(--bg-secondary);
    border-color: var(--primary-color);
}

.sort-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.sort-select {
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.9rem;
    background: white;
}

.export-controls {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.date-select {
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.9rem;
    background: white;
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
    gap: 0.5rem;
}

.export-btn:hover {
    background: var(--primary-hover);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(56, 193, 185, 0.3);
}

/* Orders Table */
.orders-table-container {
    overflow-x: auto;
    border-radius: 8px;
    border: 1px solid var(--border-light);
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    font-size: 0.9rem;
}

.orders-table th,
.orders-table td {
    padding: 1rem 0.75rem;
    text-align: left;
    border-bottom: 1px solid var(--border-light);
}

.orders-table th {
    background: var(--bg-secondary);
    font-weight: 600;
    color: var(--text-secondary);
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.orders-table tbody tr {
    transition: all 0.2s ease;
}

.orders-table tbody tr:hover {
    background: var(--bg-secondary);
}

/* Status Badges */
.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
    display: inline-block;
}

.status-badge.completed {
    background: #dcfce7;
    color: #15803d;
}

.status-badge.on-progress {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.revision {
    background: #dbeafe;
    color: #1e40af;
}

.status-badge.pending {
    background: #fed7d7;
    color: #c53030;
}

.status-badge.paid {
    background: #dcfce7;
    color: #15803d;
}

.status-badge.unpaid {
    background: #fed7d7;
    color: #c53030;
}

.status-badge.dp {
    background: #fef3c7;
    color: #92400e;
}

.report-btn {
    padding: 0.25rem 0.75rem;
    border: 1px solid #ef4444;
    color: #ef4444;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
    background: white;
    cursor: pointer;
    transition: all 0.2s ease;
}

.report-btn:hover {
    background: #fef2f2;
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: between;
    align-items: center;
    padding: 1rem 0;
    border-top: 1px solid var(--border-light);
}

.pagination-info {
    font-size: 0.9rem;
    color: var(--text-secondary);
}

.pagination-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.pagination-btn {
    padding: 0.5rem 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    background: white;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.pagination-btn:hover {
    background: var(--bg-secondary);
}

.pagination-btn.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.go-to-page {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-left: 1rem;
}

.go-to-page input {
    width: 60px;
    padding: 0.5rem;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    text-align: center;
    font-size: 0.8rem;
}

.go-btn {
    padding: 0.5rem 0.75rem;
    background: var(--text-secondary);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 0.8rem;
    cursor: pointer;
}

.go-btn:hover {
    background: var(--text-primary);
}

/* Responsive Design */
@media (max-width: 1024px) {
    .orders-header {
        flex-direction: column;
        align-items: stretch;
        gap: 1rem;
    }

    .filter-controls {
        flex-wrap: wrap;
        gap: 0.75rem;
    }
}

@media (max-width: 768px) {
    .filter-controls {
        flex-direction: column;
        align-items: stretch;
    }

    .export-controls {
        justify-content: stretch;
    }

    .pagination-controls {
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>
@endpush

@section('content')
<!-- Orders Section -->
<div class="orders-section">
    <div class="orders-header">
        <h2 class="orders-title">Orders Management</h2>
    
        </div>
    </div>

    <!-- Filter Controls -->
    <div class="filter-controls">
        <button class="filter-btn">
            <iconify-icon icon="material-symbols:filter-list"></iconify-icon>
            <span>Filter</span>
        </button>
        
        <div class="sort-controls">
            <iconify-icon icon="material-symbols:sort" style="color: var(--text-muted);"></iconify-icon>
            <span style="font-size: 0.9rem; color: var(--text-secondary);">Sort by</span>
            <select class="sort-select">
                <option value="az">A-Z</option>
                <option value="za">Z-A</option>
                <option value="date_desc">Newest First</option>
                <option value="date_asc">Oldest First</option>
            </select>
        </div>

        <div class="export-controls" style="margin-left: auto;">
            <select class="date-select">
                <option value="30">Last 30 days</option>
                <option value="7">Last 7 days</option>
                <option value="90">Last 90 days</option>
            </select>
            
            <button class="export-btn">
                <iconify-icon icon="material-symbols:download"></iconify-icon>
                <span>Export Data</span>
            </button>
        </div>
    </div>

    <div class="orders-table-container">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>FREELANCER</th>
                    <th>CLIENT</th>
                    <th>TITLE</th>
                    <th>STATUS ORDER</th>
                    <th>STATUS PAYMENT</th>
                    <th>REPORT</th>
                    <th>DEADLINE</th>
                </tr>
            </thead>
            <tbody id="ordersTableBody">
                @forelse($orders as $order)
                <tr>
                    <td>{{ $order->offer->job->freelancer->name ?? 'N/A' }}</td>
                    <td>{{ $order->offer->client->name ?? 'N/A' }}</td>
                    <td>{{ $order->offer->job->title ?? 'N/A' }}</td>
                    <td>
                        <span class="status-badge {{ strtolower(str_replace(' ', '-', $order->status ?? 'pending')) }}">
                            {{ $order->status ?? 'Pending' }}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge {{ $order->amount_paid >= $order->amount ? 'paid' : ($order->amount_paid > 0 ? 'dp' : 'unpaid') }}">
                            {{ $order->amount_paid >= $order->amount ? 'Paid' : ($order->amount_paid > 0 ? 'DP' : 'Unpaid') }}
                        </span>
                    </td>
                    <td>
                        @if($order->has_report ?? false)
                            <button class="report-btn">Detail Report</button>
                        @else
                            <span style="color: var(--text-muted);">-</span>
                        @endif
                    </td>
                    <td>{{ $order->deadline ? date('j F Y', strtotime($order->deadline)) : 'N/A' }}</td>
                </tr>
                @empty
                <!-- Sample Data jika tidak ada orders -->
                <tr>
                    <td>Nadia Ima</td>
                    <td>Adam Johnson</td>
                    <td>Pembuatan Buku Cerita</td>
                    <td><span class="status-badge completed">Completed</span></td>
                    <td><span class="status-badge paid">Paid</span></td>
                    <td><span style="color: var(--text-muted);">-</span></td>
                    <td>1 Oktober 2025</td>
                </tr>
                <tr>
                    <td>Nadia Ima</td>
                    <td>Adam Johnson</td>
                    <td>Design kaos barong</td>
                    <td><span class="status-badge completed">Completed</span></td>
                    <td><span class="status-badge paid">Paid</span></td>
                    <td><button class="report-btn">Detail Report</button></td>
                    <td>1 Oktober 2025</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        <div class="pagination-info">
            <span>Showing</span>
            <span style="font-weight: 600; color: var(--text-primary); margin: 0 4px;">1 to {{ count($orders) }}</span>
            <span>of</span>
            <span style="font-weight: 600; color: var(--text-primary); margin: 0 4px;">{{ count($orders) }}</span>
            <span>entries</span>
        </div>
        
        <div class="pagination-controls">
            <button class="pagination-btn">← Previous</button>
            <button class="pagination-btn active">1</button>
            <button class="pagination-btn">2</button>
            <button class="pagination-btn">3</button>
            <span style="padding: 0.5rem;">...</span>
            <button class="pagination-btn">14</button>
            <button class="pagination-btn">Next →</button>
            
            <div class="go-to-page">
                <span style="font-size: 0.9rem; color: var(--text-secondary);">Go to page</span>
                <input type="number" placeholder="1">
                <button class="go-btn">Go</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Orders page specific functions
window.performSearch = function(query = null) {
    if (query === null) {
        query = document.getElementById('orderSearch').value.toLowerCase();
    }
    
    const rows = document.querySelectorAll('#ordersTableBody tr');
    let visibleCount = 0;

    rows.forEach(function(row) {
        const text = row.textContent.toLowerCase();

        if (text.includes(query) || query === '') {
            row.style.display = 'table-row';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    if (visibleCount === 0 && query !== '') {
        console.log('No orders found matching: ' + query);
    }
};

// Initialize orders page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Orders page loaded');
    
    // Set up search input listener
    const searchInput = document.getElementById('orderSearch');
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