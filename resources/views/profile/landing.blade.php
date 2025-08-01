<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillMatch - Find Your Perfect Talent</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #38C1B9, #1F7066);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .landing-container {
            text-align: center;
            max-width: 600px;
            padding: 2rem;
        }

        .logo {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
        }

        .logo span {
            color: #e0f2f1;
        }

        .tagline {
            font-size: 1.2rem;
            margin-bottom: 3rem;
            color: #e0f2f1;
            line-height: 1.6;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            min-width: 150px;
        }

        .btn-primary {
            background: white;
            color: #38C1B9;
        }

        .btn-primary:hover {
            background: #f8fafc;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border-color: white;
        }

        .btn-secondary:hover {
            background: white;
            color: #38C1B9;
            transform: translateY(-2px);
        }

        .features {
            margin-top: 4rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .feature {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .feature-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .feature h3 {
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .feature p {
            color: #e0f2f1;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .logo {
                font-size: 2.5rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .features {
                grid-template-columns: 1fr;
                margin-top: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <h1 class="logo">skill<span>Match</span></h1>
        
        <p class="tagline">
            Connect with talented freelancers and find the perfect match for your projects. 
            From developers to designers, writers to videographers - discover your next collaboration.
        </p>
        
        <div class="cta-buttons">
            <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            <a href="#" class="btn btn-secondary">Learn More</a>
        </div>
        
        <div class="features">
            <div class="feature">
                <div class="feature-icon">🎯</div>
                <h3>Find Perfect Matches</h3>
                <p>Advanced filtering to find exactly the skills you need</p>
            </div>
            
            <div class="feature">
                <div class="feature-icon">💬</div>
                <h3>Easy Communication</h3>
                <p>Built-in chat system for seamless collaboration</p>
            </div>
            
            <div class="feature">
                <div class="feature-icon">⚡</div>
                <h3>Fast & Reliable</h3>
                <p>Quick project matching and reliable delivery</p>
            </div>
        </div>
    </div>
</body>
</html>