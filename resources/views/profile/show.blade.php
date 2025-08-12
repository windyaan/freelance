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
}

.back-button iconify-icon {
    width: 20px;
    height: 20px;
}

/* Profile Layout */
.profile-container {
    display: flex;
    gap: 2rem;
    align-items: flex-start;
}

.profile-left {
    flex: 1;
}

.profile-right {
    flex: 1;
    max-width: 500px;
}

/* Services Section */
.services-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    margin-bottom: 2rem;
}

.services-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 2rem;
}

.service-item {
    padding: 1.5rem 0;
    border-bottom: 1px solid #f1f5f9;
}

.service-item:last-child {
    border-bottom: none;
}

.service-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.service-info {
    flex: 1;
}

.service-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.service-status-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.service-status {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.service-status.available {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.service-status.not-available {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.service-price {
    font-size: 0.9rem;
    color: #64748b;
    font-weight: 500;
}

.service-description {
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 0.5rem;
}

.service-project {
    color: #64748b;
    font-size: 0.85rem;
    word-break: break-all;
}

.service-chat-btn {
    background: #64748b;
    color: white;
    border: none;
    padding: 0.5rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.85rem;
    transition: all 0.2s ease;
    margin-left: auto;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.service-chat-btn:hover {
    background: #475569;
    transform: translateY(-1px);
}

.service-chat-btn:disabled {
    background: #94a3b8;
    cursor: not-allowed;
    transform: none;
}

/* Profile Card */
.profile-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
    text-align: center;
    position: sticky;
    top: 90px;
}

.profile-image {
    width: 200px;
    height: 200px;
    border-radius: 16px;
    object-fit: cover;
    margin: 0 auto 1.5rem;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.profile-name {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1rem;
}

.profile-skills {
    display: flex;
    gap: 0.75rem;
    justify-content: center;
    margin-bottom: 1.5rem;
    flex-wrap: wrap;
}

.skill-tag {
    background: #38C1B9;
    color: white;
    padding: 0.4rem 1rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.profile-contact {
    margin-bottom: 1.5rem;
}

.contact-item {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    color: #64748b;
    font-size: 0.9rem;
}

.contact-item strong {
    color: #1e293b;
}

.contact-item iconify-icon {
    color: #38C1B9;
    font-size: 1.1rem;
}

.profile-bio {
    text-align: left;
    color: #64748b;
    line-height: 1.6;
    font-size: 0.9rem;
}

/* Mobile Responsiveness */
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

    .profile-container {
        flex-direction: column-reverse;
    }

    .profile-card {
        position: static;
    }
}

@media (max-width: 768px) {
    .navbar-title {
        display: none;
    }

    .services-section,
    .profile-card {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .main-content {
        padding: 1rem;
    }

    .profile-image {
        width: 150px;
        height: 150px;
    }

    .profile-name {
        font-size: 1.5rem;
    }

    .service-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .service-chat-btn {
        margin-left: 0;
        width: 100%;
    }

    .service-status-wrapper {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
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
        height: 120px;
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
<script>
// Fallback loading method
if (typeof IconifyIcon === 'undefined') {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/@iconify/iconify@3.1.1/dist/iconify.min.js';
    document.head.appendChild(script);
}
</script>

<!-- Top Navigation -->
<div class="top-navbar">
    <div class="navbar-left">
        <div class="sidebar-toggle" id="sidebarToggle" style="display: none;">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <div class="logo" style="margin-top: 60px;">
                <h1>Skill<span>Match</span></h1>
            </div>
        </a>
        <h1 class="navbar-title">Dashboard</h1>
    </div>
    <div class="navbar-right">
        <!-- Profile Button -->
        <div class="navbar-profile" onclick="goToProfile()">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face" alt="Profile">
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

    <div class="profile-container">
        <!-- Left Side - Services -->
        <div class="profile-left">
            <div class="services-section">
                <h2 class="services-title">JOB</h2>

                @forelse($user->jobs as $index => $job)
                    <div class="service-item">
                        <div class="service-header">
                            <div class="service-info">
                                <h3 class="service-name">{{ $job->title }}</h3>
                                <div class="service-status-wrapper">
                                    <span class="service-status {{ $job->is_active ? 'available' : 'not-available' }}">
                                        {{ $job->is_active ? 'Available' : 'Not Available' }}
                                    </span>
                                    @if($job->price_min && $job->price_max)
                                        <span class="service-price">Rp{{ number_format($job->price_min, 0, ',', '.') }}-Rp{{ number_format($job->price_max, 0, ',', '.') }}</span>
                                    @else
                                        @php
                                            // Default price ranges based on service type
                                            $defaultPrices = [
                                                'UI Design' => ['min' => 400000, 'max' => 600000],
                                                'Front-End' => ['min' => 700000, 'max' => 900000],
                                                'Web Development' => ['min' => 700000, 'max' => 900000],
                                            ];
                                            $priceRange = $defaultPrices[$job->title] ?? ['min' => 500000, 'max' => 800000];
                                        @endphp
                                        <span class="service-price">Rp{{ number_format($priceRange['min'], 0, ',', '.') }}-Rp{{ number_format($priceRange['max'], 0, ',', '.') }}</span>
                                    @endif
                                </div>
                            </div>
                            <button class="service-chat-btn" {{ !$job->is_active ? 'disabled' : '' }}>
                                <iconify-icon icon="{{ $job->is_active ? 'material-symbols:chat' : 'material-symbols:chat-disabled' }}"></iconify-icon>
                                Chat
                            </button>
                        </div>
                        <p class="service-description">{{ $job->description }}</p>
                        <p class="service-project">contoh project : https://link-project-{{ Str::slug($job->title) }}</p>
                    </div>
                @empty
                    <!-- Default job listings if no jobs exist -->
                    <div class="service-item">
                        <div class="service-header">
                            <div class="service-info">
                                <h3 class="service-name">UI Design</h3>
                                <div class="service-status-wrapper">
                                    <span class="service-status available">Available</span>
                                    <span class="service-price">Rp400.000-Rp600.000</span>
                                </div>
                            </div>
                            <button class="service-chat-btn">
                                <iconify-icon icon="material-symbols:chat"></iconify-icon>
                                Chat
                            </button>
                        </div>
                        <p class="service-description">Pembuatan prototype menggunakan figma dan sketch.</p>
                        <p class="service-project">contoh project : https://link-project-prototype-figma</p>
                    </div>

                    <div class="service-item">
                        <div class="service-header">
                            <div class="service-info">
                                <h3 class="service-name">Front-End</h3>
                                <div class="service-status-wrapper">
                                    <span class="service-status available">Available</span>
                                    <span class="service-price">Rp700.000-Rp900.000</span>
                                </div>
                            </div>
                            <button class="service-chat-btn">
                                <iconify-icon icon="material-symbols:chat"></iconify-icon>
                                Chat
                            </button>
                        </div>
                        <p class="service-description">Jasa pembuatan website toko pakaian dengan menggunakan laravel.</p>
                        <p class="service-project">contoh project : https://link-project-website-toko-pakaian</p>
                    </div>

                    <div class="service-item">
                        <div class="service-header">
                            <div class="service-info">
                                <h3 class="service-name">Front-End</h3>
                                <div class="service-status-wrapper">
                                    <span class="service-status not-available">Not Available</span>
                                    <span class="service-price">Rp700.000-Rp900.000</span>
                                </div>
                            </div>
                            <button class="service-chat-btn" disabled>
                                <iconify-icon icon="material-symbols:chat-disabled"></iconify-icon>
                                Chat
                            </button>
                        </div>
                        <p class="service-description">Jasa pembuatan website toko furniture dengan menggunakan laravel.</p>
                        <p class="service-project">contoh project : https://link-project-website-toko-furniture</p>
                    </div>

                    <div class="service-item">
                        <div class="service-header">
                            <div class="service-info">
                                <h3 class="service-name">Front-End</h3>
                                <div class="service-status-wrapper">
                                    <span class="service-status not-available">Not Available</span>
                                    <span class="service-price">Rp700.000-Rp900.000</span>
                                </div>
                            </div>
                            <button class="service-chat-btn" disabled>
                                <iconify-icon icon="material-symbols:chat-disabled"></iconify-icon>
                                Chat
                            </button>
                        </div>
                        <p class="service-description">Jasa pembuatan website toko barang dengan menggunakan laravel.</p>
                        <p class="service-project">contoh project : https://link-project-website-toko-barang</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Side - Profile Info -->
        <div class="profile-right">
            <div class="profile-card">
                <img src="https://images.unsplash.com/photo-1544725176-7c40e5a71c5e?w=200&h=200&fit=crop&crop=face" alt="Profile" class="profile-image">

                <h1 class="profile-name">{{ $user->name ?? 'Nadia Ima' }}</h1>

                <div class="profile-skills">
                    @if($user->profile && $user->profile->skills)
                        @if(is_array($user->profile->skills))
                            @foreach($user->profile->skills as $skill)
                                <span class="skill-tag">{{ $skill }}</span>
                            @endforeach
                        @else
                            @foreach(explode(',', $user->profile->skills) as $skill)
                                <span class="skill-tag">{{ trim($skill) }}</span>
                            @endforeach
                        @endif
                    @else
                        <span class="skill-tag">UI Design</span>
                        <span class="skill-tag">Front-End</span>
                    @endif
                </div>

                <div class="profile-contact">
                    <div class="contact-item">
                        <iconify-icon icon="material-symbols:mail"></iconify-icon>
                        <strong>EMAIL :</strong> {{ $user->email ?? 'namira@gmail.com' }}
                    </div>
                    <div class="contact-item">
                        <iconify-icon icon="material-symbols:star"></iconify-icon>
                        <strong>SKILLS :</strong>
                        @if($user->profile && $user->profile->skills)
                            @if(is_array($user->profile->skills))
                                {{ implode(', ', $user->profile->skills) }}
                            @else
                                {{ $user->profile->skills }}
                            @endif
                        @else
                            photoshop, canva, laravel
                        @endif
                    </div>
                </div>

                <div class="profile-bio">
                    <p>{{ $user->profile->bio ?? "I'm a third-year IT student at Airlangga University passionate about software development. In UI design and data analysis, I've gained practical experience through building and optimizing web apps and contributing to student tech projects, strengthening my technical and teamwork skills." }}</p>

                    <p style="margin-top: 1rem;">{{ $user->profile->achievement ?? "As a Top 200 Finalist in the 2023 National UI Design Competition, I demonstrated my ability to create intuitive, visually appealing digital experiences by combining design thinking with technical execution." }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.getElementById('sidebar');
    var sidebarToggle = document.getElementById('sidebarToggle');

    // Sidebar functionality
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

    // Chat button functionality
    document.querySelectorAll('.service-chat-btn:not([disabled])').forEach(btn => {
        btn.addEventListener('click', function() {
            const serviceItem = this.closest('.service-item');
            const serviceName = serviceItem.querySelector('.service-name').textContent;
            alert(`Starting chat for ${serviceName} service...`);
            // Here you would typically redirect to chat page or open chat modal
            // window.location.href = `/chat/{{ $user->id ?? 1 }}?service=${encodeURIComponent(serviceName)}`;
        });
    });
});

// Logout confirmation
function confirmLogout() {
    return confirm('Are you sure you want to log out?');
}
// Profile navigation
function goToProfile() {
    window.location.href = "{{ route('profile.edit') }}";
}
</script>
@endsection
