@extends('layouts.freelancer')

@section('title', 'Services - SkillMatch')
@section('page-title', 'Services')

@section('content')
<style>
/* Services Section */
.services-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    width: 100%;
    max-width: 1000px;
    overflow: hidden;
    position: relative;
}

.services-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f5f9;
}

.services-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
}

.add-service-btn {
    background: #38C1B9;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.add-service-btn:hover {
    background: #2da89f;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(56, 193, 185, 0.3);
    color: white;
    text-decoration: none;
}

.add-service-btn iconify-icon {
    font-size: 1.2rem;
}

.services-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    width: 100%;
}

/* Service Card - Design sederhana seperti di gambar */
.service-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    position: relative;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    width: 100%;
}

.service-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-color: #38C1B9;
}

.service-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.service-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.service-status {
    font-size: 0.85rem;
    font-weight: 500;
    color: #10b981;
    margin: 0;
}

.service-price {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.service-description {
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.5;
    margin: 0.5rem 0 0 0;
}

.service-project-link {
    color: #38C1B9;
    font-size: 0.85rem;
    text-decoration: none;
    font-weight: 500;
}

.service-project-link:hover {
    color: #2da89f;
    text-decoration: underline;
}

.service-actions {
    display: flex;
    gap: 0.75rem;
    align-items: flex-start;
    flex-shrink: 0;
}

.edit-btn {
    background: #64748b;
    color: white;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.edit-btn:hover {
    background: #475569;
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

.delete-btn {
    background: #ef4444;
    color: white;
    border: none;
    padding: 0.6rem;
    border-radius: 8px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-btn:hover {
    background: #dc2626;
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
    color: #94a3b8;
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
    margin-bottom: 1.5rem;
}

.empty-state-btn {
    background: #38C1B9;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.empty-state-btn:hover {
    background: #2da89f;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(56, 193, 185, 0.3);
    color: white;
    text-decoration: none;
}

/* Back Button */
.back-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
    transition: all 0.2s ease;
    width: fit-content;
}

.back-btn:hover {
    color: #1e293b;
    text-decoration: none;
}

.back-btn iconify-icon {
    font-size: 1.1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .services-section {
        padding: 1.5rem;
        max-width: 100%;
        margin: 0;
        width: 100%;
    }

    .services-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }

    .service-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .service-actions {
        align-self: flex-end;
        width: 100%;
        justify-content: flex-end;
    }
}

@media (max-width: 640px) {
    .service-card {
        padding: 1rem;
    }

    .service-actions {
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
        width: 100%;
    }

    .edit-btn {
        width: 100%;
        justify-content: center;
    }

    .delete-btn {
        width: 100%;
    }
}
</style>

{{-- <!-- Back Button -->
<a href="{{ route('freelancer.dashboard') }}" class="back-btn">
    <iconify-icon icon="material-symbols:arrow-back"></iconify-icon>
    Back
</a> --}}

<!-- Services Section -->
<div class="services-section">
    <div class="services-header">
        <h2 class="services-title">Services</h2>
        <a href="{{ route('freelancer.services.create') }}" class="add-service-btn">
            <iconify-icon icon="material-symbols:add"></iconify-icon>
            Add Service
        </a>
    </div>

    <div class="services-list" id="servicesList">
        @if($jobs->count() > 0)
            @foreach($jobs as $job)
                <div class="service-card" data-service="{{ strtolower(str_replace(' ', '-', $job->title)) }}" data-status="{{ $job->is_active ? 'available' : 'unavailable' }}">
                    <div class="service-info">
                        <h3 class="service-title">{{ $job->title }}</h3>
                        <p class="service-status {{ $job->is_active ? 'available' : 'unavailable' }}">
                            {{ $job->is_active ? 'Available' : 'Unavailable' }}
                        </p>
                        <div class="service-price">Rp{{ number_format($job->starting_price, 0, ',', '.') }}</div>
                        <div class="service-description">
                            {{ $job->description }}
                            @if($job->project_link)
                                <br>
                                contoh project : <a href="{{ $job->project_link }}" class="service-project-link" target="_blank">{{ $job->project_link }}</a>
                            @endif
                        </div>
                    </div>
                    <div class="service-actions">
                        <a href="{{ route('freelancer.services.edit', $job->id) }}" class="edit-btn">
                            Edit
                        </a>
                        <form action="{{ route('freelancer.services.destroy', $job->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this service?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn" title="Delete Service">
                                <iconify-icon icon="material-symbols:delete"></iconify-icon>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <iconify-icon icon="material-symbols:work-outline"></iconify-icon>
                </div>
                <h3>No services yet</h3>
                <p>Start by adding your first service to attract clients</p>
                <a href="{{ route('freelancer.services.create') }}" class="empty-state-btn">
                    <iconify-icon icon="material-symbols:add"></iconify-icon>
                    Add Your First Service
                </a>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Services page initialized');

    // Override the global search function for services
    window.performSearch = function(query) {
        searchServices(query);
    };

    // Also set the legacy function name
    window.searchOrders = function(query) {
        searchServices(query);
    };

    window.showAllOrders = function() {
        showAllServices();
    };
});

// Service-specific search function
function searchServices(query) {
    const cards = document.querySelectorAll('.service-card');
    let hasResults = false;

    console.log('Searching services for:', query);

    cards.forEach(function(card) {
        const serviceName = (card.getAttribute('data-service') || '').toLowerCase();
        const title = (card.querySelector('.service-title')?.textContent || '').toLowerCase();
        const description = (card.querySelector('.service-description')?.textContent || '').toLowerCase();
        const price = (card.querySelector('.service-price')?.textContent || '').toLowerCase();
        const status = (card.getAttribute('data-status') || '').toLowerCase();

        const hasMatch = serviceName.includes(query.toLowerCase()) ||
                      title.includes(query.toLowerCase()) ||
                      description.includes(query.toLowerCase()) ||
                      price.includes(query.toLowerCase()) ||
                      status.includes(query.toLowerCase());

        if (hasMatch || query === '') {
            card.style.display = 'flex';
            hasResults = true;
        } else {
            card.style.display = 'none';
        }
    });

    showNoResultsMessage(!hasResults && query !== '');
}

function showNoResultsMessage(show) {
    let existingMessage = document.querySelector('.no-results');

    if (show && !existingMessage) {
        const noResultsDiv = document.createElement('div');
        noResultsDiv.className = 'no-results empty-state';
        noResultsDiv.innerHTML = `
            <div class="empty-state-icon">
                <iconify-icon icon="material-symbols:search-off"></iconify-icon>
            </div>
            <h3>No services found</h3>
            <p>Try adjusting your search criteria</p>
            <button onclick="showAllServices()" class="empty-state-btn">
                <iconify-icon icon="material-symbols:clear"></iconify-icon>
                Clear Search
            </button>
        `;
        const container = document.querySelector('.services-list');
        if (container) {
            container.appendChild(noResultsDiv);
        }
    } else if (!show && existingMessage) {
        existingMessage.remove();
    }
}

function showAllServices() {
    const serviceCards = document.querySelectorAll('.service-card');
    serviceCards.forEach(function(card) {
        card.style.display = 'flex';
    });

    const searchInput = document.getElementById('globalSearch');
    if (searchInput) {
        searchInput.value = '';
    }

    const noResults = document.querySelector('.no-results');
    if (noResults) {
        noResults.remove();
    }

    console.log('Showing all services');
}

// Make functions globally available
window.searchServices = searchServices;
window.showAllServices = showAllServices;
</script>

@endsection
