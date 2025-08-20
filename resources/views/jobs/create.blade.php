@extends('layouts.freelancer')

@section('title', 'Add Service - SkillMatch')
@section('page-title', 'Add Service')

@push('styles')
<style>
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

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    background: white;
}

.form-control:focus {
    outline: none;
    border-color: #38C1B9;
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
}

.form-select {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.9rem;
    background: white;
    cursor: pointer;
    transition: all 0.2s ease;
}

.form-select:focus {
    outline: none;
    border-color: #38C1B9;
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
}

.form-textarea {
    min-height: 120px;
    resize: vertical;
}

.submit-btn {
    width: 100%;
    background: #374151;
    color: white;
    border: none;
    padding: 1rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 1rem;
}

.submit-btn:hover {
    background: #1f2937;
    transform: translateY(-1px);
}

.close-btn {
    position: absolute;
    top: 1.5rem;
    right: 1.5rem;
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #6b7280;
    cursor: pointer;
    padding: 0.5rem;
    transition: all 0.2s ease;
}

.close-btn:hover {
    color: #374151;
}

.error-message {
    color: #dc2626;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

@media (max-width: 768px) {
    .card {
        margin: 0;
        border-radius: 12px;
    }
}
</style>
@endpush

@section('content')
<!-- Back Button -->
<a href="{{ route('freelancer.services') }}" class="back-btn">
    <iconify-icon icon="material-symbols:arrow-back"></iconify-icon>
    Back
</a>

<!-- Add Service Form -->
<div class="card" style="position: relative;">
    <a href="{{ route('freelancer.services') }}" class="close-btn">
        <iconify-icon icon="material-symbols:close"></iconify-icon>
    </a>
    
    <div class="card-header">
        <h2 class="card-title">Add Services</h2>
    </div>

    <form action="{{ route('freelancer.services.store') }}" method="POST">
        @csrf
        
        <!-- Category -->
        <div class="form-group">
            <label for="category" class="form-label">Category</label>
            <select name="category" id="category" class="form-control form-select" required>
                <option value="">Select Category</option>
                <option value="web-development" {{ old('category') == 'web-development' ? 'selected' : '' }}>Web Development</option>
                <option value="mobile-development" {{ old('category') == 'mobile-development' ? 'selected' : '' }}>Mobile Development</option>
                <option value="ui-ux-design" {{ old('category') == 'ui-ux-design' ? 'selected' : '' }}>UI/UX Design</option>
                <option value="graphic-design" {{ old('category') == 'graphic-design' ? 'selected' : '' }}>Graphic Design</option>
                <option value="illustrator" {{ old('category') == 'illustrator' ? 'selected' : '' }}>Illustrator</option>
                <option value="content-writing" {{ old('category') == 'content-writing' ? 'selected' : '' }}>Content Writing</option>
                <option value="digital-marketing" {{ old('category') == 'digital-marketing' ? 'selected' : '' }}>Digital Marketing</option>
                <option value="video-editing" {{ old('category') == 'video-editing' ? 'selected' : '' }}>Video Editing</option>
                <option value="photography" {{ old('category') == 'photography' ? 'selected' : '' }}>Photography</option>
                <option value="data-analysis" {{ old('category') == 'data-analysis' ? 'selected' : '' }}>Data Analysis</option>
                <option value="translation" {{ old('category') == 'translation' ? 'selected' : '' }}>Translation</option>
                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('category')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control form-textarea" placeholder="Describe your service and include project examples" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Price -->
        <div class="form-group">
            <label for="starting_price" class="form-label">Price</label>
            <input type="number" name="starting_price" id="starting_price" class="form-control" value="{{ old('starting_price') }}" placeholder="700.000-900.000" min="0" step="1000" required>
            @error('starting_price')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Status -->
        <div class="form-group">
            <label for="is_active" class="form-label">Status</label>
            <select name="is_active" id="is_active" class="form-control form-select" required>
                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Available</option>
                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Unavailable</option>
            </select>
            @error('is_active')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">
            Add
        </button>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Add service page initialized');
    
    // Auto-format price input
    const priceInput = document.getElementById('starting_price');
    if (priceInput) {
        priceInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value) {
                // Format with dots as thousand separators
                value = parseInt(value).toLocaleString('id-ID');
                e.target.value = value.replace(/,/g, '.');
            }
        });
        
        // Remove formatting before form submission
        priceInput.closest('form').addEventListener('submit', function() {
            priceInput.value = priceInput.value.replace(/\./g, '');
        });
    }
    
    // Category change handler
    const categorySelect = document.getElementById('category');
    if (categorySelect) {
        categorySelect.addEventListener('change', function(e) {
            console.log('Category selected:', e.target.value);
        });
    }
});
</script>
@endpush