@extends('layouts.app')

@section('title', 'Dashboard - SkillMatch')
@section('page-title', 'Dashboard')

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
        <span class="nav-text">Order</span>
    </a>
@endsection

@section('content')
<!-- Embed jobs data in a script tag for JavaScript access -->
<script id="jobs-data" type="application/json">
{!! json_encode($jobs->map(function($job) {
    return [
        'id' => $job->id,
        'title' => $job->title,
        'description' => $job->description,
        'starting_price' => $job->starting_price,
        'category' => $job->category->name ?? 'General',
        'freelancer' => [
            'id' => $job->freelancer->id ?? 0,
            'name' => $job->freelancer->name ?? 'Unknown User'
        ]
    ];
})) !!}
</script>

<!-- Skills Grid -->
<div class="skills-section">
    <div class="skills-slider-container">
        <button class="slider-nav prev" id="prevSlide">
            <iconify-icon icon="material-symbols:chevron-left"></iconify-icon>
        </button>
        <button class="slider-nav next" id="nextSlide">
            <iconify-icon icon="material-symbols:chevron-right"></iconify-icon>
        </button>

        <div class="skills-slider-wrapper" id="skillsSlider">
            <!-- Slide 1 -->
            <div class="skills-slide">
                <div class="skill-card" data-skill="videographer">
                    <div class="skill-icon">
                        <iconify-icon icon="material-symbols:videocam"></iconify-icon>
                    </div>
                    <div class="skill-name">video<br>grapher</div>
                </div>
                <div class="skill-card" data-skill="video editor">
                    <div class="skill-icon">
                        <iconify-icon icon="material-symbols:video-camera-back"></iconify-icon>
                    </div>
                    <div class="skill-name">video<br>editor</div>
                </div>
                <div class="skill-card" data-skill="photographer">
                    <div class="skill-icon">
                        <iconify-icon icon="material-symbols:photo-camera"></iconify-icon>
                    </div>
                    <div class="skill-name">photo<br>grapher</div>
                </div>
                <div class="skill-card" data-skill="content writing">
                    <div class="skill-icon">
                        <iconify-icon icon="material-symbols:edit"></iconify-icon>
                    </div>
                    <div class="skill-name">content<br>writing</div>
                </div>
                <div class="skill-card" data-skill="copywriting">
                    <div class="skill-icon">
                        <iconify-icon icon="material-symbols:description"></iconify-icon>
                    </div>
                    <div class="skill-name">copy<br>writing</div>
                </div>
                <div class="skill-card" data-skill="translator">
                    <div class="skill-icon">
                        <iconify-icon icon="material-symbols:translate"></iconify-icon>
                    </div>
                    <div class="skill-name">translator</div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="skills-slide">
                <div class="skill-card" data-skill="ui design">
                    <div class="skill-icon">
                        <iconify-icon icon="material-symbols:palette"></iconify-icon>
                    </div>
                    <div class="skill-name">UI<br>design</div>
                </div>
                <div class="skill-card" data-skill="front-end">
                    <div class="skill-icon">
                        <iconify-icon icon="material-symbols:monitor"></iconify-icon>
                    </div>
                    <div class="skill-name">front-end</div>
                </div>
                <div class="skill-card" data-skill="back-end">
                    <div class="skill-icon">
                        <iconify-icon icon="material-symbols:dns"></iconify-icon>
                    </div>
                    <div class="skill-name">back-end</div>
                </div>
                <div class="skill-card" data-skill="fullstack">
                    <div class="skill-icon">
                        <iconify-icon icon="material-symbols:layers"></iconify-icon>
                    </div>
                    <div class="skill-name">fullstack</div>
                </div>
                <div class="skill-card" data-skill="graphic design">
                    <div class="skill-icon">
                        <iconify-icon icon="material-symbols:brush"></iconify-icon>
                    </div>
                    <div class="skill-name">graphic<br>design</div>
                </div>
                <div class="skill-card" data-skill="illustrator">
                    <div class="skill-icon">
                        <iconify-icon icon="material-symbols:draw"></iconify-icon>
                    </div>
                    <div class="skill-name">illustrator</div>
                </div>
            </div>
        </div>

        <!-- Slide indicators -->
        <div class="slide-indicators">
            <div class="slide-indicator active" data-slide="0"></div>
            <div class="slide-indicator" data-slide="1"></div>
        </div>
    </div>
</div>

