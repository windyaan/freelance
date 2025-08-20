@extends('layouts.freelancer')

@section('title', 'Edit Service - SkillMatch')
@section('page-title', 'Edit Service')

@section('content')
<style>
/* Edit Services Section */
.edit-services-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    width: 100%;
    max-width: 800px;
    overflow: hidden;
    position: relative;
}

.edit-services-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f5f9;
}

.edit-services-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
}

.close-btn {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #64748b;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0.5rem;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.close-btn:hover {
    background: #f1f5f9;
    color: #1e293b;
}

/* Form Styles */
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
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    background: white;
    color: #1f2937;
}

.form-control:focus {
    outline: none;
    border-color: #38C1B9;
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
}

.form-textarea {
    min-height: 120px;
    resize: vertical;
    font-family: inherit;
}

.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
    appearance: none;
    cursor: pointer;
}

.form-select option {
    padding: 0.5rem;
}

/* Save Button */
.save-btn {
    background: #4f46e5;
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.save-btn:hover {
    background: #4338ca;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
}

.save-btn:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
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

/* Alert Messages */
.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.alert-success {
    background: #dcfce7;
    border: 1px solid #bbf7d0;
    color: #166534;
}

.alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #dc2626;
}

.alert-validation {
    background: #fef3c7;
    border: 1px solid #fde68a;
    color: #92400e;
}

.alert ul {
    margin: 0;
    padding-left: 1.25rem;
}

.alert li {
    margin-bottom: 0.25rem;
}

