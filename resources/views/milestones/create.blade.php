@extends('layouts.app')

@section('title', 'Create Milestone - ' . $order->title)
@section('page-title', 'Create New Milestone')

@section('navbar-center')
    @component('components.search')
        @slot('placeholder', 'Search...')
    @endcomponent
@endsection

@section('navigation')
    <a href="{{ route('freelancer.dashboard') }}" class="nav-item">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
        </div>
        <span class="nav-text">Dashboard</span>
    </a>

    <a href="{{ route('milestones.index', $order) }}" class="nav-item">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:flag"></iconify-icon>
        </div>
        <span class="nav-text">Milestones</span>
    </a>

    <a href="{{ route('milestones.create', $order) }}" class="nav-item active">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:add-circle"></iconify-icon>
        </div>
        <span class="nav-text">Create</span>
    </a>
@endsection

@section('content')
<div class="create-milestone-container">
    <!-- Back Button -->
    <div class="back-section">
        <a href="{{ route('milestones.index', $order) }}" class="back-btn">
            <iconify-icon icon="material-symbols:arrow-back"></iconify-icon>
            Back to Milestones
        </a>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <iconify-icon icon="material-symbols:add-circle"></iconify-icon>
                Create New Milestone
            </h1>
            <p class="page-subtitle">Add a new milestone to track project progress</p>
        </div>
        
        <!-- Order Info Card -->
        <div class="order-info-card">
            <div class="order-header">
                <div class="order-title">{{ $order->title }}</div>
                <div class="order-status status-{{ strtolower(str_replace(' ', '-', $order->status)) }}">
                    {{ ucfirst($order->status) }}
                </div>
            </div>
            <div class="order-client">
                <img src="{{ $order->client->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($order->client->name) . '&background=38C1B9&color=fff&size=40' }}" 
                     alt="{{ $order->client->name }}" class="client-avatar">
                <div class="client-details">
                    <span class="client-name">{{ $order->client->name }}</span>
                    <span class="order-date">{{ $order->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Form -->
    <div class="create-form-section">
        <form action="{{ route('milestones.store', $order) }}" method="POST" class="milestone-form" id="milestoneForm">
            @csrf
            
            <div class="form-grid">
                <!-- Left Column -->
                <div class="form-column">
                    <!-- Title -->
                    <div class="form-group">
                        <label for="title" class="form-label">
                            <iconify-icon icon="material-symbols:title"></iconify-icon>
                            Milestone Title
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               class="form-input"
                               placeholder="e.g., Initial Design Concepts"
                               value="{{ old('title') }}"
                               required>
                        @error('title')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label for="description" class="form-label">
                            <iconify-icon icon="material-symbols:description"></iconify-icon>
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  class="form-textarea"
                                  rows="4"
                                  placeholder="Describe what will be accomplished in this milestone..."
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Deliverables -->
                    <div class="form-group">
                        <label for="deliverables" class="form-label">
                            <iconify-icon icon="material-symbols:inventory"></iconify-icon>
                            Deliverables (Optional)
                        </label>
                        <textarea id="deliverables" 
                                  name="deliverables" 
                                  class="form-textarea"
                                  rows="3"
                                  placeholder="List specific deliverables (files, documents, etc.)">{{ old('deliverables') }}</textarea>
                        @error('deliverables')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <!-- Due Date -->
                    <div class="form-group">
                        <label for="due_date" class="form-label">
                            <iconify-icon icon="material-symbols:schedule"></iconify-icon>
                            Due Date
                        </label>
                        <input type="date" 
                               id="due_date" 
                               name="due_date" 
                               class="form-input"
                               value="{{ old('due_date') }}"
                               min="{{ date('Y-m-d') }}"
                               required>
                        @error('due_date')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="form-group">
                        <label for="amount" class="form-label">
                            <iconify-icon icon="material-symbols:payments"></iconify-icon>
                            Milestone Amount (IDR)
                        </label>
                        <div class="currency-input">
                            <span class="currency-prefix">Rp</span>
                            <input type="number" 
                                   id="amount" 
                                   name="amount" 
                                   class="form-input currency"
                                   placeholder="0"
                                   value="{{ old('amount') }}"
                                   min="0"
                                   step="1000"
                                   required>
                        </div>
                        @error('amount')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        <div class="help-text">Enter amount in Indonesian Rupiah</div>
                    </div>

                    <!-- Preview Card -->
                    <div class="milestone-preview">
                        <h4 class="preview-title">
                            <iconify-icon icon="material-symbols:preview"></iconify-icon>
                            Preview
                        </h4>
                        <div class="preview-card">
                            <div class="preview-header">
                                <div class="preview-milestone-title" id="previewTitle">Milestone Title</div>
                                <div class="preview-status">Pending</div>
                            </div>
                            <div class="preview-content">
                                <div class="preview-description" id="previewDescription">Description will appear here...</div>
                                <div class="preview-footer">
                                    <div class="preview-amount" id="previewAmount">Rp 0</div>
                                    <div class="preview-date" id="previewDate">Due date</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="history.back()">
                    <iconify-icon icon="material-symbols:cancel"></iconify-icon>
                    Cancel
                </button>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <iconify-icon icon="material-symbols:save"></iconify-icon>
                    Create Milestone
                </button>
            </div>
        </form>
    </div>

    <!-- Tips Section -->
    <div class="tips-section">
        <h3 class="tips-title">
            <iconify-icon icon="material-symbols:lightbulb"></iconify-icon>
            Tips for Creating Effective Milestones
        </h3>
        <div class="tips-grid">
            <div class="tip-card">
                <div class="tip-icon">
                    <iconify-icon icon="material-symbols:target"></iconify-icon>
                </div>
                <div class="tip-content">
                    <h4>Be Specific</h4>
                    <p>Make milestone titles and descriptions clear and specific to avoid confusion.</p>
                </div>
            </div>
            
            <div class="tip-card">
                <div class="tip-icon">
                    <iconify-icon icon="material-symbols:schedule"></iconify-icon>
                </div>
                <div class="tip-content">
                    <h4>Realistic Deadlines</h4>
                    <p>Set achievable deadlines that account for complexity and dependencies.</p>
                </div>
            </div>
            
            <div class="tip-card">
                <div class="tip-icon">
                    <iconify-icon icon="material-symbols:payments"></iconify-icon>
                </div>
                <div class="tip-content">
                    <h4>Fair Pricing</h4>
                    <p>Break down payments proportionally based on milestone complexity and value.</p>
                </div>
            </div>
            
            <div class="tip-card">
                <div class="tip-icon">
                    <iconify-icon icon="material-symbols:handshake"></iconify-icon>
                </div>
                <div class="tip-content">
                    <h4>Clear Deliverables</h4>
                    <p>Define exactly what the client will receive when the milestone is completed.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
:root {
    --primary-color: #38C1B9;
    --secondary-color: #7E8EF1;
    --success-color: #22c55e;
    --warning-color: #f59e0b;
    --error-color: #ef4444;
    --bg-primary: #ffffff;
    --bg-secondary: #f8fafc;
    --bg-muted: #f1f5f9;
    --text-primary: #1e293b;
    --text-secondary: #64748b;
    --border-color: #e2e8f0;
    --border-light: #f1f5f9;
    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
}

.create-milestone-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    background: var(--bg-secondary);
    min-height: 100vh;
}

/* Back Section */
.back-section {
    margin-bottom: 2rem;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    text-decoration: none;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    border: 1px solid var(--border-color);
    background: white;
}

.back-btn:hover {
    color: var(--primary-color);
    background: var(--bg-muted);
    transform: translateX(-2px);
}

/* Page Header */
.page-header {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 2rem;
    align-items: start;
    margin-bottom: 3rem;
}

.header-content {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-light);
}

