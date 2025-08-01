<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>SkillMatch - Sign Up</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
    <style>
        /* Salin semua CSS dari halaman login di sini agar konsisten */
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

        .form-input,
        .form-select {
            width: 100%;
            padding: 15px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
            background: white;
        }

        .form-input:focus,
        .form-select:focus {
            outline: none;
            border-color: #4ade80;
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

        .error-message {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .hero-content {
                position: relative;
                padding: 40px;
                text-align: center;
            }

            .hero-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="left-section">
        <div class="hero-content">
            <h2 class="hero-title">Jual Skillmu dan Buat Penawaran dengan berbagai Client</h2>
        </div>
        <div class="pagination">1 of 5</div>
    </div>

        <div class="right-section">
            <div class="signup-form">
                <div class="logo">
                    <h1><span class="skill">Skill</span><span class="match">Matchaaaaaaaaaaaaaaaaaaaaaaa</span></h1>
                </div>
                <h2 class="welcome-title">Welcome back</h2>
                <p class="welcome-subtitle">Already have account? <a href="{{ route('login') }}">Log In</a></p>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">NAMA</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                    @error('name')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">EMAIL</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
                    @error('email')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">PASSWORD</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                    @error('password')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">CONFIRM PASSWORD</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
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

                <button type="submit" class="btn-primary">Sign Up</button>
            </form>

            <div class="divider">
                <span>or</span>
            </div>

            <button class="btn-google">
                <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google" style="width: 20px; height: 20px;">
                Sign up with Google
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
