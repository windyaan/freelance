<div class="top-navbar">
    <div class="navbar-left">
        @include('components.ui.sidebar-toggle')
        @include('components.ui.logo', ['route' => $dashboardRoute ?? 'dashboard'])
        <h1 class="navbar-title hidden-mobile">@yield('page-title', 'Dashboard')</h1>
    </div>
    
    <div class="navbar-center hidden-mobile">
        @include('components.search.search-bar')
    </div>
    
    <div class="navbar-right">
        @include('components.ui.profile-avatar')
        @include('components.buttons.logout-button')
    </div>
</div>

@push('styles')
<style>
.top-navbar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: var(--navbar-height);
    background: white;
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    align-items: center;
    padding: 0 2rem;
    z-index: 1001;
    box-shadow: var(--shadow-sm);
}

.navbar-left,
.navbar-center,
.navbar-right {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.navbar-left {
    flex: 1;
    min-width: 0;
}

.navbar-center {
    flex: 2;
    justify-content: center;
    max-width: 600px;
    margin: 0 auto;
}

.navbar-right {
    flex: 1;
    justify-content: flex-end;
}

.navbar-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-800);
    white-space: nowrap;
    margin-left: 2rem;
}

@media (max-width: 768px) {
    .top-navbar {
        padding: 0 1rem;
    }
    
    .navbar-title {
        margin-left: 1rem;
    }
}
</style>
@endpush

{{-- resources/views/partials/navigation/sidebar.blade.php --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<div class="sidebar" id="sidebar">
    <nav class="sidebar-nav">
        @yield('sidebar-content')
        @stack('sidebar-items')
    </nav>
</div>

@push('styles')
<style>
.sidebar {
    position: fixed;
    left: 0;
    top: var(--navbar-height);
    width: var(--sidebar-width);
    height: calc(100vh - var(--navbar-height));
    background: white;
    border-right: 1px solid var(--gray-200);
    z-index: 1000;
    padding: 1.5rem 0;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.08);
    transition: var(--transition-normal);
}

.sidebar-nav {
    height: 100%;
    display: flex;
    flex-direction: column;
}

.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    backdrop-filter: blur(4px);
}

@media (max-width: 1024px) {
    .sidebar {
        transform: translateX(-100%);
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
    
    .sidebar-overlay.show {
        display: block;
    }
}
</style>
@endpush