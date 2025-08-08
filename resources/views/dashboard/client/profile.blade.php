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

.navbar-right {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    justify-content: flex-end;
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

.sidebar-toggle {
    display: none;
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

/* Back Button */
.back-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    text-decoration: none;
    font-weight: 500;
    margin-bottom: 2rem;
    cursor: pointer;
    transition: color 0.2s ease;
}

.back-button:hover {
    color: #38C1B9;
    text-decoration: none;
}

/* Profile Layout - FIXED */
.profile-container {
    display: flex;
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
    align-items: start;
}

.profile-left {
    flex: 1;
    min-width: 0;
}

.profile-right {
    width: 350px;
    flex-shrink: 0;
}

/* Profile Info Card */
.profile-info-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    margin-bottom: 1rem;
    width: 100%;
}

.profile-header {
    margin-bottom: 1.5rem;
}

.profile-name-large {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.profile-contact-info {
    margin-bottom: 2rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
    color: #64748b;
    font-size: 0.9rem;
}

.contact-item strong {
    color: #1e293b;
    min-width: 60px;
    font-weight: 600;
}

.profile-bio-section {
    color: #64748b;
    line-height: 1.6;
    font-size: 0.9rem;
    margin-bottom: 2rem;
}

.edit-profile-btn {
    background: #475569;
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: auto;
    max-width: 200px;
}

.edit-profile-btn:hover {
    background: #334155;
    transform: translateY(-1px);
}

/* Profile Picture Card - FIXED */
.profile-picture-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    text-align: center;
    position: sticky;
    top: 90px;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.profile-image {
    width: 280px;
    height: 350px;
    border-radius: 16px;
    object-fit: cover;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    display: block;
    background: #f3f4f6;
}

/* Fallback untuk gambar yang tidak load */
.profile-image[src=""], 
.profile-image:not([src]) {
    background: #f3f4f6 url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%239ca3af' d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E") center/60% no-repeat;
}

/* Edit Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    backdrop-filter: blur(4px);
}

.modal-overlay.show {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #64748b;
    cursor: pointer;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: #f1f5f9;
    color: #1e293b;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    background: white;
}

.form-input:focus {
    outline: none;
    border-color: #38C1B9;
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
}

.form-textarea {
    min-height: 120px;
    resize: vertical;
    font-family: inherit;
}

.file-upload-container {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.file-upload-input {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.file-upload-button {
    background: #f8fafc;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    cursor: pointer;
    font-size: 0.85rem;
    color: #64748b;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.file-upload-button:hover {
    background: #f1f5f9;
    border-color: #38C1B9;
}

.file-name {
    color: #64748b;
    font-size: 0.85rem;
    flex: 1;
}

.modal-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn-cancel {
    flex: 1;
    background: #f1f5f9;
    color: #64748b;
    border: 1px solid #d1d5db;
    padding: 0.75rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-cancel:hover {
    background: #e2e8f0;
    color: #475569;
}

.btn-save {
    flex: 1;
    background: #475569;
    color: white;
    border: none;
    padding: 0.75rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-save:hover {
    background: #334155;
    transform: translateY(-1px);
}

.logo h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #38C1B9;
}

.logo span {
    color: #1e293b;
}

/* Success/Error Messages */
.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    border: 1px solid;
}

.alert-success {
    background-color: #d1fae5;
    border-color: #a7f3d0;
    color: #065f46;
}

.alert-error {
    background-color: #fee2e2;
    border-color: #fecaca;
    color: #991b1b;
}

/* Mobile Responsiveness - IMPROVED */
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
    }
    
    .main-content {
        margin-left: 0;
        max-width: 100vw;
        padding: 1.5rem;
    }
    
    .profile-container {
        flex-direction: column;
        gap: 1rem;
    }
    
    .profile-right {
        width: 100%;
        order: -1;
        margin-bottom: 1rem;
    }
    
    .profile-picture-card {
        position: static;
    }
    
    .profile-image {
        width: 200px;
        height: 250px;
    }
}

@media (max-width: 768px) {
    .navbar-title {
        display: none;
    }
    
    .profile-info-card,
    .profile-picture-card {
        padding: 1.5rem;
    }
    
    .main-content {
        padding: 1rem;
    }
    
    .profile-image {
        width: 150px;
        height: 200px;
    }
    
    .profile-name-large {
        font-size: 1.5rem;
    }
    
    .modal-content {
        padding: 1.5rem;
        width: 95%;
    }
}

