<?php
session_start();

// Include database connection
require_once 'dbconnect.php';

// Display errors if any
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];

// Clear messages after displaying
unset($_SESSION['errors'], $_SESSION['success_message'], $_SESSION['form_data']);

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = trim($_POST['role'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Store form data for repopulation if there's an error
    $_SESSION['form_data'] = ['role' => $role, 'email' => $email];
    
    // Basic validation
    if (empty($role) || empty($email) || empty($password)) {
        $_SESSION['errors'] = ['Please fill in all fields.'];
        header("Location: JoinUs.php");
        exit();
    }
    
    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['errors'] = ['Please enter a valid email address.'];
        header("Location: JoinUs.php");
        exit();
    }
    
    try {
        $user = null;
        
        // Check credentials based on selected role
        if ($role == 'entrepreneur') {
            $user = getEntrepreneurByEmail($email, $pdo);
            if ($user && verifyPassword($password, $user['password_hash'])) {
                // Login successful for entrepreneur
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = 'entrepreneur';
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['login_time'] = time();
                
                // Update last login
                updateLastLogin('entrepreneurs', $user['id'], $pdo);
                
                // Clear form data after successful login
                unset($_SESSION['form_data']);
                
                header("Location: entrepreneur/EntreDashBoard.php");
                exit();
            }
        } elseif ($role == 'investor') {
            $user = getInvestorByEmail($email, $pdo);
            if ($user && verifyPassword($password, $user['password_hash'])) {
                // Login successful for investor
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = 'investor';
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['login_time'] = time();
                
                // Update last login
                updateLastLogin('investors', $user['id'], $pdo);
                
                // Clear form data after successful login
                unset($_SESSION['form_data']);
                
                header("Location: investor/InvestorDashBoard.php");
                exit();
            }
        }
        
        // If we reach here, login failed
        $_SESSION['errors'] = ['Invalid email, password, or role. Please check your credentials.'];
        header("Location: JoinUs.php");
        exit();
        
    } catch(Exception $e) {
        $_SESSION['errors'] = ['Login error. Please try again later.'];
        error_log("Login error: " . $e->getMessage());
        header("Location: JoinUs.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Us - Elevator X</title>

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
            align-items: center;
            justify-content: center;
            gap: 80px;
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
            font-size: clamp(24px, 5vw, 48px);
            margin-bottom: 40px;
            text-align: center;
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

        /* Error and Success Messages */
        .error-messages {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .error-message {
            color: #fca5a5;
            font-size: 14px;
            margin-bottom: 5px;
            text-align: center;
            font-weight: 500;
        }

        .error-message:last-child {
            margin-bottom: 0;
        }

        .success-message {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            color: #86efac;
            font-size: 14px;
            backdrop-filter: blur(10px);
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        /* Login Form Container */
        .form-container {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(30, 144, 255, 0.3);
            border-radius: 20px;
            padding: 40px;
            width: 400px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #1e90ff, #00bfff);
            border-radius: 20px 20px 0 0;
        }

        .form-container::after {
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
        }

        /* Form Elements */
        .input-group {
            margin-bottom: 25px;
            position: relative;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #ccc;
            font-weight: 500;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            color: white;
            font-size: 16px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #1e90ff;
            background: rgba(30, 144, 255, 0.1);
            box-shadow: 0 0 20px rgba(30, 144, 255, 0.3);
        }

        .input-group input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .input-group select option {
            background: #111;
            color: white;
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(45deg, #1e90ff, #00bfff);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 144, 255, 0.5);
        }

        .btn-login:disabled {
            background: linear-gradient(45deg, #666, #888);
            cursor: not-allowed;
            transform: none;
        }

        /* Register Link */
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #ccc;
        }

        .register-link a {
            color: #1e90ff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #00bfff;
            text-decoration: underline;
        }

        /* Simple Bubble Animation Container */
        .animation-container {
            width: 500px;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .bubbles-container {
            width: 300px;
            height: 350px;
            background: rgba(30, 144, 255, 0.1);
            border: 2px solid #1e90ff;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
        }

        .bubble {
            position: absolute;
            border-radius: 50%;
            background: #1e90ff;
            animation: simpleBubble 3s ease-in-out infinite;
        }

        .bubble:nth-child(1) {
            width: 80px;
            height: 80px;
            left: 20%;
            top: 60%;
            animation-delay: 0s;
        }

        .bubble:nth-child(2) {
            width: 120px;
            height: 120px;
            left: 50%;
            top: 40%;
            animation-delay: 1s;
        }

        .bubble:nth-child(3) {
            width: 60px;
            height: 60px;
            left: 70%;
            top: 70%;
            animation-delay: 2s;
        }

        @keyframes simpleBubble {
            0%, 100% { 
                transform: translateY(0px) scale(1);
                opacity: 0.6;
            }
            50% { 
                transform: translateY(-20px) scale(1.1);
                opacity: 0.8;
            }
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

            .content-wrapper {
                gap: 40px;
                flex-direction: column;
            }

            .animation-container {
                width: 400px;
                height: 300px;
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

            .content-wrapper {
                gap: 30px;
            }

            .form-container {
                width: 100%;
                max-width: 400px;
                padding: 30px;
            }

            .animation-container {
                width: 300px;
                height: 250px;
            }

            .bubbles-container {
                width: 250px;
                height: 200px;
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

            .form-container {
                padding: 25px;
            }

            .welcome-title {
                margin-bottom: 25px;
            }

            .animation-container {
                display: none;
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
            <a href="Mentorship/M_index.php">Mentorship</a>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <div class="content-wrapper">
            <div class="form-section">
                <h1 class="welcome-title">Welcome back to Elevator X</h1>
                
                <!-- Error/Success Messages -->
                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success_message)): ?>
                    <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
                <?php endif; ?>
                
                <!-- Login Form -->
                <div class="form-container">
                    <form method="POST" id="loginForm">
                        <div class="input-group">
                            <label for="role">Select Role</label>
                            <select id="role" name="role" required>
                                <option value="" disabled selected>Choose your role</option>
                                <option value="entrepreneur" <?php echo (($form_data['role'] ?? '') == 'entrepreneur') ? 'selected' : ''; ?>>Entrepreneur</option>
                                <option value="investor" <?php echo (($form_data['role'] ?? '') == 'investor') ? 'selected' : ''; ?>>Investor</option>
                            </select>
                        </div>

                        <div class="input-group">
                            <label for="email">E-mail Address</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email address" 
                                   value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>" required>
                        </div>

                        <div class="input-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>

                        <button type="submit" class="btn-login" id="loginBtn">Login</button>
                        
                        <div class="register-link">
                            Don't have an account? <a href="Register.php">Register now</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Simple Bubble Animation -->
            <div class="animation-container">
                <div class="bubbles-container">
                    <div class="bubble"></div>
                    <div class="bubble"></div>
                    <div class="bubble"></div>
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
        // Enhanced form animations and interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add focus animations to inputs
            const inputs = document.querySelectorAll('input, select');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // Form submission with loading effect
            const form = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            
            form.addEventListener('submit', function() {
                loginBtn.innerHTML = '<span>Verifying credentials...</span>';
                loginBtn.style.background = 'linear-gradient(45deg, #666, #888)';
                loginBtn.disabled = true;
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
        });

        // Page load animation
        window.addEventListener('load', () => {
            document.body.style.opacity = '1';
        });
    </script>
</body>
</html>