.page-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.page-title iconify-icon {
    color: var(--primary-color);
    font-size: 2.5rem;
}

.page-subtitle {
    color: var(--text-secondary);
    font-size: 1.1rem;
    margin: 0;
}

.order-info-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-light);
    min-width: 300px;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 1rem;
    gap: 1rem;
}

.order-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    line-height: 1.3;
}

.order-status {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
    white-space: nowrap;
}

.status-accepted {
    background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.1));
    color: #16a34a;
    border: 1px solid rgba(34, 197, 94, 0.3);
}

.status-in-progress {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(59, 130, 246, 0.1));
    color: #2563eb;
    border: 1px solid rgba(59, 130, 246, 0.3);
}

.order-client {
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

.client-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.client-name {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-primary);
}

.order-date {
    font-size: 0.8rem;
    color: var(--text-secondary);
}

/* Create Form Section */
.create-form-section {
    margin-bottom: 3rem;
}

.milestone-form {
    background: white;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-light);
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    margin-bottom: 2rem;
}

.form-column {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.9rem;
}

.form-label iconify-icon {
    color: var(--primary-color);
    font-size: 1.1rem;
}

.form-input, .form-textarea {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 10px;
    font-size: 0.9rem;
    color: var(--text-primary);
    background: white;
    transition: all 0.2s ease;
}