@media (max-width: 640px) {
    .navbar-brand span:last-child {
        display: none;
    }
    
    .main-content {
        padding: 0.8rem;
    }
    
    .profile-image {
        width: 120px;
        height: 160px;
    }
    
    .modal-buttons {
        flex-direction: column;
    }
}

/* Debug styles - remove after fixing */
.debug .profile-container {
    border: 2px dashed red;
}

.debug .profile-left {
    border: 1px dashed blue;
}

.debug .profile-right {
    border: 1px dashed green;
}
</style>

<!-- Load Iconify -->
<script src="https://code.iconify.design/iconify-icon/1.0.8/iconify-icon.min.js"></script>

<!-- Top Navigation -->
<div class="top-navbar">
    <div class="navbar-left">
        <div class="sidebar-toggle" id="sidebarToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <div class="logo">
                <h1>skill<span>Match</span></h1>
            </div>
        </a>
        <h1 class="navbar-title">Profile</h1>
    </div>
    <div class="navbar-right">
        <!-- Profile Button -->
        <div class="navbar-profile" onclick="goToProfile()">
            <img src="{{ Auth::user()->profile_image ?? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face' }}" 
                 alt="Profile"
                 onerror="this.src='https://via.placeholder.com/40x40/f3f4f6/9ca3af?text=👤'">
        </div>
        
        <!-- Logout Form -->
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
        <a href="{{ route('dashboard') }}" class="nav-item">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:dashboard"></iconify-icon>
            </div>
            <span class="nav-text">Dashboard</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:chat"></iconify-icon>
            </div>
            <span class="nav-text">Chat</span>
            <span class="nav-badge">3</span>
        </a>
        <a href="#" class="nav-item">
            <div class="nav-icon">
                <iconify-icon icon="material-symbols:list-alt"></iconify-icon>
            </div>
            <span class="nav-text">Orders</span>
        </a>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content">
    <!-- Display Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success" id="successMessage">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error" id="errorMessage">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error" id="validationErrors">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Back Button -->
    <a href="{{ route('dashboard') }}" class="back-button">
        <iconify-icon icon="material-symbols:chevron-left"></iconify-icon>
        Back
    </a>

    <!-- Profile Container with Flexbox Layout -->
    <div class="profile-container">
        <!-- Left Side - Profile Info -->
        <div class="profile-left">
            <div class="profile-info-card">
                <div class="profile-header">
                    <h1 class="profile-name-large" id="profileName">{{ Auth::user()->name }}</h1>
                    
                    <div class="profile-contact-info">
                        <div class="contact-item">
                            <strong>EMAIL :</strong> <span id="profileEmail">{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="profile-bio-section">
                    <p id="profileBio">{{ Auth::user()->bio ?? "I am a publishing professional at Gramedia Pustaka, responsible for managing the editing and design process throughout book production. With experience in ensuring visual and content quality, I focus on detail, aesthetics, and design consistency to create engaging and professional publications. My expertise includes coordinating with editorial teams, designers, and printers to deliver works that meet the highest publishing standards." }}</p>
                </div>

                <button class="edit-profile-btn" onclick="openEditModal()">
                    <iconify-icon icon="material-symbols:edit"></iconify-icon>
                    Edit
                </button>
            </div>
        </div>

        <!-- Right Side - Profile Picture -->
        <div class="profile-right">
            <div class="profile-picture-card">
                <img src="{{ Auth::user()->profile_image ?? 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=280&h=350&fit=crop&crop=faces' }}" 
                     alt="Profile" 
                     class="profile-image" 
                     id="profileImage"
                     onerror="this.src='https://via.placeholder.com/280x350/f3f4f6/9ca3af?text=Profile'">
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal-overlay" id="editProfileModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Edit Profile</h2>
            <button class="modal-close" onclick="closeEditModal()">
                <iconify-icon icon="material-symbols:close"></iconify-icon>
            </button>
        </div>

        <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label">Profile Picture</label>
                <div class="file-upload-container">
                    <input type="file" id="profilePictureInput" name="profile_image" class="file-upload-input" accept="image/*" onchange="handleFileSelect(this)">
                    <label for="profilePictureInput" class="file-upload-button">
                        <iconify-icon icon="material-symbols:add"></iconify-icon>
                        Choose File
                    </label>
                    <span class="file-name" id="fileName">{{ Auth::user()->profile_image ? basename(Auth::user()->profile_image) : 'No file selected' }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" class="form-input" id="editName" name="name" value="{{ Auth::user()->name }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-input" id="editEmail" name="email" value="{{ Auth::user()->email }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Bio</label>
                <textarea class="form-input form-textarea" id="editBio" name="bio" rows="6">{{ Auth::user()->bio ?? "I am a publishing professional at Gramedia Pustaka, responsible for managing the editing and design process throughout book production. With experience in ensuring visual and content quality, I focus on detail, aesthetics, and design consistency to create engaging and professional publications. My expertise includes coordinating with editorial teams, designers, and printers to deliver works that meet the highest publishing standards." }}</textarea>
            </div>

            <div class="modal-buttons">
                <button type="button" class="btn-cancel" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn-save">
                    <iconify-icon icon="material-symbols:save"></iconify-icon>
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Debug mode - uncomment to see layout borders
    // document.body.classList.add('debug');
    
    // Auto-hide success/error messages after 5 seconds
    const successMessage = document.getElementById('successMessage');
    const errorMessage = document.getElementById('errorMessage');
    const validationErrors = document.getElementById('validationErrors');
    
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.opacity = '0';
            setTimeout(() => successMessage.remove(), 300);
        }, 5000);
    }
    
    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.opacity = '0';
            setTimeout(() => errorMessage.remove(), 300);
        }, 5000);
    }
    
    if (validationErrors) {
        setTimeout(() => {
            validationErrors.style.opacity = '0';
            setTimeout(() => validationErrors.remove(), 300);
        }, 7000);
    }

    // Sidebar functionality
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    if (sidebarToggle) {
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
        
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            sidebarOverlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
        });
        
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.style.display = 'none';
        });
    }

    // Form validation
    const editForm = document.getElementById('editProfileForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const name = document.getElementById('editName').value.trim();
            const email = document.getElementById('editEmail').value.trim();
            
            if (!name) {
                e.preventDefault();
                alert('Name is required');
                return;
            }
            
            if (!email) {
                e.preventDefault();
                alert('Email is required');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address');
                return;
            }
            
            // Show loading state
            const submitButton = editForm.querySelector('.btn-save');
            if (submitButton) {
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<iconify-icon icon="material-symbols:hourglass-empty"></iconify-icon> Saving...';
                submitButton.disabled = true;
            }
        });
    }
});

