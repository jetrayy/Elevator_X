<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elevator X</title>

    <!-- Favicon -->
    <link rel="icon" href="includes/img/favicon.ico" type="image/x-icon">

    <!-- Inline CSS for Styling -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            font-family: 'Arial', sans-serif;
            background-color: #111;
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

        .header-scrolled {
            background: transparent;
            backdrop-filter: none;
            box-shadow: none;
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

        /* Mobile Menu */
        .mobile-menu-toggle {
            display: none;
        }

        .mobile-menu {
            display: none;
        }

        /* Section Styles */
        .section {
            min-height: 100vh;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            padding: 120px 20px 50px;
            color: white;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            position: relative;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Dark overlay for better text readability */
        .section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.3));
            z-index: 1;
        }

        /* Ensure content is above the background and overlay */
        .section > * {
            position: relative;
            z-index: 2;
        }

        .section h1 {
            font-size: clamp(32px, 8vw, 72px);
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
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

        .section p {
            font-size: clamp(16px, 4vw, 24px);
            max-width: 800px;
            line-height: 1.8;
            margin-bottom: 40px;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.8);
            opacity: 0;
            animation: fadeInUp 1s ease 0.5s forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn-primary, .btn-secondary {
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 18px;
            text-decoration: none;
            color: white;
            display: inline-block;
            margin: 10px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #1e90ff, #00bfff);
            box-shadow: 0 8px 25px rgba(30, 144, 255, 0.3);
        }

        .btn-secondary {
            background: transparent;
            border: 2px solid #1e90ff;
            color: #1e90ff;
        }

        .btn-primary:hover, .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(30, 144, 255, 0.5);
        }

        .btn-secondary:hover {
            background: #1e90ff;
            color: white;
        }

        .btn-primary::before, .btn-secondary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before, .btn-secondary:hover::before {
            left: 100%;
        }

        /* Button container for welcome section */
        .button-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 30px;
        }

        /* Fallback background colors */
        #welcome {
            background: linear-gradient(135deg, #0f3460, #16537e);
        }

        #aboutus {
            background: linear-gradient(135deg, #1a252f, #2c3e50);
        }

        #vision {
            background: linear-gradient(135deg, #0f3460, #16537e);
        }

        #mission {
            background: linear-gradient(135deg, #1a252f, #2c3e50);
        }

        /* Footer Styles */
        footer {
            background: linear-gradient(135deg, #111, #1a1a1a);
            color: white;
            text-align: center;
            padding: 40px 20px;
            position: relative;
            border-top: 1px solid #333;
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

        /* Scroll Progress Bar */
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #1e90ff, #00bfff);
            z-index: 1001;
            transition: width 0.1s ease;
        }

        /* Floating Elements */
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
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
            top: 20%;
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

        /* Responsive Design */
        @media only screen and (max-width: 1024px) {
            header {
                padding: 20px 30px;
            }
            
            nav {
                gap: 20px;
            }
            
            .section {
                background-attachment: scroll;
                padding: 100px 15px 30px;
            }
        }

        @media only screen and (max-width: 768px) {
            header {
                padding: 20px 20px;
            }
            
            nav {
                display: none;
            }
            
            .mobile-menu-toggle {
                display: flex;
            }
            
            .mobile-menu nav {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }
            
            .section {
                padding: 100px 15px 30px;
                background-attachment: scroll;
            }
            
            .button-container {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-primary, .btn-secondary {
                width: 100%;
                max-width: 300px;
                margin: 8px 0;
            }
            
            .footer-sections {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
                text-align: center;
            }
            
            .social-links {
                justify-content: center;
            }
        }

        @media only screen and (max-width: 480px) {
            header {
                padding: 15px 15px;
            }
            
            .section {
                padding: 90px 10px 20px;
            }
        }

        /* High DPI displays */
        @media only screen and (-webkit-min-device-pixel-ratio: 2),
               only screen and (min--moz-device-pixel-ratio: 2),
               only screen and (-o-min-device-pixel-ratio: 2/1),
               only screen and (min-device-pixel-ratio: 2),
               only screen and (min-resolution: 192dpi),
               only screen and (min-resolution: 2dppx) {
            .section h1 {
                text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.9);
            }
        }
    </style>
</head>
<body>
    <!-- Scroll Progress Bar -->
    <div class="scroll-progress" id="scrollProgress"></div>

    <!-- Header Section with Navigation Links -->
    <header id="header">
        <div class="logo">
            <img src="includes/img/logo.png" alt="Elevator X Logo">
        </div>
        <nav id="desktopNav">
            <a href="index.php">Home</a>
            <a href="includes/JoinUs.php">Join Us</a>
            <a href="includes/LearnX/learnx_home.php">Learn-X</a>
            <a href="includes/Gigs.php">Gigs</a>
            <a href="includes/Mentorship/M_index.php">Mentorship</a>
        </nav>
        <div class="mobile-menu-toggle" id="mobileToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <nav>
                <a href="index.php">Home</a>
                <a href="includes/JoinUs.php">Join Us</a>
                <a href="includes/LearnX/learnx_home.php">Learn-X</a>
                <a href="includes/Gigs.php">Gigs</a>
                <a href="includes/Mentorship/M_index.php">Mentorship</a>
            </nav>
        </div>
    </header>

    <!-- Welcome Section -->
    <div class="section" style="background-image: url('includes/img/homebg.png');" id="welcome">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <h1>WELCOME TO<br>ELEVATOR-X</h1>
        <p>Your one-stop platform for mentorship, funding, and education. Empowering entrepreneurs to transform ideas into successful ventures.</p>
        <div class="button-container">
            <a href="#aboutus" class="btn-secondary">About Us</a>
            <a href="includes/JoinUs.php" class="btn-primary">Join Us</a>
        </div>
    </div>

    <!-- Who We Are Section -->
    <div class="section" style="background-image: url('includes/img/about1.png');" id="aboutus">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <h1>Who We Are?</h1>
        <p>Elevator X is a web-based platform developed by a team of passionate undergraduate software engineering students. Our goal is to support new entrepreneurs by providing them with the essential resources they need to succeed—mentorship, funding opportunities, and comprehensive business education tailored for the digital age.</p>
    </div>

    <!-- Our Vision Section -->
    <div class="section" style="background-image: url('includes/img/about2.png');" id="vision">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <h1>Our Vision</h1>
        <p>Our vision is to create a unified ecosystem where entrepreneurs can easily connect with the right people and resources. We aim to build a platform that fosters collaboration and innovation, empowering the next generation of entrepreneurs to transform their ideas into successful businesses that make a positive impact on the world.</p>
    </div>

    <!-- Our Mission Section -->
    <div class="section" style="background-image: url('includes/img/about3.png');" id="mission">
        <div class="floating-elements">
            <div class="floating-element"></div>
            <div class="floating-element"></div>
            <div class="floating-element"></div>
        </div>
        <h1>Our Mission</h1>
        <p>Our mission is to provide a user-friendly and comprehensive platform that combines mentorship, funding, and education. Elevator X seeks to bridge the gap between early-stage entrepreneurs and the support they need to grow, offering a streamlined approach to accessing investors, mentors, and educational resources at every stage of their entrepreneurial journey.</p>
        <div class="button-container">
            <a href="includes/JoinUs.php" class="btn-primary">Join Us Now</a>
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
                        <li><a href="includes/JoinUs.php">Join Us</a></li>
                        <li><a href="includes/LearnX.php">Learn-X</a></li>
                        <li><a href="includes/Gigs.php">Gigs</a></li>
                        <li><a href="includes/Mentorship.php">Mentorship</a></li>
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

    <!-- Enhanced JavaScript for Animations and Interactions -->
    <script>
        // Mobile menu toggle
        const mobileToggle = document.getElementById('mobileToggle');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });

        // Close mobile menu when clicking on links
        document.querySelectorAll('.mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
            });
        });

        // Header remains transparent always - no scroll effects needed for background
        const header = document.getElementById('header');
        // Keeping scroll listener for other potential effects but header stays transparent

        // Scroll progress bar
        const scrollProgress = document.getElementById('scrollProgress');
        
        window.addEventListener('scroll', () => {
            const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrollPercentage = (scrollTop / scrollHeight) * 100;
            scrollProgress.style.width = scrollPercentage + '%';
        });

        // Enhanced scroll animations with Intersection Observer
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all sections
        document.querySelectorAll('.section').forEach(section => {
            observer.observe(section);
        });

        // Smooth scroll for anchor links
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

        // Parallax effect for background images
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const sections = document.querySelectorAll('.section');
            
            sections.forEach((section, index) => {
                const rate = scrolled * -0.5;
                section.style.transform = `translateY(${rate}px)`;
            });
        });

        // Initialize first section as visible on load
        document.addEventListener('DOMContentLoaded', () => {
            const firstSection = document.querySelector('.section');
            if (firstSection) {
                firstSection.classList.add('visible');
            }
        });

        // Add loading animation
        window.addEventListener('load', () => {
            document.body.style.opacity = '1';
        });

        // Performance optimization for scroll events
        let ticking = false;
        
        function updateScrollEffects() {
            // Scroll progress
            const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrollPercentage = (scrollTop / scrollHeight) * 100;
            scrollProgress.style.width = scrollPercentage + '%';
            
            // Header effect
            if (window.scrollY > 100) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
            
            ticking = false;
        }

        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(updateScrollEffects);
                ticking = true;
            }
        });
    </script>

</body>
</html>