<!-- Search Component -->
<div class="search-container">
    <iconify-icon icon="material-symbols:search" class="search-icon"></iconify-icon>
    <input 
        type="text" 
        class="search-input" 
        placeholder="{{ $placeholder ?? 'Search...' }}" 
        id="globalSearch" 
        autocomplete="off"
        @if(isset($value)) value="{{ $value }}" @endif
    >
    <button class="search-btn" id="searchBtn" type="button">
        {{ $buttonText ?? 'Search' }}
    </button>
    
    @if(isset($showResults) && $showResults)
        <div class="search-results" id="searchResults" style="display: none;">
            <!-- Search results will be populated here -->
        </div>
    @endif
</div>

@push('styles')
<style>
    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--bg-primary);
        border-radius: 8px;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
        margin-top: 8px;
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000;
    }

    .search-results.show {
        display: block;
    }

    .search-result-item {
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border-light);
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .search-result-item:hover {
        background-color: var(--bg-secondary);
    }

    .search-result-item:last-child {
        border-bottom: none;
    }

    .search-result-name {
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .search-result-details {
        font-size: 0.85rem;
        color: var(--text-secondary);
    }
</style>
@endpush