// Modal functions
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
        
        // Reset form if needed
        const form = document.getElementById('editProfileForm');
        const submitButton = form?.querySelector('.btn-save');
        if (submitButton) {
            submitButton.innerHTML = '<iconify-icon icon="material-symbols:save"></iconify-icon> Save';
            submitButton.disabled = false;
        }
    }
}

// File upload handler
function handleFileSelect(input) {
    const file = input.files[0];
    if (file) {
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPEG, PNG, or GIF)');
            input.value = '';
            return;
        }
        
        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            input.value = '';
            return;
        }
        
        const fileNameElement = document.getElementById('fileName');
        if (fileNameElement) {
            fileNameElement.textContent = file.name;
        }
        
        // Preview image
        const reader = new FileReader();
        reader.onload = function(e) {
            const profileImage = document.getElementById('profileImage');
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

// Logout confirmation
function confirmLogout() {
    return confirm('Are you sure you want to log out?');
}

// Profile navigation
function goToProfile() {
    window.location.reload();
}

// Prevent form resubmission on page refresh
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

// Image error handling
document.addEventListener('DOMContentLoaded', function() {
    const profileImages = document.querySelectorAll('.profile-image, .navbar-profile img');
    profileImages.forEach(img => {
        img.addEventListener('error', function() {
            if (this.classList.contains('profile-image')) {
                this.src = 'https://via.placeholder.com/280x350/f3f4f6/9ca3af?text=Profile';
            } else {
                this.src = 'https://via.placeholder.com/40x40/f3f4f6/9ca3af?text=👤';
            }
        });
    });
});
</script>
@endsection