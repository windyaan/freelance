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

        <div>
        <label for="title">Title</label>
        {{-- <input type="text" name="title" id="title" required> --}}
        <input type="text" name="title" id="title" class="form-control">
    </div>

        <!-- Category -->
        <div class="form-group">
            <label for="category_id" class="form-label">Category</label>
             {{-- <select name="category_id" id="category_id" required> --}}
            <select name="category_id" id="category_id" class="form-control form-select" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <div class="form-help">Pilih Salah Satu Category</div>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control form-textarea" placeholder="Deskripsikan Projectmu Disini" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Price -->
        <div class="form-group">
            <label for="starting_price" class="form-label">Price</label>
        <input
        type="number"
        name="starting_price"
        id="starting_price"
        class="form-control @error('starting_price') is-invalid @enderror"
        value="{{ old('starting_price') }}"
        placeholder="Masukkan harga, contoh: 500000"
        min="0"
        step="any"
        required
    >
    @error('starting_price')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
        </div>

        <!-- Status -->
        <div class="form-group">
            <label for="is_active" class="form-label">Status</label>
            <select name="is_active" id="is_active">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
        </div>

        <!-- Submit Button -->
        <a href="{{ route('freelancer.services') }}" class="back-btn">
        <button type="submit" class="submit-btn">
            Add Job
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
