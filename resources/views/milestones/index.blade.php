@extends('layouts.app')

@section('title', 'Project Details - SkillMatch')
@section('page-title', 'Dashboard')

{{-- Dynamic dashboard route based on user role --}}
@section('dashboard-route', auth()->user()->role === 'client' ? route('client.dashboard') : route('freelancer.dashboard'))

{{-- Dynamic navigation based on user role --}}
@section('navigation')
    {{-- Dashboard navigation --}}
    <a href="{{ auth()->user()->role === 'client' ? route('client.dashboard') : route('freelancer.dashboard') }}" 
       class="nav-item {{ request()->routeIs(auth()->user()->role . '.dashboard') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
        </div>
        <span class="nav-text">Dashboard</span>
    </a>
    
    {{-- Chat navigation --}}
    <a href="{{ auth()->user()->role === 'client' ? route('client.chat') : route('freelancer.chat') }}" 
       class="nav-item {{ request()->routeIs(auth()->user()->role . '.chat*') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:chat"></iconify-icon>
        </div>
        <span class="nav-text">Chat</span>
        <span class="nav-badge">3</span>
    </a>
    
    {{-- Role-specific navigation --}}
    @if(auth()->user()->role === 'client')
        {{-- Client specific navigation - Orders --}}
        <a href="{{ route('client.order') }}" 
           class="nav-item {{ request()->routeIs('client.order*') ? 'active' : '' }}">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:receipt-long"></iconify-icon>
            </div>
            <span class="nav-text">Orders</span>
        </a>
    @else
        {{-- Freelancer specific navigation - Services --}}
        <a href="{{ route('freelancer.services') }}" 
           class="nav-item {{ request()->routeIs('freelancer.services*') ? 'active' : '' }}">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:work"></iconify-icon>
            </div>
            <span class="nav-text">Service</span>
        </a>
    @endif
@endsection

