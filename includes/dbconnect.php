<?php
/**
 * dbconnect.php
 * Database Connection for Elevator X Platform
 */

// Database configuration
$servername = "localhost";
$username = "root";        
$password = "";            
$dbname = "elevator_x_db"; 

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    
    // Set PDO attributes for better security and error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Create required tables if they don't exist
try {
    // Create entrepreneurs table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS entrepreneurs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(100) NOT NULL,
            last_name VARCHAR(100) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            phone VARCHAR(20),
            password_hash VARCHAR(255) NOT NULL,
            business_name VARCHAR(255),
            business_category ENUM('technology', 'healthcare', 'fintech', 'e-commerce', 'education', 'sustainability', 'food-beverage', 'other') DEFAULT 'other',
            business_stage ENUM('idea', 'research', 'prototype', 'early-revenue', 'growth') DEFAULT 'idea',
            business_location VARCHAR(255),
            business_description TEXT,
            business_website VARCHAR(255),
            linkedin_profile VARCHAR(255),
            is_active BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    // Create investors table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS investors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(100) NOT NULL,
            last_name VARCHAR(100) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            phone VARCHAR(20),
            password_hash VARCHAR(255) NOT NULL,
            company_name VARCHAR(255),
            investment_focus VARCHAR(255),
            investment_range ENUM('10k-50k', '50k-100k', '100k-250k', '250k-500k', '500k+') DEFAULT '50k-100k',
            geographic_preference VARCHAR(255),
            website VARCHAR(255),
            linkedin_profile VARCHAR(255),
            messaging_unlocked BOOLEAN DEFAULT FALSE,
            is_active BOOLEAN DEFAULT TRUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    // Create gigs table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS gigs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            entrepreneur_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            category ENUM('technology', 'healthcare', 'fintech', 'e-commerce', 'education', 'sustainability', 'food-beverage', 'other') NOT NULL,
            funding_needed ENUM('10k-50k', '50k-100k', '100k-250k', '250k-500k', '500k+') NOT NULL,
            status ENUM('active', 'paused', 'closed') DEFAULT 'active',
            visibility ENUM('public', 'private') DEFAULT 'public',
            views_count INT DEFAULT 0,
            interests_count INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (entrepreneur_id) REFERENCES entrepreneurs(id) ON DELETE CASCADE,
            INDEX idx_entrepreneur (entrepreneur_id),
            INDEX idx_category (category),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    // Create gig_images table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS gig_images (
            id INT AUTO_INCREMENT PRIMARY KEY,
            gig_id INT NOT NULL,
            image_filename VARCHAR(255) NOT NULL,
            original_filename VARCHAR(255) NOT NULL,
            image_order INT DEFAULT 1,
            uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (gig_id) REFERENCES gigs(id) ON DELETE CASCADE,
            INDEX idx_gig_id (gig_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    // Create investor_connections table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS investor_connections (
            id INT AUTO_INCREMENT PRIMARY KEY,
            investor_id INT NOT NULL,
            entrepreneur_id INT NOT NULL,
            gig_id INT,
            connection_type ENUM('interest', 'investment_offer') DEFAULT 'interest',
            status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
            request_message TEXT,
            response_message TEXT,
            requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            responded_at TIMESTAMP NULL,
            FOREIGN KEY (investor_id) REFERENCES investors(id) ON DELETE CASCADE,
            FOREIGN KEY (entrepreneur_id) REFERENCES entrepreneurs(id) ON DELETE CASCADE,
            FOREIGN KEY (gig_id) REFERENCES gigs(id) ON DELETE CASCADE,
            UNIQUE KEY unique_connection (investor_id, entrepreneur_id, gig_id),
            INDEX idx_investor (investor_id),
            INDEX idx_entrepreneur (entrepreneur_id),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    // Create messages table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            sender_id INT NOT NULL,
            sender_type ENUM('entrepreneur', 'investor') NOT NULL,
            recipient_id INT NOT NULL,
            recipient_type ENUM('entrepreneur', 'investor') NOT NULL,
            connection_id INT,
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            attachment_filename VARCHAR(255),
            attachment_original_name VARCHAR(255),
            is_read BOOLEAN DEFAULT FALSE,
            sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            read_at TIMESTAMP NULL,
            FOREIGN KEY (connection_id) REFERENCES investor_connections(id) ON DELETE CASCADE,
            INDEX idx_sender (sender_id, sender_type),
            INDEX idx_recipient (recipient_id, recipient_type),
            INDEX idx_connection (connection_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

    // Create investor_payments table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS investor_payments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            investor_id INT NOT NULL,
            payment_type ENUM('messaging_access') NOT NULL,
            amount DECIMAL(10,2) NOT NULL,
            status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (investor_id) REFERENCES investors(id) ON DELETE CASCADE,
            INDEX idx_investor (investor_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");

} catch(PDOException $e) {
    error_log("Table creation error: " . $e->getMessage());
}

// Function to check if email already exists in either table
function emailExists($email, $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT email FROM entrepreneurs WHERE email = ? UNION SELECT email FROM investors WHERE email = ?");
        $stmt->execute([$email, $email]);
        return $stmt->rowCount() > 0;
    } catch(PDOException $e) {
        error_log("Email exists check failed: " . $e->getMessage());
        return false;
    }
}

// Function to hash password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to verify password
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// Function to get entrepreneur by email
function getEntrepreneurByEmail($email, $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM entrepreneurs WHERE email = ? AND is_active = 1");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result !== false ? $result : false;
    } catch(PDOException $e) {
        error_log("Get entrepreneur failed: " . $e->getMessage());
        return false;
    }
}

// Function to get investor by email
function getInvestorByEmail($email, $pdo) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM investors WHERE email = ? AND is_active = 1");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result !== false ? $result : false;
    } catch(PDOException $e) {
        error_log("Get investor failed: " . $e->getMessage());
        return false;
    }
}

