<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnX - Business Articles</title>
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

        /* Articles Grid */
        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
        }

        .article-card {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(0, 229, 255, 0.3);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .article-card:hover {
            transform: translateY(-8px);
            border-color: #00e5ff;
            box-shadow: 0 15px 30px rgba(0, 229, 255, 0.2);
        }

        .article-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            color: #ccc;
            font-size: 13px;
            align-items: center;
        }

        .article-author {
            background: rgba(0, 229, 255, 0.2);
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
            color: #00e5ff;
        }

        .article-date {
            background: rgba(0, 188, 212, 0.2);
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
        }

        .read-time {
            color: #aaa;
            font-size: 12px;
        }

        .article-title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #00e5ff;
        }

        .article-excerpt {
            color: #ddd;
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 15px;
        }

        .article-tags {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
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

        .read-more-btn {
            background: linear-gradient(45deg, #00e5ff, #00bcd4);
            color: #000;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .read-more-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 229, 255, 0.4);
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

        /* Featured Article */
        .featured-article {
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
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 15px;
        }

        .featured-title {
            font-size: 28px;
            color: #00e5ff;
            margin-bottom: 15px;
        }

        .featured-excerpt {
            font-size: 16px;
            color: #ddd;
            line-height: 1.6;
            margin-bottom: 20px;
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

            .articles-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .page-title {
                font-size: 32px;
            }

            .sub-nav ul {
                gap: 10px;
            }

            .sub-nav a {
                padding: 6px 12px;
                font-size: 14px;
            }

            .featured-article {
                padding: 25px;
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

        .article-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .article-card:nth-child(1) { animation-delay: 0.1s; }
        .article-card:nth-child(2) { animation-delay: 0.2s; }
        .article-card:nth-child(3) { animation-delay: 0.3s; }
        .article-card:nth-child(4) { animation-delay: 0.4s; }
        .article-card:nth-child(5) { animation-delay: 0.5s; }
        .article-card:nth-child(6) { animation-delay: 0.6s; }
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
            <h1 class="page-title">Business Articles</h1>
            <p class="page-subtitle">Expert insights and practical guides for entrepreneurs</p>
        </div>

        <!-- Sub Navigation -->
        <nav class="sub-nav">
            <ul>
                <li><a href="learnx_home.php">Home</a></li>
                <li><a href="articles.php" class="active">Articles</a></li>
                <li><a href="videos.php">Videos</a></li>
                <li><a href="case_studies.php">Case Studies</a></li>
                <li><a href="quizzes.php">Quizzes</a></li>
                <li><a href="webinars.php">Webinars</a></li>
            </ul>
        </nav>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">150+</div>
                    <div class="stat-label">Articles</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">25+</div>
                    <div class="stat-label">Expert Authors</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50k+</div>
                    <div class="stat-label">Readers</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">Weekly</div>
                    <div class="stat-label">New Content</div>
                </div>
            </div>
        </div>

        <!-- Featured Article -->
        <div class="featured-article">
            <span class="featured-badge">🔥 TRENDING</span>
            <h2 class="featured-title">Entrepreneurship Trends for 2025</h2>
            <p class="featured-excerpt">
                Discover the emerging sectors and technologies that will shape entrepreneurship in 2025, from AI-powered startups to sustainable business models.
            </p>
            <a href="#" class="read-more-btn">Read Featured Article</a>
        </div>

        <!-- Articles Grid -->
        <div class="articles-grid">
            <!-- Article 1 -->
            <div class="article-card">
                <div class="article-meta">
                    <span class="article-author">👤 William Sahlman</span>
                    <span class="article-date">📅 Jan 2025</span>
                    <span class="read-time">⏱️ 8 min read</span>
                </div>
                <h2 class="article-title">How to Write a Winning Business Plan</h2>
                <p class="article-excerpt">
                    Harvard Business School professor William Sahlman breaks down the essential components of a business plan that attracts investors and sets your startup up for success.
                </p>
                <div class="article-tags">
                    <span class="tag">Business Planning</span>
                    <span class="tag">Funding</span>
                    <span class="tag">Strategy</span>
                </div>
                <a href="#" class="read-more-btn">Read More</a>
            </div>

            <!-- Article 2 -->
            <div class="article-card">
                <div class="article-meta">
                    <span class="article-author">👤 Ron Ashkenas</span>
                    <span class="article-date">📅 Dec 2024</span>
                    <span class="read-time">⏱️ 6 min read</span>
                </div>
                <h2 class="article-title">The Go-to-Market Approach Startups Need</h2>
                <p class="article-excerpt">
                    Learn the strategic framework that successful startups use to bring their products to market effectively and build sustainable customer relationships.
                </p>
                <div class="article-tags">
                    <span class="tag">Marketing</span>
                    <span class="tag">Sales Strategy</span>
                    <span class="tag">Customer Acquisition</span>
                </div>
                <a href="#" class="read-more-btn">Read More</a>
            </div>

            <!-- Article 3 -->
            <div class="article-card">
                <div class="article-meta">
                    <span class="article-author">👤 QuickBooks Research</span>
                    <span class="article-date">📅 Dec 2024</span>
                    <span class="read-time">⏱️ 12 min read</span>
                </div>
                <h2 class="article-title">Small Business Trends for 2025</h2>
                <p class="article-excerpt">
                    Comprehensive analysis of emerging trends in entrepreneurship, including technology adoption, funding patterns, and market opportunities for small businesses.
                </p>
                <div class="article-tags">
                    <span class="tag">Trends</span>
                    <span class="tag">Market Analysis</span>
                    <span class="tag">Technology</span>
                </div>
                <a href="#" class="read-more-btn">Read More</a>
            </div>

            <!-- Article 4 -->
            <div class="article-card">
                <div class="article-meta">
                    <span class="article-author">👤 Entrepreneur Magazine</span>
                    <span class="article-date">📅 Jan 2025</span>
                    <span class="read-time">⏱️ 15 min read</span>
                </div>
                <h2 class="article-title">70 Profitable Small Business Ideas</h2>
                <p class="article-excerpt">
                    A comprehensive guide to the most profitable and viable small business opportunities for entrepreneurs looking to start their venture in 2025.
                </p>
                <div class="article-tags">
                    <span class="tag">Business Ideas</span>
                    <span class="tag">Opportunities</span>
                    <span class="tag">Profitability</span>
                </div>
                <a href="#" class="read-more-btn">Read More</a>
            </div>

            <!-- Article 5 -->
            <div class="article-card">
                <div class="article-meta">
                    <span class="article-author">👤 Center for American Progress</span>
                    <span class="article-date">📅 Oct 2024</span>
                    <span class="read-time">⏱️ 10 min read</span>
                </div>
                <h2 class="article-title">Entrepreneurship is Booming Across the U.S.</h2>
                <p class="article-excerpt">
                    Analysis of the unprecedented boom in business formation and its impact on local economies, job creation, and economic growth patterns.
                </p>
                <div class="article-tags">
                    <span class="tag">Economics</span>
                    <span class="tag">Job Creation</span>
                    <span class="tag">Business Formation</span>
                </div>
                <a href="#" class="read-more-btn">Read More</a>
            </div>

            <!-- Article 6 -->
            <div class="article-card">
                <div class="article-meta">
                    <span class="article-author">👤 South Summit</span>
                    <span class="article-date">📅 Feb 2025</span>
                    <span class="read-time">⏱️ 7 min read</span>
                </div>
                <h2 class="article-title">Top Emerging Sectors for Entrepreneurship</h2>
                <p class="article-excerpt">
                    Explore the most promising sectors for new entrepreneurs, including AI, renewable energy, digital health, and fintech opportunities.
                </p>
                <div class="article-tags">
                    <span class="tag">Emerging Markets</span>
                    <span class="tag">Technology</span>
                    <span class="tag">Innovation</span>
                </div>
                <a href="#" class="read-more-btn">Read More</a>
            </div>
        </div>
    </div>

    <script>
        // Add click tracking for articles
        document.querySelectorAll('.article-card').forEach((card, index) => {
            card.addEventListener('click', function(e) {
                if (!e.target.classList.contains('read-more-btn')) {
                    const title = this.querySelector('.article-title').textContent;
                    console.log(`Article clicked: ${title}`);
                }
            });
        });

        // Enhanced hover effects
        document.querySelectorAll('.article-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Featured article interaction
        document.querySelector('.featured-article').addEventListener('click', function() {
            console.log('Featured article clicked');
        });

        console.log("Articles page loaded successfully");
    </script>
</body>
</html>