<!-- Filters Section -->
<div class="filters-section">
    <div class="filter-button" id="filterBtn">
        <iconify-icon icon="material-symbols:tune"></iconify-icon>
        Filter
        <span class="filter-arrow">▼</span>
        
        <!-- Main Filter Dropdown -->
        <div class="filter-dropdown" id="filterDropdown">
            <!-- Price Filter Section -->
            <div class="filter-section">
                <div class="filter-section-header">
                    <iconify-icon icon="material-symbols:payments"></iconify-icon>
                    Price Range
                </div>
                <div class="price-inputs">
                    <div class="price-input-group">
                        <label class="price-label">MIN</label>
                        <input type="number" class="price-input" id="minPrice" placeholder="0" min="0">
                    </div>
                    <div class="price-input-group">
                        <label class="price-label">MAX</label>
                        <input type="number" class="price-input" id="maxPrice" placeholder="1000000" min="0">
                    </div>
                </div>
            </div>
            
            <!-- You can add more filter sections here in the future -->
            <!-- 
            <div class="filter-section">
                <div class="filter-section-header">
                    <iconify-icon icon="material-symbols:location-on"></iconify-icon>
                    Location
                </div>
                <select class="filter-select">
                    <option value="">All Locations</option>
                    <option value="jakarta">Jakarta</option>
                    <option value="bandung">Bandung</option>
                </select>
            </div>
            -->
            
            <div class="filter-actions">
                <button class="filter-clear-btn" id="clearFilters">Clear</button>
                <button class="filter-apply-btn" id="applyFilters">Apply</button>
            </div>
        </div>
    </div>
</div>

<!-- Selected Filters Display -->
<div class="selected-filters" id="selectedFilters" style="display: none;">
    <!-- Dynamic filter tags will be inserted here -->
</div>

<!-- Talent Grid with Data from Jobs -->
<div class="talents-section">
    <div class="talent-slider-container">
        <div class="talent-slider-wrapper" id="talentSlider">
            @php
                $jobsPerSlide = 3;
                $totalSlides = ceil($jobs->count() / $jobsPerSlide);
            @endphp

            @for ($slideIndex = 0; $slideIndex < $totalSlides; $slideIndex++)
                <div class="talent-slide">
                    @php
                        $startIndex = $slideIndex * $jobsPerSlide;
                        $slideJobs = $jobs->slice($startIndex, $jobsPerSlide);
                    @endphp

                    @foreach ($slideJobs as $job)
                        <div class="talent-card"
                             data-name="{{ $job->freelancer->name ?? 'Unknown' }}"
                             data-user-id="{{ $job->freelancer->id ?? 0 }}"
                             data-skills="{{ strtolower($job->category->name ?? 'general') }}"
                             data-price="{{ $job->starting_price }}"
                             data-category="{{ strtolower($job->category->name ?? 'general') }}"
                             data-job-id="{{ $job->id }}">
                            <div class="talent-header">
                                <div class="talent-skill-badge">{{ $job->category->name ?? 'General' }}</div>
                                <h3 class="talent-name">{{ $job->freelancer->name ?? 'Unknown User' }}</h3>
                            </div>
                            <p class="talent-description">{{ Str::limit($job->description, 100) }}</p>
                            <a href="#" class="talent-project-link">{{ $job->title }}</a>
                            <div class="talent-price">Rp{{ number_format($job->starting_price, 0, ',', '.') }}</div>
                            <button class="talent-profile-btn" data-freelancer-id="{{ $job->freelancer->id ?? 0 }}">profile</button>
                        </div>
                    @endforeach

                    @if ($slideJobs->count() < $jobsPerSlide)
                        @for ($i = $slideJobs->count(); $i < $jobsPerSlide; $i++)
                            <div class="talent-card" style="opacity: 0; pointer-events: none;">
                                <!-- Empty placeholder to maintain grid layout -->
                            </div>
                        @endfor
                    @endif
                </div>
            @endfor

            @if ($jobs->count() == 0)
                <div class="talent-slide">
                    <div class="no-results">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">
                            <iconify-icon icon="material-symbols:work-off"></iconify-icon>
                        </div>
                        <h3 style="margin-bottom: 0.5rem; color: #1e293b;">No jobs available</h3>
                        <p>There are currently no jobs to display</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Dynamic Talent Pagination -->
    @if ($totalSlides > 1)
        <div class="talent-pagination">
            <button id="prevPageBtn">
                <iconify-icon icon="material-symbols:chevron-left"></iconify-icon>
            </button>
            @for ($i = 0; $i < $totalSlides; $i++)
                <button data-page="{{ $i }}" class="{{ $i == 0 ? 'active' : '' }}">{{ $i + 1 }}</button>
            @endfor
            <button id="nextPageBtn">
                <iconify-icon icon="material-symbols:chevron-right"></iconify-icon>
            </button>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
