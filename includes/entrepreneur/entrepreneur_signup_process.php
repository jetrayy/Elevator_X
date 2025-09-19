<?php
session_start();

// Include database connection - Update this path to match your file structure
require_once '../dbconnect.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../entrepreneur/EntreRegForm.php');
    exit;
}

// Initialize error array
$errors = [];

// Validate required fields
$required_fields = [
    'first_name', 'last_name', 'email', 'password', 'confirm_password',
    'business_category', 'business_stage', 'business_location', 'business_description',
    'date_of_birth', 'nationality'
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

// Validate date of birth (must be 18 or older)
if (!empty($_POST['date_of_birth'])) {
    $dob = new DateTime($_POST['date_of_birth']);
    $today = new DateTime();
    $age = $today->diff($dob)->y;
    
    if ($age < 18) {
        $errors[] = "You must be at least 18 years old to register.";
    }
}

// Validate support needed (at least one must be selected)
if (empty($_POST['support_needed'])) {
    $errors[] = "Please select at least one type of support you're looking for.";
}

// Terms and conditions consent
if (empty($_POST['terms_consent'])) {
    $errors[] = "You must agree to the Terms & Conditions.";
}

// Handle file upload if provided
$business_registration_file = null;
if (isset($_FILES['business_registration']) && $_FILES['business_registration']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = '../uploads/business_registrations/';
    
    // Create directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file_extension = pathinfo($_FILES['business_registration']['name'], PATHINFO_EXTENSION);
    $allowed_extensions = ['pdf', 'jpg', 'jpeg', 'png'];
    
    if (!in_array(strtolower($file_extension), $allowed_extensions)) {
        $errors[] = "Only PDF, JPG, and PNG files are allowed for business registration.";
    } else {
        $business_registration_file = uniqid() . '_' . time() . '.' . $file_extension;
        $file_path = $upload_dir . $business_registration_file;
        
        if (!move_uploaded_file($_FILES['business_registration']['tmp_name'], $file_path)) {
            $errors[] = "Failed to upload business registration file.";
            $business_registration_file = null;
        }
    }
}

// If there are errors, redirect back with error messages
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header('Location: ../entrepreneur/EntreRegForm.php');
    exit;
}

try {
    // Prepare data for insertion
    $support_needed = isset($_POST['support_needed']) ? implode(',', $_POST['support_needed']) : '';
    
    // Prepare SQL statement
    $sql = "INSERT INTO entrepreneurs (
        first_name, last_name, email, phone, password_hash,
        business_name, business_category, business_stage, business_location,
        business_description, business_website, date_of_birth, nationality,
        linkedin_profile, support_needed, funding_need, business_plan,
        business_registration_file, how_heard, newsletter_subscribe,
        created_at, updated_at
    ) VALUES (
        :first_name, :last_name, :email, :phone, :password_hash,
        :business_name, :business_category, :business_stage, :business_location,
        :business_description, :business_website, :date_of_birth, :nationality,
        :linkedin_profile, :support_needed, :funding_need, :business_plan,
        :business_registration_file, :how_heard, :newsletter_subscribe,
        NOW(), NOW()
    )";
    
    $stmt = $pdo->prepare($sql);
    
    // Execute with parameters
    $result = $stmt->execute([
        ':first_name' => trim($_POST['first_name']),
        ':last_name' => trim($_POST['last_name']),
        ':email' => trim(strtolower($_POST['email'])),
        ':phone' => trim($_POST['phone']) ?: null,
        ':password_hash' => password_hash($_POST['password'], PASSWORD_DEFAULT),
        ':business_name' => trim($_POST['business_name']) ?: null,
        ':business_category' => $_POST['business_category'],
        ':business_stage' => $_POST['business_stage'],
        ':business_location' => trim($_POST['business_location']),
        ':business_description' => trim($_POST['business_description']),
        ':business_website' => trim($_POST['business_website']) ?: null,
        ':date_of_birth' => $_POST['date_of_birth'],
        ':nationality' => $_POST['nationality'],
        ':linkedin_profile' => trim($_POST['linkedin_profile']) ?: null,
        ':support_needed' => $support_needed,
        ':funding_need' => $_POST['funding_need'] ?: null,
        ':business_plan' => $_POST['business_plan'] ?: null,
        ':business_registration_file' => $business_registration_file,
        ':how_heard' => $_POST['how_heard'] ?: null,
        ':newsletter_subscribe' => isset($_POST['newsletter_subscribe']) ? 1 : 0
    ]);
    
    if ($result) {
        $user_id = $pdo->lastInsertId();
        
        // Set success message
        $_SESSION['success_message'] = "Registration successful! Welcome to Elevator X!";
        
        // Auto-login the user
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_role'] = 'entrepreneur';
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
    if ($business_registration_file && file_exists($upload_dir . $business_registration_file)) {
        unlink($upload_dir . $business_registration_file);
    }
    
    header('Location: ../entrepreneur/EntreRegForm.php');
    exit;
}
?>