@extends('layouts.app')

@section('page-title', 'Profile')

@section('navigation')
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
@endsection

@push('styles')
<style>
/* Profile-specific styles only */
.back-btn {
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

.back-btn:hover {
    color: var(--primary-color);
    text-decoration: none;
}

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

.services-section {
    background: var(--bg-primary);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
    margin-bottom: 2rem;
}

.services-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 2rem;
}

.service-item {
    padding: 1.5rem 0;
    border-bottom: 1px solid var(--border-light);
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
    color: var(--text-primary);
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
    color: var(--text-secondary);
    font-weight: 500;
}

.service-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 0.5rem;
}

.service-project {
    color: var(--text-secondary);
    font-size: 0.85rem;
    word-break: break-all;
}

.service-chat-btn {
    background: var(--text-secondary);
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
    background: var(--secondary-color);
    transform: translateY(-1px);
}

.service-chat-btn:disabled {
    background: #94a3b8;
    cursor: not-allowed;
    transform: none;
}

.profile-card {
    background: var(--bg-primary);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
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
    box-shadow: var(--shadow-lg);
}

.profile-name {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-primary);
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
    background: var(--primary-color);
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
    color: var(--text-secondary);
    font-size: 0.9rem;
}

.contact-item strong {
    color: var(--text-primary);
}

.contact-item iconify-icon {
    color: var(--primary-color);
    font-size: 1.1rem;
}

.profile-bio {
    text-align: left;
    color: var(--text-secondary);
    line-height: 1.6;
    font-size: 0.9rem;
}

/* Mobile Responsiveness */
@media (max-width: 1024px) {
    .profile-container {
        flex-direction: column-reverse;
    }

    .profile-card {
        position: static;
    }
}

@media (max-width: 768px) {
    .services-section,
    .profile-card {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
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
    .profile-image {
        width: 120px;
        height: 120px;
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
            default => route('dashboard'),
        };
    @endphp
    
    <!-- Back Button -->
    <a href="{{ $dashboardRoute }}" class="back-btn">
        <iconify-icon icon="material-symbols:chevron-left"></iconify-icon>
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
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
</script>
@endpush