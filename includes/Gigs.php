<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Gigs - Elevator X</title>
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">
    
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
            min-height: 100vh;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Header Styles - Same as JoinUs page */
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

        nav a:hover, nav a.active {
            background-color: #1e90ff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 144, 255, 0.4);
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

        /* Main Content */
        .main-container {
            padding: 150px 20px 50px;
            max-width: 1200px;
            margin: 0 auto;
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInUp 1s ease 0.3s forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .page-title {
            font-size: clamp(36px, 5vw, 48px);
            margin-bottom: 20px;
            background: linear-gradient(45deg, #fff, #1e90ff);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from { filter: drop-shadow(0 0 20px rgba(30, 144, 255, 0.5)); }
            to { filter: drop-shadow(0 0 30px rgba(30, 144, 255, 0.8)); }
        }

        .page-subtitle {
            font-size: 18px;
            color: #ccc;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Gigs Grid */
        .gigs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .gig-card {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(30, 144, 255, 0.3);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .gig-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #1e90ff, #00bfff);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .gig-card:hover {
            transform: translateY(-10px);
            border-color: #1e90ff;
            box-shadow: 0 15px 40px rgba(30, 144, 255, 0.3);
        }

        .gig-card:hover::before {
            transform: scaleX(1);
        }

        .gig-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid rgba(30, 144, 255, 0.3);
        }

        .gig-content {
            padding: 25px;
        }

        .gig-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #1e90ff;
            line-height: 1.3;
        }

        .gig-entrepreneur {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            color: #ccc;
            font-size: 14px;
        }

        .entrepreneur-icon {
            color: #1e90ff;
        }

        .gig-location {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            color: #ccc;
            font-size: 14px;
        }

        .location-icon {
            color: #1e90ff;
        }

        .gig-description {
            color: #ddd;
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 15px;
        }

        .gig-stage {
            display: inline-block;
            background: rgba(30, 144, 255, 0.2);
            color: #1e90ff;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .invest-btn {
            width: 100%;
            background: linear-gradient(45deg, #1e90ff, #00bfff);
            color: white;
            padding: 15px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .invest-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .invest-btn:hover::before {
            left: 100%;
        }

        .invest-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 144, 255, 0.4);
        }

        /* Footer Styles - Same as JoinUs page */
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
        @media (max-width: 1024px) {
            header {
                padding: 20px 30px;
            }
            
            nav {
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }

            nav {
                gap: 15px;
                flex-wrap: wrap;
            }

            .main-container {
                padding: 200px 15px 30px;
            }

            .gigs-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .page-title {
                font-size: 36px;
            }

            .footer-sections {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            header {
                padding: 15px 15px;
            }

            nav {
                gap: 10px;
            }
            
            nav a {
                font-size: 14px;
                padding: 8px 15px;
            }

            .main-container {
                padding: 180px 10px 20px;
            }

            .gig-content {
                padding: 20px;
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
            <a href="index.php">Home</a>
            <a href="JoinUs.php">Join Us</a>
            <a href="LearnX/learnx_home.php">Learn-X</a>
            <a href="Gigs.php" class="active">Gigs</a>
            <a href="Mentorship/M_index.php">Mentorship</a>
        </nav>
    </header>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">Browse Investment Opportunities</h1>
            <p class="page-subtitle">
                Discover innovative startups and connect with entrepreneurs looking for funding
            </p>
        </div>

        <!-- Gigs Grid -->
        <div class="gigs-grid">
            <!-- Gig 1 -->
            <div class="gig-card">
                <img src="img/gigs/gg1.png" alt="AI Healthcare Platform" class="gig-image">
                <div class="gig-content">
                    <h3 class="gig-title">AI-Powered Healthcare Platform</h3>
                    <div class="gig-entrepreneur">
                        <span class="entrepreneur-icon">👤</span>
                        <span><strong>Entrepreneur:</strong> Dr. Priyanka Jayawardena</span>
                    </div>
                    <div class="gig-location">
                        <span class="location-icon">📍</span>
                        <span>Colombo, Western Province</span>
                    </div>
                    <div class="gig-stage">MVP Ready</div>
                    <p class="gig-description">
                        Revolutionary healthcare platform using artificial intelligence to improve patient outcomes and reduce medical costs through predictive analytics.
                    </p>
                    <a href="JoinUs.php" class="invest-btn">Start Invest</a>
                </div>
            </div>

            <!-- Gig 2 -->
            <div class="gig-card">
                <img src="img/gigs/gg2.png" alt="Sustainable E-commerce" class="gig-image">
                <div class="gig-content">
                    <h3 class="gig-title">Sustainable E-commerce Solution</h3>
                    <div class="gig-entrepreneur">
                        <span class="entrepreneur-icon">👤</span>
                        <span><strong>Entrepreneur:</strong> Roshan Perera</span>
                    </div>
                    <div class="gig-location">
                        <span class="location-icon">📍</span>
                        <span>Kandy, Central Province</span>
                    </div>
                    <div class="gig-stage">Prototype</div>
                    <p class="gig-description">
                        Eco-friendly e-commerce platform promoting sustainable products with carbon-neutral shipping and packaging solutions.
                    </p>
                    <a href="JoinUs.php" class="invest-btn">Start Invest</a>
                </div>
            </div>

            <!-- Gig 3 -->
            <div class="gig-card">
                <img src="img/gigs/gg3.png" alt="FinTech Payment Gateway" class="gig-image">
                <div class="gig-content">
                    <h3 class="gig-title">FinTech Payment Gateway</h3>
                    <div class="gig-entrepreneur">
                        <span class="entrepreneur-icon">👤</span>
                        <span><strong>Entrepreneur:</strong> Amal Mendis</span>
                    </div>
                    <div class="gig-location">
                        <span class="location-icon">📍</span>
                        <span>Galle, Southern Province</span>
                    </div>
                    <div class="gig-stage">Beta Testing</div>
                    <p class="gig-description">
                        Next-generation payment processing system with enhanced security, lower fees, and seamless integration for businesses.
                    </p>
                    <a href="JoinUs.php" class="invest-btn">Start Invest</a>
                </div>
            </div>

            <!-- Gig 4 -->
            <div class="gig-card">
                <img src="img/gigs/gg4.png" alt="VR Education Platform" class="gig-image">
                <div class="gig-content">
                    <h3 class="gig-title">VR Education Platform</h3>
                    <div class="gig-entrepreneur">
                        <span class="entrepreneur-icon">👤</span>
                        <span><strong>Entrepreneur:</strong> Lakshika Fernando</span>
                    </div>
                    <div class="gig-location">
                        <span class="location-icon">📍</span>
                        <span>Negombo, Western Province</span>
                    </div>
                    <div class="gig-stage">Concept</div>
                    <p class="gig-description">
                        Immersive virtual reality platform for educational institutions, making learning interactive and engaging for students.
                    </p>
                    <a href="JoinUs.php" class="invest-btn">Start Invest</a>
                </div>
            </div>

            <!-- Gig 5 -->
            <div class="gig-card">
                <img src="img/gigs/gg5.png" alt="Smart Home Energy System" class="gig-image">
                <div class="gig-content">
                    <h3 class="gig-title">Smart Home Energy System</h3>
                    <div class="gig-entrepreneur">
                        <span class="entrepreneur-icon">👤</span>
                        <span><strong>Entrepreneur:</strong> Dhanushka Silva</span>
                    </div>
                    <div class="gig-location">
                        <span class="location-icon">📍</span>
                        <span>Matara, Southern Province</span>
                    </div>
                    <div class="gig-stage">MVP Ready</div>
                    <p class="gig-description">
                        IoT-based smart home energy management system that optimizes electricity usage and integrates renewable energy sources.
                    </p>
                    <a href="JoinUs.php" class="invest-btn">Start Invest</a>
                </div>
            </div>

            <!-- Gig 6 -->
            <div class="gig-card">
                <img src="img/gigs/gg6.png" alt="Food Delivery Drone Service" class="gig-image">
                <div class="gig-content">
                    <h3 class="gig-title">Food Delivery Drone Service</h3>
                    <div class="gig-entrepreneur">
                        <span class="entrepreneur-icon">👤</span>
                        <span><strong>Entrepreneur:</strong> Eshan Wijeratne</span>
                    </div>
                    <div class="gig-location">
                        <span class="location-icon">📍</span>
                        <span>Jaffna, Northern Province</span>
                    </div>
                    <div class="gig-stage">Pilot Program</div>
                    <p class="gig-description">
                        Autonomous drone delivery service for restaurants and grocery stores, reducing delivery time and costs.
                    </p>
                    <a href="JoinUs.php" class="invest-btn">Start Invest</a>
                </div>
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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="JoinUs.php">Join Us</a></li>
                        <li><a href="LearnX/learnx_home.php">Learn-X</a></li>
                        <li><a href="Gigs.php">Gigs</a></li>
                        <li><a href="Mentorship/M_index.php">Mentorship</a></li>
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
            // Add parallax effect to floating elements
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const parallaxElements = document.querySelectorAll('.floating-element');
                
                parallaxElements.forEach((element, index) => {
                    const speed = 0.5 + (index * 0.1);
                    element.style.transform = `translateY(${scrolled * speed}px) rotate(${scrolled * 0.1}deg)`;
                });
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

            // Add stagger animation to gig cards
            const gigCards = document.querySelectorAll('.gig-card');
            gigCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.animation = `fadeInUp 0.6s ease ${index * 0.1}s forwards`;
            });
        });

        // Page load animation
        window.addEventListener('load', () => {
            document.body.style.opacity = '1';
        });
    </script>
</body>
</html>