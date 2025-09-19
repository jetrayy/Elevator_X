<?php
session_start();

// Display errors if any
$errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : [];
$success_message = isset($_SESSION['success_message']) ? $_SESSION['success_message'] : '';
$form_data = isset($_SESSION['form_data']) ? $_SESSION['form_data'] : [];

// Clear messages after displaying
unset($_SESSION['errors'], $_SESSION['success_message'], $_SESSION['form_data']);
?>
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrepreneur Registration - Elevator X</title>

    <!-- Favicon -->
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">

    <!-- Inline CSS for Styling -->
    <style>
        /* Error and Success Messages */
.error-messages {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
    backdrop-filter: blur(10px);
}

.error-message {
    color: #fca5a5;
    font-size: 14px;
    margin-bottom: 5px;
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
}
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
            padding: 120px 20px 50px;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            position: relative;
        }

        .form-wrapper {
            max-width: 800px;
            width: 100%;
            opacity: 0;
            transform: translateY(50px);
            animation: fadeInUp 1s ease 0.3s forwards;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Form Header */
        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-title {
            font-size: clamp(28px, 5vw, 48px);
            margin-bottom: 15px;
            background: linear-gradient(45deg, #fff, #1e90ff);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
            animation: glow 2s ease-in-out infinite alternate;
        }

        .form-subtitle {
            font-size: clamp(16px, 3vw, 20px);
            color: #ccc;
            font-weight: 300;
        }

        @keyframes glow {
            from { filter: drop-shadow(0 0 20px rgba(30, 144, 255, 0.5)); }
            to { filter: drop-shadow(0 0 30px rgba(30, 144, 255, 0.8)); }
        }

        /* Form Container */
        .form-container {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(30, 144, 255, 0.3);
            border-radius: 20px;
            padding: 40px;
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

        /* Form Sections */
        .form-section {
            margin-bottom: 35px;
        }

        .section-title {
            font-size: 20px;
            color: #1e90ff;
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: linear-gradient(45deg, #1e90ff, #00bfff);
            border-radius: 2px;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row.single {
            grid-template-columns: 1fr;
        }

        .form-group label {
            display: block;
            font-size: 14px;
            color: #ccc;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .required::after {
            content: ' *';
            color: #ff6b6b;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(30, 144, 255, 0.3);
            border-radius: 10px;
            color: white;
            font-size: 14px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: #999;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #1e90ff;
            box-shadow: 0 0 15px rgba(30, 144, 255, 0.3);
            background: rgba(255, 255, 255, 0.15);
        }

        .form-group select option {
            background: #1a252f;
            color: white;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        /* File Upload Styling */
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-upload input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px 15px;
            background: rgba(30, 144, 255, 0.1);
            border: 2px dashed rgba(30, 144, 255, 0.5);
            border-radius: 10px;
            color: #1e90ff;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .file-upload:hover .file-upload-label {
            background: rgba(30, 144, 255, 0.2);
            border-color: #1e90ff;
        }

        /* Checkbox Group Styling */
        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }

        .checkbox-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .checkbox-item input[type="checkbox"] {
            width: auto;
            margin: 0;
            transform: scale(1.2);
            accent-color: #1e90ff;
            margin-top: 2px;
        }

        .checkbox-item label {
            margin: 0;
            font-size: 13px;
            line-height: 1.4;
            cursor: pointer;
        }

        .checkbox-item a {
            color: #1e90ff;
            text-decoration: none;
        }

        .checkbox-item a:hover {
            text-decoration: underline;
        }

        /* Support Options */
        .support-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 10px;
        }

        .support-option {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(30, 144, 255, 0.2);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .support-option:hover {
            background: rgba(30, 144, 255, 0.1);
            border-color: #1e90ff;
        }

        .support-option input[type="checkbox"] {
            width: auto;
            margin: 0;
            accent-color: #1e90ff;
        }

        .support-option label {
            margin: 0;
            font-size: 13px;
            cursor: pointer;
            color: #ccc;
        }

        /* Submit Button */
        .submit-section {
            text-align: center;
            margin-top: 30px;
        }

        .submit-btn {
            width: 100%;
            max-width: 300px;
            padding: 15px 30px;
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
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 144, 255, 0.5);
        }

        /* Back Link */
        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(30, 144, 255, 0.5);
            border-radius: 25px;
            color: #1e90ff;
            text-decoration: none;
            font-size: 14px;
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

        /* Responsive Design */
        @media only screen and (max-width: 768px) {
            header {
                padding: 15px 20px;
                flex-direction: column;
                gap: 15px;
            }

            nav {
                gap: 15px;
            }

            nav a {
                font-size: 14px;
                padding: 8px 15px;
            }

            .main-container {
                padding: 180px 15px 30px;
            }

            .form-container {
                padding: 30px 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .section-title {
                font-size: 18px;
            }

            .support-options {
                grid-template-columns: 1fr;
            }
        }

        @media only screen and (max-width: 480px) {
            .form-container {
                padding: 25px 15px;
            }

            .form-title {
                font-size: 24px;
            }

            .form-subtitle {
                font-size: 16px;
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
            <img src="../img/logo.png" alt="Elevator X Logo">
        </div>
        <nav>
            <a href="../../index.php">Home</a>
            <a href="../JoinUs.php">Join Us</a>
            <a href="../LearnX/learnx_home.php">Learn-X</a>
            <a href="../Gigs.php">Gigs</a>
            <a href="../Mentorship.php">Mentorship</a>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <div class="form-wrapper">
            <!-- Form Header -->
            <div class="form-header">
                <h1 class="form-title">Entrepreneur Registration</h1>
                <p class="form-subtitle">Start your entrepreneurial journey with us</p>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <form action="../entrepreneur/entrepreneur_signup_process.php" method="POST" enctype="multipart/form-data">
                    
                    <!-- Basic Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">👤 Basic Information</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name" class="required">First Name</label>
                                <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name" class="required">Last Name</label>
                                <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email" class="required">Email Address</label>
                                <input type="email" id="email" name="email" placeholder="your.email@example.com" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" placeholder="+1 (555) 123-4567">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="password" class="required">Password</label>
                                <input type="password" id="password" name="password" placeholder="Create a strong password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="required">Confirm Password</label>
                                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                            </div>
                        </div>
                    </div>

                    <!-- Business Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">🚀 Business Information</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="business_name">Business Name</label>
                                <input type="text" id="business_name" name="business_name" placeholder="Your business name (if you have one)">
                            </div>
                            <div class="form-group">
                                <label for="business_category" class="required">Business Category</label>
                                <select id="business_category" name="business_category" required>
                                    <option value="">Select your business category</option>
                                    <option value="technology">Technology</option>
                                    <option value="healthcare">Healthcare</option>
                                    <option value="fintech">FinTech</option>
                                    <option value="e-commerce">E-commerce</option>
                                    <option value="education">Education</option>
                                    <option value="sustainability">Sustainability</option>
                                    <option value="food-beverage">Food & Beverage</option>
                                    <option value="manufacturing">Manufacturing</option>
                                    <option value="retail">Retail</option>
                                    <option value="consulting">Consulting</option>
                                    <option value="media-entertainment">Media & Entertainment</option>
                                    <option value="travel-tourism">Travel & Tourism</option>
                                    <option value="real-estate">Real Estate</option>
                                    <option value="agriculture">Agriculture</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="business_stage" class="required">Business Stage</label>
                                <select id="business_stage" name="business_stage" required>
                                    <option value="">Select your current stage</option>
                                    <option value="idea">Idea Stage</option>
                                    <option value="research">Research & Validation</option>
                                    <option value="prototype">Prototype/MVP</option>
                                    <option value="early-revenue">Early Revenue</option>
                                    <option value="growth">Growth Stage</option>
                                    <option value="established">Established Business</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="business_location" class="required">Business Location</label>
                                <input type="text" id="business_location" name="business_location" placeholder="City, Country" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="business_description" class="required">Brief Business Description</label>
                            <textarea id="business_description" name="business_description" placeholder="Describe your business idea, product, or service in a few sentences..." required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="business_website">Business Website or Social Media Links</label>
                            <input type="url" id="business_website" name="business_website" placeholder="https://yourwebsite.com or social media profile">
                        </div>
                    </div>

                    <!-- Personal Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">🆔 Personal Information</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="date_of_birth" class="required">Date of Birth</label>
                                <input type="date" id="date_of_birth" name="date_of_birth" required>
                            </div>
                            <div class="form-group">
                                <label for="nationality" class="required">Nationality</label>
                                <select id="nationality" name="nationality" required>
                                    <option value="">Select your nationality</option>
                                    <option value="sri-lankan">Sri Lankan</option>
                                    <option value="indian">Indian</option>
                                    <option value="american">American</option>
                                    <option value="british">British</option>
                                    <option value="canadian">Canadian</option>
                                    <option value="australian">Australian</option>
                                    <option value="german">German</option>
                                    <option value="french">French</option>
                                    <option value="chinese">Chinese</option>
                                    <option value="japanese">Japanese</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="linkedin_profile">LinkedIn Profile</label>
                            <input type="url" id="linkedin_profile" name="linkedin_profile" placeholder="https://linkedin.com/in/yourprofile">
                        </div>
                    </div>

                    <!-- Startup Needs Section -->
                    <div class="form-section">
                        <h3 class="section-title">💡 Startup Needs</h3>
                        
                        <div class="form-group">
                            <label class="required">What kind of support are you looking for?</label>
                            <div class="support-options">
                                <div class="support-option">
                                    <input type="checkbox" id="support_mentorship" name="support_needed[]" value="mentorship">
                                    <label for="support_mentorship">Mentorship</label>
                                </div>
                                <div class="support-option">
                                    <input type="checkbox" id="support_funding" name="support_needed[]" value="funding">
                                    <label for="support_funding">Funding</label>
                                </div>
                                <div class="support-option">
                                    <input type="checkbox" id="support_education" name="support_needed[]" value="education">
                                    <label for="support_education">Educational Resources</label>
                                </div>
                                <div class="support-option">
                                    <input type="checkbox" id="support_networking" name="support_needed[]" value="networking">
                                    <label for="support_networking">Networking</label>
                                </div>
                                <div class="support-option">
                                    <input type="checkbox" id="support_legal" name="support_needed[]" value="legal">
                                    <label for="support_legal">Legal Advice</label>
                                </div>
                                <div class="support-option">
                                    <input type="checkbox" id="support_marketing" name="support_needed[]" value="marketing">
                                    <label for="support_marketing">Marketing Support</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="funding_need">Estimated Funding Need</label>
                                <select id="funding_need" name="funding_need">
                                    <option value="">Select funding range (if applicable)</option>
                                    <option value="no-funding">Not seeking funding</option>
                                    <option value="under-10k">Under $10K</option>
                                    <option value="10k-25k">$10K - $25K</option>
                                    <option value="25k-50k">$25K - $50K</option>
                                    <option value="50k-100k">$50K - $100K</option>
                                    <option value="100k-250k">$100K - $250K</option>
                                    <option value="250k-500k">$250K - $500K</option>
                                    <option value="500k-1m">$500K - $1M</option>
                                    <option value="over-1m">Over $1M</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="business_plan">Do you have a business plan?</label>
                                <select id="business_plan" name="business_plan">
                                    <option value="">Select an option</option>
                                    <option value="yes-detailed">Yes, detailed business plan</option>
                                    <option value="yes-basic">Yes, basic outline</option>
                                    <option value="working-on-it">Working on it</option>
                                    <option value="no">No, need help creating one</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Document Upload Section (Optional) -->
                    <div class="form-section">
                        <h3 class="section-title">📄 Business Registration (Optional)</h3>
                        
                        <div class="form-group">
                            <label for="business_registration">Upload Business Registration Copy (Optional)</label>
                            <div class="file-upload">
                                <input type="file" id="business_registration" name="business_registration" accept="image/*,application/pdf">
                                <div class="file-upload-label">
                                    <span>📎</span>
                                    <span>Choose File (PDF, JPG, PNG) - Optional</span>
                                </div>
                            </div>
                            <small style="color: #999; font-size: 12px; margin-top: 5px; display: block;">
                                Only upload if you already have business registration documents
                            </small>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="form-section">
                        <h3 class="section-title">ℹ️ Additional Information</h3>
                        
                        <div class="form-group">
                            <label for="how_heard">How did you hear about us?</label>
                            <select id="how_heard" name="how_heard">
                                <option value="">Select an option</option>
                                <option value="google">Google Search</option>
                                <option value="social-media">Social Media</option>
                                <option value="referral">Referral from Friend/Colleague</option>
                                <option value="networking-event">Networking Event</option>
                                <option value="newsletter">Newsletter/Email</option>
                                <option value="advertisement">Advertisement</option>
                                <option value="news-article">News Article</option>
                                <option value="university">University/Educational Institution</option>
                                <option value="incubator">Incubator/Accelerator</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Consent Checkboxes -->
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" id="terms_consent" name="terms_consent" required>
                                <label for="terms_consent">
                                    I agree to the <a href="#" target="_blank">Terms & Conditions</a> and <a href="#" target="_blank">Privacy Policy</a>. I consent to receive communications from Elevator X regarding opportunities and platform updates.
                                </label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" id="newsletter_subscribe" name="newsletter_subscribe">
                                <label for="newsletter_subscribe">
                                    Subscribe to our newsletter for startup tips, funding opportunities, and success stories.
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="submit-section">
                        <button type="submit" class="submit-btn">Start Your Journey</button>
                    </div>
                </form>

                <!-- Back Link -->
                <div class="back-link">
                    <a href="../JoinUs.php" class="back-btn">
                        <span>←</span>
                        <span>Back to Login</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Enhanced Interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password confirmation validation
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            
            function validatePassword() {
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity("Passwords don't match");
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }
            
            password.addEventListener('change', validatePassword);
            confirmPassword.addEventListener('keyup', validatePassword);

            // File upload feedback
            const fileInput = document.getElementById('business_statement');
            const fileLabel = fileInput.nextElementSibling;
            
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    fileLabel.innerHTML = `<span>✓</span><span>File Selected: ${fileName}</span>`;
                    fileLabel.style.background = 'rgba(34, 197, 94, 0.2)';
                    fileLabel.style.borderColor = '#22c55e';
                    fileLabel.style.color = '#22c55e';
                }
            });

            // Form submission loading state
            const form = document.querySelector('form');
            const submitBtn = document.querySelector('.submit-btn');
            
            form.addEventListener('submit', function() {
                submitBtn.innerHTML = 'Processing Registration...';
                submitBtn.style.background = 'linear-gradient(45deg, #666, #888)';
                submitBtn.disabled = true;
            });

            // Smooth animations for form sections
            const sections = document.querySelectorAll('.form-section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            sections.forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';
                section.style.transition = 'all 0.6s ease';
                observer.observe(section);
            });
        });

        // Page load animation
        window.addEventListener('load', () => {
            document.body.style.opacity = '1';
        });
    </script>
</body>
</html>