/* Dashboard-specific styles */
.skills-section {
    background: var(--bg-primary);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
    overflow: hidden;
    position: relative;
}

.skills-slider-container {
    position: relative;
    overflow: hidden;
    border-radius: 12px;
}

.skills-slider-wrapper {
    display: flex;
    transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    will-change: transform;
}

.skills-slide {
    min-width: 100%;
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 1.5rem;
    padding: 1rem 0;
}

.slider-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.95);
    border: 1px solid var(--border-color);
    border-radius: 50%;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: var(--text-secondary);
    font-size: 1.2rem;
    font-weight: bold;
    z-index: 10;
    backdrop-filter: blur(8px);
    box-shadow: var(--shadow-md);
}

.slider-nav:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(56, 193, 185, 0.3);
}

.slider-nav.disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

.slider-nav.prev {
    left: -22px;
}

.slider-nav.next {
    right: -22px;
}

.slide-indicators {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1.5rem;
    padding: 0 1rem;
}

.slide-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #cbd5e1;
    cursor: pointer;
    transition: all 0.3s ease;
}

.slide-indicator.active {
    background: var(--primary-color);
    transform: scale(1.2);
    box-shadow: 0 2px 8px rgba(56, 193, 185, 0.4);
}

.slide-indicator:hover {
    background: var(--text-muted);
    transform: scale(1.1);
}

.skill-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
    padding: 1.5rem 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
    text-align: center;
    background: var(--bg-secondary);
    border: 1px solid var(--border-light);
    position: relative;
}

.skill-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
}

.skill-card.active {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    background: rgba(56, 193, 185, 0.1);
    border-color: var(--primary-color);
}

.skill-card.active .skill-icon {
    background: var(--primary-color) !important;
    color: white !important;
    box-shadow: 0 6px 20px rgba(56, 193, 185, 0.4) !important;
}

.skill-card.active .skill-name {
    color: var(--primary-color) !important;
    font-weight: 600 !important;
}

.skill-card.active::after {
    content: '✓';
    position: absolute;
    top: -8px;
    right: -8px;
    background: var(--primary-color);
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
    font-weight: bold;
    box-shadow: 0 4px 15px rgba(56, 193, 185, 0.4);
}

.skill-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    background: linear-gradient(135deg, var(--primary-color), #2da89f);
    box-shadow: 0 4px 12px rgba(56, 193, 185, 0.3);
}

.skill-name {
    font-weight: 500;
    color: var(--text-secondary);
    font-size: 0.8rem;
    text-align: center;
    line-height: 1.3;
    transition: all 0.3s ease;
}

/* Filters Section */
.filters-section {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1rem 0;
    flex-wrap: wrap;
}

.filter-button {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 500;
    color: var(--text-secondary);
    transition: all 0.2s ease;
    position: relative;
}

.filter-button:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    background: var(--bg-secondary);
}

.filter-button.active {
    border-color: var(--primary-color);
    background: var(--primary-color);
    color: white;
}

.filter-arrow {
    font-size: 0.8rem;
    transition: transform 0.2s ease;
}

.filter-button.open .filter-arrow {
    transform: rotate(180deg);
}

/* Main Filter Dropdown */
.filter-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    box-shadow: var(--shadow-lg);
    margin-top: 8px;
    padding: 0;
    min-width: 350px;
    z-index: 1000;
    display: none;
    overflow: hidden;
}

.filter-dropdown.show {
    display: block;
}

/* Filter Sections */
.filter-section {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-light);
}

.filter-section:last-of-type {
    border-bottom: none;
}

.filter-section-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.filter-section-header iconify-icon {
    color: var(--primary-color);
    font-size: 1rem;
}

/* Price inputs styling */
.price-inputs {
    display: flex;
    gap: 1rem;
}

.price-input-group {
    flex: 1;
}

.price-label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.price-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.9rem;
    outline: none;
    transition: all 0.2s ease;
    background: var(--bg-secondary);
}

.price-input:focus {
    border-color: var(--primary-color);
    background: var(--bg-primary);
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
}