/* Form Help Text */
.form-help {
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

/* Required Field Indicator */
.required {
    color: #ef4444;
}

/* Responsive Design */
@media (max-width: 768px) {
    .edit-services-section {
        padding: 1.5rem;
        max-width: 100%;
        margin: 0;
        width: 100%;
    }

    .edit-services-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .close-btn {
        align-self: flex-end;
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
    }
}

@media (max-width: 640px) {
    .edit-services-section {
        padding: 1rem;
        border-radius: 0;
        margin: 0;
    }
}

/* Loading State */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading .save-btn {
    background: #9ca3af;
    cursor: not-allowed;
}
</style>

<!-- Back Button -->
<a href="{{ route('freelancer.services.index') }}" class="back-btn">
    <iconify-icon icon="material-symbols:arrow-back"></iconify-icon>
    Back to Services
</a>

<!-- Edit Services Section -->
<div class="edit-services-section">
    <div class="edit-services-header">
        <h2 class="edit-services-title">Edit Service</h2>
        <a href="{{ route('freelancer.services.index') }}" class="close-btn">
            <iconify-icon icon="material-symbols:close"></iconify-icon>
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-validation">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Form -->
    <form action="{{ route('freelancer.services.update', $job->id) }}" method="POST" id="editServiceForm">
        @csrf
        @method('PUT')
        
        <!-- Category -->
        <div class="form-group">
            <label for="category" class="form-label">Category <span class="required">*</span></label>
            <select name="category" id="category" class="form-control form-select" required>
                <option value="">Select Category</option>
                <option value="Web Development" {{ old('category', $job->category) == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                <option value="Mobile Development" {{ old('category', $job->category) == 'Mobile Development' ? 'selected' : '' }}>Mobile Development</option>
                <option value="UI/UX Design" {{ old('category', $job->category) == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design</option>
                <option value="Graphic Design" {{ old('category', $job->category) == 'Graphic Design' ? 'selected' : '' }}>Graphic Design</option>
                <option value="Illustration" {{ old('category', $job->category) == 'Illustration' ? 'selected' : '' }}>Illustration</option>
                <option value="Content Writing" {{ old('category', $job->category) == 'Content Writing' ? 'selected' : '' }}>Content Writing</option>
                <option value="Digital Marketing" {{ old('category', $job->category) == 'Digital Marketing' ? 'selected' : '' }}>Digital Marketing</option>
                <option value="Video Editing" {{ old('category', $job->category) == 'Video Editing' ? 'selected' : '' }}>Video Editing</option>
                <option value="Photography" {{ old('category', $job->category) == 'Photography' ? 'selected' : '' }}>Photography</option>
                <option value="Data Entry" {{ old('category', $job->category) == 'Data Entry' ? 'selected' : '' }}>Data Entry</option>
                <option value="Virtual Assistant" {{ old('category', $job->category) == 'Virtual Assistant' ? 'selected' : '' }}>Virtual Assistant</option>
                <option value="Translation" {{ old('category', $job->category) == 'Translation' ? 'selected' : '' }}>Translation</option>
                <option value="Other" {{ old('category', $job->category) == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            <div class="form-help">Choose the category that best describes your service</div>
        </div>

        <!-- Title -->
        <div class="form-group">
            <label for="title" class="form-label">Service Title <span class="required">*</span></label>
            <input type="text" name="title" id="title" class="form-control" 
                   value="{{ old('title', $job->title) }}" 
                   placeholder="Enter service title" 
                   required maxlength="100">
            <div class="form-help">A clear and descriptive title for your service</div>
        </div>

        <!-- Description -->
        <div class="form-group">
            <label for="description" class="form-label">Description <span class="required">*</span></label>
            <textarea name="description" id="description" class="form-control form-textarea" 
                      placeholder="Describe your service in detail..." 
                      required maxlength="1000">{{ old('description', $job->description) }}</textarea>
            <div class="form-help">Provide a detailed description of what you offer</div>
        </div>

        <!-- Project Link -->
        <div class="form-group">
            <label for="project_link" class="form-label">Example Project Link</label>
            <input type="url" name="project_link" id="project_link" class="form-control" 
                   value="{{ old('project_link', $job->project_link) }}" 
                   placeholder="https://example.com/your-project">
            <div class="form-help">Optional: Link to showcase your work or portfolio</div>
        </div>

        <!-- Price -->
        <div class="form-group">
            <label for="starting_price" class="form-label">Starting Price (Rp) <span class="required">*</span></label>
            <input type="number" name="starting_price" id="starting_price" class="form-control" 
                   value="{{ old('starting_price', $job->starting_price) }}" 
                   placeholder="500000" 
                   required min="50000" max="100000000" step="1000">
            <div class="form-help">Minimum price starts from Rp 50,000</div>
        </div>

        <!-- Status -->
        <div class="form-group">
            <label for="is_active" class="form-label">Status <span class="required">*</span></label>
            <select name="is_active" id="is_active" class="form-control form-select" required>
                <option value="1" {{ old('is_active', $job->is_active) == 1 ? 'selected' : '' }}>Available</option>
                <option value="0" {{ old('is_active', $job->is_active) == 0 ? 'selected' : '' }}>Unavailable</option>
            </select>
            <div class="form-help">Set whether this service is currently available for booking</div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="save-btn" id="saveBtn">
            <iconify-icon icon="material-symbols:save"></iconify-icon>
            Save Changes
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editServiceForm');
    const saveBtn = document.getElementById('saveBtn');
    const section = document.querySelector('.edit-services-section');

    // Form submission handler
    form.addEventListener('submit', function(e) {
        // Show loading state
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<iconify-icon icon="material-symbols:hourglass-empty"></iconify-icon> Saving...';
        section.classList.add('loading');
    });

    // Price formatter
    const priceInput = document.getElementById('starting_price');
    priceInput.addEventListener('input', function() {
        // Remove non-numeric characters except for the decimal point
        let value = this.value.replace(/[^0-9]/g, '');
        
        // Ensure minimum value
        if (value && parseInt(value) < 50000) {
            this.setCustomValidity('Minimum price is Rp 50,000');
        } else {
            this.setCustomValidity('');
        }
    });

    // Character counter for title and description
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');

    function addCharacterCounter(element, maxLength) {
        const counter = document.createElement('div');
        counter.className = 'form-help';
        counter.style.textAlign = 'right';
        counter.style.marginTop = '0.25rem';
        
        function updateCounter() {
            const remaining = maxLength - element.value.length;
            counter.textContent = `${element.value.length}/${maxLength} characters`;
            counter.style.color = remaining < 10 ? '#ef4444' : '#6b7280';
        }
        
        updateCounter();
        element.addEventListener('input', updateCounter);
        element.parentNode.appendChild(counter);
    }

    addCharacterCounter(titleInput, 100);
    addCharacterCounter(descriptionInput, 1000);

    // Validate URLs
    const projectLinkInput = document.getElementById('project_link');
    projectLinkInput.addEventListener('blur', function() {
        if (this.value && !this.value.startsWith('http')) {
            this.setCustomValidity('Please enter a valid URL starting with http:// or https://');
        } else {
            this.setCustomValidity('');
        }
    });

    // Auto-save draft (optional feature)
    let draftTimer;
    function saveDraft() {
        const formData = new FormData(form);
        const draftData = {};
        for (let [key, value] of formData.entries()) {
            draftData[key] = value;
        }
        localStorage.setItem('service_edit_draft_{{ $job->id }}', JSON.stringify(draftData));
    }

    // Save draft every 30 seconds
    form.addEventListener('input', function() {
        clearTimeout(draftTimer);
        draftTimer = setTimeout(saveDraft, 30000);
    });

    // Load draft if exists
    const savedDraft = localStorage.getItem('service_edit_draft_{{ $job->id }}');
    if (savedDraft) {
        try {
            const draftData = JSON.parse(savedDraft);
            for (let [key, value] of Object.entries(draftData)) {
                const element = form.elements[key];
                if (element && !element.value) {
                    element.value = value;
                }
            }
        } catch (e) {
            console.log('Could not load draft:', e);
        }
    }

    // Clear draft on successful submission
    form.addEventListener('submit', function() {
        localStorage.removeItem('service_edit_draft_{{ $job->id }}');
    });

    console.log('Edit service page initialized');
});
</script>

@endsection