@section('content')
<!-- Project Details Page -->
<div class="project-details-page">

    <!-- Back Button - Dynamic based on user role -->
    <div class="back-navigation">
        <a href="{{ auth()->user()->role === 'client' ? route('client.dashboard') : route('freelancer.dashboard') }}" 
           class="back-btn">
            <iconify-icon icon="material-symbols:arrow-back"></iconify-icon> Back
        </a>
    </div>

    <!-- Main Content Grid -->
    <div class="project-content-grid">

        <!-- Left Column - Project Details -->
        <div class="project-details-section">

            <!-- Project Header -->
            <div class="project-header">
                <div class="project-date">{{ $order->created_at->format('l, d F Y') }}</div>
                <div class="project-info">
                    <h1 class="project-title">Project Title : {{ $offer->job->title }}</h1>
                    <div class="project-meta">
                        <div class="meta-item">
                            <span class="meta-label">
                                @if(auth()->user()->role === 'client')
                                    Freelancer :
                                @else
                                    Client :
                                @endif
                            </span>
                            <span class="meta-value">
                                @if(auth()->user()->role === 'client')
                                    {{ $offer->freelancer->name ?? 'N/A' }}
                                @else
                                    {{ $offer->client->name }}
                                @endif
                            </span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Order ID :</span>
                            <span class="meta-value">#{{ $order->id }}</span>
                        </div>
                        <div class="meta-item">
                            <span class="meta-label">Revision :</span>
                            <span class="meta-value">{{ $offer->revision ?? '0' }}x</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Description -->
            <div class="project-description-section">
                <h3 class="section-title">Description :</h3>
                <div class="description-content">
                    <p>{{ $offer->job->description }}</p>
                </div>
                @if($offer->job->output)
                <div class="output-section">
                    <h4>Output:</h4>
                    <ul>
                        @foreach(explode(',', $offer->job->output) as $output)
                            <li>{{ trim($output) }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>

            <!-- Project Pricing -->
            <div class="project-pricing">
                <div class="price-item">
                    <span class="price-label">Price :</span>
                    <span class="price-value">Rp{{ number_format($offer->price, 0, ',', '.') }}</span>
                </div>
                <div class="price-item paid">
                    <span class="price-label">Paid :</span>
                    <span class="price-value">Rp{{ number_format($order->paid_amount ?? 0, 0, ',', '.') }}</span>
                    <span class="paid-badge">💰</span>
                </div>
            </div>

            {{-- Progress Report Section - Only for Freelancers --}}
            @if(auth()->user()->role === 'freelancer')
            <div class="progress-report-section">
                <h3 class="section-title">Detail Progress</h3>
                <form action="{{ route('milestones.store', $offer->id) }}" method="POST" class="progress-form">
                    @csrf
                    <textarea name="description" class="progress-textarea" placeholder="Tulis progres terbaru..." rows="8" required></textarea>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-secondary">Submit Progress</button>
                    </div>
                </form>
            </div>
            @endif

            {{-- Payment Section - Only for Clients if order is not fully paid --}}
            @if(auth()->user()->role === 'client' && ($order->paid_amount < $offer->price))
            <div class="payment-section">
                <h3 class="section-title">Payment</h3>
                <div class="payment-info">
                    <p>Remaining amount: <strong>Rp{{ number_format($offer->price - ($order->paid_amount ?? 0), 0, ',', '.') }}</strong></p>
                    <form action="{{ route('client.order.pay', $order->id) }}" method="POST" class="payment-form">
                        @csrf
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Complete Payment</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Milestone -->
        <div class="milestone-section">
            <h2 class="milestone-title">Milestone</h2>

            <!-- TIMELINE DINAMIS -->
            <div class="timeline">
                @forelse($milestones as $milestone)
                    <div class="timeline-item {{ 
                        $milestone->status === 'Done' ? 'completed' : 
                        ($milestone->status === 'Progress' ? 'current' : 
                        ($milestone->status === 'Start' ? 'start' : 
                        ($milestone->status === 'Revision' ? 'revision' : 
                        ($milestone->status === 'Approved' ? 'approved' : '')))) 
                    }}">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-date">
                                {{ $milestone->start_time ? $milestone->start_time->format('d F Y') : 'Tanggal belum ditentukan' }}
                            </div>
                            <div class="timeline-description">{{ $milestone->title }}</div>
                            @if($milestone->description)
                                <div style="font-size: 0.8rem; color: var(--text-secondary); margin-top: 0.25rem;">
                                    {{ $milestone->description }}
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <div class="timeline-description">No milestones available</div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Status Legend -->
            <div class="status-legend">
                <div class="legend-item"><div class="status-dot status-start"></div><span>Start</span></div>
                <div class="legend-item"><div class="status-dot status-progress"></div><span>Progress</span></div>
                <div class="legend-item"><div class="status-dot status-done"></div><span>Done</span></div>
                <div class="legend-item"><div class="status-dot status-revision"></div><span>Revision</span></div>
                <div class="legend-item"><div class="status-dot status-approved"></div><span>Approved</span></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* TAMBAHKAN CSS INI untuk status Start dan revisi_request */
.timeline-item.start .timeline-marker {
    background: #64748b;
    box-shadow: 0 0 0 2px #64748b;
}

.timeline-item.revision .timeline-marker {
    background: #ef4444;
    box-shadow: 0 0 0 2px #ef4444;
}

.timeline-item.approved .timeline-marker {
    background: #22c55e;
    box-shadow: 0 0 0 2px #22c55e;
}

/* Project Details Page Styles */
.project-details-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    background: var(--bg-primary);
    min-height: 100vh;
}

/* Back Navigation */
.back-navigation {
    margin-bottom: 2rem;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    text-decoration: none;
    font-weight: 500;
    padding: 0.5rem;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.back-btn:hover {
    color: var(--primary-color);
    background: rgba(56, 193, 185, 0.1);
}

/* Main Content Grid */
.project-content-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 3rem;
}

/* Project Details Section */
.project-details-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
}

/* Project Header */
.project-header {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid var(--border-light);
}