/* Filter select styling */
.filter-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.9rem;
    outline: none;
    transition: all 0.2s ease;
    background: var(--bg-secondary);
    color: var(--text-primary);
}

.filter-select:focus {
    border-color: var(--primary-color);
    background: var(--bg-primary);
    box-shadow: 0 0 0 3px rgba(56, 193, 185, 0.1);
}

/* Filter actions */
.filter-actions {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    background: var(--bg-secondary);
}

.filter-clear-btn,
.filter-apply-btn {
    flex: 1;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
}

.filter-clear-btn {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border-color);
}

.filter-clear-btn:hover {
    background: var(--bg-primary);
    border-color: var(--text-secondary);
    color: var(--text-primary);
}

.filter-apply-btn {
    background: var(--primary-color);
    color: white;
}

.filter-apply-btn:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(56, 193, 185, 0.3);
}

/* Selected Filters */
.selected-filters {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.filter-tag {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: var(--primary-color);
    color: white;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
}

.filter-tag-close {
    cursor: pointer;
    font-size: 1rem;
    margin-left: 0.25rem;
    opacity: 0.8;
    transition: opacity 0.2s ease;
}

.filter-tag-close:hover {
    opacity: 1;
}

.clear-filters-btn {
    padding: 0.5rem 1rem;
    background: transparent;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    color: var(--text-secondary);
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.clear-filters-btn:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
    background: var(--bg-secondary);
}

.talents-section {
    background: var(--bg-primary);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--border-light);
    overflow-x: hidden;
}

.talent-slider-container {
    position: relative;
    overflow: hidden;
}

.talent-slider-wrapper {
    display: flex;
    transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    will-change: transform;
}

.talent-slide {
    min-width: 100%;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 2rem;
}

.talent-card {
    background: var(--bg-primary);
    border-radius: 16px;
    padding: 2rem;
    position: relative;
    transition: all 0.3s ease;
    border: 1px solid var(--border-color);
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
    min-height: 320px;
    height: 100%;
}

.talent-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary-color);
}

.talent-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.talent-skill-badge {
    background: var(--primary-color);
    color: white;
    padding: 0.4rem 0.8rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
}

.talent-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
    text-align: right;
    line-height: 1.2;
}

.talent-description {
    color: var(--text-secondary);
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
    flex-grow: 1;
    min-height: 60px;
    display: flex;
    align-items: flex-start;
}

.talent-project-link {
    color: var(--primary-color);
    font-size: 0.85rem;
    text-decoration: none;
    font-weight: 500;
    margin-bottom: 1rem;
    display: block;
    word-break: break-all;
    min-height: 40px;
    display: flex;
    align-items: center;
}

.talent-project-link:hover {
    text-decoration: underline;
}

.talent-price {
    color: var(--primary-color);
    font-size: 0.9rem;
    font-weight: 700;
    text-align: right;
    white-space: nowrap;
    margin-bottom: 1rem;
    margin-top: auto;
    min-height: 24px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.talent-profile-btn {
    background: var(--secondary-color);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    width: 100%;
}

.talent-profile-btn:hover {
    background: var(--secondary-hover);
    transform: translateY(-1px);
}

.talent-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-top: 2rem;
}

.talent-pagination button {
    width: 40px;
    height: 40px;
    border: 1px solid var(--border-color);
    background: var(--bg-primary);
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    color: var(--text-secondary);
    transition: all 0.2s ease;
}

