@extends('layouts.client')

{{-- @if (auth()->user()->role === 'freelancer')
    @extends('layouts.freelance')
@else
    @extends('layouts.client')
@endif --}}

@section('title', 'Profile - SkillMatch')

@section('content')
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    background-color: #f8fafc;
    color: #334155;
}

/* Top Navigation */
.top-navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 80px;
    background: white;
    display: flex;
    align-items: center;
    padding: 0 2rem;
    z-index: 1001;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

.navbar-left {
    display: flex;
    align-items: center;
    gap: 2rem;
    flex: 1;
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.8rem;
    font-weight: 700;
    color: #38C1B9;
    text-decoration: none;
}

.navbar-brand span {
    color: #1e293b;
}

.page-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1e293b;
}

.navbar-right {
    display: flex;
    align-items: center;
}

.logout-btn {
    background: #ef4444;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.logout-btn:hover {
    background: #dc2626;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    color: white;
    text-decoration: none;
}

/* Sidebar */
.sidebar {
    position: fixed;
    left: 0;
    top: 80px;
    width: 280px;
    height: calc(100vh - 80px);
    background: #ffffff;
    z-index: 1000;
    padding: 2rem 0;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.08);
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 1rem 2rem;
    color: #64748b;
    text-decoration: none;
    cursor: pointer;
    margin: 0 1rem 0.5rem 1rem;
    border-radius: 12px;
    transition: all 0.2s ease;
    font-weight: 500;
}

.nav-item:hover {
    background: #f1f5f9;
    color: #1e293b;
    text-decoration: none;
}

.nav-item.active {
    background: #475569;
    color: white;
}

.nav-icon {
    width: 24px;
    height: 24px;
    margin-right: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    background: rgba(100, 116, 139, 0.1);
    border-radius: 8px;
    color: #64748b;
}

.nav-item.active .nav-icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.nav-text {
    flex: 1;
    font-size: 0.95rem;
}

/* Main Content */
.main-content {
    margin-left: 280px;
    margin-top: 80px;
    min-height: calc(100vh - 80px);
    padding: 2.5rem;
    background: #f8fafc;
}

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    text-decoration: none;
    font-weight: 500;
    margin-bottom: 2rem;
    padding: 0.5rem 0;
    transition: color 0.2s ease;
}

.back-button:hover {
    color: #38C1B9;
    text-decoration: none;
}

/* Profile Container */
.profile-container {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2.5rem;
    align-items: start;
}

/* Profile Info Card */
.profile-info {
    background: white;
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #f1f5f9;
}

.profile-name {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.profile-email {
    color: #64748b;
    font-size: 0.9rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 2.5rem;
}

.profile-bio {
    color: #475569;
    line-height: 1.7;
    font-size: 1rem;
    margin-bottom: 3rem;
}

.profile-skills {
    color: #475569;
    line-height: 1.7;
    font-size: 1rem;
    margin-bottom: 3rem;
}

.profile-skills strong {
    color: #1e293b;
    font-weight: 600;
}

.edit-profile-btn {
    background: #475569;
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
    background: #334155;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(71, 85, 105, 0.3);
}

/* Profile Image Card */
.profile-image-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #f1f5f9;
    position: sticky;
    top: 100px;
}

.profile-image {
    width: 100%;
    height: 400px;
    border-radius: 16px;
    object-fit: cover;
    background: #f3f4f6;
    display: block;
}

/* Success Message */
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

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.modal-content {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    width: 90%;
    max-width: 550px;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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
    color: #1e293b;
}

.modal-close {
    background: #f1f5f9;
    border: none;
    font-size: 1.5rem;
    color: #64748b;
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
    background: #e2e8f0;
    color: #1e293b;
    transform: scale(1.1);
}

/* Form Styles */
.form-group {
    margin-bottom: 2rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.form-input {
    width: 100%;
    padding: 1rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    background: #fafbfc;
}

.form-input:focus {
    outline: none;
    border-color: #38C1B9;
    background: white;
    box-shadow: 0 0 0 4px rgba(56, 193, 185, 0.1);
}

.form-textarea {
    min-height: 140px;
    resize: vertical;
    font-family: inherit;
}

/* File Upload */
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
    background: #f8fafc;
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    cursor: pointer;
    font-size: 0.9rem;
    color: #64748b;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
}

.file-upload-button:hover {
    background: #f1f5f9;
    border-color: #38C1B9;
    color: #38C1B9;
}

.file-name {
    color: #64748b;
    font-size: 0.9rem;
    flex: 1;
    font-weight: 500;
}

/* Modal Buttons */
.modal-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2.5rem;
}

.btn-cancel {
    flex: 1;
    background: #f8fafc;
    color: #64748b;
    border: 2px solid #e2e8f0;
    padding: 1rem;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    font-size: 0.95rem;
}

.btn-cancel:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
    color: #475569;
}