.form-input:focus, .form-textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
}

.form-textarea {
    resize: vertical;
    font-family: inherit;
}

.currency-input {
    position: relative;
    display: flex;
    align-items: center;
}

.currency-prefix {
    position: absolute;
    left: 1rem;
    color: var(--text-secondary);
    font-weight: 600;
    z-index: 1;
}

.form-input.currency {
    padding-left: 2.5rem;
}

.error-message {
    color: var(--error-color);
    font-size: 0.8rem;
    font-weight: 500;
}

.help-text {
    color: var(--text-secondary);
    font-size: 0.8rem;
}

/* Preview Section */
.milestone-preview {
    border: 2px solid var(--border-light);
    border-radius: 12px;
    padding: 1.5rem;
    background: var(--bg-muted);
}

.preview-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.preview-title iconify-icon {
    color: var(--primary-color);
}

.preview-card {
    background: white;
    border-radius: 8px;
    padding: 1rem;
    border: 1px solid var(--border-color);
}

.preview-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 0.75rem;
    gap: 1rem;
}

.preview-milestone-title {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-primary);
}

.preview-status {
    padding: 0.25rem 0.5rem;
    background: linear-gradient(135deg, rgba(156, 163, 175, 0.15), rgba(156, 163, 175, 0.1));
    color: #6b7280;
    border: 1px solid rgba(156, 163, 175, 0.3);
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
}

.preview-description {
    font-size: 0.8rem;
    color: var(--text-secondary);
    line-height: 1.4;
    margin-bottom: 0.75rem;
}

.preview-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.preview-amount {
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--primary-color);
}

.preview-date {
    font-size: 0.7rem;
    color: var(--text-secondary);
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 2px solid var(--border-light);
}

.btn {
    padding: 0.875rem 2rem;
    border-radius: 10px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: none;
    min-width: 140px;
    justify-content: center;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    box-shadow: var(--shadow-md);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-primary:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.btn-secondary {
    background: white;
    color: var(--text-secondary);
    border: 2px solid var(--border-color);
}

.btn-secondary:hover {
    background: var(--bg-muted);
    color: var(--text-primary);
    border-color: var(--primary-color);
}

/* Tips Section */
.tips-section {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-light);
}

.tips-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
}

.tips-title iconify-icon {
    color: var(--warning-color);
    font-size: 1.5rem;
}

.tips-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.tip-card {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--bg-muted);
    border-radius: 12px;
    border: 1px solid var(--border-light);
    transition: all 0.3s ease;
}

.tip-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.tip-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.tip-content h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
}

.tip-content p {
    font-size: 0.9rem;
    color: var(--text-secondary);
    line-height: 1.4;
    margin: 0;
}