.talent-pagination button:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.talent-pagination button.active {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.talent-pagination button:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

.no-results {
    text-align: center;
    padding: 3rem;
    color: var(--text-secondary);
    font-size: 1.1rem;
    grid-column: 1 / -1;
}

/* Responsive */
@media (max-width: 1024px) {
    .talent-slide {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .skills-slide {
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    .filter-dropdown {
        min-width: 300px;
    }

    .filters-section {
        flex-wrap: wrap;
        gap: 0.8rem;
    }

    .filter-button {
        padding: 0.6rem 1.2rem;
        font-size: 0.85rem;
    }

    .filter-dropdown {
        min-width: 250px;
    }
}

@media (max-width: 768px) {
    .skills-section,
    .talents-section {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .talent-slide {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .skills-slide {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.8rem;
    }

    .skill-card {
        padding: 1rem 0.5rem;
    }

    .filter-dropdown {
        min-width: 200px;
        left: -50px;
    }

    .filters-section {
        gap: 0.5rem;
    }

    .filter-button {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }
}

@media (max-width: 640px) {
    .skill-card {
        padding: 0.8rem 0.4rem;
    }

    .skill-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }

    .talent-slide {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .skills-slide {
        grid-template-columns: repeat(2, 1fr);
        gap: 0.6rem;
    }

    .filters-section {
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
    }

    .filter-dropdown {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90vw;
        max-width: 300px;
        margin-top: 0;
    }

    .selected-filters {
        justify-content: center;
    }

    .price-inputs {
        flex-direction: column;
        gap: 1rem;
    }

    .filter-actions {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Enhanced JavaScript code for Dashboard with Nested Filters
document.addEventListener('DOMContentLoaded', function() {
    // Get jobs data from the embedded JSON script
    let jobsData = [];
    try {
        const jobsScript = document.getElementById('jobs-data');
        if (jobsScript && jobsScript.textContent) {
            jobsData = JSON.parse(jobsScript.textContent);
        }
    } catch (error) {
        console.error('Failed to parse jobs data:', error);
        jobsData = [];
    }

    // Cache DOM elements
    const searchInput = document.getElementById('globalSearch');
    const filterBtn = document.getElementById('filterBtn');
    const filterDropdown = document.getElementById('filterDropdown');
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');
    const applyFiltersBtn = document.getElementById('applyFilters');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const selectedFiltersDiv = document.getElementById('selectedFilters');

    // Filter state
    let activeFilters = {
        skills: [],
        priceMin: null,
        priceMax: null,
        search: ''
    };

    // Skills slider functionality
    let currentSlide = 0;
    const skillsSlides = document.querySelectorAll('.skills-slide');
    const totalSlides = skillsSlides.length;
    const skillsSlider = document.getElementById('skillsSlider');
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    const indicators = document.querySelectorAll('.slide-indicator');

    // Talent slider functionality
    let currentTalentSlide = 0;
    const talentSlides = document.querySelectorAll('.talent-slide');
    const totalTalentSlides = talentSlides.length;
    const talentSlider = document.getElementById('talentSlider');

    // Skills slider functions
    function updateSkillsSlider() {
        if (!skillsSlider) return;

        const translateX = -currentSlide * 100;
        skillsSlider.style.transform = `translateX(${translateX}%)`;

        // Update navigation buttons
        if (prevBtn) {
            prevBtn.classList.toggle('disabled', currentSlide === 0);
        }
        if (nextBtn) {
            nextBtn.classList.toggle('disabled', currentSlide === totalSlides - 1);
        }

        // Update indicators
        indicators.forEach((indicator, index) => {
            if (indicator) {
                indicator.classList.toggle('active', index === currentSlide);
            }
        });
    }

    function nextSkillsSlide() {
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            updateSkillsSlider();
        }
    }

    function prevSkillsSlide() {
        if (currentSlide > 0) {
            currentSlide--;
            updateSkillsSlider();
        }
    }

    // Talent slider functions
    function updateTalentSlider() {
        if (!talentSlider) return;

        const translateX = -currentTalentSlide * 100;
        talentSlider.style.transform = `translateX(${translateX}%)`;

        // Update pagination buttons
        const paginationBtns = document.querySelectorAll('.talent-pagination button[data-page]');
        paginationBtns.forEach((btn, index) => {
            if (btn) {
                btn.classList.toggle('active', index === currentTalentSlide);
            }
        });

        // Update prev/next buttons
        const prevPageBtn = document.getElementById('prevPageBtn');
        const nextPageBtn = document.getElementById('nextPageBtn');
        if (prevPageBtn) {
            prevPageBtn.disabled = currentTalentSlide === 0;
        }
        if (nextPageBtn) {
            nextPageBtn.disabled = currentTalentSlide === totalTalentSlides - 1;
        }
    }

    function nextTalentSlide() {
        if (currentTalentSlide < totalTalentSlides - 1) {
            currentTalentSlide++;
            updateTalentSlider();
        }
    }

    function prevTalentSlide() {
        if (currentTalentSlide > 0) {
            currentTalentSlide--;
            updateTalentSlider();
        }
    }

    function goToTalentSlide(slideIndex) {
        if (slideIndex >= 0 && slideIndex < totalTalentSlides) {
            currentTalentSlide = slideIndex;
            updateTalentSlider();
        }
    }

    // Filter dropdown functions
    function toggleFilterDropdown() {
        if (filterDropdown && filterBtn) {
            const isOpen = filterDropdown.classList.contains('show');

            // Close all dropdowns first
            document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
            document.querySelectorAll('.filter-button').forEach(btn => {
                btn.classList.remove('open');
            });

            if (!isOpen) {
                filterDropdown.classList.add('show');
                filterBtn.classList.add('open');
            }
        }
    }

    function applyAllFilters() {
        // Get price values and handle empty strings
        const minPriceValue = minPriceInput ? minPriceInput.value.trim() : '';
        const maxPriceValue = maxPriceInput ? maxPriceInput.value.trim() : '';
        
        const minPrice = minPriceValue !== '' ? parseInt(minPriceValue) : null;
        const maxPrice = maxPriceValue !== '' ? parseInt(maxPriceValue) : null;

        // Validate price range
        if (minPrice !== null && maxPrice !== null && minPrice > maxPrice) {
            alert('Minimum price cannot be greater than maximum price');
            return;
        }

        activeFilters.priceMin = minPrice;
        activeFilters.priceMax = maxPrice;

        console.log('Applying filters:', activeFilters); // Debug log

        applyFilters();
        updateSelectedFilters();
        updateFilterButtonState();

        // Close dropdown
        if (filterDropdown && filterBtn) {
            filterDropdown.classList.remove('show');
            filterBtn.classList.remove('open');
        }
    }

    function clearAllFiltersFromDropdown() {
        // Clear price inputs
        if (minPriceInput) minPriceInput.value = '';
        if (maxPriceInput) maxPriceInput.value = '';

        // Clear all filter states
        activeFilters = {
            skills: [],
            priceMin: null,
            priceMax: null,
            search: ''
        };

        // Clear UI elements
        document.querySelectorAll('.skill-card').forEach(card => {
            card.classList.remove('active');
        });

        if (searchInput) searchInput.value = '';

        // Apply filters (show all)
        applyFilters();
        updateSelectedFilters();
        updateFilterButtonState();
    }

    function updateFilterButtonState() {
        if (!filterBtn) return;

        const hasActiveFilters = activeFilters.skills.length > 0 || 
                                activeFilters.priceMin !== null || 
                                activeFilters.priceMax !== null || 
                                activeFilters.search;

        if (hasActiveFilters) {
            filterBtn.classList.add('active');
        } else {
            filterBtn.classList.remove('active');
        }
    }

    // Filter application function
    function applyFilters() {
        const cards = document.querySelectorAll('.talent-card[data-name]');
        let visibleCount = 0;

        console.log('Filter state:', activeFilters); // Debug log
        console.log('Total cards found:', cards.length); // Debug log

        cards.forEach((card, index) => {
            let show = true;

            // Filter by skills/categories
            if (activeFilters.skills.length > 0) {
                const cardCategory = (card.getAttribute('data-category') || '').toLowerCase();
                const cardSkills = (card.getAttribute('data-skills') || '').toLowerCase();

                const hasMatchingSkill = activeFilters.skills.some(skill =>
                    cardCategory.includes(skill.toLowerCase()) ||
                    cardSkills.includes(skill.toLowerCase())
                );

                if (!hasMatchingSkill) {
                    show = false;
                }
            }

            // Filter by price range
            if (show && (activeFilters.priceMin !== null || activeFilters.priceMax !== null)) {
                const cardPriceAttr = card.getAttribute('data-price');
                const cardPrice = cardPriceAttr ? parseInt(cardPriceAttr) : 0;

                console.log(`Card ${index + 1} price:`, cardPrice, 'Min:', activeFilters.priceMin, 'Max:', activeFilters.priceMax);

                if (activeFilters.priceMin !== null && cardPrice < activeFilters.priceMin) {
                    console.log(`Card ${index + 1} filtered out: price ${cardPrice} < min ${activeFilters.priceMin}`);
                    show = false;
                }
                if (activeFilters.priceMax !== null && cardPrice > activeFilters.priceMax) {
                    console.log(`Card ${index + 1} filtered out: price ${cardPrice} > max ${activeFilters.priceMax}`);
                    show = false;
                }
            }

            // Filter by search term
            if (show && activeFilters.search) {
                const name = (card.getAttribute('data-name') || '').toLowerCase();
                const skills = (card.getAttribute('data-skills') || '').toLowerCase();
                const category = (card.getAttribute('data-category') || '').toLowerCase();
                const searchTerm = activeFilters.search.toLowerCase();

                if (!name.includes(searchTerm) && !skills.includes(searchTerm) && !category.includes(searchTerm)) {
                    show = false;
                }
            }

            if (show) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        console.log('Visible cards:', visibleCount); // Debug log
        showNoResultsMessage(visibleCount === 0);
        
        // Reset to first slide if current slide has no visible cards
        if (visibleCount > 0) {
            currentTalentSlide = 0;
            updateTalentSlider();
        }
    }

    // Update selected filters display
    function updateSelectedFilters() {
        if (!selectedFiltersDiv) return;

        let filterTags = [];

        // Add skill filters
        activeFilters.skills.forEach(skill => {
            filterTags.push({
                type: 'skill',
                value: skill,
                display: skill.charAt(0).toUpperCase() + skill.slice(1),
                onRemove: () => removeSkillFilter(skill)
            });
        });

        // Add price filter
        if (activeFilters.priceMin !== null || activeFilters.priceMax !== null) {
            let priceDisplay = 'Price: ';
            if (activeFilters.priceMin !== null && activeFilters.priceMax !== null) {
                priceDisplay += `Rp${activeFilters.priceMin.toLocaleString()} - Rp${activeFilters.priceMax.toLocaleString()}`;
            } else if (activeFilters.priceMin !== null) {
                priceDisplay += `Min Rp${activeFilters.priceMin.toLocaleString()}`;
            } else {
                priceDisplay += `Max Rp${activeFilters.priceMax.toLocaleString()}`;
            }

            filterTags.push({
                type: 'price',
                value: 'price',
                display: priceDisplay,
                onRemove: removePriceFilter
            });
        }

        // Add search filter
        if (activeFilters.search) {
            filterTags.push({
                type: 'search',
                value: 'search',
                display: `Search: "${activeFilters.search}"`,
                onRemove: removeSearchFilter
            });
        }

        if (filterTags.length > 0) {
            selectedFiltersDiv.style.display = 'flex';
            selectedFiltersDiv.innerHTML = filterTags.map(tag => `
                <div class="filter-tag" data-type="${tag.type}" data-value="${tag.value}">
                    ${tag.display}
                    <span class="filter-tag-close" onclick="removeFilter('${tag.type}', '${tag.value}')">&times;</span>
                </div>
            `).join('') + `
                <button class="clear-filters-btn" onclick="clearAllFilters()">Clear All</button>
            `;
        } else {
            selectedFiltersDiv.style.display = 'none';
        }
    }

    // Filter removal functions
    function removeSkillFilter(skill) {
        activeFilters.skills = activeFilters.skills.filter(s => s !== skill);

        // Remove active state from skill card
        const skillCards = document.querySelectorAll('.skill-card');
        skillCards.forEach(card => {
            if (card.getAttribute('data-skill') === skill) {
                card.classList.remove('active');
            }
        });

        applyFilters();
        updateSelectedFilters();
        updateFilterButtonState();
    }

    function removePriceFilter() {
        activeFilters.priceMin = null;
        activeFilters.priceMax = null;

        if (minPriceInput) minPriceInput.value = '';
        if (maxPriceInput) maxPriceInput.value = '';

        applyFilters();
        updateSelectedFilters();
        updateFilterButtonState();
    }

    function removeSearchFilter() {
        activeFilters.search = '';
        if (searchInput) searchInput.value = '';

        applyFilters();
        updateSelectedFilters();
        updateFilterButtonState();
    }

    // Global function to remove individual filters
    window.removeFilter = function(type, value) {
        switch(type) {
            case 'skill':
                removeSkillFilter(value);
                break;
            case 'price':
                removePriceFilter();
                break;
            case 'search':
                removeSearchFilter();
                break;
        }
    };

    // Global function to clear all filters
    window.clearAllFilters = function() {
        clearAllFiltersFromDropdown();
    };

    // Search functionality
    function performSearch(query) {
        activeFilters.search = query;
        applyFilters();
        updateSelectedFilters();
        updateFilterButtonState();
    }

    // Show no results message
    function showNoResultsMessage(show) {
        let existingMessage = document.querySelector('.no-results');

        if (show && !existingMessage) {
            const noResultsDiv = document.createElement('div');
            noResultsDiv.className = 'no-results';
            noResultsDiv.innerHTML = `
                <div style="font-size: 3rem; margin-bottom: 1rem;">
                    <iconify-icon icon="material-symbols:search-off"></iconify-icon>
                </div>
                <h3 style="margin-bottom: 0.5rem; color: #1e293b;">No talents found</h3>
                <p>Try adjusting your search or filter criteria</p>
                <button onclick="clearAllFilters()" style="margin-top: 1rem; padding: 0.5rem 1rem; background: #38C1B9; color: white; border: none; border-radius: 6px; cursor: pointer;">Clear Filters</button>
            `;
            const container = document.querySelector('.talent-slider-container');
            if (container) {
                container.appendChild(noResultsDiv);
            }
        } else if (!show && existingMessage) {
            existingMessage.remove();
        }
    }

    // Event listeners for skills slider
    if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            nextSkillsSlide();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            prevSkillsSlide();
        });
    }

    // Indicator event listeners
    indicators.forEach((indicator, index) => {
        if (indicator) {
            indicator.addEventListener('click', function(e) {
                e.preventDefault();
                currentSlide = index;
                updateSkillsSlider();
            });
        }
    });

    // Filter dropdown event listeners
    if (filterBtn) {
        filterBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleFilterDropdown();
        });
    }

    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', function(e) {
            e.preventDefault();
            applyAllFilters();
        });
    }

    // Price input event listeners for real-time validation
    if (minPriceInput) {
        minPriceInput.addEventListener('input', function() {
            const value = parseInt(this.value);
            if (value < 0) {
                this.value = '';
            }
        });
    }

    if (maxPriceInput) {
        maxPriceInput.addEventListener('input', function() {
            const value = parseInt(this.value);
            if (value < 0) {
                this.value = '';
            }
        });
    }

    // Allow Enter key to apply filters
    if (minPriceInput) {
        minPriceInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyAllFilters();
            }
        });
    }

    if (maxPriceInput) {
        maxPriceInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                applyAllFilters();
            }
        });
    }

    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function(e) {
            e.preventDefault();
            clearAllFiltersFromDropdown();
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.filter-button')) {
            document.querySelectorAll('.filter-dropdown').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
            document.querySelectorAll('.filter-button').forEach(btn => {
                btn.classList.remove('open');
            });
        }
    });

    // Pagination event listeners
    const paginationBtns = document.querySelectorAll('.talent-pagination button[data-page]');
    paginationBtns.forEach(btn => {
        if (btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const page = parseInt(this.getAttribute('data-page'));
                if (!isNaN(page)) {
                    goToTalentSlide(page);
                }
            });
        }
    });

    // Prev/Next pagination buttons
    const prevPageBtn = document.getElementById('prevPageBtn');
    const nextPageBtn = document.getElementById('nextPageBtn');

    if (prevPageBtn) {
        prevPageBtn.addEventListener('click', function(e) {
            e.preventDefault();
            prevTalentSlide();
        });
    }

    if (nextPageBtn) {
        nextPageBtn.addEventListener('click', function(e) {
            e.preventDefault();
            nextTalentSlide();
        });
    }

    // Skill card and profile button event delegation
    document.addEventListener('click', function(e) {
        // Handle skill card clicks
        const skillCard = e.target.closest('.skill-card');
        if (skillCard) {
            e.preventDefault();
            const skillName = skillCard.getAttribute('data-skill');

            if (skillName) {
                const isActive = skillCard.classList.contains('active');

                if (isActive) {
                    // Remove skill from active filters
                    skillCard.classList.remove('active');
                    activeFilters.skills = activeFilters.skills.filter(s => s !== skillName);
                } else {
                    // Add skill to active filters
                    skillCard.classList.add('active');
                    if (!activeFilters.skills.includes(skillName)) {
                        activeFilters.skills.push(skillName);
                    }
                }

                applyFilters();
                updateSelectedFilters();
                updateFilterButtonState();
            }
        }

        // Handle profile button clicks
        if (e.target.classList.contains('talent-profile-btn')) {
            e.preventDefault();
            const freelancerId = e.target.getAttribute('data-freelancer-id');

            if (freelancerId && freelancerId !== '0') {
                // Redirect to profile page with freelancer ID
                window.location.href = `/profile/${freelancerId}`;
            } else {
                console.error('Freelancer ID not found');
                alert('Cannot open profile - Freelancer ID not found');
            }
        }
    });

    // Initialize sliders
    updateSkillsSlider();
    updateTalentSlider();

    // Initialize filters
    applyFilters();
    updateSelectedFilters();
    updateFilterButtonState();

    // Override global search function from app layout
    window.performSearch = performSearch;
    window.searchItems = performSearch;

    console.log('Enhanced Dashboard with nested filters initialized successfully');
});
</script>
@endpush