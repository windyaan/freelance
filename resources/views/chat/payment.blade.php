@extends('layouts.app')

@section('title', 'Payment Detail - SkillMatch')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <!-- Payment Form Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gray-50 px-6 py-4 border-b">
                <h1 class="text-xl font-semibold text-gray-900">Payment Detail</h1>
            </div>

            <!-- Form -->
            <form id="paymentForm" action="{{ route('offers.payment.process', $offer) }}" method="POST" class="p-6">
                @csrf
                
                <!-- Waktu Pengajuan -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-500 mb-2">Waktu Pengajuan</label>
                    <div class="relative">
                        <input type="date" 
                               name="payment_date" 
                               value="{{ now()->format('Y-m-d') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Amount -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-500 mb-2">Amount</label>
                    <div class="relative">
                        <input type="number" 
                               name="amount" 
                               value="{{ $offer->final_price }}"
                               step="0.01"
                               min="0"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-500 mb-2">Description</label>
                    <textarea name="description" 
                              rows="4"
                              placeholder="pembayaran dp kaos barong"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg resize-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">pembayaran dp kaos barong</textarea>
                </div>

                <!-- Pay Button -->
                <button type="submit" 
                        id="payButton"
                        class="w-full bg-slate-600 hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200">
                    Pay
                </button>
            </form>
        </div>

        <!-- Project Info (Optional) -->
        <div class="mt-4 text-center text-sm text-gray-600">
            <p>{{ $offer->title }}</p>
            <p class="font-semibold">{{ $offer->formatted_price }}</p>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Payment Successful!</h3>
            <p class="text-sm text-gray-500 mb-4">Your payment has been processed successfully.</p>
            <button id="closeModal" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                Back to Chat
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentForm = document.getElementById('paymentForm');
    const payButton = document.getElementById('payButton');
    const successModal = document.getElementById('successModal');
    const closeModal = document.getElementById('closeModal');

    // Handle form submission
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        const originalText = payButton.textContent;
        payButton.disabled = true;
        payButton.innerHTML = '<div class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></div>Processing...';

        // Get form data
        const formData = new FormData(this);

        // Send AJAX request
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success modal
                successModal.classList.remove('hidden');
                
                // Store redirect URL
                window.paymentRedirectUrl = data.redirect_url || '{{ route(auth()->user()->role . ".chat", ["chat_id" => $offer->chat_id]) }}';
            } else {
                throw new Error(data.error || 'Payment failed');
            }
        })
        .catch(error => {
            console.error('Payment error:', error);
            alert('Payment failed. Please try again.');
            
            // Reset button state
            payButton.disabled = false;
            payButton.textContent = originalText;
        });
    });

    // Handle modal close
    closeModal.addEventListener('click', function() {
        successModal.classList.add('hidden');
        
        // Redirect to chat
        const redirectUrl = window.paymentRedirectUrl || '{{ route(auth()->user()->role . ".chat", ["chat_id" => $offer->chat_id]) }}';
        window.location.href = redirectUrl;
    });

    // Close modal on outside click
    successModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal.click();
        }
    });

    // Auto-format amount input
    const amountInput = document.querySelector('input[name="amount"]');
    amountInput.addEventListener('input', function() {
        // Remove non-numeric characters except decimal point
        let value = this.value.replace(/[^0-9.]/g, '');
        
        // Ensure only one decimal point
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }
        
        this.value = value;
    });
});
</script>
@endpush
@endsection