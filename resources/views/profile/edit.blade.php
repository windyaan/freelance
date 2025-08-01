@extends('layouts.client')

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

.top-navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 70px;
    background: white;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    padding: 0 2rem;
    z-index: 1001;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.navbar-left {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.5rem;
    font-weight: 700;
    color: #38C1B9;
    text-decoration: none;
}

.navbar-title {
    margin-left: 2rem;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
}

.navbar-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.navbar-logout {
    background: #ef4444;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.navbar-logout:hover {
    background: #dc2626;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    color: white;
    text-decoration: none;
}

.sidebar {
    position: fixed;
    left: 0;
    top: 70px;
    width: 240px;
    height: calc(100vh - 70px);
    background: #ffffff;
    border-right: 1px solid #e2e8f0;
    z-index: 1000;
    padding: 1.5rem 0;
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    color: #64748b;
    text-decoration: none;
    cursor: pointer;
    margin-bottom: 0.5rem;
    transition: all 0.2s ease;
}

.nav-item:hover {
    background: #f8fafc;
    color: #1e293b;
}

.nav-item.active {
    background: #475569;
    color: white;
    border-radius: 12px;
    margin: 0 1rem 0.5rem 1rem;
}

.nav-icon {
    width: 32px;
    height: 32px;
    margin-right: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    background: #f1f5f9;
    border-radius: 8px;
    color: #64748b;
}

.nav-item.active .nav-icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.nav-text {
    flex: 1;
    font-weight: 500;
    font-size: 0.95rem;
}

.main-content {
    margin-left: 240px;
    margin-top: 70px;
    min-height: calc(100vh - 70px);
    padding: 2rem;
    background: #f8fafc;
}

.back-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    text-decoration: none;
    font-weight: 500;
    margin-bottom: 2rem;
    transition: color 0.2s ease;
}

.back-btn:hover {
    color: #38C1B9;
}

.profile-container {
    background: white;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    overflow: hidden;
}

.profile-header {
    display: flex;
    gap: 2rem;
    padding: 2rem;
    align-items: flex-start;
}

.profile-info {
    flex: 1;
}

.profile-name {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.profile-email {
    color: #64748b;
    font-size: 0.9rem;
    margin-bottom: 2rem;
}

.profile-bio {
    color: #4b5563;
    line-height: 1.6;
    margin-bottom: 2rem;
}

.edit-btn {
    background: #475569;
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-block;
    text-align: center;
}

.edit-btn:hover {
    background: #334155;
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

.profile-avatar {
    flex-shrink: 0;
}

.avatar-img {
    width: 200px;
    height: 200px;
    border-radius: 16px;
    object-fit: cover;
    border: 1px solid #e2e8f0;
}

.profile-form {
    padding: 2rem;
    border-top: 1px solid #f1f5f9;
    display: none;
}

.profile-form.active {
    display: block;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: border-color 0.2s ease;
}

.form-input:focus {
    outline: none;
    border-color: #38C1B9;
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
}

.form-textarea {
    height: 120px;
    resize: vertical;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
}

.btn-primary {
    background: #38C1B9;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    background: #2da89f;
    transform: translateY(-1px);
}

.btn-secondary {
    background: #f1f5f9;
    color: #64748b;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.btn-secondary:hover {
    background: #e2e8f0;
}

.success-message {
    background: #d1fae5;
    color: #065f46;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    border: 1px solid #a7f3d0;
}

.logo h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #38C1B9;
}

.logo span {
    color: #1e293b;
}

/* Mobile Responsiveness */
@media (max-width: 1024px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .profile-header {
        flex-direction: column;
        text-align: center;
    }
    
    .avatar-img {
        width: 150px;
        height: 150px;
    }
}

@media (max-width: 768px) {
    .main-content {
        padding: 1rem;
    }
    
    .profile-container {
        border-radius: 12px;
    }
    
    .profile-header {
        padding: 1.5rem;
    }
    
    .profile-form {
        padding: 1.5rem;
    }
    
    .profile-name {
        font-size: 1.5rem;
    }
    
    .avatar-img {
        width: 120px;
        height: 120px;
    }
}
</style>

<!-- Top Navigation -->
<div class="top-navbar">
    <div class="navbar-left">
        <a href="{{ route('client.dashboard') }}" class="navbar-brand">
            <div class="logo">
                <h1>skill<span>Match</span></h1>
            </div>
        </a>
        <h1 class="navbar-title">Profile</h1>
    </div>
    <div class="navbar-right">
        <!-- Logout Button -->
        <a href="{{ route('landing') }}" class="navbar-logout" onclick="return confirmLogout()">
            <span>🚪</span>
            Log Out
        </a>
    </div>
</div>

<!-- Sidebar -->
<div class="sidebar">
    <nav>
        <a href="{{ route('client.dashboard') }}" class="nav-item">
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
    <!-- Back Button -->
    <a href="{{ route('client.dashboard') }}" class="back-btn">
        <span>←</span>
        Back
    </a>

    @if (session('status') === 'profile-updated')
        <div class="success-message">
            Profile updated successfully!
        </div>
    @endif

    <!-- Profile Container -->
    <div class="profile-container">
        <!-- Profile Display -->
        <div class="profile-header" id="profileDisplay">
            <div class="profile-info">
                <h1 class="profile-name">{{ $user->name ?? 'Ifa Maria' }}</h1>
                <p class="profile-email">EMAIL : {{ $user->email ?? 'ifamaria@gmail.com' }}</p>
                <p class="profile-bio">
                    {{ $user->bio ?? 'I am a publishing professional at Gramedia Pustaka, responsible for managing the editing and design process throughout book production. With experience in ensuring visual and content quality, I focus on detail, aesthetics, and design consistency to create engaging and professional publications. My expertise includes coordinating with editorial teams, designers, and printers to deliver works that meet the highest publishing standards.' }}
                </p>
                <button class="edit-btn" onclick="toggleEditMode()">Edit</button>
            </div>
            <div class="profile-avatar">
                <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=200&h=200&fit=crop&crop=face" alt="Profile" class="avatar-img">
            </div>
        </div>

        <!-- Profile Edit Form -->
        <form class="profile-form" id="profileForm" method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')
            
            <div class="form-group">
                <label class="form-label" for="name">Name</label>
                <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $user->name ?? 'Ifa Maria') }}" required>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="email">Email</label>  
                <input type="email" id="email" name="email" class="form-input" value="{{ old('email', $user->email ?? 'ifamaria@gmail.com') }}" required>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="bio">Bio</label>
                <textarea id="bio" name="bio" class="form-input form-textarea" placeholder="Tell us about yourself...">{{ old('bio', $user->bio ?? 'I am a publishing professional at Gramedia Pustaka, responsible for managing the editing and design process throughout book production. With experience in ensuring visual and content quality, I focus on detail, aesthetics, and design consistency to create engaging and professional publications. My expertise includes coordinating with editorial teams, designers, and printers to deliver works that meet the highest publishing standards.') }}</textarea>
                @error('bio')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="button" class="btn-secondary" onclick="toggleEditMode()">Cancel</button>
                <button type="submit" class="btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleEditMode() {
    const profileDisplay = document.getElementById('profileDisplay');
    const profileForm = document.getElementById('profileForm');
    
    if (profileForm.classList.contains('active')) {
        // Switch to view mode
        profileForm.classList.remove('active');
        profileDisplay.style.display = 'flex';
    } else {
        // Switch to edit mode
        profileForm.classList.add('active');
        profileDisplay.style.display = 'none';
    }
}

function confirmLogout() {
    return confirm('Are you sure you want to log out?');
}

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