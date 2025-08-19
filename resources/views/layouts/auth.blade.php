@extends('layouts.core')

@section('title', 'Authentication - SkillMatch')

@section('body')
<div class="auth-container">
    <div class="auth-background">
        <div class="auth-overlay"></div>
    </div>
    
    <div class="auth-content">
        <div class="auth-brand">
            <h1 class="brand-title">Skill<span>Match</span></h1>
            <p class="brand-subtitle">Connect with talented professionals</p>
        </div>
        
        <div class="auth-card">
            @yield('content')
        </div>
        
        <div class="auth-footer">
            <p>&copy; {{ date('Y') }} SkillMatch. All rights reserved.</p>
        </div>
    </div>
</div>

@push('styles')
<style>
    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        overflow-x: hidden;
    }

    .auth-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
        position: relative;
    }

    .auth-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(120, 119, 198, 0.2) 0%, transparent 50%);
    }

    .auth-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(1px);
    }

    .auth-content {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    .auth-brand {
        margin-bottom: 2rem;
    }

    .brand-title {
        font-size: 3rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        letter-spacing: -1px;
    }

    .brand-title span {
        color: #f0f9ff;
    }

    .brand-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        font-weight: 400;
        text-shadow: 0 1px 5px rgba(0, 0, 0, 0.3);
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 3rem 2rem;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        margin-bottom: 2rem;
        text-align: left;
    }

    .auth-footer {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.85rem;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-input {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #fafbfc;
        color: var(--text-primary);
    }

    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        background: white;
        box-shadow: 0 0 0 4px rgba(56, 193, 185, 0.1);
        transform: translateY(-1px);
    }

    .form-input::placeholder {
        color: var(--text-muted);
    }

    .form-checkbox {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .checkbox-input {
        width: 18px;
        height: 18px;
        accent-color: var(--primary-color);
    }

    .checkbox-label {
        font-size: 0.9rem;
        color: var(--text-secondary);
        cursor: pointer;
    }

    .form-button {
        width: 100%;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .form-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(56, 193, 185, 0.4);
    }

    .form-button:active {
        transform: translateY(0);
    }

    .form-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .form-button:hover::before {
        left: 100%;
    }

    .auth-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .auth-link:hover {
        color: var(--primary-hover);
        text-decoration: none;
    }

    .auth-divider {
        display: flex;
        align-items: center;
        margin: 2rem 0;
    }

    .auth-divider::before,
    .auth-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border-color);
    }

    .auth-divider span {
        padding: 0 1rem;
        color: var(--text-muted);
        font-size: 0.9rem;
        background: white;
    }

    .social-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .social-btn {
        flex: 1;
        padding: 0.75rem;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        background: white;
        color: var(--text-secondary);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .social-btn:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
        transform: translateY(-1px);
        text-decoration: none;
    }

    .error-message {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        border-left: 4px solid #dc2626;
    }

    .success-message {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        border-left: 4px solid #059669;
    }

    /* Animation */
    .auth-card {
        animation: slideUp 0.6s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 640px) {
        .auth-container {
            padding: 1rem 0.5rem;
        }

        .auth-content {
            max-width: 100%;
        }

        .auth-card {
            padding: 2rem 1.5rem;
            border-radius: 16px;
        }

        .brand-title {
            font-size: 2.5rem;
        }

        .brand-subtitle {
            font-size: 1rem;
        }

        .social-buttons {
            flex-direction: column;
        }
    }

    @media (max-width: 480px) {
        .brand-title {
            font-size: 2rem;
        }

        .auth-card {
            padding: 1.5rem 1rem;
        }

        .form-input,
        .form-button {
            padding: 0.875rem 1rem;
            font-size: 0.95rem;
        }
    }
</style>
@endpush
@endsection