.btn-save {
    flex: 1;
    background: #475569;
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
    background: #334155;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(71, 85, 105, 0.3);
}

/* Error Messages */
.error-message {
    color: #dc2626;
    font-size: 0.85rem;
    margin-top: 0.5rem;
    font-weight: 500;
}

/* Responsive Design */
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

@media (max-width: 1024px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    .main-content {
        margin-left: 0;
        padding: 2rem;
    }
}

@media (max-width: 768px) {
    .top-navbar {
        padding: 0 1rem;
    }

    .navbar-brand {
        font-size: 1.5rem;
    }

    .page-title {
        font-size: 1.25rem;
    }

    .main-content {
        padding: 1.5rem;
    }

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
</style>

<!-- Top Navigation -->
<div class="top-navbar">
    <div class="navbar-left">
        <a href="{{ route('client.dashboard') }}" class="navbar-brand">
            skill<span>Match</span>
        </a>
        <h1 class="page-title">Profile</h1>
    </div>
       <!-- Logout Form - Using Laravel's proper logout method -->
        <form method="POST" action="{{ route('logout') }}" class="navbar-logout-form">
            @csrf
            <button type="submit" class="navbar-logout" onclick="return confirmLogout()">
                <span>🚪</span>
                Log Out
            </button>
        </form>
    </div>
</div>

<!-- Sidebar -->
<div class="sidebar">
    <nav>
        <a href="{{ route('client.dashboard') }}" class="nav-item active">
            <div class="nav-icon">📊</div>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon">💬</div>
            <span class="nav-text">Chat</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon">📋</div>
            <span class="nav-text">Orders</span>
        </a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    @php
        $dashboardRoute = match(auth()->user()->role) {
            'client' => route('client.dashboard'),
            'freelancer' => route('freelancer.dashboard'),
            'admin' => route('admin.dashboard'),
            // default => route('landing'),
        };
    @endphp

    <!-- Back Button -->
    <a href="{{ $dashboardRoute }}" class="back-btn">
        <span>←</span>
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
            <h1 class="profile-name">{{ $user->name ?? 'Ifa Maria' }}</h1>

            <div class="profile-email">
                EMAIL : {{ $user->email ?? 'ifamaria@gmail.com' }}
            </div>

            <div class="profile-bio">
                {{ $user->bio ?? 'I am a publishing professional at Gramedia Pustaka, responsible for managing the editing and design process throughout book production. With experience in ensuring visual and content quality, I focus on detail, aesthetics, and design consistency to create engaging and professional publications. My expertise includes coordinating with editorial teams, designers, and printers to deliver works that meet the highest publishing standards.' }}
            </div>

            @if ($user->role === 'freelancer' && $user->skills)
            <div class="profile-skills">
                <strong>Skills:</strong> {{ $user->skills }}
            </div>
            @endif

            <button class="edit-profile-btn" onclick="openEditModal()">
                Edit
            </button>
        </div>

        <!-- Profile Image -->
        <div class="profile-image-card">
            <img src="{{ $user->avatar_url ?? 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=350&h=400&fit=crop&crop=face' }}"
                 alt="Profile Picture"
                 class="profile-image"
                 onerror="this.onerror=null; this.src='https://placehold.co/350x400/f3f4f6/9ca3af?text=Profile'">
        </div>
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
                    <input type="file" id="profilePictureInput" name="avatar_url" class="file-upload-input" accept="image/*" onchange="handleFileSelect(this)">
                    <label for="profilePictureInput" class="file-upload-button">
                        📁 Choose File
                    </label>
                    <span class="file-name" id="fileName">{{ $user->avatar_url ? basename($user->avatar_url) : 'No file selected' }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-input" name="name" value="{{ old('name', $user->name ?? 'Ifa Maria') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-input" name="email" value="{{ old('email', $user->email ?? 'ifamaria@gmail.com') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Bio</label>
                <textarea class="form-input form-textarea" name="bio" rows="6" placeholder="Tell us about yourself...">{{ old('bio', $user->bio ?? 'I am a publishing professional at Gramedia Pustaka, responsible for managing the editing and design process throughout book production. With experience in ensuring visual and content quality, I focus on detail, aesthetics, and design consistency to create engaging and professional publications. My expertise includes coordinating with editorial teams, designers, and printers to deliver works that meet the highest publishing standards.') }}</textarea>
                @error('bio')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            @if ($user->role === 'freelancer')
            <div class="form-group">
                <label class="form-label">Skills</label>
                @php
                $skills = old('skills', explode(',', $user->skills ?? ''));
                @endphp

                @foreach ($skills as $index => $skill)
                <input type="text" name="skills" class="form-input" value="{{ trim($skill) }}" placeholder="Skill {{ $index + 1 }}" style="margin-bottom: 0.75rem;">
                @endforeach

                <input type="text" name="skills" class="form-input" placeholder="Add new skill...">

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

<script>
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

function confirmLogout() {
    return confirm('Are you sure you want to log out?');
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
@endsection
