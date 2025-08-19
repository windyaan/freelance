@extends('layouts.app')

@section('page-title', 'Client Dashboard')

@push('styles')
<style>
.client-dashboard .nav-item.client-active {
    background: var(--primary-color);
    color: white;
}

.client-dashboard .search-container {
    max-width: 450px;
}

.client-dashboard .navbar-brand {
    color: var(--primary-color);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Client-specific JavaScript
    console.log('Client dashboard loaded');
    
    // Initialize client-specific features
    if (typeof initClientDashboard === 'function') {
        initClientDashboard();
    }
});
</script>
@endpush

{{-- resources/views/layouts/freelancer.blade.php --}}
@extends('layouts.app')

@section('page-title', 'Freelancer Dashboard')

@push('styles')
<style>
.freelancer-dashboard .nav-item.freelancer-active {
    background: #1f7066;
    color: white;
}

.freelancer-dashboard .navbar-brand {
    color: var(--primary-color);
}

.freelancer-dashboard .earnings-card {
    background: linear-gradient(135deg, var(--primary-color), #1f7066);
    color: white;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Freelancer-specific JavaScript
    console.log('Freelancer dashboard loaded');
    
    // Initialize freelancer-specific features
    if (typeof initFreelancerDashboard === 'function') {
        initFreelancerDashboard();
    }
});
</script>
@endpush

{{-- resources/views/layouts/admin.blade.php --}}
@extends('layouts.app')

@section('page-title', 'Admin Panel')
@section('body-class', 'admin-layout')

@push('styles')
<style>
.admin-layout {
    background: var(--gray-100);
}

.admin-layout .navbar-brand {
    color: var(--danger-color);
}

.admin-layout .sidebar {
    background: var(--gray-900);
}

.admin-layout .nav-item {
    color: var(--gray-300);
}

.admin-layout .nav-item:hover {
    background: var(--gray-800);
    color: white;
}

.admin-layout .nav-item.active {
    background: var(--danger-color);
    color: white;
}
</style>
@endpush

{{-- resources/views/layouts/auth.blade.php --}}
@extends('layouts.core')

@section('body-class', 'auth-layout')
@section('container-class', 'auth-container')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            @include('components.ui.logo')
        </div>
        <div class="auth-content">
            {{ $slot ?? '' }}
            @yield('auth-content')
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.auth-layout {
    background: linear-gradient(135deg, var(--primary-color), #1f7066);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.auth-wrapper {
    width: 100%;
    max-width: 400px;
    padding: 2rem;
}

.auth-card {
    background: white;
    border-radius: var(--border-radius-xl);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
}

.auth-header {
    background: var(--gray-50);
    padding: 2rem;
    text-align: center;
    border-bottom: 1px solid var(--gray-200);
}

.auth-content {
    padding: 2rem;
}

@media (max-width: 640px) {
    .auth-wrapper {
        padding: 1rem;
        max-width: 100%;
    }
    
    .auth-card {
        border-radius: var(--border-radius-lg);
    }
}
</style>
@endpush