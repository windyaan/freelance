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

/* Service Card */
.service-card {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    width: 100%;
}

.service-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-color: #38C1B9;
}

.service-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
}

.service-info {
    flex: 1;
}

.service-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.service-status {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    margin-bottom: 0.75rem;
}

.service-status.available {
    background: #dcfce7;
    color: #166534;
}

.service-status.unavailable {
    background: #fee2e2;
    color: #991b1b;
}

.service-price {
    font-size: 1rem;
    font-weight: 600;
    color: #38C1B9;
    margin-bottom: 0.5rem;
}

.service-description {
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 0.75rem;
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
    align-items: center;
    flex-shrink: 0;
}

.edit-btn {
    background: #475569;
    color: white;
    border: none;
    padding: 0.6rem 1.2rem;
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

.edit-btn:hover {
    background: #334155;
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

    .service-header {
        flex-direction: column;
        align-items: flex-start;
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

<!-- Back Button -->
<a href="{{ route('freelancer.dashboard') }}" class="back-btn">
    <iconify-icon icon="material-symbols:arrow-back"></iconify-icon>
    Back
</a>

<!-- Services Section -->
<div class="services-section">
    <div class="services-header">
        <h2 class="services-title">Services</h2>
        <a href="#" class="add-service-btn" onclick="addNewService()">
            <iconify-icon icon="material-symbols:add"></iconify-icon>
            Add Service
        </a>
    </div>

    <div class="services-list" id="servicesList">
        <!-- Service Card 1 - UI Design -->
        <div class="service-card" data-service="ui design" data-status="available">
            <div class="service-header">
                <div class="service-info">
                    <h3 class="service-title">UI Design</h3>
                    <span class="service-status available">Available</span>
                    <div class="service-price">Rp400.000-Rp600.000</div>
                    <div class="service-description">
                        Pembuatan design kaos<br>
                        contoh project : <a href="https://link-project-kaos" class="service-project-link" target="_blank">https://link-project-kaos</a>
                    </div>
                </div>
                <div class="service-actions">
                    <a href="#" class="edit-btn" onclick="editService('ui-design')">
                        <iconify-icon icon="material-symbols:edit"></iconify-icon>
                        Edit
                    </a>
                    <button class="delete-btn" onclick="deleteService('ui-design')" title="Delete Service">
                        <iconify-icon icon="material-symbols:delete"></iconify-icon>
                    </button>
                </div>
            </div>
        </div>

        <!-- Service Card 2 - Illustrator -->
        <div class="service-card" data-service="illustrator" data-status="available">
            <div class="service-header">
                <div class="service-info">
                    <h3 class="service-title">Illustrator</h3>
                    <span class="service-status available">Available</span>
                    <div class="service-price">Rp700.000-Rp900.000</div>
                    <div class="service-description">
                        Jasa pembuatan ilustrasi buku anak.<br>
                        contoh project : <a href="https://link-project-buku" class="service-project-link" target="_blank">https://link-project-buku</a>
                    </div>
                </div>
                <div class="service-actions">
                    <a href="#" class="edit-btn" onclick="editService('illustrator')">
                        <iconify-icon icon="material-symbols:edit"></iconify-icon>
                        Edit
                    </a>
                    <button class="delete-btn" onclick="deleteService('illustrator')" title="Delete Service">
                        <iconify-icon icon="material-symbols:delete"></iconify-icon>
                    </button>
                </div>
            </div>
        </div>
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

// Service management functions
function addNewService() {
    // In a real application, this would redirect to a create service form
    alert('Redirect to Add New Service form\n\nThis would typically open a form where you can:\n- Enter service title\n- Set price range\n- Add description\n- Upload portfolio samples\n- Set availability status');
    console.log('Add new service clicked');
}

function editService(serviceId) {
    // In a real application, this would redirect to an edit form
    alert(`Edit Service: ${serviceId}\n\nThis would typically open an edit form with pre-filled data for the selected service.`);
    console.log('Edit service:', serviceId);
}

function deleteService(serviceId) {
    if (confirm('Are you sure you want to delete this service?\n\nThis action cannot be undone.')) {
        // In a real application, this would make an AJAX request to delete the service
        const serviceCard = document.querySelector(`[data-service="${serviceId}"]`);
        if (serviceCard) {
            serviceCard.style.transition = 'all 0.3s ease';
            serviceCard.style.opacity = '0';
            serviceCard.style.transform = 'translateX(-100%)';
            
            setTimeout(() => {
                serviceCard.remove();
                checkEmptyState();
            }, 300);
        }
        
        console.log('Service deleted:', serviceId);
    }
}

function checkEmptyState() {
    const serviceCards = document.querySelectorAll('.service-card');
    const servicesList = document.getElementById('servicesList');
    
    if (serviceCards.length === 0) {
        const emptyStateDiv = document.createElement('div');
        emptyStateDiv.className = 'empty-state';
        emptyStateDiv.innerHTML = `
            <div class="empty-state-icon">
                <iconify-icon icon="material-symbols:work-outline"></iconify-icon>
            </div>
            <h3>No services yet</h3>
            <p>Start by adding your first service to attract clients</p>
            <button onclick="addNewService()" class="empty-state-btn">
                <iconify-icon icon="material-symbols:add"></iconify-icon>
                Add Your First Service
            </button>
        `;
        servicesList.appendChild(emptyStateDiv);
    }
}

// Make functions globally available
window.searchServices = searchServices;
window.showAllServices = showAllServices;
window.addNewService = addNewService;
window.editService = editService;
window.deleteService = deleteService;
</script>

@endsection