@extends('layouts.app')

@section('page-title', 'Profile')

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
    <a href="{{ route('client.order') }}" class="nav-item {{ request()->routeIs('client.order*') ? 'active' : '' }}">
        <div class="nav-icon">
            <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
        </div>
        <span class="nav-text">Orders</span>
    </a>
@endsection

@push('styles')
<style>
/* Profile-specific styles only */
.back-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-secondary);
    text-decoration: none;
    font-weight: 500;
    margin-bottom: 2rem;
    cursor: pointer;
    transition: color 0.2s ease;
}

.back-button:hover {
    color: var(--primary-color);
    text-decoration: none;
}

.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2.5rem;
    align-items: start;
}

.profile-info {
    background: var(--bg-primary);
    border-radius: 20px;
    padding: 3rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
}

.profile-name {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.profile-email {
    color: var(--text-secondary);
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 2.5rem;
}

.profile-bio {
    color: var(--text-secondary);
    line-height: 1.7;
    font-size: 1rem;
    margin-bottom: 3rem;
}

.profile-skills {
    color: var(--text-secondary);
    line-height: 1.7;
    font-size: 1rem;
    margin-bottom: 3rem;
}

.profile-skills strong {
    color: var(--text-primary);
    font-weight: 600;
}

.edit-profile-btn {
    background: var(--secondary-color);
    color: white;
    border: none;
    padding: 1rem 2.5rem;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.2s ease;
    width: 100%;
}

.edit-profile-btn:hover {
    background: var(--secondary-hover);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(71, 85, 105, 0.3);
}

.profile-image-card {
    background: var(--bg-primary);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
    position: sticky;
    top: 100px;
}

.profile-image {
    width: 100%;
    height: 400px;
    border-radius: 16px;
    object-fit: cover;
    background: var(--bg-muted);
    display: block;
}

.success-message {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #065f46;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    border: 1px solid #86efac;
    font-weight: 500;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.15);
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    backdrop-filter: blur(8px);
}

.modal-overlay.show {
    display: flex;
    animation: fadeIn 0.3s ease;
}

.modal-content {
    background: var(--bg-primary);
    border-radius: 20px;
    padding: 2.5rem;
    width: 90%;
    max-width: 550px;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    box-shadow: var(--shadow-lg);
    animation: slideUp 0.3s ease;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2.5rem;
}

.modal-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-primary);
}

.modal-close {
    background: var(--bg-muted);
    border: none;
    font-size: 1.5rem;
    color: var(--text-secondary);
    cursor: pointer;
    padding: 0.5rem;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: var(--border-color);
    color: var(--text-primary);
    transform: scale(1.1);
}

