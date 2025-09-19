<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnX - Business Quizzes</title>
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

        /* Featured Quiz */
        .featured-quiz {
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
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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

        /* Quiz Filters */
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

        /* Quizzes Grid */
        .quizzes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
        }

        .quiz-card {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(0, 229, 255, 0.3);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .quiz-card:hover {
            transform: translateY(-8px);
            border-color: #00e5ff;
            box-shadow: 0 15px 30px rgba(0, 229, 255, 0.2);
        }

        .quiz-difficulty {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .difficulty-beginner {
            background: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
            border: 1px solid rgba(76, 175, 80, 0.3);
        }

        .difficulty-intermediate {
            background: rgba(255, 193, 7, 0.2);
            color: #FFC107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .difficulty-advanced {
            background: rgba(244, 67, 54, 0.2);
            color: #F44336;
            border: 1px solid rgba(244, 67, 54, 0.3);
        }

        .quiz-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            color: #ccc;
            font-size: 13px;
            align-items: center;
            flex-wrap: wrap;
        }

        .quiz-questions {
            background: rgba(0, 229, 255, 0.2);
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
            color: #00e5ff;
        }

        .quiz-duration {
            background: rgba(0, 188, 212, 0.2);
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
        }

        .quiz-attempts {
            color: #aaa;
            font-size: 12px;
        }

        .quiz-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #00e5ff;
        }

        .quiz-description {
            color: #ddd;
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 15px;
        }

        .quiz-topics {
            list-style: none;
            margin-bottom: 20px;
        }

        .quiz-topics li {
            color: #ddd;
            margin-bottom: 5px;
            padding-left: 20px;
            position: relative;
            font-size: 14px;
        }

        .quiz-topics li::before {
            content: '•';
            color: #00e5ff;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .quiz-progress {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
            height: 8px;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .quiz-progress-bar {
            height: 100%;
            background: linear-gradient(45deg, #00e5ff, #00bcd4);
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        .quiz-score {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            color: #ccc;
            font-size: 14px;
        }

        .take-quiz-btn {
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

        .take-quiz-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 229, 255, 0.4);
        }

        .take-quiz-btn.retake {
            background: linear-gradient(45deg, #FFC107, #FF9800);
            color: #000;
        }

        .take-quiz-btn.completed {
            background: linear-gradient(45deg, #4CAF50, #45a049);
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

            .quizzes-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .page-title {
                font-size: 32px;
            }

            .featured-quiz {
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

        .quiz-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .quiz-card:nth-child(1) { animation-delay: 0.1s; }
        .quiz-card:nth-child(2) { animation-delay: 0.2s; }
        .quiz-card:nth-child(3) { animation-delay: 0.3s; }
        .quiz-card:nth-child(4) { animation-delay: 0.4s; }
        .quiz-card:nth-child(5) { animation-delay: 0.5s; }
        .quiz-card:nth-child(6) { animation-delay: 0.6s; }

        /* Pulse effect for new quizzes */
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 229, 255, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(0, 229, 255, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 229, 255, 0); }
        }

        .featured-quiz {
            animation: pulse 3s infinite;
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
            <h1 class="page-title">Business Quizzes</h1>
            <p class="page-subtitle">Test your entrepreneurial knowledge and track your learning progress</p>
        </div>

        <!-- Sub Navigation -->
        <nav class="sub-nav">
            <ul>
                <li><a href="learnx_home.php">Home</a></li>
                <li><a href="articles.php">Articles</a></li>
                <li><a href="videos.php">Videos</a></li>
                <li><a href="case_studies.php">Case Studies</a></li>
                <li><a href="quizzes.php" class="active">Quizzes</a></li>
                <li><a href="webinars.php">Webinars</a></li>
            </ul>
        </nav>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Available Quizzes</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">10k+</div>
                    <div class="stat-label">Quiz Attempts</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">85%</div>
                    <div class="stat-label">Average Score</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">3k+</div>
                    <div class="stat-label">Active Learners</div>
                </div>
            </div>
        </div>

        <!-- Featured Quiz -->
        <div class="featured-quiz">
            <span class="featured-badge">🔥 TRENDING NOW</span>
            <h2 class="featured-title">Ultimate Entrepreneurship Challenge</h2>
            <p class="featured-description">
                Put your business knowledge to the test with our comprehensive 50-question challenge covering all aspects of modern entrepreneurship.
            </p>
            <div class="featured-details">
                <div class="detail-item">
                    <div class="detail-label">Questions</div>
                    <div class="detail-value">50 Questions</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Duration</div>
                    <div class="detail-value">45 Minutes</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Difficulty</div>
                    <div class="detail-value">Mixed Levels</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Certificate</div>
                    <div class="detail-value">Available</div>
                </div>
            </div>
            <a href="#" class="take-quiz-btn">Start Challenge</a>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">All Quizzes</button>
                <button class="filter-btn" data-filter="beginner">Beginner</button>
                <button class="filter-btn" data-filter="intermediate">Intermediate</button>
                <button class="filter-btn" data-filter="advanced">Advanced</button>
                <button class="filter-btn" data-filter="startup">Startup</button>
                <button class="filter-btn" data-filter="marketing">Marketing</button>
                <button class="filter-btn" data-filter="finance">Finance</button>
            </div>
        </div>

        <!-- Quizzes Grid -->
        <div class="quizzes-grid">
            <!-- Beginner Quiz -->
            <div class="quiz-card" data-category="beginner startup">
                <span class="quiz-difficulty difficulty-beginner">🟢 BEGINNER</span>
                <div class="quiz-meta">
                    <span class="quiz-questions">📊 15 Questions</span>
                    <span class="quiz-duration">⏱️ 10 mins</span>
                    <span class="quiz-attempts">👥 2.3k attempts</span>
                </div>
                <h2 class="quiz-title">Startup Fundamentals Quiz</h2>
                <p class="quiz-description">
                    Test your understanding of startup essentials, from idea validation to basic business planning. Perfect for aspiring entrepreneurs.
                </p>
                <ul class="quiz-topics">
                    <li>Business idea validation</li>
                    <li>Market research basics</li>
                    <li>MVP development concepts</li>
                    <li>Basic business planning</li>
                </ul>
                <div class="quiz-progress">
                    <div class="quiz-progress-bar" style="width: 0%"></div>
                </div>
                <div class="quiz-score">
                    <span>Best Score: Not taken</span>
                    <span>Attempts: 0</span>
                </div>
                <a href="#" class="take-quiz-btn">Take Quiz</a>
            </div>

            <!-- Intermediate Quiz -->
            <div class="quiz-card" data-category="intermediate marketing">
                <span class="quiz-difficulty difficulty-intermediate">🟡 INTERMEDIATE</span>
                <div class="quiz-meta">
                    <span class="quiz-questions">📊 20 Questions</span>
                    <span class="quiz-duration">⏱️ 15 mins</span>
                    <span class="quiz-attempts">👥 1.8k attempts</span>
                </div>
                <h2 class="quiz-title">Marketing Strategy Quiz</h2>
                <p class="quiz-description">
                    Evaluate your knowledge of low-budget marketing tactics, digital marketing strategies, and customer acquisition methods.
                </p>
                <ul class="quiz-topics">
                    <li>Digital marketing fundamentals</li>
                    <li>Social media marketing</li>
                    <li>Content marketing strategies</li>
                    <li>Customer acquisition tactics</li>
                </ul>
                <div class="quiz-progress">
                    <div class="quiz-progress-bar" style="width: 75%"></div>
                </div>
                <div class="quiz-score">
                    <span>Best Score: 78%</span>
                    <span>Attempts: 2</span>
                </div>
                <a href="#" class="take-quiz-btn retake">Retake Quiz</a>
            </div>

            <!-- Advanced Quiz -->
            <div class="quiz-card" data-category="advanced finance">
                <span class="quiz-difficulty difficulty-advanced">🔴 ADVANCED</span>
                <div class="quiz-meta">
                    <span class="quiz-questions">📊 25 Questions</span>
                    <span class="quiz-duration">⏱️ 20 mins</span>
                    <span class="quiz-attempts">👥 956 attempts</span>
                </div>
                <h2 class="quiz-title">Financial Management Mastery</h2>
                <p class="quiz-description">
                    Advanced financial concepts including cash flow management, fundraising strategies, and financial planning for scaling businesses.
                </p>
                <ul class="quiz-topics">
                    <li>Advanced cash flow analysis</li>
                    <li>Fundraising and valuation</li>
                    <li>Financial modeling</li>
                    <li>Investment strategies</li>
                </ul>
                <div class="quiz-progress">
                    <div class="quiz-progress-bar" style="width: 100%"></div>
                </div>
                <div class="quiz-score">
                    <span>Best Score: 92%</span>
                    <span>Attempts: 3</span>
                </div>
                <a href="#" class="take-quiz-btn completed">View Results</a>
            </div>

            <!-- Beginner Quiz 2 -->
            <div class="quiz-card" data-category="beginner startup">
                <span class="quiz-difficulty difficulty-beginner">🟢 BEGINNER</span>
                <div class="quiz-meta">
                    <span class="quiz-questions">📊 12 Questions</span>
                    <span class="quiz-duration">⏱️ 8 mins</span>
                    <span class="quiz-attempts">👥 3.1k attempts</span>
                </div>
                <h2 class="quiz-title">Business Model Canvas Quiz</h2>
                <p class="quiz-description">
                    Learn and test your understanding of the Business Model Canvas framework and how to apply it to your startup idea.
                </p>
                <ul class="quiz-topics">
                    <li>9 Building blocks of BMC</li>
                    <li>Value propositions</li>
                    <li>Customer segments</li>
                    <li>Revenue streams</li>
                </ul>
                <div class="quiz-progress">
                    <div class="quiz-progress-bar" style="width: 0%"></div>
                </div>
                <div class="quiz-score">
                    <span>Best Score: Not taken</span>
                    <span>Attempts: 0</span>
                </div>
                <a href="#" class="take-quiz-btn">Take Quiz</a>
            </div>

            <!-- Intermediate Quiz 2 -->
            <div class="quiz-card" data-category="intermediate startup">
                <span class="quiz-difficulty difficulty-intermediate">🟡 INTERMEDIATE</span>
                <div class="quiz-meta">
                    <span class="quiz-questions">📊 18 Questions</span>
                    <span class="quiz-duration">⏱️ 12 mins</span>
                    <span class="quiz-attempts">👥 1.5k attempts</span>
                </div>
                <h2 class="quiz-title">Growth Hacking Essentials</h2>
                <p class="quiz-description">
                    Test your knowledge of growth hacking techniques, metrics that matter, and scalable growth strategies for startups.
                </p>
                <ul class="quiz-topics">
                    <li>Growth metrics and KPIs</li>
                    <li>A/B testing strategies</li>
                    <li>Viral marketing techniques</li>
                    <li>Product-led growth</li>
                </ul>
                <div class="quiz-progress">
                    <div class="quiz-progress-bar" style="width: 40%"></div>
                </div>
                <div class="quiz-score">
                    <span>Best Score: 65%</span>
                    <span>Attempts: 1</span>
                </div>
                <a href="#" class="take-quiz-btn">Continue Quiz</a>
            </div>

            <!-- Advanced Quiz 2 -->
            <div class="quiz-card" data-category="advanced startup">
                <span class="quiz-difficulty difficulty-advanced">🔴 ADVANCED</span>
                <div class="quiz-meta">
                    <span class="quiz-questions">📊 30 Questions</span>
                    <span class="quiz-duration">⏱️ 25 mins</span>
                    <span class="quiz-attempts">👥 678 attempts</span>
                </div>
                <h2 class="quiz-title">Scaling & Leadership Challenge</h2>
                <p class="quiz-description">
                    Advanced concepts in scaling operations, team leadership, and strategic decision-making for growing businesses.
                </p>
                <ul class="quiz-topics">
                    <li>Organizational design</li>
                    <li>Leadership styles</li>
                    <li>Strategic planning</li>
                    <li>Change management</li>
                </ul>
                <div class="quiz-progress">
                    <div class="quiz-progress-bar" style="width: 0%"></div>
                </div>
                <div class="quiz-score">
                    <span>Best Score: Not taken</span>
                    <span>Attempts: 0</span>
                </div>
                <a href="#" class="take-quiz-btn">Take Quiz</a>
            </div>
        </div>
    </div>

    <script>
        // Filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const quizCards = document.querySelectorAll('.quiz-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                button.classList.add('active');
                
                const filter = button.getAttribute('data-filter');
                
                quizCards.forEach(card => {
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
        document.querySelectorAll('.quiz-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Quiz taking functionality
        document.querySelectorAll('.take-quiz-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const quizTitle = this.closest('.quiz-card').querySelector('.quiz-title').textContent;
                const isRetake = this.textContent.includes('Retake');
                const isCompleted = this.textContent.includes('View Results');
                const isContinue = this.textContent.includes('Continue');
                
                if (isCompleted) {
                    console.log(`Viewing results for: ${quizTitle}`);
                    alert('Opening detailed quiz results...');
                } else if (isRetake) {
                    console.log(`Retaking quiz: ${quizTitle}`);
                    alert('Starting quiz from the beginning...');
                } else if (isContinue) {
                    console.log(`Continuing quiz: ${quizTitle}`);
                    alert('Resuming quiz from where you left off...');
                } else {
                    console.log(`Starting quiz: ${quizTitle}`);
                    alert('Loading quiz interface...');
                }
            });
        });

        // Featured quiz functionality
        document.querySelector('.featured-quiz .take-quiz-btn').addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Starting Ultimate Entrepreneurship Challenge');
            alert('Preparing comprehensive quiz challenge...');
        });

        // Progress bar animation on page load
        window.addEventListener('load', function() {
            const progressBars = document.querySelectorAll('.quiz-progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });
        });

        // Simulate quiz progress updates
        function updateQuizProgress(cardIndex, progress, score, attempts) {
            const cards = document.querySelectorAll('.quiz-card');
            if (cards[cardIndex]) {
                const progressBar = cards[cardIndex].querySelector('.quiz-progress-bar');
                const scoreElement = cards[cardIndex].querySelector('.quiz-score');
                const button = cards[cardIndex].querySelector('.take-quiz-btn');
                
                progressBar.style.width = progress + '%';
                scoreElement.innerHTML = `<span>Best Score: ${score}%</span><span>Attempts: ${attempts}</span>`;
                
                if (progress === 100) {
                    button.textContent = 'View Results';
                    button.className = 'take-quiz-btn completed';
                } else if (attempts > 0) {
                    button.textContent = 'Retake Quiz';
                    button.className = 'take-quiz-btn retake';
                }
            }
        }

        // Track user interactions for analytics
        let userInteractions = {
            quizesViewed: 0,
            filtersUsed: [],
            quizesAttempted: []
        };

        // Log filter usage
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-filter');
                if (!userInteractions.filtersUsed.includes(filter)) {
                    userInteractions.filtersUsed.push(filter);
                }
                console.log('User interactions:', userInteractions);
            });
        });

        // Log quiz attempts
        document.querySelectorAll('.take-quiz-btn').forEach((btn, index) => {
            btn.addEventListener('click', () => {
                const quizTitle = btn.closest('.quiz-card').querySelector('.quiz-title').textContent;
                if (!userInteractions.quizesAttempted.includes(quizTitle)) {
                    userInteractions.quizesAttempted.push(quizTitle);
                }
                console.log('User interactions:', userInteractions);
            });
        });

        // Count quiz views
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    userInteractions.quizesViewed++;
                }
            });
        });

        document.querySelectorAll('.quiz-card').forEach(card => {
            observer.observe(card);
        });

        console.log("Quizzes page loaded successfully with enhanced features");
    </script>
</body>
</html>