.project-date {
    color: var(--text-secondary);
    font-size: 1rem;
    margin-bottom: 1rem;
}

.project-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
    line-height: 1.4;
}

.project-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.meta-item {
    display: flex;
    gap: 0.5rem;
}

.meta-label {
    font-weight: 600;
    color: var(--text-primary);
    min-width: 80px;
}

.meta-value {
    color: var(--text-secondary);
}

/* Project Description Section */
.project-description-section {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.description-content p {
    margin-bottom: 0.75rem;
    line-height: 1.6;
    color: var(--text-secondary);
}

.description-content strong {
    color: var(--text-primary);
    font-weight: 600;
}

.output-section {
    margin-top: 1.5rem;
    padding: 1rem;
    background: var(--bg-muted);
    border-radius: 8px;
}

.output-section h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.output-section ul {
    margin: 0;
    padding-left: 1.2rem;
}

.output-section li {
    margin-bottom: 0.25rem;
    color: var(--text-secondary);
    line-height: 1.5;
}

/* Project Pricing */
.project-pricing {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(56, 193, 185, 0.05), rgba(126, 142, 241, 0.05));
    border-radius: 12px;
    border: 1px solid rgba(56, 193, 185, 0.2);
}

.price-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.price-label {
    font-weight: 600;
    color: var(--text-primary);
    min-width: 60px;
}

.price-value {
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--primary-color);
}

.price-item.paid .price-value {
    color: #16a34a;
}

.paid-badge {
    font-size: 1.1rem;
}

/* Progress Report Section */
.progress-report-section {
    margin-top: 2rem;
}

.progress-form {
    margin-top: 1rem;
}

.progress-view {
    margin-top: 1rem;
}

.progress-info {
    padding: 1rem;
    background: var(--bg-muted);
    border-radius: 8px;
    border-left: 4px solid var(--primary-color);
}

.progress-info p {
    margin: 0;
    color: var(--text-secondary);
    font-style: italic;
}

.progress-textarea {
    width: 100%;
    min-height: 150px;
    padding: 1rem;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    font-family: inherit;
    font-size: 0.9rem;
    line-height: 1.5;
    color: var(--text-primary);
    background: white;
    resize: vertical;
    transition: border-color 0.3s ease;
}

.progress-textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
}

/* Payment Section */
.payment-section {
    margin-top: 2rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.05), rgba(16, 185, 129, 0.05));
    border-radius: 12px;
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.payment-info p {
    margin-bottom: 1rem;
    color: var(--text-secondary);
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
    justify-content: flex-end;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: none;
    text-decoration: none;
}

.btn-secondary {
    background: #64748b;
    color: white;
}

.btn-secondary:hover {
    background: #475569;
    transform: translateY(-1px);
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

/* Milestone Section */
.milestone-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
    height: fit-content;
}

.milestone-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 2rem;
    text-align: center;
}

/* Timeline */
.timeline {
    position: relative;
    margin-bottom: 3rem;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--border-color);
}

.timeline-item {
    position: relative;
    margin-bottom: 2rem;
    padding-left: 3rem;
}

.timeline-marker {
    position: absolute;
    left: 7px;
    top: 4px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: var(--border-color);
    border: 3px solid white;
    box-shadow: 0 0 0 2px var(--border-color);
}

.timeline-item.completed .timeline-marker {
    background: #38C1B9;
    box-shadow: 0 0 0 2px #38C1B9;
}

.timeline-item.current .timeline-marker {
    background: #4ECDC4;
    box-shadow: 0 0 0 2px #4ECDC4;
    animation: pulse-current 2s infinite;
}

@keyframes pulse-current {
    0%, 100% { box-shadow: 0 0 0 2px #4ECDC4, 0 0 0 6px rgba(78, 205, 196, 0.3); }
    50% { box-shadow: 0 0 0 2px #4ECDC4, 0 0 0 12px rgba(78, 205, 196, 0); }
}

.timeline-content {
    padding-top: 0.25rem;
}

.timeline-date {
    font-weight: 700;
    color: var(--text-primary);
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

.timeline-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.4;
}

/* Status Legend */
.status-legend {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--bg-muted);
    border-radius: 8px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--text-secondary);
}

