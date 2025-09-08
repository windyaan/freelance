@extends('layouts.app')

@section('title', 'Payment Detail - SkillMatch')

@section('page-title', 'Payment Detail')

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
<a href="{{ route('client.order') }}" class="nav-item {{ request()->routeIs('client.order') ? 'active' : '' }}">
    <div class="nav-icon">
        <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
    </div>
    <span class="nav-text">Orders</span>
</a>
@endsection

@push('styles')
<style>
    .payment-container {
        max-width: 600px;
        margin: 2rem auto;
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 1px solid #f1f5f9;
    }

    .payment-header {
        text-align: left;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .payment-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .payment-subtitle {
        font-size: 1rem;
        color: #64748b;
        margin: 0;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1rem;
        color: #1f2937;
        background-color: #ffffff;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-input:focus {
        outline: none;
        border-color: #38C1B9;
        box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
    }

    .form-input:disabled {
        background-color: #f9fafb;
        color: #6b7280;
        cursor: not-allowed;
    }

    .form-textarea {
        width: 100%;
        min-height: 120px;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 1rem;
        color: #1f2937;
        background-color: #ffffff;
        resize: vertical;
        font-family: inherit;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-textarea:focus {
        outline: none;
        border-color: #38C1B9;
        box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
    }

    .input-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 1.25rem;
        pointer-events: none;
    }

    .payment-info {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 2rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .info-row:last-child {
        margin-bottom: 0;
        padding-top: 0.5rem;
        border-top: 1px solid #e2e8f0;
        font-weight: 600;
        color: #1e293b;
    }

    .info-label {
        font-size: 0.875rem;
        color: #64748b;
    }

    .info-value {
        font-size: 0.875rem;
        color: #1e293b;
        font-weight: 500;
    }

    .payment-methods {
        margin-bottom: 2rem;
    }

    .method-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .method-option {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
        background: white;
    }

    .method-option:hover {
        border-color: #38C1B9;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .method-option.selected {
        border-color: #38C1B9;
        background: rgba(56, 193, 185, 0.05);
    }

    .method-icon {
        width: 40px;
        height: 40px;
        margin: 0 auto 0.5rem;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 1.25rem;
    }

    .method-option.selected .method-icon {
        background: #38C1B9;
        color: white;
    }

    .method-name {
        font-size: 0.75rem;
        font-weight: 500;
        color: #64748b;
    }

    .method-option.selected .method-name {
        color: #38C1B9;
    }

    .btn-pay {
        width: 100%;
        background: #38C1B9;
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-pay:hover {
        background: #2da89f;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(56, 193, 185, 0.3);
    }

    .btn-pay:active {
        transform: translateY(0);
    }

    .btn-pay:disabled {
        background: #94a3b8;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .back-button {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        text-decoration: none;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        transition: color 0.2s ease;
    }

    .back-button:hover {
        color: #38C1B9;
    }

    .order-summary {
        background: #fefefe;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .order-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 0.5rem;
    }

    .order-details {
        font-size: 0.875rem;
        color: #64748b;
        line-height: 1.5;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .payment-container {
            margin: 1rem;
            padding: 1.5rem;
        }

        .payment-title {
            font-size: 1.5rem;
        }

        .method-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .method-grid {
            grid-template-columns: 1fr;
        }

        .info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
    }

    /* Loading state */
    .loading {
        opacity: 0.7;
        pointer-events: none;
    }

    .loading .btn-pay {
        background: #94a3b8;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')
<div class="payment-container">
    <a href="{{ route('client.order') }}" class="back-button">
        <iconify-icon icon="material-symbols:arrow-back"></iconify-icon>
        Back to Orders
    </a>

    <div class="payment-header">
        <h1 class="payment-title">Payment Detail</h1>
        <p class="payment-subtitle">Complete your payment to proceed with the order</p>
    </div>

    @if($order ?? null)
    <!-- Order Summary -->
    <div class="order-summary">
        <div class="order-title">{{ $order->offer->title ?? 'Order Payment' }}</div>
        <div class="order-details">
            <strong>Freelancer:</strong> {{ $order->offer->job->freelancer->name ?? 'N/A' }}<br>
            <strong>Order ID:</strong> #{{ $order->id }}<br>
            <strong>Status:</strong> {{ ucfirst($order->status) }}
        </div>
    </div>

    <!-- Payment Information -->
    <div class="payment-info">
        <div class="info-row">
            <span class="info-label">Order Amount:</span>
            <span class="info-value">Rp{{ number_format($order->amount, 0, ',', '.') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Amount Paid:</span>
            <span class="info-value">Rp{{ number_format($order->amount_paid, 0, ',', '.') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Remaining:</span>
            <span class="info-value">Rp{{ number_format($order->amount - $order->amount_paid, 0, ',', '.') }}</span>
        </div>
    </div>
    @endif

    <form id="paymentForm" action="{{ route('order.processPayment', $order->id ?? 1) }}" method="POST">
        @csrf
        
        <!-- Payment Date -->
        <div class="form-group">
            <label for="payment_date" class="form-label">Waktu Pengajuan</label>
            <div class="input-group">
                <input type="date" 
                       id="payment_date" 
                       name="payment_date" 
                       class="form-input" 
                       value="{{ old('payment_date', date('Y-m-d')) }}" 
                       required>
                <iconify-icon icon="material-symbols:calendar-today" class="input-icon"></iconify-icon>
            </div>
        </div>

        <!-- Amount -->
        <div class="form-group">
            <label for="amount" class="form-label">Amount</label>
            <div class="input-group">
                <input type="number" 
                       id="amount" 
                       name="amount" 
                       class="form-input" 
                       value="{{ old('amount', isset($order) ? $order->amount - $order->amount_paid : 100000) }}" 
                       min="1000" 
                       step="1000" 
                       required>
                <iconify-icon icon="material-symbols:payments" class="input-icon"></iconify-icon>
            </div>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" 
                      name="description" 
                      class="form-textarea" 
                      placeholder="Enter payment description..."
                      required>{{ old('description', 'pembayaran dp kaos barong') }}</textarea>
        </div>

        <!-- Payment Methods -->
        <div class="payment-methods">
            <label class="form-label">Payment Method</label>
            <div class="method-grid">
                <div class="method-option selected" data-method="bank_transfer">
                    <div class="method-icon">
                        <iconify-icon icon="material-symbols:account-balance"></iconify-icon>
                    </div>
                    <div class="method-name">Bank Transfer</div>
                </div>
                <div class="method-option" data-method="credit_card">
                    <div class="method-icon">
                        <iconify-icon icon="material-symbols:credit-card"></iconify-icon>
                    </div>
                    <div class="method-name">Credit Card</div>
                </div>
                <div class="method-option" data-method="e_wallet">
                    <div class="method-icon">
                        <iconify-icon icon="material-symbols:wallet"></iconify-icon>
                    </div>
                    <div class="method-name">E-Wallet</div>
                </div>
                <div class="method-option" data-method="qris">
                    <div class="method-icon">
                        <iconify-icon icon="material-symbols:qr-code"></iconify-icon>
                    </div>
                    <div class="method-name">QRIS</div>
                </div>
            </div>
            <input type="hidden" id="payment_method" name="payment_method" value="bank_transfer">
        </div>

        <!-- Pay Button -->
        <button type="submit" class="btn-pay" id="payButton">
            <iconify-icon icon="material-symbols:payment"></iconify-icon>
            Pay Now
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payment method selection
    const methodOptions = document.querySelectorAll('.method-option');
    const paymentMethodInput = document.getElementById('payment_method');
    const paymentForm = document.getElementById('paymentForm');
    const payButton = document.getElementById('payButton');

    methodOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected class from all options
            methodOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Add selected class to clicked option
            this.classList.add('selected');
            
            // Update hidden input value
            const method = this.getAttribute('data-method');
            paymentMethodInput.value = method;
        });
    });

    // Form submission handling
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        document.body.classList.add('loading');
        payButton.disabled = true;
        payButton.innerHTML = `
            <iconify-icon icon="material-symbols:hourglass-empty"></iconify-icon>
            Processing...
        `;

        // Validate form data
        const formData = new FormData(this);
        const amount = parseInt(formData.get('amount'));
        const description = formData.get('description').trim();
        const paymentDate = formData.get('payment_date');

        if (amount < 1000) {
            alert('Minimum payment amount is Rp 1,000');
            resetButton();
            return;
        }

        if (!description) {
            alert('Please enter a payment description');
            resetButton();
            return;
        }

        if (!paymentDate) {
            alert('Please select a payment date');
            resetButton();
            return;
        }

        // Simulate payment processing delay
        setTimeout(() => {
            // In a real application, you would submit to your backend here
            console.log('Payment data:', {
                amount: amount,
                description: description,
                payment_date: paymentDate,
                payment_method: paymentMethodInput.value
            });

            // Show success message
            alert(`Payment of Rp${amount.toLocaleString('id-ID')} has been submitted successfully!`);
            
            // Redirect back to orders page
            window.location.href = "{{ route('client.order') }}";
        }, 2000);
    });

    function resetButton() {
        document.body.classList.remove('loading');
        payButton.disabled = false;
        payButton.innerHTML = `
            <iconify-icon icon="material-symbols:payment"></iconify-icon>
            Pay Now
        `;
    }

    // Auto-format amount input
    const amountInput = document.getElementById('amount');
    amountInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value) {
            this.value = parseInt(value);
        }
    });

    // Set minimum date to today
    const dateInput = document.getElementById('payment_date');
    dateInput.min = new Date().toISOString().split('T')[0];
});
</script>
@endsection