.form-group {
    margin-bottom: 2rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.form-input {
    width: 100%;
    padding: 1rem;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    background: var(--bg-secondary);
    color: var(--text-primary);
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    background: var(--bg-primary);
    box-shadow: 0 0 0 4px rgba(56, 193, 185, 0.1);
}

.form-textarea {
    min-height: 140px;
    resize: vertical;
    font-family: inherit;
}

.file-upload-container {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.file-upload-input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.file-upload-button {
    background: var(--bg-secondary);
    border: 2px dashed var(--border-color);
    border-radius: 12px;
    padding: 1rem 1.5rem;
    cursor: pointer;
    font-size: 0.9rem;
    color: var(--text-secondary);
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
}

.file-upload-button:hover {
    background: var(--bg-muted);
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.file-name {
    color: var(--text-secondary);
    font-size: 0.9rem;
    flex: 1;
    font-weight: 500;
}

.modal-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2.5rem;
}

.btn-cancel {
    flex: 1;
    background: var(--bg-secondary);
    color: var(--text-secondary);
    border: 2px solid var(--border-color);
    padding: 1rem;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.95rem;
}

.btn-cancel:hover {
    background: var(--bg-muted);
    border-color: var(--text-muted);
    color: var(--secondary-color);
}

.btn-save {
    flex: 1;
    background: var(--secondary-color);
    color: white;
    border: none;
    padding: 1rem;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.95rem;
}

.btn-save:hover {
    background: var(--secondary-hover);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(71, 85, 105, 0.3);
}

.error-message {
    color: var(--danger-color);
    font-size: 0.85rem;
    margin-top: 0.5rem;
    font-weight: 500;
}

/* Mobile Responsiveness */
@media (max-width: 1200px) {
    .profile-container {
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .profile-image-card {
        order: -1;
        position: static;
    }

    .profile-image {
        height: 300px;
    }
}

@media (max-width: 768px) {
    .profile-info {
        padding: 2rem;
    }

    .profile-name {
        font-size: 2rem;
    }

    .modal-content {
        padding: 2rem;
        width: 95%;
    }

    .modal-title {
        font-size: 1.5rem;
    }
}

@media (max-width: 640px) {
    .main-content {
        padding: 0.8rem;
    }
}
</style>
@endpush

@section('content')
    @php
        $dashboardRoute = match(auth()->user()->role) {
            'client' => route('client.dashboard'),
            'freelancer' => route('freelancer.dashboard'),
            'admin' => route('admin.dashboard'),
        };
    @endphp

    <!-- Back Button -->
    <a href="{{ $dashboardRoute }}" class="back-button">
        <iconify-icon icon="material-symbols:chevron-left"></iconify-icon>
        Back
    </a>

    <!-- Success Message -->
    @if (session('status') === 'profile-updated')
        <div class="success-message">
            ✅ Profile updated successfully!
        </div>
    @endif

    <!-- Profile Container -->
    <div class="profile-container">
        <!-- Profile Information -->
        <div class="profile-info">
            <h1 class="profile-name">{{ $user->name ?? 'User Name' }}</h1>

            <div class="profile-email">
                EMAIL : {{ $user->email ?? 'user@example.com' }}
            </div>

            <div class="profile-bio">
                {{ $user->profile->bio ?? 'No bio available.' }}
            </div>

            @if ($user->role === 'freelancer' && $user->profile->skills)
            <div class="profile-skills">
                <strong>Skills:</strong> {{ $user->profile->skills }}
            </div>
            @endif

            <button class="edit-profile-btn" onclick="openEditModal()">
                Edit
            </button>
        </div>

        <!-- Profile Image -->
        <div class="profile-image-card">
            <img src="{{ $user->profile->avatar_url ?? 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=350&h=400&fit=crop&crop=face' }}"
                 alt="Profile Picture"
                 class="profile-image"
                 onerror="this.onerror=null; this.src='https://placehold.co/350x400/f3f4f6/9ca3af?text=Profile'">
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal-overlay" id="editProfileModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Edit Profile</h2>
                <button class="modal-close" onclick="closeEditModal()">×</button>
            </div>

            <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="form-group">
                    <label class="form-label">Profile Picture</label>
                    <div class="file-upload-container">
                        {{-- <input type="file" id="profilePictureInput" name="avatar_url" class="file-upload-input" accept="image/*" onchange="handleFileSelect(this)"> --}}
                        <input type="text"
                   id="avatar_url"
                   name="avatar_url"
                   class="form-control"
                   placeholder="Masukkan URL gambar profil"
                   value="{{ $user->profile->avatar_url ?? '' }}">
                        {{-- <label for="profilePictureInput" class="file-upload-button">
                            📁 Choose File
                        </label>
                        <span class="file-name" id="fileName">{{ $user->avatar_url ? basename($user->avatar_url) : 'No file selected' }}</span> --}}
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-input" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-input" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Bio</label>
                    <textarea class="form-input form-textarea" name="bio" rows="6" placeholder="Tell us about yourself...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                    @error('bio')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                @if (auth()->user()->role === 'freelancer')
                <div class="form-group">
                    <label for="skills" class="form-label">Skills</label>
                    <input
                        type="text"
                        id="skills"
                        name="skills"
                        class="form-input @error('skills') border-red-500 @enderror"
                        value="{{ old('skills', $user->profile->skills ?? '') }}"
                        placeholder="Example: PHP, Laravel, JavaScript"
                        autocomplete="off">
                    <small style="color: var(--text-muted); font-size: 0.85rem;">Separate skills with commas (,)</small>
                    @error('skills')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                @endif

                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn-save">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Profile page initialized successfully');
});

// Modal Functions
function openEditModal() {
    const modal = document.getElementById('editProfileModal');
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
}

function closeEditModal() {
    const modal = document.getElementById('editProfileModal');
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
}

function handleFileSelect(input) {
    const file = input.files[0];
    if (file) {
        const fileNameElement = document.getElementById('fileName');
        if (fileNameElement) {
            fileNameElement.textContent = file.name;
        }

        // Preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            const profileImage = document.querySelector('.profile-image');
            if (profileImage) {
                profileImage.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
}

// Close modal when clicking outside
const editModal = document.getElementById('editProfileModal');
if (editModal) {
    editModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
}

// Escape key to close modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
    }
});

// Auto-hide success message after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.querySelector('.success-message');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.opacity = '0';
            setTimeout(() => {
                successMessage.remove();
            }, 300);
        }, 5000);
    }
});
</script>
@endpush
