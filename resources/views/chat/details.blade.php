@extends('layouts.app')

@section('title', 'Offer Details - SkillMatch')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header dengan tombol back -->
        <div class="mb-6">
            <a href="{{ route(auth()->user()->role . '.chat', ['chat_id' => $offer->chat_id]) }}" 
               class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Chat
            </a>
        </div>

        <!-- Offer Details Card -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h1 class="text-xl font-bold text-white">Project Title : {{ $offer->title }}</h1>
                <button type="button" onclick="window.history.back()" 
                        class="absolute top-4 right-4 text-white hover:text-gray-200 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-6 space-y-4">
                <!-- Project Info -->
                <div class="space-y-2 text-sm text-gray-700">
                    <p><span class="font-medium">Client :</span> {{ $offer->client->name }}</p>
                    <p><span class="font-medium">Revision :</span> 2x</p>
                    <p><span class="font-medium">Start :</span> {{ now()->format('d F Y') }}</p>
                    <p><span class="font-medium">Deadline :</span> {{ $offer->formatted_deadline }}</p>
                </div>

                <!-- Description -->
                <div class="pt-4">
                    <h3 class="font-medium text-gray-900 mb-2">Description :</h3>
                    <div class="text-sm text-gray-700 space-y-1">
                        @foreach(explode("\n", $offer->description) as $line)
                            @if(trim($line))
                                <p>{{ trim($line) }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Output (static content based on example) -->
                <div class="pt-4">
                    <h3 class="font-medium text-gray-900 mb-2">Output :</h3>
                    <div class="text-sm text-gray-700 space-y-1">
                        <p>Website siap digunakan & dihosting</p>
                        <p>Panduan singkat untuk mengelola website</p>
                        <p>Desain UI/UX yang konsisten dengan tema brand</p>
                    </div>
                </div>

                <!-- Price -->
                <div class="pt-6 pb-4">
                    <h2 class="text-2xl font-bold text-gray-900">Price : {{ $offer->formatted_price }}</h2>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 pb-6 space-y-3">
                <!-- Reject Button -->
                <form action="{{ route('offers.reject', $offer) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            onclick="return confirm('Are you sure you want to reject this offer?')"
                            class="w-full bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200">
                        Reject
                    </button>
                </form>

                <!-- Accept Button -->
                <form action="{{ route('offers.accept', $offer) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200">
                        Accept
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submissions with loading states
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            const button = this.querySelector('button[type="submit"]');
            const originalText = button.textContent;
            button.disabled = true;
            button.innerHTML = '<div class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></div>Processing...';
            
            // Re-enable after timeout as fallback
            setTimeout(() => {
                button.disabled = false;
                button.textContent = originalText;
            }, 5000);
        });
    });
});
</script>
@endpush
@endsection