<?php
session_start();

// Include database connection - Update this path to match your file structure
require_once '../dbconnect.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../investor/InvestorRegForm.php');
    exit;
}

// Initialize error array
$errors = [];

// Validate required fields
$required_fields = [
    'first_name', 'last_name', 'email', 'password', 'confirm_password',
    'investment_focus', 'investment_range'
];

foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        $errors[] = ucwords(str_replace('_', ' ', $field)) . " is required.";
    }
}

// Validate email format
if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
}

// Check if email already exists
if (!empty($_POST['email'])) {
    try {
        $stmt = $pdo->prepare("SELECT email FROM entrepreneurs WHERE email = ? UNION SELECT email FROM investors WHERE email = ?");
        $stmt->execute([$_POST['email'], $_POST['email']]);
        if ($stmt->rowCount() > 0) {
            $errors[] = "An account with this email already exists.";
        }
    } catch (PDOException $e) {
        $errors[] = "Database error occurred. Please try again.";
    }
}

// Validate password match
if (!empty($_POST['password']) && !empty($_POST['confirm_password'])) {
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $errors[] = "Passwords do not match.";
    }
    if (strlen($_POST['password']) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }
}

// Terms and conditions consent
if (empty($_POST['terms_consent'])) {
    $errors[] = "You must agree to the Terms & Conditions.";
}

// Handle required file upload (business statement)
$business_statement_file = null;
if (isset($_FILES['business_statement']) && $_FILES['business_statement']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../uploads/business_statements/';
    
    // Create directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_extension = pathinfo($_FILES['business_statement']['name'], PATHINFO_EXTENSION);
    $allowed_extensions = ['pdf', 'jpg', 'jpeg', 'png'];
    
    if (!in_array(strtolower($file_extension), $allowed_extensions)) {
        $errors[] = "Only PDF, JPG, and PNG files are allowed for business statement.";
    } else {
        // Check file size (max 5MB)
        if ($_FILES['business_statement']['size'] > 5 * 1024 * 1024) {
            $errors[] = "Business statement file must be less than 5MB.";
        } else {
            $business_statement_file = uniqid() . '_' . time() . '.' . $file_extension;
            $file_path = $upload_dir . $business_statement_file;
            
            if (!move_uploaded_file($_FILES['business_statement']['tmp_name'], $file_path)) {
                $errors[] = "Failed to upload business statement file.";
                $business_statement_file = null;
            }
        }
    }
} else {
    $errors[] = "Business statement file is required.";
}

// If there are errors, redirect back with error messages
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: ../investor/InvestorRegForm.php');
    exit;
}

try {
    // Prepare SQL statement
    $sql = "INSERT INTO investors (
        first_name, last_name, email, phone, password_hash,
        investment_focus, investment_range, business_stage, geographic_preference,
        investment_experience, investment_details, company_name, job_title,
        linkedin_profile, website, business_statement_file, how_heard,
        additional_info, created_at, updated_at
    ) VALUES (
        :first_name, :last_name, :email, :phone, :password_hash,
        :investment_focus, :investment_range, :business_stage, :geographic_preference,
        :investment_experience, :investment_details, :company_name, :job_title,
        :linkedin_profile, :website, :business_statement_file, :how_heard,
        :additional_info, NOW(), NOW()
    )";
    
    $stmt = $pdo->prepare($sql);
    
    // Execute with parameters
    $result = $stmt->execute([
        ':first_name' => trim($_POST['first_name']),
        ':last_name' => trim($_POST['last_name']),
        ':email' => trim(strtolower($_POST['email'])),
        ':phone' => trim($_POST['phone']) ?: null,
        ':password_hash' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        ':investment_focus' => $_POST['investment_focus'],
        ':investment_range' => $_POST['investment_range'],
        ':business_stage' => $_POST['business_stage'] ?: null,
        ':geographic_preference' => $_POST['geographic_preference'] ?: null,
        ':investment_experience' => $_POST['investment_experience'] ?: null,
        ':investment_details' => trim($_POST['investment_details']) ?: null,
        ':company_name' => trim($_POST['company_name']) ?: null,
        ':job_title' => trim($_POST['job_title']) ?: null,
        ':linkedin_profile' => trim($_POST['linkedin_profile']) ?: null,
        ':website' => trim($_POST['website']) ?: null,
        ':business_statement_file' => $business_statement_file,
        ':how_heard' => $_POST['how_heard'] ?: null,
        ':additional_info' => trim($_POST['additional_info']) ?: null
    ]);
    
    if ($result) {
        $user_id = $pdo->lastInsertId();
        
        // Set success message
        $_SESSION['success_message'] = "Registration successful! Welcome to Elevator X!";
        
        // Auto-login the user
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_role'] = 'investor';
        $_SESSION['user_name'] = trim($_POST['first_name']) . ' ' . trim($_POST['last_name']);
        $_SESSION['user_email'] = trim(strtolower($_POST['email']));
        
        // Clear any form data
        unset($_SESSION['form_data']);
        unset($_SESSION['errors']);
        
        // For now, redirect back to registration form with success message
        // You can change this to redirect to dashboard once you create it
        header('Location: ../JoinUs.php');
        exit;
        
    } else {
        throw new Exception("Failed to create account. Please try again.");
    }
    
} catch (Exception $e) {
    // Handle database errors
    $_SESSION['errors'] = ["Registration failed: " . $e->getMessage()];
    $_SESSION['form_data'] = $_POST;
    
    // Clean up uploaded file if registration failed
    if ($business_statement_file && file_exists($upload_dir . $business_statement_file)) {
        unlink($upload_dir . $business_statement_file);
    }
    
    header('Location: ../investor/InvestorRegForm.php');
    exit;
}
?>