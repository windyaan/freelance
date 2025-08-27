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
    /* Fix untuk search container positioning */
    .search-container {
        position: relative;
        width: 100%;
        max-width: 450px;
        background: var(--bg-primary);
        border-radius: 8px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--border-color);
        overflow: visible; /* Changed from hidden to visible */
        display: flex;
        align-items: center;
        z-index: 100; /* Added z-index */
    }

    .search-container:focus-within {
        box-shadow: 0 4px 16px rgba(56, 193, 185, 0.15);
        border-color: var(--primary-color);
        z-index: 101; /* Higher z-index when focused */
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        color: var(--text-muted);
        font-size: 1.1rem;
        z-index: 102; /* Higher than input */
        pointer-events: none;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border: none;
        border-radius: 8px;
        font-size: 0.9rem;
        background: transparent;
        outline: none;
        color: var(--text-primary);
        flex: 1;
        z-index: 1; /* Lower z-index */
        position: relative;
    }

    .search-input::placeholder {
        color: var(--text-muted);
        font-weight: 400;
        opacity: 1; /* Ensure placeholder is fully opaque */
    }

    .search-btn {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        margin: 4px;
        white-space: nowrap;
        min-width: 80px;
        flex-shrink: 0;
        z-index: 102; /* Same as icon */
        position: relative;
    }

    .search-btn:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(56, 193, 185, 0.3);
    }

    /* Search results dengan positioning yang benar */
    .search-results {
        position: absolute;
        top: calc(100% + 8px); /* Space from container */
        left: 0;
        right: 0;
        background: var(--bg-primary);
        border-radius: 8px;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
        max-height: 300px;
        overflow-y: auto;
        z-index: 1000; /* Very high z-index for results */
        display: none;
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

    /* Additional fixes for mobile */
    @media (max-width: 768px) {
        .search-input {
            font-size: 16px; /* Prevent zoom on iOS */
            padding: 0.6rem 0.8rem 0.6rem 2.5rem;
        }
        
        .search-icon {
            left: 0.8rem;
        }
        
        .search-btn {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            min-width: 70px;
        }
    }

    /* Fix for potential text overlap issues */
    .search-input:focus {
        background: var(--bg-primary);
        color: var(--text-primary);
    }

    /* Ensure no text rendering issues */
    .search-container * {
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: optimizeLegibility;
    }
</style>
@endpush