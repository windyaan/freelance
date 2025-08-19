@extends('layouts.core')

@section('body')
    <!-- Top Navigation -->
    <div class="top-navbar">
        <div class="navbar-left">
            <div class="sidebar-toggle" id="sidebarToggle" style="display: none;">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <a href="@yield('dashboard-route', route('dashboard'))" class="navbar-brand">
                Skill<span>Match</span>
            </a>
            <h1 class="navbar-title">@yield('page-title', 'Dashboard')</h1>
        </div>

        @hasSection('navbar-center')
            <div class="navbar-center">
                @yield('navbar-center')
            </div>
        @else
            <div class="navbar-center">
                @component('components.search')
                    @slot('placeholder', 'Search...')
                    @slot('action', '#')
                @endcomponent
            </div>
        @endif

        <div class="navbar-right">
            <a href="{{ route('profile.edit') }}" class="navbar-profile">
                @if(auth()->user()->avatar_url ?? false)
                    <img src="{{ auth()->user()->avatar_url }}" alt="Profile">
                @else
                    <iconify-icon icon="material-symbols:person"></iconify-icon>
                @endif
            </a>

            <form method="POST" action="{{ route('logout') }}" class="navbar-logout-form">
                @csrf
                <button type="submit" class="navbar-logout" onclick="return window.SkillMatch.confirmLogout()">
                    <iconify-icon icon="material-symbols:logout"></iconify-icon>
                    <span>Log Out</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <nav>
            @yield('navigation')
        </nav>
    </div>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchInput = document.getElementById('globalSearch');
            const searchBtn = document.getElementById('searchBtn');
            
            if (searchInput && searchBtn) {
                let searchTimeout;
                
                // Set up search with debounce
                const performSearch = (query) => {
                    console.log('App layout performing search:', query);
                    
                    // Try page-specific search functions
                    if (typeof window.performSearch === 'function') {
                        window.performSearch(query);
                    } else if (typeof window.searchItems === 'function') {
                        window.searchItems(query);
                    }
                };

                // Search input with debounce
                searchInput.addEventListener('input', function(e) {
                    const query = e.target.value.trim();
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        performSearch(query);
                    }, 300);
                });
                
                // Search button click
                searchBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const query = searchInput.value.trim();
                    clearTimeout(searchTimeout);
                    performSearch(query);
                });
                
                // Enter key search
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const query = e.target.value.trim();
                        clearTimeout(searchTimeout);
                        performSearch(query);
                    }
                });
            }
        });
    </script>
    @endpush
@endsection