/* Mobile Responsiveness */
@media (max-width: 1024px) {
    .page-header {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .form-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .tips-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .create-milestone-container {
        padding: 1rem;
    }

    .milestone-form {
        padding: 1.5rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }

    .order-info-card {
        min-width: auto;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 1.5rem;
    }

    .order-header {
        flex-direction: column;
        align-items: start;
    }

    .tip-card {
        flex-direction: column;
        text-align: center;
    }

    .tip-icon {
        align-self: center;
    }
}

/* Loading States */
.form-loading {
    opacity: 0.6;
    pointer-events: none;
}

.form-loading .btn-primary {
    position: relative;
}

.form-loading .btn-primary::after {
    content: '';
    position: absolute;
    width: 16px;
    height: 16px;
    border: 2px solid transparent;
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin-left: 0.5rem;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Validation Styles */
.form-input.is-invalid, .form-textarea.is-invalid {
    border-color: var(--error-color);
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.form-input.is-valid, .form-textarea.is-valid {
    border-color: var(--success-color);
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
}
</style>
@endpush

@push('scripts')
<script>
// Form validation and preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('milestoneForm');
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');
    const dueDateInput = document.getElementById('due_date');
    const amountInput = document.getElementById('amount');
    const submitBtn = document.getElementById('submitBtn');

    // Preview elements
    const previewTitle = document.getElementById('previewTitle');
    const previewDescription = document.getElementById('previewDescription');
    const previewDate = document.getElementById('previewDate');
    const previewAmount = document.getElementById('previewAmount');

    // Update preview in real-time
    function updatePreview() {
        const title = titleInput.value.trim() || 'Milestone Title';
        const description = descriptionInput.value.trim() || 'Description will appear here...';
        const dueDate = dueDateInput.value;
        const amount = parseFloat(amountInput.value) || 0;

        previewTitle.textContent = title;
        previewDescription.textContent = description;
        previewAmount.textContent = formatCurrency(amount);
        
        if (dueDate) {
            const date = new Date(dueDate);
            previewDate.textContent = date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
        } else {
            previewDate.textContent = 'Due date';
        }
    }

    // Format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount);
    }

    // Auto-resize textarea
    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    }

    // Event listeners for real-time preview
    titleInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', function() {
        updatePreview();
        autoResize(this);
    });
    dueDateInput.addEventListener('change', updatePreview);
    amountInput.addEventListener('input', updatePreview);

    // Auto-resize textareas
    const textareas = document.querySelectorAll('.form-textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function() {
            autoResize(this);
        });
    });

    // Form validation
    function validateForm() {
        let isValid = true;
        const inputs = [titleInput, descriptionInput, dueDateInput, amountInput];

        inputs.forEach(input => {
            input.classList.remove('is-invalid', 'is-valid');
            
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                isValid = false;
            } else {
                input.classList.add('is-valid');
            }
        });

        // Validate due date is not in the past
        if (dueDateInput.value) {
            const selectedDate = new Date(dueDateInput.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                dueDateInput.classList.remove('is-valid');
                dueDateInput.classList.add('is-invalid');
                isValid = false;
            }
        }

        // Validate amount is positive
        if (amountInput.value && parseFloat(amountInput.value) <= 0) {
            amountInput.classList.remove('is-valid');
            amountInput.classList.add('is-invalid');
            isValid = false;
        }

        return isValid;
    }

    // Form submission handling
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            alert('Please fill in all required fields correctly.');
            return;
        }

        // Add loading state
        form.classList.add('form-loading');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<iconify-icon icon="material-symbols:hourglass-empty"></iconify-icon>Creating...';
    });

    // Real-time validation
    const inputs = [titleInput, descriptionInput, dueDateInput, amountInput];
    inputs.forEach(input => {
        input.addEventListener('blur', validateForm);
    });

    // Initialize preview
    updatePreview();

    // Initialize auto-resize for existing content
    textareas.forEach(autoResize);

    // Amount input formatting
    amountInput.addEventListener('input', function() {
        // Remove non-numeric characters except decimal point
        this.value = this.value.replace(/[^\d]/g, '');
        
        // Ensure minimum step
        const value = parseInt(this.value) || 0;
        const remainder = value % 1000;
        if (remainder !== 0) {
            this.value = value - remainder + (remainder >= 500 ? 1000 : 0);
        }
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S to save
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            form.dispatchEvent(new Event('submit', { cancelable: true }));
        }
        
        // Escape to go back
        if (e.key === 'Escape') {
            if (confirm('Are you sure you want to leave? Any unsaved changes will be lost.')) {
                history.back();
            }
        }
    });

    // Warn about unsaved changes
    let formChanged = false;
    inputs.forEach(input => {
        input.addEventListener('input', () => formChanged = true);
    });

    window.addEventListener('beforeunload', function(e) {
        if (formChanged && !form.classList.contains('form-loading')) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Mark form as submitted to prevent warning
    form.addEventListener('submit', () => formChanged = false);
});
</script>
@endpush