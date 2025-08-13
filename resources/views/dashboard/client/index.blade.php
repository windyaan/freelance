@extends('layouts.client')

@section('title', 'Dashboard - SkillMatch')

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

<style>
/* Previous CSS remains the same - keeping it short for space */
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

.skills-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
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
    border: 1px solid #e2e8f0;
    border-radius: 50%;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    color: #64748b;
    font-size: 1.2rem;
    font-weight: bold;
    z-index: 10;
    backdrop-filter: blur(8px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.slider-nav:hover {
    background: #38C1B9;
    color: white;
    border-color: #38C1B9;
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
    background: #38C1B9;
    transform: scale(1.2);
    box-shadow: 0 2px 8px rgba(56, 193, 185, 0.4);
}

.slide-indicator:hover {
    background: #94a3b8;
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
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    position: relative;
}

.skill-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.skill-card.active {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    background: rgba(56, 193, 185, 0.1);
    border-color: #38C1B9;
}

.skill-card.active .skill-icon {
    background: #38C1B9 !important;
    color: white !important;
    box-shadow: 0 6px 20px rgba(56, 193, 185, 0.4) !important;
}

.skill-card.active .skill-name {
    color: #38C1B9 !important;
    font-weight: 600 !important;
}

.skill-card.active::after {
    content: '✓';
    position: absolute;
    top: -8px;
    right: -8px;
    background: #38C1B9;
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

.skill-card[data-skill="videographer"]:hover,
.skill-card[data-skill="video editor"]:hover,
.skill-card[data-skill="photographer"]:hover {
    background: rgba(116, 204, 205, 0.1);
    border-color: rgba(116, 204, 205, 0.3);
}

.skill-card[data-skill="videographer"] .skill-icon,
.skill-card[data-skill="video editor"] .skill-icon,
.skill-card[data-skill="photographer"] .skill-icon {
    background: linear-gradient(135deg, #74CCCD, #5fb4b5);
    box-shadow: 0 4px 12px rgba(116, 204, 205, 0.3);
}

.skill-card[data-skill="content writing"]:hover,
.skill-card[data-skill="copywriting"]:hover,
.skill-card[data-skill="translator"]:hover {
    background: rgba(40, 160, 148, 0.1);
    border-color: rgba(40, 160, 148, 0.3);
}

.skill-card[data-skill="content writing"] .skill-icon,
.skill-card[data-skill="copywriting"] .skill-icon,
.skill-card[data-skill="translator"] .skill-icon {
    background: linear-gradient(135deg, #28A094, #1f8a7e);
    box-shadow: 0 4px 12px rgba(40, 160, 148, 0.3);
}

.skill-card[data-skill="ui design"]:hover,
.skill-card[data-skill="front-end"]:hover,
.skill-card[data-skill="back-end"]:hover,
.skill-card[data-skill="fullstack"]:hover {
    background: rgba(31, 112, 102, 0.1);
    border-color: rgba(31, 112, 102, 0.3);
}

.skill-card[data-skill="ui design"] .skill-icon,
.skill-card[data-skill="front-end"] .skill-icon,
.skill-card[data-skill="back-end"] .skill-icon,
.skill-card[data-skill="fullstack"] .skill-icon {
    background: linear-gradient(135deg, #1F7066, #196e63);
    box-shadow: 0 4px 12px rgba(31, 112, 102, 0.3);
}

.skill-card[data-skill="graphic design"]:hover,
.skill-card[data-skill="illustrator"]:hover {
    background: rgba(27, 98, 91, 0.1);
    border-color: rgba(27, 98, 91, 0.3);
}

.skill-card[data-skill="graphic design"] .skill-icon,
.skill-card[data-skill="illustrator"] .skill-icon {
    background: linear-gradient(135deg, #1B625B, #155751);
    box-shadow: 0 4px 12px rgba(27, 98, 91, 0.3);
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
}

.skill-name {
    font-weight: 500;
    color: #64748b;
    font-size: 0.8rem;
    text-align: center;
    line-height: 1.3;
    transition: all 0.3s ease;
}

/* NEW: Filters Section */
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
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    cursor: pointer;
    font-size: 0.9rem;
    font-weight: 500;
    color: #64748b;
    transition: all 0.2s ease;
    position: relative;
}

.filter-button:hover {
    border-color: #38C1B9;
    color: #38C1B9;
    background: #f8fafc;
}

.filter-button.active {
    border-color: #38C1B9;
    background: #38C1B9;
    color: white;
}

.filter-button.active .filter-arrow {
    color: white;
}

.filter-arrow {
    font-size: 0.8rem;
    transition: transform 0.2s ease;
}

.filter-button.open .filter-arrow {
    transform: rotate(180deg);
}

/* Price Filter Dropdown */
.price-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    margin-top: 8px;
    padding: 1.5rem;
    min-width: 300px;
    z-index: 1000;
    display: none;
}

.price-dropdown.show {
    display: block;
}

.price-inputs {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.price-input-group {
    flex: 1;
}

.price-label {
    display: block;
    font-size: 0.8rem;
    font-weight: 500;
    color: #64748b;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
}

.price-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 0.9rem;
    outline: none;
    transition: border-color 0.2s ease;
}

.price-input:focus {
    border-color: #38C1B9;
}

.price-apply-btn {
    background: #38C1B9;
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    width: 100%;
    transition: all 0.2s ease;
}

.price-apply-btn:hover {
    background: #2da89f;
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
    background: #38C1B9;
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
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    color: #64748b;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.clear-filters-btn:hover {
    border-color: #38C1B9;
    color: #38C1B9;
    background: #f8fafc;
}

.talents-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #f1f5f9;
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
    background: white;
    border-radius: 16px;
    padding: 2rem;
    position: relative;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    display: flex;
    flex-direction: column;
    min-height: 320px;
    height: 100%;
}

.talent-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border-color: #38C1B9;
}

.talent-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.talent-skill-badge {
    background: #38C1B9;
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
    color: #1e293b;
    text-align: right;
    line-height: 1.2;
}

.talent-description {
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
    flex-grow: 1;
    min-height: 60px;
    display: flex;
    align-items: flex-start;
}

.talent-project-link {
    color: #38C1B9;
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
    color: #38C1B9;
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
    background: #64748b;
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
    background: #475569;
    transform: translateY(-1px);
}

.talent-nav {
    display: none !important;
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
    border: 1px solid #e2e8f0;
    background: white;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    color: #64748b;
    transition: all 0.2s ease;
}

.talent-pagination button:hover {
    border-color: #38C1B9;
    color: #38C1B9;
}

.talent-pagination button.active {
    background: #38C1B9;
    color: white;
    border-color: #38C1B9;
}

.talent-pagination button:disabled {
    opacity: 0.4;
    cursor: not-allowed;
    pointer-events: none;
}

.no-results {
    text-align: center;
    padding: 3rem;
    color: #64748b;
    font-size: 1.1rem;
    grid-column: 1 / -1;
}

/* Responsive */
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

    .talent-slide {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    .skills-slide {
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    .navbar-center {
        flex: 1.5;
        max-width: 350px;
    }

    .search-container {
        max-width: 320px;
    }

    .filters-section {
        flex-wrap: wrap;
        gap: 0.8rem;
    }

    .filter-button {
        padding: 0.6rem 1.2rem;
        font-size: 0.85rem;
    }

    .price-dropdown {
        min-width: 250px;
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

    .skills-section,
    .talents-section {
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .main-content {
        padding: 1rem;
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

    .talent-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
    }

    .talent-price {
        text-align: center;
    }

    .talent-profile-btn {
        max-width: none;
    }

    .filters-section {
        gap: 0.5rem;
    }

    .filter-button {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }

    .price-dropdown {
        min-width: 200px;
        padding: 1rem;
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

    .selected-filters {
        justify-content: center;
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
        <!-- Updated navbar brand with Laravel route -->
        <a href="{{ route('client.dashboard') }}" class="navbar-brand">
            <div class="logo" style="margin-top: 60px;">
                <h1>Skill<span>Match</span></h1>
            </div>
        </a>
        <h1 class="navbar-title">Dashboard</h1>
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
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face" alt="Profile">
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
        <!-- Updated sidebar navigation with Laravel routes -->
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
        <!-- Updated navbar brand with Laravel route -->
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

    <!-- NEW: Filters Section -->
    <div class="filters-section">
        <div class="filter-button" id="filterBtn">
            <iconify-icon icon="material-symbols:tune"></iconify-icon>
            Filter
        </div>
        
        <div class="filter-button" id="priceBtn">
            <iconify-icon icon="material-symbols:payments"></iconify-icon>
            Price
            <span class="filter-arrow">▼</span>
            
            <!-- Price Filter Dropdown -->
            <div class="price-dropdown" id="priceDropdown">
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
                <button class="price-apply-btn" id="applyPriceFilter">Apply</button>
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
</div>

<script>
// Enhanced JavaScript code for Dashboard with Filters
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
    const searchResults = document.getElementById('searchResults');
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const priceBtn = document.getElementById('priceBtn');
    const priceDropdown = document.getElementById('priceDropdown');
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');
    const applyPriceBtn = document.getElementById('applyPriceFilter');
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

    // Prevent horizontal scroll
    if (document.body) {
        document.body.style.overflowX = 'hidden';
    }
    if (document.documentElement) {
        document.documentElement.style.overflowX = 'hidden';
    }

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

    // Price filter functions
    function togglePriceDropdown() {
        if (priceDropdown && priceBtn) {
            const isOpen = priceDropdown.classList.contains('show');
            
            // Close all dropdowns first
            document.querySelectorAll('.price-dropdown').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
            document.querySelectorAll('.filter-button').forEach(btn => {
                btn.classList.remove('open');
            });
            
            if (!isOpen) {
                priceDropdown.classList.add('show');
                priceBtn.classList.add('open');
            }
        }
    }

    function applyPriceFilter() {
        const minPrice = minPriceInput ? parseInt(minPriceInput.value) || null : null;
        const maxPrice = maxPriceInput ? parseInt(maxPriceInput.value) || null : null;
        
        activeFilters.priceMin = minPrice;
        activeFilters.priceMax = maxPrice;
        
        applyFilters();
        updateSelectedFilters();
        
        // Close dropdown
        if (priceDropdown && priceBtn) {
            priceDropdown.classList.remove('show');
            priceBtn.classList.remove('open');
        }
        
        // Update price button appearance
        if (priceBtn) {
            if (minPrice !== null || maxPrice !== null) {
                priceBtn.classList.add('active');
            } else {
                priceBtn.classList.remove('active');
            }
        }
    }

    // Filter application function
    function applyFilters() {
        const cards = document.querySelectorAll('.talent-card[data-name]');
        let visibleCount = 0;

        cards.forEach(card => {
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
                const cardPrice = parseInt(card.getAttribute('data-price')) || 0;
                
                if (activeFilters.priceMin !== null && cardPrice < activeFilters.priceMin) {
                    show = false;
                }
                if (activeFilters.priceMax !== null && cardPrice > activeFilters.priceMax) {
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

        showNoResultsMessage(visibleCount === 0);
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
    }

    function removePriceFilter() {
        activeFilters.priceMin = null;
        activeFilters.priceMax = null;
        
        if (minPriceInput) minPriceInput.value = '';
        if (maxPriceInput) maxPriceInput.value = '';
        if (priceBtn) priceBtn.classList.remove('active');
        
        applyFilters();
        updateSelectedFilters();
    }

    function removeSearchFilter() {
        activeFilters.search = '';
        if (searchInput) searchInput.value = '';
        
        applyFilters();
        updateSelectedFilters();
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

        if (minPriceInput) minPriceInput.value = '';
        if (maxPriceInput) maxPriceInput.value = '';
        if (priceBtn) priceBtn.classList.remove('active');
        if (searchInput) searchInput.value = '';

        // Apply filters (show all)
        applyFilters();
        updateSelectedFilters();
    };

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

    // Price filter event listeners
    if (priceBtn) {
        priceBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            togglePriceDropdown();
        });
    }

    if (applyPriceBtn) {
        applyPriceBtn.addEventListener('click', function(e) {
            e.preventDefault();
            applyPriceFilter();
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.filter-button')) {
            document.querySelectorAll('.price-dropdown').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
            document.querySelectorAll('.filter-button').forEach(btn => {
                btn.classList.remove('open');
            });
        }

        // Hide search results when clicking outside search
        if (!e.target.closest('.search-container')) {
            if (searchResults) {
                searchResults.classList.remove('show');
            }
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

    // Search functionality
    function performSearch(query) {
        activeFilters.search = query;
        
        if (!query || query.length < 2) {
            if (searchResults) {
                searchResults.classList.remove('show');
            }
            activeFilters.search = '';
            applyFilters();
            updateSelectedFilters();
            return;
        }

        const filtered = jobsData.filter(job => {
            const freelancerName = job.freelancer && job.freelancer.name ? job.freelancer.name.toLowerCase() : '';
            const category = job.category ? job.category.toLowerCase() : '';
            const title = job.title ? job.title.toLowerCase() : '';
            const searchTerm = query.toLowerCase();

            return freelancerName.includes(searchTerm) ||
                   category.includes(searchTerm) ||
                   title.includes(searchTerm);
        });

        displaySearchResults(filtered);
        applyFilters();
        updateSelectedFilters();
    }

    function displaySearchResults(results) {
        if (!searchResults) return;

        if (results.length === 0) {
            searchResults.innerHTML = '<div class="search-result-item">No results found</div>';
        } else {
            searchResults.innerHTML = results.map(job => {
                const freelancerName = job.freelancer && job.freelancer.name ? job.freelancer.name : 'Unknown';
                const category = job.category || 'General';
                const title = job.title || 'Untitled';

                return `
                    <div class="search-result-item" onclick="selectSearchResult('${freelancerName}', '${category}')">
                        <div class="search-result-name">${freelancerName}</div>
                        <div class="search-result-skills">${category} - ${title}</div>
                    </div>
                `;
            }).join('');
        }
        searchResults.classList.add('show');
    }

    // Search input event listeners
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length >= 2) {
                performSearch(query);
            } else if (query.length === 0) {
                activeFilters.search = '';
                applyFilters();
                updateSelectedFilters();
                if (searchResults) {
                    searchResults.classList.remove('show');
                }
            }
        });

        searchInput.addEventListener('focus', function() {
            const query = this.value.trim();
            if (query.length >= 2) {
                performSearch(query);
            }
        });

        // Enter key search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const query = this.value.trim();
                if (query) {
                    performSearch(query);
                    if (searchResults) {
                        searchResults.classList.remove('show');
                    }
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
                    performSearch(query);
                    if (searchResults) {
                        searchResults.classList.remove('show');
                    }
                }
            }
        });
    }

    // Global function for search result selection
    window.selectSearchResult = function(name, category) {
        if (searchInput) {
            searchInput.value = name;
            activeFilters.search = name;
            applyFilters();
            updateSelectedFilters();
        }
        if (searchResults) {
            searchResults.classList.remove('show');
        }
    };

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

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Arrow keys for skills slider when focused
        if (e.target.closest('.skills-section')) {
            if (e.key === 'ArrowLeft') {
                e.preventDefault();
                prevSkillsSlide();
            } else if (e.key === 'ArrowRight') {
                e.preventDefault();
                nextSkillsSlide();
            }
        }

        // Escape to clear search and close dropdowns
        if (e.key === 'Escape') {
            if (searchResults) {
                searchResults.classList.remove('show');
            }
            
            document.querySelectorAll('.price-dropdown').forEach(dropdown => {
                dropdown.classList.remove('show');
            });
            document.querySelectorAll('.filter-button').forEach(btn => {
                btn.classList.remove('open');
            });
            
            if (searchInput && searchInput.value) {
                searchInput.value = '';
                activeFilters.search = '';
                applyFilters();
                updateSelectedFilters();
            }
        }

        // Ctrl/Cmd + K to focus search
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
            }
        }
    });

    // Initialize sliders
    updateSkillsSlider();
    updateTalentSlider();

    // Initialize filters
    applyFilters();
    updateSelectedFilters();

    console.log('Enhanced Dashboard with filters initialized successfully');
});

// Logout confirmation function
function confirmLogout() {
    return confirm('Are you sure you want to log out?');
}

// Profile navigation function
function goToProfile() {
    // This function will be handled by the Blade template
    window.location.href = "/profile";
}
</script>
@endsection