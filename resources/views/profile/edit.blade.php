@extends('layouts.client')

@section('title', 'Profile - SkillMatch')

@section('content')
<style>
/* Prevent horizontal overflow globally */
html, body {
    overflow-x: hidden;
    max-width: 100vw;
}

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
    max-width: 100vw;
    overflow: hidden;
}

.navbar-left {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    min-width: 0;
}

.navbar-brand {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.5rem;
    font-weight: 700;
    color: #38C1B9;
    text-decoration: none;
    white-space: nowrap;
}

.navbar-title {
    margin-left: 2rem;
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    white-space: nowrap;
}

.navbar-center {
    flex: 2;
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: 600px;
    margin: 0 auto;
}

.search-container {
    position: relative;
    width: 100%;
    max-width: 450px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.search-container:focus-within {
    box-shadow: 0 4px 16px rgba(56, 193, 185, 0.15);
    border-color: #38C1B9;
}

.search-input-wrapper {
    display: flex;
    align-items: center;
    width: 100%;
}

.search-container input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: none;
    border-radius: 8px;
    font-size: 0.9rem;
    background: transparent;
    outline: none;
    color: #334155;
    flex: 1;
}

.search-container input::placeholder {
    color: #94a3b8;
    font-weight: 400;
}

.search-container .search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 1.1rem;
    z-index: 2;
    pointer-events: none;
}

.search-container .search-btn {
    background: #38C1B9;
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
}

.search-container .search-btn:hover {
    background: #2da89f;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(56, 193, 185, 0.3);
}

.search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border-radius: 8px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    border: 1px solid #e2e8f0;
    margin-top: 8px;
    max-height: 300px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
}

.search-results.show {
    display: block;
}

.search-result-item {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #f1f5f9;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.search-result-item:hover {
    background-color: #f8fafc;
}

