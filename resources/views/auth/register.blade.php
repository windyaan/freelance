<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillMatch - Sign Up</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
        }

        .container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .left-section {
            flex: 1;
            background: url('/images/gambar.jpg') no-repeat center center;
            background-size: cover;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            position: absolute;
            bottom: 60px;
            left: 40px;
            color: white;
            z-index: 2;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
        }

        .hero-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 10px;
        }

        .hero-author {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .pagination {
            position: absolute;
            bottom: 20px;
            left: 40px;
            color: white;
            font-size: 0.9rem;
        }



        .right-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .signup-form {
            width: 100%;
            max-width: 400px;
        }

        .logo {
            margin-bottom: 40px;
        }

        .logo h1 {
            font-size: 2rem;
            font-weight: 700;
        }

        .skill {
            color: #4ade80;
        }

        .match {
            color: #1f2937;
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .welcome-subtitle {
            color: #6b7280;
            margin-bottom: 30px;
        }

        .welcome-subtitle a {
            color: #4ade80;
            text-decoration: none;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 8px;
            text-transform: uppercase;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #4ade80;
        }

        .form-input::placeholder {
            color: #9ca3af;
        }

        .select-wrapper {
            position: relative;
        }

        .form-select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
            background: white;
            appearance: none;
            cursor: pointer;
        }

        .form-select:focus {
            outline: none;
            border-color: #4ade80;
        }

        .select-wrapper::after {
            content: '\f078';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            pointer-events: none;
        }
        .forgot-password {
            text-align: right;
            margin-bottom: 30px;
        }

        .forgot-password a {
            color: #4ade80;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-primary {
            width: 100%;
            background: #312e81;
            color: white;
            border: none;
            padding: 15px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-bottom: 20px;
        }

        .btn-primary:hover {
            background: #1e1b4b;
        }

        .btn-register {
            background: #4ade80;
            margin-bottom: 15px;
        }

        .btn-register:hover {
            background: #22c55e;
        }

        .divider {
            text-align: center;
            color: #6b7280;
            margin: 20px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
            z-index: 1;
        }

        .divider span {
            background: #f8f9fa;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }

        .btn-google {
            width: 100%;
            background: white;
            color: #1f2937;
            border: 2px solid #e5e7eb;
            padding: 15px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: border-color 0.3s;
            margin-bottom: 30px;
        }

        .btn-google:hover {
            border-color: #d1d5db;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .footer-links a {
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .footer-links a:hover {
            color: #4ade80;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left-section {
                min-height: 200px;
            }

            .hero-content {
                position: relative;
                bottom: auto;
                left: auto;
                padding: 40px;
                text-align: center;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .hero-image {
                display: none;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
            <div class="hero-content">
                <h2 class="hero-title">Jual Skillmu dan Buat Penawaran dengan berbagai Client</h2>
            </div>

            <div class="pagination">1 of 5</div>
        </div>

        <div class="right-section">
            <div class="signup-form">
                <div class="logo">
                    <h1><span class="skill">Skill</span><span class="match">Match</span></h1>
                </div>
                <h2 class="welcome-title">Welcome back</h2>
                <p class="welcome-subtitle">Already have account? <a href="{{ route('login') }}">Log In</a></p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- NAME --}}
                    <div class="form-group">
                        <label class="form-label" for="name">NAMA</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-input"
                            placeholder="Your name"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="form-group">
                        <label class="form-label" for="email">EMAIL</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input"
                            placeholder="Your email"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- PASSWORD --}}
                    <div class="form-group">
                        <label class="form-label" for="password">PASSWORD</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="Enter your password"
                            required
                        >
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">CONFIRM PASSWORD</label>
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="Re-enter your password"
                            required
                        >
                        @error('password_confirmation')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>


                    {{-- ROLE --}}
                    <div class="form-group">
                        <label class="form-label" for="role">REGISTER AS</label>
                        <div class="select-wrapper">
                            <select name="role" id="role" class="form-select" required>
                                <option value="">Choose role</option>
                                <option value="freelancer" {{ old('role') == 'freelancer' ? 'selected' : '' }}>Freelancer</option>
                                <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        @error('role')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- SUBMIT --}}
                    <button type="submit" class="btn-primary btn-register">Sign In</button>
                </form>

                <div class="divider">
                    <span>or</span>
                </div>

                <button class="btn-google">
                    <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" style="width: 20px; height: 20px;">
                    Sign in with Google
                </button>

                <div class="footer-links">
                    <a href="#">Customer Support</a>
                    <a href="#">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
