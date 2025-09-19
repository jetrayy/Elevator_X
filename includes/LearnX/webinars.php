<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnX - Business Webinars</title>
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
            max-width: 1200px;
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

        /* Featured Webinar */
        .featured-webinar {
            background: linear-gradient(135deg, rgba(0, 229, 255, 0.1), rgba(0, 188, 212, 0.1));
            border: 2px solid rgba(0, 229, 255, 0.3);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            text-align: center;
        }

        .featured-badge {
            background: #00e5ff;
            color: #000;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 20px;
        }

        .featured-title {
            font-size: 32px;
            color: #00e5ff;
            margin-bottom: 15px;
        }

        .featured-description {
            font-size: 18px;
            color: #ddd;
            line-height: 1.6;
            margin-bottom: 25px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .featured-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .detail-item {
            background: rgba(0, 229, 255, 0.1);
            padding: 15px;
            border-radius: 15px;
            border: 1px solid rgba(0, 229, 255, 0.2);
        }

        .detail-label {
            color: #ccc;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .detail-value {
            color: #00e5ff;
            font-weight: bold;
            font-size: 16px;
        }

        /* Webinar Filters */
        .filter-section {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .filter-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .filter-btn {
            background: rgba(0, 229, 255, 0.1);
            border: 1px solid rgba(0, 229, 255, 0.3);
            color: #00e5ff;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .filter-btn:hover, .filter-btn.active {
            background: #00e5ff;
            color: #000;
            transform: translateY(-2px);
        }

        /* Webinars Grid */
        .webinars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
        }

        .webinar-card {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(0, 229, 255, 0.3);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .webinar-card:hover {
            transform: translateY(-8px);
            border-color: #00e5ff;
            box-shadow: 0 15px 30px rgba(0, 229, 255, 0.2);
        }

        .webinar-status {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .status-live {
            background: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
            border: 1px solid rgba(76, 175, 80, 0.3);
        }

        .status-upcoming {
            background: rgba(255, 193, 7, 0.2);
            color: #FFC107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .status-recorded {
            background: rgba(158, 158, 158, 0.2);
            color: #9E9E9E;
            border: 1px solid rgba(158, 158, 158, 0.3);
        }

        .webinar-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            color: #ccc;
            font-size: 13px;
            align-items: center;
            flex-wrap: wrap;
        }

        .speaker-info {
            background: rgba(0, 229, 255, 0.2);
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
            color: #00e5ff;
        }

        .date-time {
            background: rgba(0, 188, 212, 0.2);
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
        }

        .duration {
            color: #aaa;
            font-size: 12px;
        }

        .webinar-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #00e5ff;
        }

        .webinar-description {
            color: #ddd;
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 15px;
        }

        .webinar-topics {
            list-style: none;
            margin-bottom: 20px;
        }

        .webinar-topics li {
            color: #ddd;
            margin-bottom: 5px;
            padding-left: 20px;
            position: relative;
            font-size: 14px;
        }

        .webinar-topics li::before {
            content: '•';
            color: #00e5ff;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .register-btn {
            background: linear-gradient(45deg, #00e5ff, #00bcd4);
            color: #000;
            padding: 12px 25px;
            border: none;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
            width: 100%;
            text-align: center;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 229, 255, 0.4);
        }

        .register-btn.watch-now {
            background: linear-gradient(45deg, #4CAF50, #45a049);
            color: white;
        }

        .register-btn.view-recording {
            background: linear-gradient(45deg, #9E9E9E, #757575);
            color: white;
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

            .webinars-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .page-title {
                font-size: 32px;
            }

            .featured-webinar {
                padding: 25px;
            }

            .featured-title {
                font-size: 24px;
            }

            .featured-details {
                grid-template-columns: 1fr;
            }

            .filter-buttons {
                gap: 10px;
            }

            .filter-btn {
                padding: 6px 12px;
                font-size: 12px;
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

        .webinar-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .webinar-card:nth-child(1) { animation-delay: 0.1s; }
        .webinar-card:nth-child(2) { animation-delay: 0.2s; }
        .webinar-card:nth-child(3) { animation-delay: 0.3s; }
        .webinar-card:nth-child(4) { animation-delay: 0.4s; }
        .webinar-card:nth-child(5) { animation-delay: 0.5s; }
        .webinar-card:nth-child(6) { animation-delay: 0.6s; }

        /* Pulse effect for live webinars */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(76, 175, 80, 0); }
            100% { box-shadow: 0 0 0 0 rgba(76, 175, 80, 0); }
        }

        .status-live {
            animation: pulse 2s infinite;
        }
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
            <h1 class="page-title">Business Webinars</h1>
            <p class="page-subtitle">Join live sessions with industry experts and successful entrepreneurs</p>
        </div>

        <!-- Sub Navigation -->
        <nav class="sub-nav">
            <ul>
                <li><a href="learnx_home.php">Home</a></li>
                <li><a href="articles.php">Articles</a></li>
                <li><a href="videos.php">Videos</a></li>
                <li><a href="case_studies.php">Case Studies</a></li>
                <li><a href="quizzes.php">Quizzes</a></li>
                <li><a href="webinars.php" class="active">Webinars</a></li>
            </ul>
        </nav>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">25+</div>
                    <div class="stat-label">Monthly Webinars</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">5k+</div>
                    <div class="stat-label">Participants</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Expert Speakers</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Recordings Available</div>
                </div>
            </div>
        </div>

        <!-- Featured Webinar -->
        <div class="featured-webinar">
            <span class="featured-badge">🔴 LIVE THIS WEEK</span>
            <h2 class="featured-title">Harvard Entrepreneurship Summit 2025</h2>
            <p class="featured-description">
                Join 25+ founders from leading companies like Perplexity, Beli, and Cotopaxi for insights on modern entrepreneurship and scaling strategies.
            </p>
            <div class="featured-details">
                <div class="detail-item">
                    <div class="detail-label">Date & Time</div>
                    <div class="detail-value">August 25, 2025 • 2:00 PM EST</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Duration</div>
                    <div class="detail-value">Full Day Event</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Speakers</div>
                    <div class="detail-value">25+ Industry Leaders</div>
                </div>
            </div>
            <a href="#" class="register-btn">Register for Free</a>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">All Webinars</button>
                <button class="filter-btn" data-filter="upcoming">Upcoming</button>
                <button class="filter-btn" data-filter="live">Live Now</button>
                <button class="filter-btn" data-filter="recorded">Recordings</button>
                <button class="filter-btn" data-filter="fundraising">Fundraising</button>
                <button class="filter-btn" data-filter="growth">Growth</button>
                <button class="filter-btn" data-filter="leadership">Leadership</button>
            </div>
        </div>

        <!-- Webinars Grid -->
        <div class="webinars-grid">
            <!-- Live Webinar -->
            <div class="webinar-card" data-category="live fundraising">
                <span class="webinar-status status-live">🔴 LIVE NOW</span>
                <div class="webinar-meta">
                    <span class="speaker-info">👤 Sarah Chen, VC Partner</span>
                    <span class="date-time">📅 Aug 21 • 3:00 PM EST</span>
                    <span class="duration">⏱️ 60 mins</span>
                </div>
                <h2 class="webinar-title">Fundraising Tactics That Actually Work</h2>
                <p class="webinar-description">
                    Learn proven strategies for securing seed funding from a top-tier VC partner. Discover what investors really look for and how to craft compelling pitches.
                </p>
                <ul class="webinar-topics">
                    <li>Essential elements of a winning pitch deck</li>
                    <li>Common mistakes that kill funding deals</li>
                    <li>How to value your startup correctly</li>
                    <li>Building relationships with investors</li>
                </ul>
                <a href="#" class="register-btn watch-now">Join Live Session</a>
            </div>

            <!-- Upcoming Webinar -->
            <div class="webinar-card" data-category="upcoming growth">
                <span class="webinar-status status-upcoming">📅 UPCOMING</span>
                <div class="webinar-meta">
                    <span class="speaker-info">👤 Marcus Johnson, Growth Expert</span>
                    <span class="date-time">📅 Aug 25 • 2:00 PM EST</span>
                    <span class="duration">⏱️ 90 mins</span>
                </div>
                <h2 class="webinar-title">Data-Driven Business Growth Strategies</h2>
                <p class="webinar-description">
                    Discover how successful startups use analytics and data to reshape their growth strategies and accelerate customer acquisition.
                </p>
                <ul class="webinar-topics">
                    <li>Setting up effective growth metrics</li>
                    <li>A/B testing for product optimization</li>
                    <li>Customer acquisition cost optimization</li>
                    <li>Using data to drive strategic decisions</li>
                </ul>
                <a href="#" class="register-btn">Register Now</a>
            </div>

            <!-- Upcoming Webinar 2 -->
            <div class="webinar-card" data-category="upcoming leadership">
                <span class="webinar-status status-upcoming">📅 UPCOMING</span>
                <div class="webinar-meta">
                    <span class="speaker-info">👤 Dr. Amanda Rodriguez</span>
                    <span class="date-time">📅 Aug 28 • 1:00 PM EST</span>
                    <span class="duration">⏱️ 75 mins</span>
                </div>
                <h2 class="webinar-title">Building High-Performance Teams</h2>
                <p class="webinar-description">
                    Learn how to recruit, motivate, and retain top talent while building a culture of innovation and accountability in your startup.
                </p>
                <ul class="webinar-topics">
                    <li>Effective hiring strategies for startups</li>
                    <li>Creating a strong company culture</li>
                    <li>Remote team management best practices</li>
                    <li>Performance management and feedback systems</li>
                </ul>
                <a href="#" class="register-btn">Register Now</a>
            </div>

            <!-- Recorded Webinar -->
            <div class="webinar-card" data-category="recorded growth">
                <span class="webinar-status status-recorded">📼 RECORDED</span>
                <div class="webinar-meta">
                    <span class="speaker-info">👤 Small Business Expo</span>
                    <span class="date-time">📅 Aug 15 • Recorded</span>
                    <span class="duration">⏱️ 45 mins</span>
                </div>
                <h2 class="webinar-title">Small Business Success Stories 2025</h2>
                <p class="webinar-description">
                    Inspiring stories from entrepreneurs who built successful businesses from scratch. Learn from their challenges, victories, and key insights.
                </p>
                <ul class="webinar-topics">
                    <li>Real entrepreneur success journeys</li>
                    <li>Overcoming common business challenges</li>
                    <li>Scaling strategies that work</li>
                    <li>Key lessons learned from failures</li>
                </ul>
                <a href="#" class="register-btn view-recording">Watch Recording</a>
            </div>

            <!-- Upcoming Webinar 3 -->
            <div class="webinar-card" data-category="upcoming fundraising">
                <span class="webinar-status status-upcoming">📅 UPCOMING</span>
                <div class="webinar-meta">
                    <span class="speaker-info">👤 SCORE Mentors</span>
                    <span class="date-time">📅 Sep 2 • 11:00 AM EST</span>
                    <span class="duration">⏱️ 90 mins</span>
                </div>
                <h2 class="webinar-title">First Step Express: Starting Your Business</h2>
                <p class="webinar-description">
                    Perfect for aspiring entrepreneurs who dream of starting their own business but aren't sure where to begin. Get the fundamentals right.
                </p>
                <ul class="webinar-topics">
                    <li>Business idea validation techniques</li>
                    <li>Legal structure and registration process</li>
                    <li>Financial planning for startups</li>
                    <li>Marketing your new business</li>
                </ul>
                <a href="#" class="register-btn">Register Now</a>
            </div>

            <!-- Recorded Webinar 2 -->
            <div class="webinar-card" data-category="recorded leadership">
                <span class="webinar-status status-recorded">📼 RECORDED</span>
                <div class="webinar-meta">
                    <span class="speaker-info">👤 Global Summit Speakers</span>
                    <span class="date-time">📅 Aug 10 • Recorded</span>
                    <span class="duration">⏱️ 120 mins</span>
                </div>
                <h2 class="webinar-title">Empowering Global Leaders in Business</h2>
                <p class="webinar-description">
                    Comprehensive session on modern leadership principles, innovation strategies, and building sustainable business practices for the future.
                </p>
                <ul class="webinar-topics">
                    <li>Leadership in the digital age</li>
                    <li>Innovation management strategies</li>
                    <li>Sustainable business practices</li>
                    <li>Global market expansion tactics</li>
                </ul>
                <a href="#" class="register-btn view-recording">Watch Recording</a>
            </div>
        </div>
    </div>

    <script>
        // Filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const webinarCards = document.querySelectorAll('.webinar-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                button.classList.add('active');
                
                const filter = button.getAttribute('data-filter');
                
                webinarCards.forEach(card => {
                    if (filter === 'all') {
                        card.style.display = 'block';
                        card.style.animation = 'fadeInUp 0.6s ease forwards';
                    } else {
                        const categories = card.getAttribute('data-category');
                        if (categories && categories.includes(filter)) {
                            card.style.display = 'block';
                            card.style.animation = 'fadeInUp 0.6s ease forwards';
                        } else {
                            card.style.display = 'none';
                        }
                    }
                });
                
                console.log(`Filter applied: ${filter}`);
            });
        });

        // Enhanced hover effects
        document.querySelectorAll('.webinar-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Registration tracking
        document.querySelectorAll('.register-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const webinarTitle = this.closest('.webinar-card').querySelector('.webinar-title').textContent;
                const isLive = this.textContent.includes('Join Live');
                const isRecording = this.textContent.includes('Watch Recording');
                
                if (isLive) {
                    console.log(`Joining live webinar: ${webinarTitle}`);
                    alert('Redirecting to live webinar room...');
                } else if (isRecording) {
                    console.log(`Watching recording: ${webinarTitle}`);
                    alert('Loading webinar recording...');
                } else {
                    console.log(`Registering for webinar: ${webinarTitle}`);
                    alert('Registration form will open...');
                }
            });
        });

        // Featured webinar registration
        document.querySelector('.featured-webinar .register-btn').addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Registering for featured webinar: Harvard Entrepreneurship Summit 2025');
            alert('Redirecting to Harvard Business School event page...');
        });

        // Auto-update live status (simulation)
        setInterval(() => {
            const liveCards = document.querySelectorAll('.status-live');
            liveCards.forEach(status => {
                const now = new Date();
                const hours = now.getHours();
                if (hours < 15 || hours > 16) { // Simulating webinar ended
                    status.textContent = '📼 RECORDED';
                    status.className = 'webinar-status status-recorded';
                    const btn = status.closest('.webinar-card').querySelector('.register-btn');
                    btn.textContent = 'Watch Recording';
                    btn.className = 'register-btn view-recording';
                }
            });
        }, 60000); // Check every minute

        console.log("Webinars page loaded successfully");
    </script>
</body>
</html>