// Function to create entrepreneur
function createEntrepreneur($data, $pdo) {
    try {
        $sql = "INSERT INTO entrepreneurs (
            first_name, last_name, email, phone, password_hash,
            business_name, business_category, business_stage, business_location,
            business_description, business_website, linkedin_profile
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $data['first_name'], $data['last_name'], $data['email'], 
            $data['phone'], $data['password_hash'], $data['business_name'],
            $data['business_category'], $data['business_stage'], $data['business_location'],
            $data['business_description'], $data['business_website'], $data['linkedin_profile']
        ]);
    } catch(PDOException $e) {
        error_log("Create entrepreneur failed: " . $e->getMessage());
        return false;
    }
}

// Function to create investor
function createInvestor($data, $pdo) {
    try {
        $sql = "INSERT INTO investors (
            first_name, last_name, email, phone, password_hash,
            company_name, investment_focus, investment_range, geographic_preference,
            website, linkedin_profile
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $data['first_name'], $data['last_name'], $data['email'],
            $data['phone'], $data['password_hash'], $data['company_name'],
            $data['investment_focus'], $data['investment_range'], $data['geographic_preference'],
            $data['website'], $data['linkedin_profile']
        ]);
    } catch(PDOException $e) {
        error_log("Create investor failed: " . $e->getMessage());
        return false;
    }
}

// Function to update last login (called by JoinUs.php)
function updateLastLogin($table, $id, $pdo) {
    try {
        // Validate table name to prevent SQL injection
        $allowed_tables = ['entrepreneurs', 'investors'];
        if (!in_array($table, $allowed_tables)) {
            return false;
        }
        
        $sql = "UPDATE {$table} SET updated_at = CURRENT_TIMESTAMP WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    } catch(PDOException $e) {
        error_log("Update last login failed: " . $e->getMessage());
        return false;
    }
}

// Function to authenticate user (for login)
function authenticateUser($email, $password, $user_type, $pdo) {
    try {
        $table = ($user_type === 'entrepreneur') ? 'entrepreneurs' : 'investors';
        $stmt = $pdo->prepare("SELECT * FROM {$table} WHERE email = ? AND is_active = 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && verifyPassword($password, $user['password_hash'])) {
            // Update last login
            updateLastLogin($table, $user['id'], $pdo);
            return $user;
        }
        return false;
    } catch(PDOException $e) {
        error_log("Authentication failed: " . $e->getMessage());
        return false;
    }
}

// Function to create sample data for testing
function createSampleData($pdo) {
    try {
        // Check if we already have data
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM entrepreneurs");
        $entrepreneur_count = $stmt->fetch()['count'];
        
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM investors");  
        $investor_count = $stmt->fetch()['count'];
        
        // Only create sample data if tables are empty
        if ($entrepreneur_count == 0) {
            // Create sample entrepreneur
            $entrepreneur_data = [
                'first_name' => 'John',
                'last_name' => 'Entrepreneur',
                'email' => 'entrepreneur@test.com',
                'phone' => '+1234567890',
                'password_hash' => hashPassword('password123'),
                'business_name' => 'TechStartup Inc',
                'business_category' => 'technology',
                'business_stage' => 'prototype',
                'business_location' => 'Silicon Valley',
                'business_description' => 'Revolutionary AI-powered solution for small businesses.',
                'business_website' => 'https://techstartup.com',
                'linkedin_profile' => 'https://linkedin.com/in/johnentrepreneur'
            ];
            createEntrepreneur($entrepreneur_data, $pdo);
        }
        
        if ($investor_count == 0) {
            // Create sample investor
            $investor_data = [
                'first_name' => 'Jane',
                'last_name' => 'Investor',
                'email' => 'investor@test.com',
                'phone' => '+1987654321', 
                'password_hash' => hashPassword('password123'),
                'company_name' => 'VentureCapital LLC',
                'investment_focus' => 'technology, healthcare',
                'investment_range' => '100k-250k',
                'geographic_preference' => 'global',
                'website' => 'https://venturecapital.com',
                'linkedin_profile' => 'https://linkedin.com/in/janeinvestor'
            ];
            createInvestor($investor_data, $pdo);
        }
        
        return true;
    } catch(PDOException $e) {
        error_log("Sample data creation failed: " . $e->getMessage());
        return false;
    }
}

// Create sample data on first run
createSampleData($pdo);
?>