.search-result-name {
    font-weight: 500;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.search-result-skills {
    font-size: 0.8rem;
    color: #64748b;
}

.navbar-right {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    justify-content: flex-end;
}

.navbar-logout-form {
    margin: 0;
    padding: 0;
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

.navbar-profile {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid #e2e8f0;
    transition: all 0.2s ease;
}

.navbar-profile:hover {
    border-color: #38C1B9;
}

.navbar-profile img {
    width: 100%;
    height: 100%;
    object-fit: cover;
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
    border-radius: 0;
}

.nav-item:hover {
    background: #f8fafc;
    color: #1e293b;
    text-decoration: none;
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

.nav-badge {
    background: #38C1B9;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
    margin-left: auto;
}

.main-content {
    margin-left: 240px;
    margin-top: 70px;
    min-height: calc(100vh - 70px);
    padding: 2rem;
    background: #f8fafc;
    max-width: calc(100vw - 240px);
    overflow-x: hidden;
    box-sizing: border-box;
}

/* Back Button */
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

@media (max-width: 1024px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }

    .sidebar.show {
        transform: translateX(0);
    }

    .sidebar-toggle {
        display: flex !important;
        flex-direction: column;
        cursor: pointer;
        width: 24px;
        height: 18px;
        justify-content: space-between;
        margin-right: 1rem;
    }

    .sidebar-toggle span {
        width: 100%;
        height: 2px;
        background: #64748b;
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    .main-content {
        margin-left: 0;
        max-width: 100vw;
        padding: 1.5rem;
    }

    .navbar-center {
        flex: 1.5;
        max-width: 350px;
    }

    .search-container {
        max-width: 320px;
    }
}

@media (max-width: 768px) {
    .navbar-title {
        display: none;
    }

    .navbar-center {
        flex: 2;
        max-width: 280px;
    }

    .search-container {
        max-width: 250px;
    }

    .search-container input {
        font-size: 0.85rem;
        padding: 0.6rem 0.8rem 0.6rem 2.5rem;
    }

    .search-container .search-btn {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
    }

    .main-content {
        padding: 1rem;
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

@media (max-width: 640px) {
    .navbar-brand span:last-child {
        display: none;
    }

    .navbar-center {
        display: none;
    }

    .main-content {
        padding: 0.8rem;
    }
}

.logo h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #38C1B9;
}

.logo span {
    color: #1e293b;
}
</style>

<!-- Load Iconify -->
<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

<!-- Top Navigation -->
<div class="top-navbar">
    <div class="navbar-left">
        <div class="sidebar-toggle" id="sidebarToggle" style="display: none;">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <a href="{{ route('client.dashboard') }}" class="navbar-brand">
            <div class="logo" style="margin-top: 60px;">
                <h1>Skill<span>Match</span></h1>
            </div>
        </a>
        <h1 class="navbar-title">Profile</h1>
    </div>
    <div class="navbar-center">
        <div class="search-container">
            <iconify-icon icon="material-symbols:search" class="search-icon"></iconify-icon>
            <input type="text" class="search-input" placeholder="Search talents, skills..." id="globalSearch">
            <button class="search-btn" id="searchBtn">Search</button>
            <div class="search-results" id="searchResults"></div>
        </div>
    </div>
    <div class="navbar-right">
        <div class="navbar-profile" onclick="goToProfile()">
            <img src="{{ $user->avatar_url ?? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face' }}" alt="Profile">
        </div>

        <form method="POST" action="{{ route('logout') }}" class="navbar-logout-form">
            @csrf
            <button type="submit" class="navbar-logout" onclick="return confirmLogout()">
                <iconify-icon icon="material-symbols:logout"></iconify-icon>
                Log Out
            </button>
        </form>
    </div>
</div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <nav>
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
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    @php
        $dashboardRoute = match(auth()->user()->role) {
            'client' => route('client.dashboard'),
            'freelancer' => route('freelancer.dashboard'),
            'admin' => route('admin.dashboard'),
        };
    @endphp

    <!-- Back Button -->
    <a href="{{ $dashboardRoute }}" class="back-button">
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
                {{ $user->profile->bio ?? '' }}
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
                <textarea class="form-input form-textarea" name="bio" rows="6" placeholder="Tell us about yourself...">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                @error('bio')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            @if (auth()->user()->role === 'freelancer')
            <div class="form-group">
                <label for="skills">Skills</label>
                <input
                    type="text"
                    id="skills"
                    name="skills"
                    class="form-input @error('skills') border-red-500 @enderror"
                    value="{{ old('skills', $user->profile->skills ?? '') }}"
                    placeholder="Contoh: PHP, Laravel, JavaScript"
                    autocomplete="off">
                <small class="text-gray-500">Pisahkan skill dengan koma (,)</small>
                @error('skills')
                <div class="error-message text-red-500 mt-1">{{ $message }}</div>
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
document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const searchInput = document.getElementById('globalSearch');
    const searchResults = document.getElementById('searchResults');

    // Sidebar functionality
    if (sidebarToggle && sidebar) {
        // Create overlay
        const sidebarOverlay = document.createElement('div');
        sidebarOverlay.style.cssText = `
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            backdrop-filter: blur(4px);
        `;
        document.body.appendChild(sidebarOverlay);

        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('show');
            sidebarOverlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
        });

        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.style.display = 'none';
        });
    }

    // Search functionality (basic implementation)
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length > 2) {
                // Show search results (this would typically connect to your search API)
                if (searchResults) {
                    searchResults.innerHTML = `
                        <div class="search-result-item">
                            <div class="search-result-name">Search for: "${query}"</div>
                            <div class="search-result-skills">Press Enter to search</div>
                        </div>
                    `;
                    searchResults.classList.add('show');
                }
            } else {
                if (searchResults) {
                    searchResults.classList.remove('show');
                }
            }
        });

        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = this.value.trim();
                if (query) {
                    // Redirect to dashboard with search query
                    window.location.href = `{{ route('client.dashboard') }}?search=${encodeURIComponent(query)}`;
                }
            }
        });
    }

    // Search button functionality
    const searchBtn = document.getElementById('searchBtn');
    if (searchBtn) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (searchInput) {
                const query = searchInput.value.trim();
                if (query) {
                    window.location.href = `{{ route('client.dashboard') }}?search=${encodeURIComponent(query)}`;
                }
            }
        });
    }

    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container')) {
            if (searchResults) {
                searchResults.classList.remove('show');
            }
        }
    });

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

function confirmLogout() {
    return confirm('Are you sure you want to log out?');
}

function goToProfile() {
    // Already on profile page, could open edit modal instead
    openEditModal();
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