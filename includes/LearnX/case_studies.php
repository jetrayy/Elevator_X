<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnX - Business Case Studies</title>
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

        /* Case Studies Grid */
        .case-studies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 30px;
        }

        .case-study-card {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(0, 229, 255, 0.3);
            border-radius: 20px;
            padding: 30px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .case-study-card:hover {
            transform: translateY(-8px);
            border-color: #00e5ff;
            box-shadow: 0 15px 30px rgba(0, 229, 255, 0.2);
        }

        .case-meta {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            color: #ccc;
            font-size: 13px;
            align-items: center;
            flex-wrap: wrap;
        }

        .company-logo {
            background: rgba(0, 229, 255, 0.2);
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
            color: #00e5ff;
            font-weight: bold;
        }

        .industry-tag {
            background: rgba(0, 188, 212, 0.2);
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
        }

        .revenue-tag {
            background: rgba(76, 175, 80, 0.2);
            color: #4CAF50;
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: bold;
        }

        .case-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #00e5ff;
        }

        .case-summary {
            color: #ddd;
            line-height: 1.6;
            margin-bottom: 20px;
            font-size: 15px;
        }

        .case-metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
            padding: 20px;
            background: rgba(0, 229, 255, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(0, 229, 255, 0.1);
        }

        .metric {
            text-align: center;
        }

        .metric-value {
            font-size: 18px;
            font-weight: bold;
            color: #00e5ff;
            margin-bottom: 5px;
        }

        .metric-label {
            font-size: 12px;
            color: #ccc;
        }

        .case-highlights {
            list-style: none;
            margin-bottom: 25px;
        }

        .case-highlights li {
            color: #ddd;
            margin-bottom: 8px;
            padding-left: 20px;
            position: relative;
            font-size: 14px;
        }

        .case-highlights li::before {
            content: '✓';
            color: #00e5ff;
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .read-case-btn {
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
        }

        .read-case-btn:hover {
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

        /* Featured Case Study */
        .featured-case {
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

        .featured-description {
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

            .case-studies-grid {
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

            .featured-case {
                padding: 25px;
            }

            .case-metrics {
                grid-template-columns: repeat(2, 1fr);
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

        .case-study-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .case-study-card:nth-child(1) { animation-delay: 0.1s; }
        .case-study-card:nth-child(2) { animation-delay: 0.2s; }
        .case-study-card:nth-child(3) { animation-delay: 0.3s; }
        .case-study-card:nth-child(4) { animation-delay: 0.4s; }
        .case-study-card:nth-child(5) { animation-delay: 0.5s; }
        .case-study-card:nth-child(6) { animation-delay: 0.6s; }
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
            <h1 class="page-title">Business Case Studies</h1>
            <p class="page-subtitle">Real startup success stories and business transformation journeys</p>
        </div>

        <!-- Sub Navigation -->
        <nav class="sub-nav">
            <ul>
                <li><a href="learnx_home.php">Home</a></li>
                <li><a href="articles.php">Articles</a></li>
                <li><a href="videos.php">Videos</a></li>
                <li><a href="case_studies.php" class="active">Case Studies</a></li>
                <li><a href="quizzes.php">Quizzes</a></li>
                <li><a href="webinars.php">Webinars</a></li>
            </ul>
        </nav>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Case Studies</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">$2B+</div>
                    <div class="stat-label">Companies Studied</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Industries</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">98%</div>
                    <div class="stat-label">Success Rate</div>
                </div>
            </div>
        </div>

        <!-- Featured Case Study -->
        <div class="featured-case">
            <span class="featured-badge">🏆 MOST POPULAR</span>
            <h2 class="featured-title">Airbnb: Disrupting Hospitality</h2>
            <p class="featured-description">
                How two designers turned air mattresses in their apartment into a $75 billion company that revolutionized travel and accommodation.
            </p>
            <a href="#" class="read-case-btn">Read Full Case Study</a>
        </div>

        <!-- Case Studies Grid -->
        <div class="case-studies-grid">
            <!-- Case Study 1 -->
            <div class="case-study-card">
                <div class="case-meta">
                    <span class="company-logo">🏢 Basecamp</span>
                    <span class="industry-tag">💼 Project Management</span>
                    <span class="revenue-tag">$25M ARR</span>
                </div>
                <h2 class="case-title">Basecamp: Bootstrapped to $25M Revenue</h2>
                <p class="case-summary">
                    How Jason Fried and team built Basecamp from a web design agency's internal tool into a $25M ARR SaaS company without external funding.
                </p>
                <div class="case-metrics">
                    <div class="metric">
                        <div class="metric-value">20+</div>
                        <div class="metric-label">Years</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">3M+</div>
                        <div class="metric-label">Users</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">$0</div>
                        <div class="metric-label">VC Funding</div>
                    </div>
                </div>
                <ul class="case-highlights">
                    <li>Started as internal project management tool</li>
                    <li>Pivoted from web design to software company</li>
                    <li>Maintained profitability without external funding</li>
                    <li>Built strong company culture and remote work model</li>
                </ul>
                <a href="#" class="read-case-btn">Read Case Study</a>
            </div>

            <!-- Case Study 2 -->
            <div class="case-study-card">
                <div class="case-meta">
                    <span class="company-logo">📧 Mailchimp</span>
                    <span class="industry-tag">📊 Email Marketing</span>
                    <span class="revenue-tag">$12B Valuation</span>
                </div>
                <h2 class="case-title">Mailchimp: From Side Project to $12B</h2>
                <p class="case-summary">
                    Ben Chestnut's journey from web design side project to building one of the most successful bootstrapped companies in history.
                </p>
                <div class="case-metrics">
                    <div class="metric">
                        <div class="metric-value">21</div>
                        <div class="metric-label">Years</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">14M</div>
                        <div class="metric-label">Users</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">$12B</div>
                        <div class="metric-label">Valuation</div>
                    </div>
                </div>
                <ul class="case-highlights">
                    <li>Started as greeting card company's email tool</li>
                    <li>Bootstrapped for 17 years before taking investment</li>
                    <li>Acquired by Intuit for $12 billion in 2021</li>
                    <li>Built freemium model that scaled globally</li>
                </ul>
                <a href="#" class="read-case-btn">Read Case Study</a>
            </div>

            <!-- Case Study 3 -->
            <div class="case-study-card">
                <div class="case-meta">
                    <span class="company-logo">🤖 Conversational AI</span>
                    <span class="industry-tag">🧠 Artificial Intelligence</span>
                    <span class="revenue-tag">Series A</span>
                </div>
                <h2 class="case-title">AI Startup: Revolutionizing Customer Service</h2>
                <p class="case-summary">
                    Case study of a 2025 AI startup using advanced NLP and real-time response technology to transform customer interactions and achieve remarkable growth.
                </p>
                <div class="case-metrics">
                    <div class="metric">
                        <div class="metric-value">2.3x</div>
                        <div class="metric-label">Funding Rate</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">500+</div>
                        <div class="metric-label">Clients</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">95%</div>
                        <div class="metric-label">Satisfaction</div>
                    </div>
                </div>
                <ul class="case-highlights">
                    <li>Advanced conversational AI with NLP capabilities</li>
                    <li>Real-time response system for customer support</li>
                    <li>Successfully secured Series A funding</li>
                    <li>Serving 500+ enterprise clients globally</li>
                </ul>
                <a href="#" class="read-case-btn">Read Case Study</a>
            </div>

            <!-- Case Study 4 -->
            <div class="case-study-card">
                <div class="case-meta">
                    <span class="company-logo">🌱 Climate Tech</span>
                    <span class="industry-tag">♻️ Sustainability</span>
                    <span class="revenue-tag">Series A Ready</span>
                </div>
                <h2 class="case-title">Green Innovation: Carbon Reduction Success</h2>
                <p class="case-summary">
                    Climate tech startup with clear carbon reduction metrics that's 2.3x more likely to secure Series A funding, demonstrating the power of measurable impact.
                </p>
                <div class="case-metrics">
                    <div class="metric">
                        <div class="metric-value">2.3x</div>
                        <div class="metric-label">Funding Advantage</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">50%</div>
                        <div class="metric-label">Carbon Reduction</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">200+</div>
                        <div class="metric-label">Partners</div>
                    </div>
                </div>
                <ul class="case-highlights">
                    <li>Clear metrics for carbon reduction impact</li>
                    <li>Resource conservation technology platform</li>
                    <li>Strong investor interest in climate solutions</li>
                    <li>Partnerships with major corporations</li>
                </ul>
                <a href="#" class="read-case-btn">Read Case Study</a>
            </div>

            <!-- Case Study 5 -->
            <div class="case-study-card">
                <div class="case-meta">
                    <span class="company-logo">🏥 Digital Health</span>
                    <span class="industry-tag">💊 Healthcare</span>
                    <span class="revenue-tag">$10.1B Market</span>
                </div>
                <h2 class="case-title">HealthTech Innovation: Digital Transformation</h2>
                <p class="case-summary">
                    Analysis of digital health startup success in 2024's $10.1 billion market, showcasing innovative approaches to healthcare delivery and patient engagement.
                </p>
                <div class="case-metrics">
                    <div class="metric">
                        <div class="metric-value">$10.1B</div>
                        <div class="metric-label">Market Size</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">1M+</div>
                        <div class="metric-label">Patients</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">40%</div>
                        <div class="metric-label">Cost Reduction</div>
                    </div>
                </div>
                <ul class="case-highlights">
                    <li>Digital health platform serving millions</li>
                    <li>40% reduction in healthcare costs</li>
                    <li>Improved patient outcomes and engagement</li>
                    <li>Successful scaling in competitive market</li>
                </ul>
                <a href="#" class="read-case-btn">Read Case Study</a>
            </div>

            <!-- Case Study 6 -->
            <div class="case-study-card">
                <div class="case-meta">
                    <span class="company-logo">📈 Growth Hacking</span>
                    <span class="industry-tag">🚀 Startup Growth</span>
                    <span class="revenue-tag">Viral Growth</span>
                </div>
                <h2 class="case-title">Viral Growth: 124 Success Stories</h2>
                <p class="case-summary">
                    Comprehensive analysis of 124 growth hacking case studies from famous startups, revealing key strategies and tactics for explosive growth.
                </p>
                <div class="case-metrics">
                    <div class="metric">
                        <div class="metric-value">124</div>
                        <div class="metric-label">Case Studies</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">1000%</div>
                        <div class="metric-label">Avg Growth</div>
                    </div>
                    <div class="metric">
                        <div class="metric-value">50+</div>
                        <div class="metric-label">Tactics</div>
                    </div>
                </div>
                <ul class="case-highlights">
                    <li>Comprehensive growth hacking strategies</li>
                    <li>Real examples from successful startups</li>
                    <li>Proven tactics for viral growth</li>
                    <li>Actionable insights and takeaways</li>
                </ul>
                <a href="#" class="read-case-btn">Read Case Study</a>
            </div>
        </div>
    </div>

    <script>
        // Add click tracking for case studies
        document.querySelectorAll('.case-study-card').forEach((card, index) => {
            card.addEventListener('click', function(e) {
                if (!e.target.classList.contains('read-case-btn')) {
                    const title = this.querySelector('.case-title').textContent;
                    console.log(`Case study clicked: ${title}`);
                }
            });
        });

        // Enhanced hover effects with metrics animation
        document.querySelectorAll('.case-study-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
                const metrics = this.querySelectorAll('.metric-value');
                metrics.forEach(metric => {
                    metric.style.color = '#00e5ff';
                    metric.style.transform = 'scale(1.1)';
                });
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
                const metrics = this.querySelectorAll('.metric-value');
                metrics.forEach(metric => {
                    metric.style.color = '#00e5ff';
                    metric.style.transform = 'scale(1)';
                });
            });
        });

        // Featured case study interaction
        document.querySelector('.featured-case').addEventListener('click', function() {
            console.log('Featured case study clicked: Airbnb');
        });

        // Animate metrics on scroll
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const metrics = entry.target.querySelectorAll('.metric-value');
                    metrics.forEach((metric, index) => {
                        setTimeout(() => {
                            metric.style.transform = 'scale(1.1)';
                            setTimeout(() => {
                                metric.style.transform = 'scale(1)';
                            }, 200);
                        }, index * 100);
                    });
                }
            });
        }, observerOptions);

        document.querySelectorAll('.case-metrics').forEach(metrics => {
            observer.observe(metrics);
        });

        console.log("Case Studies page loaded successfully");
    </script>
</body>
</html>