<?php
session_start();
require_once '../dbconnect.php';

// Check if user is logged in and is an entrepreneur
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'entrepreneur') {
    header("Location: ../JoinUs.php");
    exit();
}

// Get entrepreneur data
$entrepreneur = [
    'id' => $_SESSION['user_id'],
    'first_name' => 'Test',
    'last_name' => 'User',
    'email' => $_SESSION['user_email'] ?? 'test@test.com',
    'phone' => '',
    'business_name' => '',
    'business_category' => 'technology',
    'business_stage' => 'idea',
    'business_description' => '',
    'business_website' => '',
    'linkedin_profile' => ''
];

try {
    if (isset($pdo) && isset($_SESSION['user_email'])) {
        $real_entrepreneur = getEntrepreneurByEmail($_SESSION['user_email'], $pdo);
        if ($real_entrepreneur) {
            $entrepreneur = array_merge($entrepreneur, $real_entrepreneur);
        }
    }
} catch (Exception $e) {
    error_log("Dashboard error: " . $e->getMessage());
}

$entrepreneur_id = $entrepreneur['id'];
$success_message = '';
$error_message = '';

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    try {
        switch ($_POST['action']) {
            case 'delete_gig':
                $gig_id = filter_var($_POST['gig_id'], FILTER_VALIDATE_INT);
                
                // Check ownership
                $stmt = $pdo->prepare("SELECT id FROM gigs WHERE id = ? AND entrepreneur_id = ?");
                $stmt->execute([$gig_id, $entrepreneur_id]);
                if (!$stmt->fetch()) {
                    throw new Exception('Unauthorized');
                }
                
                // Delete images
                $stmt = $pdo->prepare("SELECT image_filename FROM gig_images WHERE gig_id = ?");
                $stmt->execute([$gig_id]);
                $images = $stmt->fetchAll();
                
                foreach ($images as $image) {
                    $file_path = '../uploads/gig_images/' . $image['image_filename'];
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
                
                $stmt = $pdo->prepare("DELETE FROM gigs WHERE id = ?");
                $result = $stmt->execute([$gig_id]);
                
                echo json_encode(['success' => $result]);
                break;

            case 'accept_connection':
                $connection_id = filter_var($_POST['connection_id'], FILTER_VALIDATE_INT);
                
                $stmt = $pdo->prepare("
                    UPDATE investor_connections 
                    SET status = 'accepted', responded_at = NOW() 
                    WHERE id = ? AND entrepreneur_id = ?
                ");
                $result = $stmt->execute([$connection_id, $entrepreneur_id]);
                
                echo json_encode(['success' => $result]);
                break;

            case 'reject_connection':
                $connection_id = filter_var($_POST['connection_id'], FILTER_VALIDATE_INT);
                
                $stmt = $pdo->prepare("
                    UPDATE investor_connections 
                    SET status = 'rejected', responded_at = NOW() 
                    WHERE id = ? AND entrepreneur_id = ?
                ");
                $result = $stmt->execute([$connection_id, $entrepreneur_id]);
                
                echo json_encode(['success' => $result]);
                break;

            case 'send_message':
                $recipient_id = filter_var($_POST['recipient_id'], FILTER_VALIDATE_INT);
                $subject = trim($_POST['subject']);
                $message = trim($_POST['message']);
                
                $stmt = $pdo->prepare("
                    INSERT INTO messages (sender_id, sender_type, recipient_id, recipient_type, subject, message)
                    VALUES (?, 'entrepreneur', ?, 'investor', ?, ?)
                ");
                $result = $stmt->execute([$entrepreneur_id, $recipient_id, $subject, $message]);
                
                echo json_encode(['success' => $result]);
                break;
                
            default:
                throw new Exception('Invalid action');
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
    exit;
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['action'])) {
    try {
        if (isset($_POST['create_gig'])) {
            $upload_dir = '../uploads/gig_images/';
            if (!file_exists($upload_dir)) {
                if (!mkdir($upload_dir, 0755, true)) {
                    throw new Exception("Failed to create upload directory.");
                }
            }
            
            // Validate required fields
            if (empty($_POST['gig_title']) || empty($_POST['gig_description']) || 
                empty($_POST['gig_category']) || empty($_POST['funding_needed'])) {
                throw new Exception("All fields are required.");
            }
            
            // Begin transaction
            $pdo->beginTransaction();
            
            try {
                // Insert gig
                $stmt = $pdo->prepare("
                    INSERT INTO gigs (entrepreneur_id, title, description, category, funding_needed) 
                    VALUES (?, ?, ?, ?, ?)
                ");
                
                $result = $stmt->execute([
                    $entrepreneur_id,
                    trim($_POST['gig_title']),
                    trim($_POST['gig_description']),
                    $_POST['gig_category'],
                    $_POST['funding_needed']
                ]);
                
                if (!$result) {
                    throw new Exception("Failed to create gig record.");
                }
                
                $gig_id = $pdo->lastInsertId();
                
                // Handle image uploads
                $uploaded_count = 0;
                $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                $max_file_size = 5 * 1024 * 1024; // 5MB
                
                for ($i = 1; $i <= 5; $i++) {
                    if (isset($_FILES["gig_image_$i"]) && $_FILES["gig_image_$i"]['error'] === UPLOAD_ERR_OK) {
                        $file = $_FILES["gig_image_$i"];
                        
                        // Validate file type
                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                        $mime_type = finfo_file($finfo, $file['tmp_name']);
                        finfo_close($finfo);
                        
                        if (!in_array($mime_type, $allowed_types)) {
                            error_log("Invalid file type for image $i: $mime_type");
                            continue;
                        }
                        
                        // Validate file size
                        if ($file['size'] > $max_file_size) {
                            error_log("File size too large for image $i: {$file['size']} bytes");
                            continue;
                        }
                        
                        // Generate unique filename
                        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                        if (empty($extension)) {
                            $extension = 'jpg'; // Default extension
                        }
                        
                        $filename = 'gig_' . $gig_id . '_' . $i . '_' . uniqid() . '.' . $extension;
                        $file_path = $upload_dir . $filename;
                        
                        // Move uploaded file
                        if (move_uploaded_file($file['tmp_name'], $file_path)) {
                            // Insert into database
                            $stmt = $pdo->prepare("
                                INSERT INTO gig_images (gig_id, image_filename, original_filename, image_order) 
                                VALUES (?, ?, ?, ?)
                            ");
                            $result = $stmt->execute([$gig_id, $filename, $file['name'], $i]);
                            
                            if ($result) {
                                $uploaded_count++;
                            } else {
                                // If database insert fails, remove the uploaded file
                                unlink($file_path);
                                error_log("Failed to insert image record for $filename");
                            }
                        } else {
                            error_log("Failed to move uploaded file for image $i");
                        }
                    }
                }
                
                if ($uploaded_count === 0 && isset($_FILES['gig_image_1']) && $_FILES['gig_image_1']['error'] !== UPLOAD_ERR_NO_FILE) {
                    error_log("No images uploaded but files were submitted");
                }
                
                // Commit transaction - gig created successfully even without images
                $pdo->commit();
                $success_message = $uploaded_count > 0 ? 
                    "Gig posted successfully with $uploaded_count image(s)!" : 
                    "Gig posted successfully!";
                
            } catch (Exception $e) {
                // Rollback transaction
                $pdo->rollback();
                throw $e;
            }
            
        } elseif (isset($_POST['update_personal'])) {
            $stmt = $pdo->prepare("
                UPDATE entrepreneurs 
                SET first_name = ?, last_name = ?, phone = ?, linkedin_profile = ?
                WHERE id = ?
            ");
            
            $result = $stmt->execute([
                trim($_POST['first_name']),
                trim($_POST['last_name']),
                trim($_POST['phone']),
                trim($_POST['linkedin_profile']),
                $entrepreneur_id
            ]);
            
            if ($result) {
                $success_message = "Personal information updated successfully!";
                // Update session data
                $entrepreneur['first_name'] = trim($_POST['first_name']);
                $entrepreneur['last_name'] = trim($_POST['last_name']);
                $entrepreneur['phone'] = trim($_POST['phone']);
                $entrepreneur['linkedin_profile'] = trim($_POST['linkedin_profile']);
            }
        } elseif (isset($_POST['update_business'])) {
            $stmt = $pdo->prepare("
                UPDATE entrepreneurs 
                SET business_name = ?, business_category = ?, business_stage = ?, 
                    business_description = ?, business_website = ?
                WHERE id = ?
            ");
            
            $result = $stmt->execute([
                trim($_POST['business_name']),
                $_POST['business_category'],
                $_POST['business_stage'],
                trim($_POST['business_description']),
                trim($_POST['business_website']),
                $entrepreneur_id
            ]);
            
            if ($result) {
                $success_message = "Business information updated successfully!";
                // Update session data
                $entrepreneur['business_name'] = trim($_POST['business_name']);
                $entrepreneur['business_category'] = $_POST['business_category'];
                $entrepreneur['business_stage'] = $_POST['business_stage'];
                $entrepreneur['business_description'] = trim($_POST['business_description']);
                $entrepreneur['business_website'] = trim($_POST['business_website']);
            }
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Helper function for upload error messages
function getUploadErrorMessage($error_code) {
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
            return 'File exceeds upload_max_filesize directive in php.ini';
        case UPLOAD_ERR_FORM_SIZE:
            return 'File exceeds MAX_FILE_SIZE directive';
        case UPLOAD_ERR_PARTIAL:
            return 'File was only partially uploaded';
        case UPLOAD_ERR_NO_FILE:
            return 'No file was uploaded';
        case UPLOAD_ERR_NO_TMP_DIR:
            return 'Missing temporary folder';
        case UPLOAD_ERR_CANT_WRITE:
            return 'Failed to write file to disk';
        case UPLOAD_ERR_EXTENSION:
            return 'File upload stopped by extension';
        default:
            return 'Unknown upload error';
    }
}

// Get statistics
$active_gigs = 0;
$total_connections = 0;
$pending_requests = 0;
$unread_messages = 0;

try {
    if (isset($pdo)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM gigs WHERE entrepreneur_id = ? AND status = 'active'");
        $stmt->execute([$entrepreneur_id]);
        $active_gigs = $stmt->fetch()['count'];
        
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM investor_connections WHERE entrepreneur_id = ?");
        $stmt->execute([$entrepreneur_id]);
        $total_connections = $stmt->fetch()['count'];
        
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM investor_connections WHERE entrepreneur_id = ? AND status = 'pending'");
        $stmt->execute([$entrepreneur_id]);
        $pending_requests = $stmt->fetch()['count'];
        
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM messages WHERE recipient_id = ? AND recipient_type = 'entrepreneur' AND is_read = 0");
        $stmt->execute([$entrepreneur_id]);
        $unread_messages = $stmt->fetch()['count'];
    }
} catch (Exception $e) {
    error_log("Stats error: " . $e->getMessage());
}

// Get entrepreneur's gigs
$entrepreneur_gigs = [];
try {
    if (isset($pdo)) {
        $stmt = $pdo->prepare("
            SELECT g.*, GROUP_CONCAT(gi.image_filename ORDER BY gi.image_order) as images
            FROM gigs g
            LEFT JOIN gig_images gi ON g.id = gi.gig_id
            WHERE g.entrepreneur_id = ?
            GROUP BY g.id
            ORDER BY g.created_at DESC
        ");
        $stmt->execute([$entrepreneur_id]);
        $entrepreneur_gigs = $stmt->fetchAll();
    }
} catch (Exception $e) {
    error_log("Gigs error: " . $e->getMessage());
}

// Get pending connection requests
$pending_connections = [];
try {
    if (isset($pdo)) {
        $stmt = $pdo->prepare("
            SELECT ic.*, i.first_name, i.last_name, i.company_name, g.title as gig_title
            FROM investor_connections ic
            JOIN investors i ON ic.investor_id = i.id
            LEFT JOIN gigs g ON ic.gig_id = g.id
            WHERE ic.entrepreneur_id = ? AND ic.status = 'pending'
            ORDER BY ic.requested_at DESC
        ");
        $stmt->execute([$entrepreneur_id]);
        $pending_connections = $stmt->fetchAll();
    }
} catch (Exception $e) {
    error_log("Connections error: " . $e->getMessage());
}

// Get messages
$conversations = [];
try {
    if (isset($pdo)) {
        $stmt = $pdo->prepare("
            SELECT m.*, i.first_name, i.last_name, i.company_name
            FROM messages m
            LEFT JOIN investors i ON m.sender_id = i.id AND m.sender_type = 'investor'
            WHERE (m.recipient_id = ? AND m.recipient_type = 'entrepreneur') 
               OR (m.sender_id = ? AND m.sender_type = 'entrepreneur')
            ORDER BY m.sent_at DESC
        ");
        $stmt->execute([$entrepreneur_id, $entrepreneur_id]);
        $conversations = $stmt->fetchAll();
    }
} catch (Exception $e) {
    error_log("Messages error: " . $e->getMessage());
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ../JoinUs.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrepreneur Dashboard - Elevator X</title>
    <link rel="icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: white;
            min-height: 100vh;
        }

        .header {
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            border-bottom: 1px solid rgba(59, 130, 246, 0.3);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo-section { display: flex; align-items: center; gap: 15px; }
        .logo-img { width: 120px; height: auto; }
        .logo-text { font-size: 1.5rem; font-weight: bold; color: #60a5fa; }

        .user-section { display: flex; align-items: center; gap: 15px; }
        .user-info { text-align: right; }
        .user-name { font-weight: 600; color: #60a5fa; }
        .user-role { font-size: 14px; color: #cbd5e1; }

        .notification-badge {
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logout-btn {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid #ef4444;
            color: #ef4444;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .logout-btn:hover { background: #ef4444; color: white; }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 200px 1fr;
            gap: 20px;
        }

        .sidebar {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 12px;
            padding: 20px;
            height: fit-content;
        }

        .nav-menu { list-style: none; }
        .nav-item { margin-bottom: 8px; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 15px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active { 
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa; 
        }

        .main-content {
            background: rgba(0, 0, 0, 0.4);
            border-radius: 12px;
            padding: 25px;
        }

        .section { display: none; }
        .section.active { display: block; }

        .section-title {
            color: #60a5fa;
            font-size: 24px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }

        .stat-number { font-size: 24px; font-weight: 600; color: #60a5fa; }
        .stat-label { color: #cbd5e1; font-size: 14px; margin-top: 5px; }

        .btn {
            background: linear-gradient(45deg, #2563eb, #3b82f6);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-success { background: linear-gradient(45deg, #10b981, #34d399); }
        .btn-danger { background: linear-gradient(45deg, #ef4444, #dc2626); }
        .btn-secondary { background: rgba(107, 114, 128, 0.3); }

        .form-group { margin-bottom: 15px; }
        .form-label { display: block; margin-bottom: 5px; color: #cbd5e1; }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
            font-size: 14px;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 10px rgba(59, 130, 246, 0.3);
        }

        .form-input::placeholder, .form-textarea::placeholder { color: rgba(255, 255, 255, 0.5); }
        .form-select option { background: #1e3a8a; color: white; }
        .form-textarea { resize: vertical; min-height: 80px; }

        .gig-card {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
        }

        .gig-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }

        .gig-title { font-size: 18px; font-weight: 600; color: #60a5fa; }

        .gig-images {
            display: flex;
            gap: 8px;
            margin: 10px 0;
            flex-wrap: wrap;
        }

        .gig-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid rgba(59, 130, 246, 0.3);
            cursor: pointer;
        }

        .image-upload-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .image-upload-box {
            border: 2px dashed rgba(59, 130, 246, 0.3);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            background: rgba(59, 130, 246, 0.05);
            transition: all 0.3s ease;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .image-upload-box:hover {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
        }

        .image-upload-box input { display: none; }

        .image-upload-box.has-image {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.1);
        }

        .connection-card {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .connection-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 10px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 1000;
        }

        .modal-content {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            border-radius: 12px;
            padding: 25px;
            max-width: 600px;
            margin: 5% auto;
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
            color: #fff;
        }

        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
        }

        .upload-progress {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .container { grid-template-columns: 1fr; }
            .image-upload-grid { grid-template-columns: repeat(3, 1fr); }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <img src="../img/logo.png" alt="Elevator X" class="logo-img">
                
            </div>
            <div class="user-section">
                <div class="user-info">
                    <div class="user-name"><?php echo htmlspecialchars($entrepreneur['first_name'] . ' ' . $entrepreneur['last_name']); ?></div>
                    <div class="user-role">Entrepreneur</div>
                </div>
                <?php if ($unread_messages > 0): ?>
                <div class="notification-badge"><?php echo $unread_messages; ?></div>
                <?php endif; ?>
                <a href="?logout=1" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#" class="nav-link active" onclick="showSection('overview')">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showSection('gigs')">
                        <i class="fas fa-lightbulb"></i> My Gigs
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showSection('requests')">
                        <i class="fas fa-handshake"></i> Requests
                        <?php if ($pending_requests > 0): ?>
                            <span style="background: #ef4444; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; display: flex; align-items: center; justify-content: center; margin-left: auto;"><?php echo $pending_requests; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showSection('messages')">
                        <i class="fas fa-envelope"></i> Messages
                        <?php if ($unread_messages > 0): ?>
                            <span style="background: #ef4444; border-radius: 50%; width: 18px; height: 18px; font-size: 10px; display: flex; align-items: center; justify-content: center; margin-left: auto;"><?php echo $unread_messages; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showSection('profile')">
                        <i class="fas fa-user"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../LearnX/learnx_home.php" class="nav-link">
                        <i class="fas fa-graduation-cap"></i> Learning Hub
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../Mentorship/M_index.php" class="nav-link">
                        <i class="fas fa-user-tie"></i> Mentorship
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Messages -->
            <?php if ($success_message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
            <?php if ($error_message): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>

            <!-- Dashboard Overview -->
            <section id="overview" class="section active">
                <h2 class="section-title"><i class="fas fa-home"></i> Dashboard Overview</h2>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $active_gigs; ?></div>
                        <div class="stat-label">Active Gigs</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $total_connections; ?></div>
                        <div class="stat-label">Total Connections</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $pending_requests; ?></div>
                        <div class="stat-label">Pending Requests</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $unread_messages; ?></div>
                        <div class="stat-label">New Messages</div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 20px;">
                    <div class="stat-card" style="cursor: pointer;" onclick="showSection('gigs')">
                        <i class="fas fa-plus-circle" style="font-size: 2rem; color: #60a5fa; margin-bottom: 10px;"></i>
                        <h3>Post New Gig</h3>
                        <p style="color: #cbd5e1; font-size: 14px;">Share your business idea</p>
                    </div>
                    
                    <?php if ($pending_requests > 0): ?>
                    <div class="stat-card" style="cursor: pointer;" onclick="showSection('requests')">
                        <i class="fas fa-bell" style="font-size: 2rem; color: #f59e0b; margin-bottom: 10px;"></i>
                        <h3>Review Requests</h3>
                        <p style="color: #cbd5e1; font-size: 14px;"><?php echo $pending_requests; ?> pending request(s)</p>
                    </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- My Gigs Section -->
            <section id="gigs" class="section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 class="section-title" style="margin: 0;"><i class="fas fa-lightbulb"></i> My Gigs</h2>
                    <button class="btn" onclick="toggleForm('gig-form')">
                        <i class="fas fa-plus"></i> Post New Gig
                    </button>
                </div>

                <!-- Post Gig Form -->
                <div id="gig-form" style="display: none; background: rgba(59, 130, 246, 0.1); padding: 20px; border-radius: 10px; margin-bottom: 20px;">
                    <h3 style="margin-bottom: 15px;">Post New Gig</h3>
                    <form method="POST" enctype="multipart/form-data" id="gigForm">
                        <input type="hidden" name="create_gig" value="1">
                        
                        <div class="form-group">
                            <label class="form-label">Gig Title *</label>
                            <input type="text" name="gig_title" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Category *</label>
                            <select name="gig_category" class="form-select" required>
                                <option value="">Select Category</option>
                                <option value="technology">Technology</option>
                                <option value="healthcare">Healthcare</option>
                                <option value="fintech">Fintech</option>
                                <option value="e-commerce">E-commerce</option>
                                <option value="education">Education</option>
                                <option value="sustainability">Sustainability</option>
                                <option value="food-beverage">Food & Beverage</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Description *</label>
                            <textarea name="gig_description" class="form-textarea" required placeholder="Describe your business idea, what problem it solves, and what makes it unique..."></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Funding Needed *</label>
                            <select name="funding_needed" class="form-select" required>
                                <option value="">Select Range</option>
                                <option value="10k-50k">$10K - $50K</option>
                                <option value="50k-100k">$50K - $100K</option>
                                <option value="100k-250k">$100K - $250K</option>
                                <option value="250k-500k">$250K - $500K</option>
                                <option value="500k+">$500K+</option>
                            </select>
                        </div>

                        <!-- Images (Optional) -->
                        <div class="form-group">
                            <label class="form-label">Gig Images (Optional - max 5MB each)</label>
                            <div class="image-upload-grid">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                <div class="image-upload-box" onclick="document.getElementById('gig_image_<?php echo $i; ?>').click()" id="upload-box-<?php echo $i; ?>">
                                    <i class="fas fa-camera" style="font-size: 20px; color: #60a5fa;"></i>
                                    <div style="font-size: 12px; color: #cbd5e1; margin-top: 5px;">Image <?php echo $i; ?></div>
                                    <input type="file" id="gig_image_<?php echo $i; ?>" name="gig_image_<?php echo $i; ?>" 
                                           accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" 
                                           onchange="handleImageUpload(this, <?php echo $i; ?>)">
                                </div>
                                <?php endfor; ?>
                            </div>
                            <div id="upload-status" style="margin-top: 10px; font-size: 12px; color: #cbd5e1;">
                                Images are optional - you can post without images
                            </div>
                        </div>
                        
                        <div class="upload-progress" id="upload-progress">
                            <i class="fas fa-spinner fa-spin"></i> Uploading images...
                        </div>
                        
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn" id="submitGigBtn">
                                <i class="fas fa-upload"></i> Post Gig
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="resetGigForm()">Reset</button>
                            <button type="button" class="btn btn-secondary" onclick="toggleForm('gig-form')">Cancel</button>
                        </div>
                    </form>
                </div>

                <!-- My Gigs List -->
                <?php if (empty($entrepreneur_gigs)): ?>
                    <div style="text-align: center; padding: 40px; color: #cbd5e1;">
                        <i class="fas fa-lightbulb" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                        <h3>No gigs posted yet</h3>
                        <p>Create your first gig to start attracting investors!</p>
                        <button class="btn" onclick="toggleForm('gig-form')" style="margin-top: 15px;">Post Your First Gig</button>
                    </div>
                <?php else: ?>
                    <?php foreach ($entrepreneur_gigs as $gig): ?>
                        <div class="gig-card">
                            <div class="gig-header">
                                <div>
                                    <div class="gig-title"><?php echo htmlspecialchars($gig['title']); ?></div>
                                    <div style="font-size: 12px; color: #cbd5e1;">
                                        <?php echo ucfirst($gig['category']); ?> • <?php echo $gig['funding_needed']; ?>
                                    </div>
                                </div>
                                <button class="btn btn-danger" onclick="deleteGig(<?php echo $gig['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            
                            <?php if ($gig['images']): ?>
                            <div class="gig-images">
                                <?php foreach (explode(',', $gig['images']) as $image): ?>
                                    <?php if ($image): ?>
                                    <img src="../uploads/gig_images/<?php echo htmlspecialchars($image); ?>" 
                                         class="gig-image" onclick="openImageModal('<?php echo htmlspecialchars($image); ?>')"
                                         alt="Gig image" onerror="this.style.display='none'">
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            
                            <div style="margin-top: 10px; color: #fff;">
                                <?php echo htmlspecialchars(substr($gig['description'], 0, 150)); ?>...
                            </div>
                            
                            <div style="margin-top: 10px; font-size: 12px; color: #cbd5e1;">
                                Posted: <?php echo date('M j, Y', strtotime($gig['created_at'])); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <!-- Connection Requests Section -->
            <section id="requests" class="section">
                <h2 class="section-title"><i class="fas fa-handshake"></i> Connection Requests</h2>
                
                <?php if (empty($pending_connections)): ?>
                    <div style="text-align: center; padding: 40px; color: #cbd5e1;">
                        <i class="fas fa-handshake" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                        <h3>No pending requests</h3>
                        <p>Connection requests from investors will appear here.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($pending_connections as $conn): ?>
                        <div class="connection-card">
                            <div class="connection-header">
                                <div>
                                    <h4 style="color: #60a5fa;"><?php echo htmlspecialchars($conn['first_name'] . ' ' . $conn['last_name']); ?></h4>
                                    <div style="font-size: 12px; color: #cbd5e1;">
                                        <?php echo htmlspecialchars($conn['company_name'] ?? 'Independent Investor'); ?>
                                    </div>
                                    <?php if ($conn['gig_title']): ?>
                                    <div style="font-size: 12px; color: #fbbf24; margin-top: 5px;">
                                        Interest in: <?php echo htmlspecialchars($conn['gig_title']); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div style="font-size: 12px; color: #cbd5e1;">
                                    <?php echo date('M j, Y', strtotime($conn['requested_at'])); ?>
                                </div>
                            </div>
                            
                            <div style="background: rgba(0, 0, 0, 0.3); padding: 10px; border-radius: 6px; margin: 10px 0;">
                                <?php echo nl2br(htmlspecialchars($conn['request_message'])); ?>
                            </div>
                            
                            <div style="display: flex; gap: 10px;">
                                <button class="btn btn-success" onclick="acceptConnection(<?php echo $conn['id']; ?>)">
                                    <i class="fas fa-check"></i> Accept
                                </button>
                                <button class="btn btn-danger" onclick="rejectConnection(<?php echo $conn['id']; ?>)">
                                    <i class="fas fa-times"></i> Reject
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <!-- Messages Section -->
            <section id="messages" class="section">
                <h2 class="section-title"><i class="fas fa-envelope"></i> Messages</h2>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    <div></div>
                    <button class="btn" onclick="showNewMessageForm()">
                        <i class="fas fa-plus"></i> New Message
                    </button>
                </div>

                <?php if (empty($conversations)): ?>
                    <div style="text-align: center; padding: 40px; color: #cbd5e1;">
                        <i class="fas fa-envelope-open" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                        <h3>No messages yet</h3>
                        <p>Messages from investors will appear here after they connect with you.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($conversations as $msg): ?>
                        <div class="connection-card <?php echo $msg['is_read'] ? '' : 'unread-message'; ?>" style="<?php echo !$msg['is_read'] ? 'border-left: 4px solid #60a5fa;' : ''; ?>">
                            <div class="connection-header">
                                <div>
                                    <h4 style="color: #60a5fa;"><?php echo htmlspecialchars($msg['subject']); ?></h4>
                                    <div style="font-size: 12px; color: #cbd5e1;">
                                        From: <?php echo htmlspecialchars(($msg['first_name'] ?? '') . ' ' . ($msg['last_name'] ?? 'Unknown')); ?>
                                        <?php if ($msg['company_name']): ?>
                                            (<?php echo htmlspecialchars($msg['company_name']); ?>)
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div style="font-size: 12px; color: #cbd5e1;">
                                    <?php echo date('M j, Y g:i A', strtotime($msg['sent_at'])); ?>
                                </div>
                            </div>
                            
                            <div style="margin: 10px 0;">
                                <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                            </div>
                            
                           <?php if (isset($msg['attachment_filename']) && $msg['attachment_filename']): ?>
                           <div style="margin: 10px 0;">
                           <a href="../uploads/messages/<?php echo htmlspecialchars($msg['attachment_filename']); ?>" 
                           style="color: #60a5fa; text-decoration: none;" download>
                           <i class="fas fa-paperclip"></i> <?php echo htmlspecialchars($msg['attachment_original_name'] ?? 'Download'); ?>
                           </a>
                           </div>
                           <?php endif; ?>
                            
                            <div style="display: flex; gap: 10px; margin-top: 10px;">
                                <?php if (!$msg['is_read']): ?>
                                <button class="btn btn-secondary" onclick="markAsRead(<?php echo $msg['id']; ?>)">
                                    <i class="fas fa-check"></i> Mark Read
                                </button>
                                <?php endif; ?>
                                
                                <?php if ($msg['sender_type'] === 'investor'): ?>
                                <button class="btn" onclick="replyToMessage(<?php echo $msg['sender_id']; ?>, 'Re: <?php echo htmlspecialchars($msg['subject'], ENT_QUOTES); ?>')">
                                    <i class="fas fa-reply"></i> Reply
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <!-- Profile Section -->
            <section id="profile" class="section">
                <h2 class="section-title"><i class="fas fa-user"></i> Profile Settings</h2>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    <!-- Personal Information -->
                    <div>
                        <h3 style="margin-bottom: 15px;">Personal Information</h3>
                        <form method="POST">
                            <input type="hidden" name="update_personal" value="1">
                            <div class="form-group">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-input" value="<?php echo htmlspecialchars($entrepreneur['first_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-input" value="<?php echo htmlspecialchars($entrepreneur['last_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-input" value="<?php echo htmlspecialchars($entrepreneur['email']); ?>" readonly style="opacity: 0.6;">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="tel" name="phone" class="form-input" value="<?php echo htmlspecialchars($entrepreneur['phone']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">LinkedIn Profile</label>
                                <input type="url" name="linkedin_profile" class="form-input" value="<?php echo htmlspecialchars($entrepreneur['linkedin_profile']); ?>" placeholder="https://linkedin.com/in/yourprofile">
                            </div>
                            <button type="submit" class="btn">Update Personal Info</button>
                        </form>
                    </div>

                    <!-- Business Information -->
                    <div>
                        <h3 style="margin-bottom: 15px;">Business Information</h3>
                        <form method="POST">
                            <input type="hidden" name="update_business" value="1">
                            <div class="form-group">
                                <label class="form-label">Business Name</label>
                                <input type="text" name="business_name" class="form-input" value="<?php echo htmlspecialchars($entrepreneur['business_name']); ?>" placeholder="Your company name">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Business Category</label>
                                <select name="business_category" class="form-select">
                                    <option value="technology" <?php echo $entrepreneur['business_category'] == 'technology' ? 'selected' : ''; ?>>Technology</option>
                                    <option value="healthcare" <?php echo $entrepreneur['business_category'] == 'healthcare' ? 'selected' : ''; ?>>Healthcare</option>
                                    <option value="fintech" <?php echo $entrepreneur['business_category'] == 'fintech' ? 'selected' : ''; ?>>Fintech</option>
                                    <option value="e-commerce" <?php echo $entrepreneur['business_category'] == 'e-commerce' ? 'selected' : ''; ?>>E-commerce</option>
                                    <option value="education" <?php echo $entrepreneur['business_category'] == 'education' ? 'selected' : ''; ?>>Education</option>
                                    <option value="sustainability" <?php echo $entrepreneur['business_category'] == 'sustainability' ? 'selected' : ''; ?>>Sustainability</option>
                                    <option value="food-beverage" <?php echo $entrepreneur['business_category'] == 'food-beverage' ? 'selected' : ''; ?>>Food & Beverage</option>
                                    <option value="other" <?php echo $entrepreneur['business_category'] == 'other' ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Business Stage</label>
                                <select name="business_stage" class="form-select">
                                    <option value="idea" <?php echo $entrepreneur['business_stage'] == 'idea' ? 'selected' : ''; ?>>Idea</option>
                                    <option value="research" <?php echo $entrepreneur['business_stage'] == 'research' ? 'selected' : ''; ?>>Research</option>
                                    <option value="prototype" <?php echo $entrepreneur['business_stage'] == 'prototype' ? 'selected' : ''; ?>>Prototype</option>
                                    <option value="early-revenue" <?php echo $entrepreneur['business_stage'] == 'early-revenue' ? 'selected' : ''; ?>>Early Revenue</option>
                                    <option value="growth" <?php echo $entrepreneur['business_stage'] == 'growth' ? 'selected' : ''; ?>>Growth</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Website</label>
                                <input type="url" name="business_website" class="form-input" value="<?php echo htmlspecialchars($entrepreneur['business_website']); ?>" placeholder="https://yourwebsite.com">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Business Description</label>
                                <textarea name="business_description" class="form-textarea" placeholder="Describe your business, mission, and what makes it unique..."><?php echo htmlspecialchars($entrepreneur['business_description']); ?></textarea>
                            </div>
                            <button type="submit" class="btn">Update Business Info</button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="modal">
        <div class="modal-content" style="text-align: center; max-width: 80%;">
            <span class="close-modal" onclick="closeModal('imageModal')">&times;</span>
            <img id="modalImage" src="" alt="Gig image" style="max-width: 100%; border-radius: 10px;">
        </div>
    </div>

    <!-- New Message Modal -->
    <div id="newMessageModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('newMessageModal')">&times;</span>
            <h3><i class="fas fa-envelope"></i> Send Message</h3>
            <form id="messageForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">To (Investor ID)</label>
                    <input type="number" id="recipientId" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Subject</label>
                    <input type="text" id="messageSubject" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Message</label>
                    <textarea id="messageContent" class="form-textarea" required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Attachment (Optional)</label>
                    <input type="file" id="messageAttachment" class="form-input">
                </div>
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn">Send Message</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('newMessageModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let uploadedImages = 0;
        
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            document.getElementById(sectionId).classList.add('active');
            if (event.target) event.target.closest('.nav-link').classList.add('active');
        }

        function toggleForm(formId) {
            const form = document.getElementById(formId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function handleImageUpload(input, index) {
            const file = input.files[0];
            const uploadBox = document.getElementById(`upload-box-${index}`);
            const statusDiv = document.getElementById('upload-status');
            
            if (file) {
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type.toLowerCase())) {
                    showMessage('Please select a valid image file (JPEG, PNG, GIF, or WebP)', 'error');
                    input.value = '';
                    return;
                }
                
                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showMessage('Image must be smaller than 5MB', 'error');
                    input.value = '';
                    return;
                }
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    uploadBox.style.backgroundImage = `url(${e.target.result})`;
                    uploadBox.style.backgroundSize = 'cover';
                    uploadBox.style.backgroundPosition = 'center';
                    uploadBox.classList.add('has-image');
                    uploadBox.innerHTML = `
                        <div style="background: rgba(0,0,0,0.8); padding: 5px; border-radius: 4px; color: white; font-size: 10px; position: absolute; bottom: 5px; left: 5px; right: 5px;">
                            ${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}
                        </div>
                        <div style="background: rgba(16, 185, 129, 0.8); color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; position: absolute; top: 5px; right: 5px; font-size: 12px;">
                            <i class="fas fa-check"></i>
                        </div>
                    `;
                    
                    // Update counter
                    updateImageCount();
                };
                reader.readAsDataURL(file);
            }
        }

        function updateImageCount() {
            const inputs = document.querySelectorAll('input[type="file"][name^="gig_image_"]');
            let count = 0;
            inputs.forEach(input => {
                if (input.files && input.files.length > 0) {
                    count++;
                }
            });
            
            uploadedImages = count;
            const statusDiv = document.getElementById('upload-status');
            
            if (count > 0) {
                statusDiv.innerHTML = `<i class="fas fa-check" style="color: #10b981;"></i> ${count} image(s) selected`;
                statusDiv.style.color = '#10b981';
            } else {
                statusDiv.innerHTML = 'Images are optional - you can post without images';
                statusDiv.style.color = '#cbd5e1';
            }
        }

        function resetGigForm() {
            const form = document.getElementById('gigForm');
            form.reset();
            
            // Reset all upload boxes
            for (let i = 1; i <= 5; i++) {
                const uploadBox = document.getElementById(`upload-box-${i}`);
                uploadBox.style.backgroundImage = '';
                uploadBox.classList.remove('has-image');
                uploadBox.innerHTML = `
                    <i class="fas fa-camera" style="font-size: 20px; color: #60a5fa;"></i>
                    <div style="font-size: 12px; color: #cbd5e1; margin-top: 5px;">Image ${i}</div>
                `;
            }
            
            updateImageCount();
        }

        function deleteGig(gigId) {
            if (confirm('Delete this gig? This action cannot be undone.')) {
                const formData = new FormData();
                formData.append('action', 'delete_gig');
                formData.append('gig_id', gigId);
                
                fetch('', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage('Gig deleted successfully!', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showMessage('Failed to delete gig: ' + (data.error || 'Unknown error'), 'error');
                    }
                })
                .catch(error => {
                    showMessage('Network error: ' + error.message, 'error');
                });
            }
        }

        function acceptConnection(connectionId) {
            const formData = new FormData();
            formData.append('action', 'accept_connection');
            formData.append('connection_id', connectionId);
            
            fetch('', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Connection accepted!', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showMessage('Failed to accept connection: ' + (data.error || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                showMessage('Network error: ' + error.message, 'error');
            });
        }

        function rejectConnection(connectionId) {
            const formData = new FormData();
            formData.append('action', 'reject_connection');
            formData.append('connection_id', connectionId);
            
            fetch('', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Connection rejected.', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showMessage('Failed to reject connection: ' + (data.error || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                showMessage('Network error: ' + error.message, 'error');
            });
        }

        function openImageModal(imageName) {
            document.getElementById('modalImage').src = '../uploads/gig_images/' + imageName;
            document.getElementById('imageModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function showNewMessageForm() {
            document.getElementById('newMessageModal').style.display = 'block';
        }

        function replyToMessage(recipientId, subject) {
            document.getElementById('recipientId').value = recipientId;
            document.getElementById('messageSubject').value = subject;
            document.getElementById('newMessageModal').style.display = 'block';
        }

        function markAsRead(messageId) {
            const formData = new FormData();
            formData.append('action', 'mark_read');
            formData.append('message_id', messageId);
            
            fetch('', { method: 'POST', body: formData })
            .then(() => location.reload())
            .catch(error => {
                showMessage('Failed to mark message as read', 'error');
            });
        }

        function showMessage(message, type) {
            const div = document.createElement('div');
            div.className = `alert alert-${type}`;
            div.innerHTML = message;
            div.style.position = 'fixed';
            div.style.top = '20px';
            div.style.right = '20px';
            div.style.zIndex = '10000';
            div.style.maxWidth = '400px';
            document.body.appendChild(div);
            setTimeout(() => div.remove(), 5000);
        }

        // Form validation before submit
        function validateGigForm() {
            const title = document.querySelector('input[name="gig_title"]').value.trim();
            const category = document.querySelector('select[name="gig_category"]').value;
            const description = document.querySelector('textarea[name="gig_description"]').value.trim();
            const funding = document.querySelector('select[name="funding_needed"]').value;
            
            if (!title || !category || !description || !funding) {
                showMessage('Please fill in all required fields', 'error');
                return false;
            }
            
            if (description.length < 10) {
                showMessage('Description must be at least 10 characters long', 'error');
                return false;
            }
            
            return true;
        }

        // Gig form submission handler
        document.getElementById('gigForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate form
            if (!validateGigForm()) {
                return false;
            }
            
            // Show progress
            const progressDiv = document.getElementById('upload-progress');
            const submitBtn = document.getElementById('submitGigBtn');
            
            progressDiv.style.display = 'block';
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Posting...';
            
            // Submit form
            this.submit();
        });

        // Message form handler
        document.getElementById('messageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('action', 'send_message');
            formData.append('recipient_id', document.getElementById('recipientId').value);
            formData.append('subject', document.getElementById('messageSubject').value);
            formData.append('message', document.getElementById('messageContent').value);
            
            fetch('', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Message sent successfully!', 'success');
                    closeModal('newMessageModal');
                    document.getElementById('messageForm').reset();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showMessage('Failed to send message: ' + (data.error || 'Unknown error'), 'error');
                }
            })
            .catch(error => {
                showMessage('Network error: ' + error.message, 'error');
            });
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize upload count
            updateImageCount();
            
            // Auto-hide alerts
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.style.display = 'none';
                });
            }, 5000);

            // Modal click handlers
            window.addEventListener('click', function(e) {
                if (e.target.classList.contains('modal')) {
                    e.target.style.display = 'none';
                }
            });
            
            // Add drag and drop functionality
            const uploadBoxes = document.querySelectorAll('.image-upload-box');
            uploadBoxes.forEach((box, index) => {
                const realIndex = index + 1;
                const input = document.getElementById(`gig_image_${realIndex}`);
                
                box.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.style.borderColor = '#3b82f6';
                    this.style.background = 'rgba(59, 130, 246, 0.2)';
                });
                
                box.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    this.style.borderColor = 'rgba(59, 130, 246, 0.3)';
                    this.style.background = 'rgba(59, 130, 246, 0.05)';
                });
                
                box.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.style.borderColor = 'rgba(59, 130, 246, 0.3)';
                    this.style.background = 'rgba(59, 130, 246, 0.05)';
                    
                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        const dt = new DataTransfer();
                        dt.items.add(files[0]);
                        input.files = dt.files;
                        handleImageUpload(input, realIndex);
                    }
                });
            });
        });

        // Form validation before submit
        function validateGigForm() {
            const title = document.querySelector('input[name="gig_title"]').value.trim();
            const category = document.querySelector('select[name="gig_category"]').value;
            const description = document.querySelector('textarea[name="gig_description"]').value.trim();
            const funding = document.querySelector('select[name="funding_needed"]').value;
            
            if (!title || !category || !description || !funding) {
                showMessage('Please fill in all required fields', 'error');
                return false;
            }
            
            if (description.length < 50) {
                showMessage('Description must be at least 50 characters long', 'error');
                return false;
            }
            
           if (uploadedImages === 0) {
                showMessage('Please upload at least one image', 'error');
                return true;
            }
            
            return true; 
        }

        // Add validation to form submit
        document.getElementById('gigForm').addEventListener('submit', function(e) {
            if (!validateGigForm()) {
                e.preventDefault();
                return;
            }
        });
    </script>
</body>
</html>