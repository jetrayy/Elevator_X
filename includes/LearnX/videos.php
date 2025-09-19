<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnX - Video Tutorials</title>
    <link rel="icon" href="../../img/favicon.ico" type="image/x-icon">
    
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
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo h1 {
            color: #00e5ff;
            font-size: 24px;
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

        /* Main Container */
        .main-container {
            padding: 50px 20px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .page-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .page-title {
            font-size: 42px;
            margin-bottom: 15px;
            color: #00e5ff;
        }

        .page-subtitle {
            font-size: 18px;
            color: #ccc;
            margin-bottom: 30px;
        }

        /* Sub Navigation */
        .sub-nav {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            padding: 15px;
            margin-bottom: 40px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 229, 255, 0.2);
        }

        .sub-nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .sub-nav a {
            color: #00e5ff;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 16px;
            border-radius: 20px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .sub-nav a:hover, .sub-nav a.active {
            background: #00e5ff;
            color: #000;
            transform: translateY(-1px);
        }

        /* Video Grid */
        .videos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 30px;
        }

        .video-card {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(0, 229, 255, 0.3);
            border-radius: 20px;
            padding: 25px;
            transition: all 0.3s ease;
        }

        .video-card:hover {
            transform: translateY(-5px);
            border-color: #00e5ff;
            box-shadow: 0 15px 30px rgba(0, 229, 255, 0.2);
        }

        .video-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #00e5ff;
        }

        .video-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            color: #ccc;
            font-size: 14px;
        }

        .video-duration {
            background: rgba(0, 229, 255, 0.2);
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
        }

        .video-level {
            background: rgba(0, 188, 212, 0.2);
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
        }

        iframe {
            width: 100%;
            height: 280px;
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 229, 255, 0.3);
            margin-bottom: 15px;
        }

        .video-description {
            color: #ddd;
            line-height: 1.6;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .video-tags {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .tag {
            background: rgba(0, 229, 255, 0.1);
            color: #00e5ff;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            border: 1px solid rgba(0, 229, 255, 0.3);
        }

        /* Stats Section */
        .stats-section {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 40px;
            text-align: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 20px;
        }

        .stat-item {
            color: #00e5ff;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #ccc;
            font-size: 14px;
        }

        /* Responsive Design */
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
                padding: 30px 15px;
            }

            .videos-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .page-title {
                font-size: 32px;
            }

            iframe {
                height: 200px;
            }

            .sub-nav ul {
                gap: 10px;
            }

            .sub-nav a {
                padding: 6px 12px;
                font-size: 14px;
            }
        }

        /* Loading Animation */
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

        .video-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .video-card:nth-child(1) { animation-delay: 0.1s; }
        .video-card:nth-child(2) { animation-delay: 0.2s; }
        .video-card:nth-child(3) { animation-delay: 0.3s; }
        .video-card:nth-child(4) { animation-delay: 0.4s; }
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
            <a href="learnx_home.php">Learn-X</a>
            <a href="../Gigs.php">Gigs</a>
            <a href="../Mentorship/M_index.php">Mentorship</a>
            <a href="../JoinUs.php" class="login-btn">Login / Register</a>
        </nav>
    </header>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">Video Tutorials</h1>
            <p class="page-subtitle">Learn entrepreneurship through expert-led video content</p>
        </div>

        <!-- Sub Navigation -->
        <nav class="sub-nav">
            <ul>
                <li><a href="learnx_home.php">Home</a></li>
                <li><a href="articles.php">Articles</a></li>
                <li><a href="videos.php" class="active">Videos</a></li>
                <li><a href="case_studies.php">Case Studies</a></li>
                <li><a href="quizzes.php">Quizzes</a></li>
                <li><a href="webinars.php">Webinars</a></li>
            </ul>
        </nav>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Video Courses</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4.2k</div>
                    <div class="stat-label">Total Views</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">8.5h</div>
                    <div class="stat-label">Content Hours</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">95%</div>
                    <div class="stat-label">Satisfaction</div>
                </div>
            </div>
        </div>

        <!-- Videos Grid -->
        <div class="videos-grid">
            <!-- Video 1 -->
            <div class="video-card">
                <h2 class="video-title">Business Registration Process Explained</h2>
                <div class="video-meta">
                    <span class="video-duration">⏱️ 12:30</span>
                    <span class="video-level">📈 Beginner</span>
                </div>
                <iframe src="https://www.youtube.com/embed/iKNEc4pMPDc" allowfullscreen></iframe>
                <p class="video-description">
                    Complete step-by-step guide to registering your business legally. Covers documentation, fees, and common pitfalls to avoid.
                </p>
                <div class="video-tags">
                    <span class="tag">Legal</span>
                    <span class="tag">Registration</span>
                    <span class="tag">Startup</span>
                </div>
            </div>

            <!-- Video 2 -->
            <div class="video-card">
                <h2 class="video-title">How to Register Your Business</h2>
                <div class="video-meta">
                    <span class="video-duration">⏱️ 15:45</span>
                    <span class="video-level">📈 Beginner</span>
                </div>
                <iframe src="https://www.youtube.com/embed/eHJnEHyyN1Y" allowfullscreen></iframe>
                <p class="video-description">
                    Detailed walkthrough of business registration requirements, including choosing business structures and understanding tax implications.
                </p>
                <div class="video-tags">
                    <span class="tag">Business Structure</span>
                    <span class="tag">Tax</span>
                    <span class="tag">Legal</span>
                </div>
            </div>

            <!-- Video 3 -->
            <div class="video-card">
                <h2 class="video-title">Business Startup Tips</h2>
                <div class="video-meta">
                    <span class="video-duration">⏱️ 18:20</span>
                    <span class="video-level">📊 Intermediate</span>
                </div>
                <iframe src="https://www.youtube.com/embed/8Ij7A1VCB7I" allowfullscreen></iframe>
                <p class="video-description">
                    Essential tips for launching a successful startup. Learn about market validation, funding options, and building your first team.
                </p>
                <div class="video-tags">
                    <span class="tag">Startup</span>
                    <span class="tag">Funding</span>
                    <span class="tag">Team Building</span>
                </div>
            </div>

            <!-- Video 4 -->
            <div class="video-card">
                <h2 class="video-title">Entrepreneur Mindset for Success</h2>
                <div class="video-meta">
                    <span class="video-duration">⏱️ 22:15</span>
                    <span class="video-level">🎯 Advanced</span>
                </div>
                <iframe src="https://www.youtube.com/embed/IVNK5gkVq2Q" allowfullscreen></iframe>
                <p class="video-description">
                    Develop the right entrepreneurial mindset. Learn about resilience, decision-making, and maintaining motivation through challenges.
                </p>
                <div class="video-tags">
                    <span class="tag">Mindset</span>
                    <span class="tag">Psychology</span>
                    <span class="tag">Leadership</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Track video interactions
        document.querySelectorAll('iframe').forEach((iframe, index) => {
            iframe.addEventListener('load', function() {
                console.log(`Video ${index + 1} loaded successfully`);
            });
        });

        // Add hover effects for better UX
        document.querySelectorAll('.video-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        console.log("Videos page loaded successfully");
    </script>
</body>
</html>