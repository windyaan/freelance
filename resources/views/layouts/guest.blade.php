@extends('layouts.core')

@section('title', 'Welcome to SkillMatch')

@section('body')
<div class="guest-container">
    <!-- Navigation -->
    <nav class="guest-nav">
        <div class="nav-content">
            <div class="nav-brand">
                <h1>Skill<span>Match</span></h1>
            </div>
            
            <div class="nav-menu">
                <a href="#features" class="nav-link">Features</a>
                <a href="#how-it-works" class="nav-link">How It Works</a>
                <a href="#pricing" class="nav-link">Pricing</a>
            </div>
            
            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn btn-ghost">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
            </div>
            
            <!-- Mobile menu toggle -->
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
        
        <!-- Mobile menu -->
        <div class="mobile-menu" id="mobileMenu">
            <a href="#features" class="mobile-nav-link">Features</a>
            <a href="#how-it-works" class="mobile-nav-link">How It Works</a>
            <a href="#pricing" class="mobile-nav-link">Pricing</a>
            <div class="mobile-nav-actions">
                <a href="{{ route('login') }}" class="btn btn-ghost">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="guest-main">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="guest-footer">
        <div class="footer-content">
            <div class="footer-brand">
                <h3>Skill<span>Match</span></h3>
                <p>Connecting talents with opportunities worldwide.</p>
            </div>
            
            <div class="footer-links">
                <div class="footer-column">
                    <h4>Platform</h4>
                    <a href="#">Find Talent</a>
                    <a href="#">Find Work</a>
                    <a href="#">Enterprise</a>
                </div>
                
                <div class="footer-column">
                    <h4>Support</h4>
                    <a href="#">Help Center</a>
                    <a href="#">Contact Us</a>
                    <a href="#">Community</a>
                </div>
                
                <div class="footer-column">
                    <h4>Company</h4>
                    <a href="#">About Us</a>
                    <a href="#">Careers</a>
                    <a href="#">Press</a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} SkillMatch. All rights reserved.</p>
        </div>
    </footer>
</div>

@push('styles')
<style>
    body {
        background: white;
        overflow-x: hidden;
    }

    .guest-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* Navigation */
    .guest-nav {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        z-index: 1000;
        transition: all 0.3s ease;
    }

    .nav-content {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 2rem;
        height: 70px;
    }

    .nav-brand h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .nav-brand span {
        color: var(--text-primary);
    }

    .nav-menu {
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .nav-link {
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
        position: relative;
    }

    .nav-link:hover {
        color: var(--primary-color);
        text-decoration: none;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--primary-color);
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    .nav-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .btn-ghost {
        background: transparent;
        color: var(--text-secondary);
        border: 2px solid transparent;
    }

    .btn-ghost:hover {
        color: var(--primary-color);
        border-color: var(--primary-color);
        background: rgba(56, 193, 185, 0.05);
    }

    /* Mobile Menu */
    .mobile-menu-toggle {
        display: none;
        flex-direction: column;
        cursor: pointer;
        width: 24px;
        height: 18px;
        justify-content: space-between;
        background: none;
        border: none;
    }

    .mobile-menu-toggle span {
        width: 100%;
        height: 2px;
        background: var(--text-secondary);
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    .mobile-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border-top: 1px solid var(--border-color);
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }

    .mobile-menu.show {
        display: block;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .mobile-nav-link {
        display: block;
        padding: 1rem 0;
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 500;
        border-bottom: 1px solid var(--border-light);
        transition: all 0.2s ease;
    }

    .mobile-nav-link:hover {
        color: var(--primary-color);
        text-decoration: none;
        padding-left: 1rem;
    }

    .mobile-nav-actions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 2rem;
    }

    /* Main Content */
    .guest-main {
        flex: 1;
        padding-top: 70px;
    }

    /* Hero Section Styles */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 6rem 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 800px;
        margin: 0 auto;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        line-height: 1.1;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .hero-subtitle {
        font-size: 1.25rem;
        margin-bottom: 3rem;
        opacity: 0.9;
        line-height: 1.6;
    }

    .hero-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .hero-actions .btn {
        padding: 1rem 2rem;
        font-size: 1.1rem;
        min-width: 180px;
    }

    /* Content Sections */
    .content-section {
        padding: 6rem 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        text-align: center;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .section-subtitle {
        font-size: 1.1rem;
        text-align: center;
        margin-bottom: 4rem;
        color: var(--text-secondary);
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 3rem;
        margin-top: 4rem;
    }

    .feature-card {
        text-align: center;
        padding: 2rem;
        border-radius: 20px;
        background: var(--bg-primary);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-light);
        transition: all 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin: 0 auto 2rem;
    }

    .feature-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
    }

    .feature-description {
        color: var(--text-secondary);
        line-height: 1.6;
    }

    /* Footer */
    .guest-footer {
        background: var(--text-primary);
        color: white;
        padding: 4rem 2rem 2rem;
    }

    .footer-content {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 3rem;
    }

    .footer-brand h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: var(--primary-color);
    }

    .footer-brand span {
        color: white;
    }

    .footer-brand p {
        color: rgba(255, 255, 255, 0.7);
        line-height: 1.6;
    }

    .footer-column h4 {
        margin-bottom: 1rem;
        color: white;
    }

    .footer-column a {
        display: block;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
    }

    .footer-column a:hover {
        color: var(--primary-color);
        text-decoration: none;
        padding-left: 0.5rem;
    }

    .footer-bottom {
        max-width: 1200px;
        margin: 2rem auto 0;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
        color: rgba(255, 255, 255, 0.7);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .nav-menu {
            display: none;
        }

        .mobile-menu-toggle {
            display: flex;
        }

        .footer-content {
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }
    }

    @media (max-width: 768px) {
        .nav-content {
            padding: 1rem;
        }

        .nav-actions {
            display: none;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .hero-actions {
            flex-direction: column;
            align-items: center;
        }

        .hero-actions .btn {
            width: 100%;
            max-width: 300px;
        }

        .content-section {
            padding: 4rem 1rem;
        }

        .section-title {
            font-size: 2rem;
        }

        .features-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .footer-content {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 2rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenu.classList.toggle('show');
                
                // Animate toggle button
                const spans = mobileMenuToggle.querySelectorAll('span');
                if (mobileMenu.classList.contains('show')) {
                    spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                    spans[1].style.opacity = '0';
                    spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
                } else {
                    spans.forEach(span => {
                        span.style.transform = '';
                        span.style.opacity = '';
                    });
                }
            });
        }

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Close mobile menu if open
                    if (mobileMenu && mobileMenu.classList.contains('show')) {
                        mobileMenu.classList.remove('show');
                        const spans = mobileMenuToggle.querySelectorAll('span');
                        spans.forEach(span => {
                            span.style.transform = '';
                            span.style.opacity = '';
                        });
                    }
                }
            });
        });

        // Navbar scroll effect
        let lastScroll = 0;
        const navbar = document.querySelector('.guest-nav');
        
        window.addEventListener('scroll', () => {
            const currentScroll = window.pageYOffset;
            
            if (currentScroll > 100) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = 'none';
            }
            
            // Hide/show navbar on scroll
            if (currentScroll > lastScroll && currentScroll > 200) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
            
            lastScroll = currentScroll;
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.feature-card, .content-section').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s ease';
            observer.observe(el);
        });

        console.log('Guest layout loaded');
    });
</script>
@endpush
@endsection