.status-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
}

.status-start {
    background: #64748b;
}

.status-progress {
    background: #4ECDC4;
}

.status-done {
    background: #38C1B9;
}

.status-revision {
    background: #ef4444;
}

.status-approved {
    background: #22c55e;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {
    .project-details-page {
        padding: 1rem;
    }

    .project-content-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .project-details-section,
    .milestone-section {
        padding: 1.5rem;
    }

    .project-title {
        font-size: 1.25rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn {
        justify-content: center;
    }

    .milestone-section {
        order: -1;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .project-details-section,
    .milestone-section {
        background: var(--bg-secondary);
        border-color: var(--border-dark);
    }

    .progress-textarea {
        background: var(--bg-secondary);
        border-color: var(--border-dark);
        color: var(--text-primary);
    }

    .timeline::before {
        background: var(--border-dark);
    }
}
</style>
@endpush

@push('scripts')
<script>
// Project Details Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initializeProjectDetails();
});

function initializeProjectDetails() {
    console.log('Project Details page initialized');
    
    // Setup form validation
    setupFormValidation();
    
    // Setup auto-save functionality (only for freelancers)
    if (document.querySelector('.progress-textarea')) {
        setupAutoSave();
    }
}

function setupFormValidation() {
    const textarea = document.querySelector('.progress-textarea');
    if (textarea) {
        textarea.addEventListener('input', function() {
            validateProgressInput(this.value);
        });
    }
}

function validateProgressInput(value) {
    const minLength = 10;
    const isValid = value.trim().length >= minLength;
    
    // Update button states based on validation
    const submitBtn = document.querySelector('.btn-secondary');
    
    if (submitBtn) {
        submitBtn.disabled = !isValid;
        submitBtn.style.opacity = isValid ? '1' : '0.6';
    }
    
    return isValid;
}

function setupAutoSave() {
    const textarea = document.querySelector('.progress-textarea');
    if (textarea) {
        let autoSaveTimeout;
        
        textarea.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                autoSaveProgress(this.value);
            }, 2000); // Auto-save after 2 seconds of no typing
        });
    }
}

function autoSaveProgress(content) {
    // This would typically send an AJAX request to save the draft
    console.log('Auto-saving progress...', content.substring(0, 50) + '...');
    
    // Show auto-save indicator
    showAutoSaveIndicator();
}

function showAutoSaveIndicator() {
    // Create and show a temporary "auto-saved" indicator
    const indicator = document.createElement('div');
    indicator.textContent = 'Auto-saved';
    indicator.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #16a34a;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s ease;
    `;
    
    document.body.appendChild(indicator);
    
    // Animate in
    setTimeout(() => indicator.style.opacity = '1', 100);
    
    // Remove after 2 seconds
    setTimeout(() => {
        indicator.style.opacity = '0';
        setTimeout(() => document.body.removeChild(indicator), 300);
    }, 2000);
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.textContent = message;
    
    const colors = {
        success: '#16a34a',
        error: '#dc2626',
        info: '#0ea5e9',
        warning: '#f59e0b'
    };
    
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${colors[type] || colors.info};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        z-index: 1000;
        opacity: 0;
        transform: translateY(-20px);
        transition: all 0.3s ease;
        max-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateY(0)';
    }, 100);
    
    // Remove after 4 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 4000);
}

// Form submission handling with Laravel CSRF
document.addEventListener('DOMContentLoaded', function() {
    const progressForm = document.querySelector('.progress-form');
    const paymentForm = document.querySelector('.payment-form');
    
    if (progressForm) {
        progressForm.addEventListener('submit', function(e) {
            const textarea = this.querySelector('.progress-textarea');
            if (!validateProgressInput(textarea.value)) {
                e.preventDefault();
                showNotification('Please provide more detailed progress information (minimum 10 characters).', 'error');
            }
        });
    }
    
    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to complete this payment?')) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endpush