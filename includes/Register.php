<?php
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Elevator X</title>

    <!-- Favicon -->
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

    <!-- Inline CSS for Styling -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #0f3460, #16537e, #1a252f);
            color: white;
            height: 100%;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Header Styles */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: transparent;
            backdrop-filter: none;
            color: white;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 100px;
            width: auto;
            transition: transform 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.1);
        }

        nav {
            display: flex;
            gap: 30px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        nav a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(30, 144, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        nav a:hover::before {
            left: 100%;
        }

        nav a:hover {
            background-color: #1e90ff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 144, 255, 0.4);
        }

        /* Main Container */
        .main-container {
            min-height: 100vh;
            padding: 150px 20px 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .content-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            max-width: 1200px;
            width: 100%;
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInUp 1s ease 0.3s forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Welcome Title */
        .welcome-title {
            font-size: clamp(32px, 6vw, 64px);
            margin-bottom: 20px;
            text-align: center;
            background: linear-gradient(45deg, #fff, #1e90ff);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: glow 2s ease-in-out infinite alternate;
            font-weight: bold;
        }

        .subtitle {
            font-size: clamp(18px, 3vw, 24px);
            margin-bottom: 60px;
            text-align: center;
            color: #ccc;
            font-weight: 300;
        }

        @keyframes glow {
            from { filter: drop-shadow(0 0 20px rgba(30, 144, 255, 0.5)); }
            to { filter: drop-shadow(0 0 30px rgba(30, 144, 255, 0.8)); }
        }

        /* Registration Options Container */
        .registration-options {
            display: flex;
            gap: 60px;
            margin-bottom: 40px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .registration-card {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(30, 144, 255, 0.3);
            border-radius: 20px;
            padding: 50px 40px;
            width: 350px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .registration-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #1e90ff, #00bfff);
            border-radius: 20px 20px 0 0;
        }

        .registration-card::after {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, #1e90ff, transparent, #00bfff);
            border-radius: 20px;
            z-index: -1;
            opacity: 0.3;
            transition: opacity 0.3s ease;
        }

        .registration-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(30, 144, 255, 0.3);
        }

        .registration-card:hover::after {
            opacity: 0.6;
        }

        .card-header {
            margin-bottom: 30px;
        }

        .card-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            color: white;
        }

        .card-subtitle {
            font-size: 16px;
            color: #1e90ff;
            font-weight: 500;
        }

        .card-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 30px;
            background: rgba(30, 144, 255, 0.1);
            border: 2px solid #1e90ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .card-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(30, 144, 255, 0.2), transparent);
            border-radius: 50%;
            animation: iconGlow 3s linear infinite;
        }

        @keyframes iconGlow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .entrepreneur-icon {
            font-size: 48px;
            color: #1e90ff;
        }

        .investor-icon {
            font-size: 48px;
            color: #1e90ff;
        }

        .card-description {
            font-size: 14px;
            color: #ccc;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .register-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, #1e90ff, #00bfff);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .register-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .register-btn:hover::before {
            left: 100%;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 144, 255, 0.5);
            text-decoration: none;
            color: white;
        }

        /* Back to Login Button */
        .back-to-login {
            margin-top: 40px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 30px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(30, 144, 255, 0.5);
            border-radius: 25px;
            color: #1e90ff;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .back-btn:hover {
            background: rgba(30, 144, 255, 0.1);
            border-color: #1e90ff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 144, 255, 0.3);
            text-decoration: none;
            color: #00bfff;
        }

        /* Floating Elements */
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .floating-element {
            position: absolute;
            background: rgba(30, 144, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            width: 60px;
            height: 60px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            width: 40px;
            height: 40px;
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            width: 80px;
            height: 80px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(120deg); }
            66% { transform: translateY(10px) rotate(240deg); }
        }

        /* Footer Styles */
        footer {
            background: linear-gradient(135deg, #111, #1a1a1a);
            color: white;
            text-align: center;
            padding: 40px 20px;
            position: relative;
            border-top: 1px solid #333;
            margin-top: 50px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-sections {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
            text-align: left;
        }

        .footer-section h3 {
            color: #1e90ff;
            font-size: 18px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section li {
            margin-bottom: 8px;
        }

        .footer-section a {
            color: #ccc;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: #1e90ff;
        }

        .footer-section p {
            color: #ccc;
            font-size: 14px;
            line-height: 1.6;
        }

        .social-links {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin: 20px 0;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(30, 144, 255, 0.1);
            border: 1px solid #1e90ff;
            border-radius: 50%;
            color: #1e90ff;
            font-size: 18px;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: #1e90ff;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 144, 255, 0.3);
        }

        .footer-bottom {
            border-top: 1px solid #333;
            padding-top: 20px;
            color: #999;
            font-size: 14px;
        }

        /* Responsive Design */
        @media only screen and (max-width: 1024px) {
            header {
                padding: 20px 30px;
            }
            
            nav {
                gap: 20px;
            }

            .registration-options {
                gap: 40px;
            }

            .registration-card {
                width: 320px;
                padding: 40px 30px;
            }
        }

        @media only screen and (max-width: 768px) {
            header {
                padding: 20px 20px;
            }
            
            nav {
                display: flex;
                gap: 15px;
            }
            
            nav a {
                font-size: 14px;
                padding: 8px 15px;
            }

            .main-container {
                padding: 130px 15px 30px;
            }

            .registration-options {
                gap: 30px;
            }

            .registration-card {
                width: 100%;
                max-width: 350px;
                padding: 35px 25px;
            }
            
            .footer-sections {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                text-align: center;
            }
        }

        @media only screen and (max-width: 480px) {
            header {
                padding: 15px 15px;
            }

            nav {
                gap: 10px;
            }
            
            nav a {
                font-size: 12px;
                padding: 6px 12px;
            }

            .main-container {
                padding: 120px 10px 20px;
            }

            .welcome-title {
                margin-bottom: 15px;
            }

            .subtitle {
                margin-bottom: 40px;
            }

            .registration-card {
                padding: 30px 20px;
            }

            .card-icon {
                width: 100px;
                height: 100px;
                margin-bottom: 25px;
            }

            .entrepreneur-icon,
            .investor-icon {
                font-size: 40px;
            }
        }

        /* Loading Animation */
        .page-loader {
            opacity: 0;
            animation: pageLoad 0.8s ease forwards;
        }

        @keyframes pageLoad {
            to { opacity: 1; }
        }
    </style>
</head>
<body class="page-loader">
    <!-- Floating Elements -->
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <!-- Header Section -->
    <header>
        <div class="logo">
            <img src="img/logo.png" alt="Elevator X Logo">
        </div>
        <nav>
            <a href="../index.php">Home</a>
            <a href="JoinUs.php">Join Us</a>
            <a href="LearnX/learnx_home.php">Learn-X</a>
            <a href="Gigs.php">Gigs</a>
            <a href="Mentorship.php">Mentorship</a>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <div class="content-wrapper">
            <h1 class="welcome-title">Select Your Future Floor</h1>
            <p class="subtitle">Choose your path to success</p>
            
            <!-- Registration Options -->
            <div class="registration-options">
                <!-- Entrepreneur Registration -->
                <div class="registration-card">
                    <div class="card-header">
                        <h2 class="card-title">REGISTER</h2>
                        <p class="card-subtitle">As Entrepreneur</p>
                    </div>
                    
                    <div class="card-icon">
                        <img src="img/regent.png" alt="Entrepreneur" style="width: 80px; height: 80px; object-fit: contain;">
                    </div>
                    
                    <p class="card-description">
                        Turn your innovative ideas into reality. Access mentorship, funding opportunities, and resources to build your startup from the ground up.
                    </p>
                    
                    <a href="entrepreneur/EntreRegForm.php" class="register-btn">Register</a>
                </div>

                <!-- Investor Registration -->
                <div class="registration-card">
                    <div class="card-header">
                        <h2 class="card-title">REGISTER</h2>
                        <p class="card-subtitle">As Investor</p>
                    </div>
                    
                    <div class="card-icon">
                        <img src="img/reginv.png" alt="Investor" style="width: 80px; height: 80px; object-fit: contain;">
                    </div>
                    
                    <p class="card-description">
                        Discover promising startups and entrepreneurs. Connect with innovative minds and invest in the future of business and technology.
                    </p>
                    
                    <a href="investor/InvestorRegForm.php" class="register-btn">Register</a>
                </div>
            </div>

            <!-- Back to Login -->
            <div class="back-to-login">
                <a href="JoinUs.php" class="back-btn">
                    <span>←</span>
                    <span>Back to Login</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer Section -->
    <footer>
        <div class="footer-content">
            <div class="footer-sections">
                <div class="footer-section">
                    <h3>About Elevator X</h3>
                    <p>Empowering entrepreneurs with mentorship, funding, and education. Your journey from idea to success starts here.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="JoinUs.php">Join Us</a></li>
                        <li><a href="LearnX.php">Learn-X</a></li>
                        <li><a href="Gigs.php">Gigs</a></li>
                        <li><a href="Mentorship.php">Mentorship</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Services</h3>
                    <ul>
                        <li><a href="#">Startup Mentorship</a></li>
                        <li><a href="#">Funding Opportunities</a></li>
                        <li><a href="#">Business Education</a></li>
                        <li><a href="#">Networking Events</a></li>
                        <li><a href="#">Resource Library</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact Info</h3>
                    <ul>
                        <li><a href="mailto:info@elevatorx.com">info@elevatorx.com</a></li>
                        <li><a href="tel:+94123456789">+94 12 345 6789</a></li>
                        <li><a href="#">Colombo, Sri Lanka</a></li>
                        <li><a href="#">Help & Support</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="social-links">
                <a href="#" title="Facebook">📘</a>
                <a href="#" title="Twitter">🐦</a>
                <a href="#" title="LinkedIn">💼</a>
                <a href="#" title="Instagram">📷</a>
                <a href="#" title="YouTube">📺</a>
            </div>
            
            <div class="footer-bottom">
                <p>© 2025 Elevator X. All rights reserved. Built with passion for entrepreneurs worldwide.</p>
                <p>Designed & Developed by Elevator X Team | Privacy Policy | Terms of Service</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Enhanced Interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to registration cards
            const cards = document.querySelectorAll('.registration-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });

                // Remove the problematic click handler that was interfering with links
            });

            // Smooth scroll for navigation links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading animation to register buttons
            const registerBtns = document.querySelectorAll('.register-btn');
            registerBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    this.innerHTML = '<span>Redirecting...</span>';
                    this.style.background = 'linear-gradient(45deg, #666, #888)';
                });
            });
        });

        // Page load animation
        window.addEventListener('load', () => {
            document.body.style.opacity = '1';
        });
    </script>
</body>
</html>