<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnX - Entrepreneurship Learning Hub</title>
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    
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
        }

        /* Header Styles */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
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

        .logo h1 {
            color: #00e5ff;
            font-size: 24px;
        }

        .logo img {
            height: 40px;
            width: auto;
            margin-right: 10px;
        }

        nav {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        nav a:hover, nav a.active {
            background-color: #00e5ff;
            transform: translateY(-2px);
            color: #000;
        }

        .login-btn {
            background: linear-gradient(45deg, #00e5ff, #00bcd4);
            color: #000;
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 229, 255, 0.4);
        }

        /* Main Content */
        .main-container {
            padding: 120px 20px 50px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .hero-section {
            text-align: center;
            margin-bottom: 80px;
            padding: 60px 20px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 30px;
            backdrop-filter: blur(15px);
        }

        .hero-title {
            font-size: 56px;
            margin-bottom: 20px;
            background: linear-gradient(45deg, #00e5ff, #00bcd4, #0097a7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 20px;
            color: #ccc;
            max-width: 800px;
            margin: 0 auto 40px;
            line-height: 1.6;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .stat-card {
            background: rgba(0, 229, 255, 0.1);
            padding: 25px;
            border-radius: 15px;
            border: 1px solid rgba(0, 229, 255, 0.3);
            text-align: center;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #00e5ff;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #ccc;
            font-size: 14px;
        }

        /* Learning Categories */
        .section-title {
            font-size: 42px;
            text-align: center;
            margin-bottom: 20px;
            color: #00e5ff;
        }

        .section-subtitle {
            text-align: center;
            color: #ccc;
            margin-bottom: 50px;
            font-size: 18px;
        }

        .learning-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 80px;
        }

        .learning-card {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(0, 229, 255, 0.3);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .learning-card:hover {
            transform: translateY(-10px);
            border-color: #00e5ff;
            box-shadow: 0 15px 40px rgba(0, 229, 255, 0.3);
        }

        .card-icon {
            font-size: 48px;
            margin-bottom: 20px;
            color: #00e5ff;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #00e5ff;
        }

        .card-description {
            color: #ddd;
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 15px;
        }

        .card-features {
            list-style: none;
            margin-bottom: 25px;
        }

        .card-features li {
            color: #ccc;
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
        }

        .card-features li::before {
            content: '✓';
            color: #00e5ff;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .explore-btn {
            width: 100%;
            background: linear-gradient(45deg, #00e5ff, #00bcd4);
            color: #000;
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
        }

        .explore-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 229, 255, 0.4);
        }

        /* Featured Content Section */
        .featured-section {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            padding: 50px 30px;
            margin-bottom: 80px;
        }

        .featured-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
        }

        .featured-item {
            background: rgba(0, 229, 255, 0.05);
            border: 1px solid rgba(0, 229, 255, 0.2);
            border-radius: 15px;
            padding: 25px;
            transition: all 0.3s ease;
        }

        .featured-item:hover {
            background: rgba(0, 229, 255, 0.1);
            border-color: #00e5ff;
        }

        .featured-title {
            font-size: 16px;
            font-weight: bold;
            color: #00e5ff;
            margin-bottom: 10px;
        }

        .featured-desc {
            color: #ccc;
            font-size: 14px;
            line-height: 1.5;
        }

        /* Learning Path Section */
        .path-section {
            text-align: center;
            margin-bottom: 80px;
        }

        .path-timeline {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 30px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .path-step {
            background: rgba(0, 0, 0, 0.4);
            border: 2px solid rgba(0, 229, 255, 0.3);
            border-radius: 50%;
            width: 120px;
            height: 120px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .path-step:hover {
            border-color: #00e5ff;
            background: rgba(0, 229, 255, 0.1);
            transform: scale(1.05);
        }

        .step-number {
            font-size: 24px;
            font-weight: bold;
            color: #00e5ff;
            margin-bottom: 5px;
        }

        .step-label {
            font-size: 12px;
            color: #ccc;
            text-align: center;
        }

        .path-arrow {
            color: #00e5ff;
            font-size: 24px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
                position: relative;
            }

            nav {
                gap: 15px;
                flex-wrap: wrap;
            }

            .main-container {
                padding: 30px 15px;
            }

            .learning-grid, .featured-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .hero-title {
                font-size: 36px;
            }

            .section-title {
                font-size: 32px;
            }

            .hero-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .path-timeline {
                flex-direction: column;
                gap: 20px;
            }

            .path-arrow {
                transform: rotate(90deg);
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .learning-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .learning-card:nth-child(1) { animation-delay: 0.1s; }
        .learning-card:nth-child(2) { animation-delay: 0.2s; }
        .learning-card:nth-child(3) { animation-delay: 0.3s; }
        .learning-card:nth-child(4) { animation-delay: 0.4s; }
        .learning-card:nth-child(5) { animation-delay: 0.5s; }
        .learning-card:nth-child(6) { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <h1>LearnX</h1>
        </div>
        <nav>
            <a href="../../index.php">Home</a>
            <a href="../JoinUs.php">Join Us</a>
            <a href="learnx_home.php" class="active">Learn-X</a>
            <a href="../Gigs.php">Gigs</a>
            <a href="../Mentorship/M_index.php">Mentorship</a>
            <a href="../JoinUs.php" class="login-btn">Login / Register</a>
        </nav>
    </header>

    <div class="main-container">
        <!-- Hero Section -->
        <section class="hero-section">
            <h1 class="hero-title">Master Entrepreneurship</h1>
            <p class="hero-subtitle">
                Transform your business ideas into reality with our comprehensive learning platform. 
                Access expert-curated content, interactive courses, and real-world case studies.
            </p>
            <div class="hero-stats">
                <div class="stat-card">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Video Lessons</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">200+</div>
                    <div class="stat-label">Articles</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Case Studies</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">10k+</div>
                    <div class="stat-label">Active Learners</div>
                </div>
            </div>
        </section>

        <!-- Learning Categories -->
        <section>
            <h2 class="section-title">Learning Categories</h2>
            <p class="section-subtitle">Explore diverse entrepreneurial content designed to accelerate your business journey</p>
            
            <div class="learning-grid">
                <!-- Video Courses -->
                <div class="learning-card">
                    <div class="card-icon">🎥</div>
                    <h3 class="card-title">Video Courses</h3>
                    <p class="card-description">
                        Comprehensive video tutorials covering everything from startup basics to advanced business strategies.
                    </p>
                    <ul class="card-features">
                        <li>HD video content from industry experts</li>
                        <li>Step-by-step tutorials</li>
                        <li>Downloadable resources</li>
                        <li>Progress tracking</li>
                    </ul>
                    <a href="videos.php" class="explore-btn">Explore Videos</a>
                </div>

                <!-- Articles & Insights -->
                <div class="learning-card">
                    <div class="card-icon">📚</div>
                    <h3 class="card-title">Articles & Insights</h3>
                    <p class="card-description">
                        In-depth articles covering market trends, business strategies, and entrepreneurial insights.
                    </p>
                    <ul class="card-features">
                        <li>Expert-written content</li>
                        <li>Latest industry trends</li>
                        <li>Practical tips and strategies</li>
                        <li>Regular updates</li>
                    </ul>
                    <a href="articles.php" class="explore-btn">Read Articles</a>
                </div>

                <!-- Case Studies -->
                <div class="learning-card">
                    <div class="card-icon">🔍</div>
                    <h3 class="card-title">Real Case Studies</h3>
                    <p class="card-description">
                        Learn from successful entrepreneurs through detailed case studies and business breakdowns.
                    </p>
                    <ul class="card-features">
                        <li>Real success stories</li>
                        <li>Failure analysis</li>
                        <li>Financial breakdowns</li>
                        <li>Lessons learned</li>
                    </ul>
                    <a href="case_studies.php" class="explore-btn">Study Cases</a>
                </div>

                <!-- Interactive Quizzes -->
                <div class="learning-card">
                    <div class="card-icon">🧠</div>
                    <h3 class="card-title">Interactive Quizzes</h3>
                    <p class="card-description">
                        Test your knowledge and reinforce learning with engaging quizzes and assessments.
                    </p>
                    <ul class="card-features">
                        <li>Knowledge assessments</li>
                        <li>Instant feedback</li>
                        <li>Difficulty levels</li>
                        <li>Achievement badges</li>
                    </ul>
                    <a href="quizzes.php" class="explore-btn">Take Quizzes</a>
                </div>

                <!-- Live Webinars -->
                <div class="learning-card">
                    <div class="card-icon">📡</div>
                    <h3 class="card-title">Live Webinars</h3>
                    <p class="card-description">
                        Join live sessions with successful entrepreneurs and industry experts.
                    </p>
                    <ul class="card-features">
                        <li>Live Q&A sessions</li>
                        <li>Expert speakers</li>
                        <li>Interactive discussions</li>
                        <li>Recorded sessions</li>
                    </ul>
                    <a href="webinars.php" class="explore-btn">Join Webinars</a>
                </div>

                <!-- Practical Tools -->
                <div class="learning-card">
                    <div class="card-icon">🛠️</div>
                    <h3 class="card-title">Business Tools</h3>
                    <p class="card-description">
                        Access practical tools and templates to help you build and grow your business.
                    </p>
                    <ul class="card-features">
                        <li>Business plan templates</li>
                        <li>Financial calculators</li>
                        <li>Market research tools</li>
                        <li>Pitch deck templates</li>
                    </ul>
                    <a href="tools.php" class="explore-btn">Access Tools</a>
                </div>
            </div>
        </section> 

        <!-- Featured Content -->
        <section class="featured-section">
            <h2 class="section-title">Featured This Week</h2>
            <div class="featured-grid">
                <div class="featured-item">
                    <h4 class="featured-title">🔥 Trending: AI in Startups</h4>
                    <p class="featured-desc">How artificial intelligence is revolutionizing the startup ecosystem</p>
                </div>
                <div class="featured-item">
                    <h4 class="featured-title">💰 Funding Masterclass</h4>
                    <p class="featured-desc">Complete guide to raising your first round of investment</p>
                </div>
                <div class="featured-item">
                    <h4 class="featured-title">📈 Growth Hacking 101</h4>
                    <p class="featured-desc">Proven strategies to scale your startup on a shoestring budget</p>
                </div>
                <div class="featured-item">
                    <h4 class="featured-title">🎯 Market Validation</h4>
                    <p class="featured-desc">Step-by-step process to validate your business idea</p>
                </div>
            </div>
        </section>

        <!-- Learning Path -->
        <section class="path-section">
            <h2 class="section-title">Your Learning Journey</h2>
            <p class="section-subtitle">Follow our structured path from idea to successful business</p>
            
            <div class="path-timeline">
                <div class="path-step">
                    <div class="step-number">1</div>
                    <div class="step-label">Ideation</div>
                </div>
                <div class="path-arrow">→</div>
                <div class="path-step">
                    <div class="step-number">2</div>
                    <div class="step-label">Validation</div>
                </div>
                <div class="path-arrow">→</div>
                <div class="path-step">
                    <div class="step-number">3</div>
                    <div class="step-label">Planning</div>
                </div>
                <div class="path-arrow">→</div>
                <div class="path-step">
                    <div class="step-number">4</div>
                    <div class="step-label">Launch</div>
                </div>
                <div class="path-arrow">→</div>
                <div class="path-step">
                    <div class="step-number">5</div>
                    <div class="step-label">Growth</div>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Smooth scrolling for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Header background change on scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(0, 0, 0, 0.9)';
            } else {
                header.style.background = 'rgba(0, 0, 0, 0.3)';
            }
        });

        // Add click tracking for learning cards
        document.querySelectorAll('.learning-card').forEach(card => {
            card.addEventListener('click', function() {
                const title = this.querySelector('.card-title').textContent;
                console.log(`Learning card clicked: ${title}`);
            });
        });

        console.log("Advanced LearnX Home Loaded");
    </script>
</body>
</html>