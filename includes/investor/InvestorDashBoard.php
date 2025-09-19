<?php
session_start();
require_once '../dbconnect.php';

// Check if user is logged in and is an investor
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'investor') {
    header("Location: ../JoinUs.php");
    exit();
}

// Get investor data
$investor = [
    'id' => $_SESSION['user_id'],
    'first_name' => 'Test',
    'last_name' => 'User',
    'email' => $_SESSION['user_email'] ?? 'test@test.com',
    'phone' => '',
    'company_name' => '',
    'investment_focus' => 'technology',
    'investment_range' => '50k-100k',
    'geographic_preference' => 'global',
    'messaging_unlocked' => false,
    'website' => '',
    'linkedin_profile' => ''
];

try {
    if (isset($pdo) && isset($_SESSION['user_email'])) {
        $real_investor = getInvestorByEmail($_SESSION['user_email'], $pdo);
        if ($real_investor) {
            $investor = array_merge($investor, $real_investor);
        }
    }
} catch (Exception $e) {
    error_log("Dashboard error: " . $e->getMessage());
}

$investor_id = $investor['id'];
$success_message = '';
$error_message = '';

// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    try {
        switch ($_POST['action']) {
            case 'send_connection_request':
                $entrepreneur_id = filter_var($_POST['entrepreneur_id'], FILTER_VALIDATE_INT);
                $gig_id = filter_var($_POST['gig_id'], FILTER_VALIDATE_INT);
                $message = trim($_POST['message']);
                
                if (!$entrepreneur_id || !$gig_id || empty($message)) {
                    throw new Exception('Invalid input data');
                }
                
                $stmt = $pdo->prepare("
                    INSERT INTO investor_connections (investor_id, entrepreneur_id, gig_id, request_message) 
                    VALUES (?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE request_message = VALUES(request_message), status = 'pending'
                ");
                $result = $stmt->execute([$investor_id, $entrepreneur_id, $gig_id, $message]);
                
                echo json_encode(['success' => $result]);
                break;
                
            case 'unlock_messaging':
                // Simulate payment processing
                $stmt = $pdo->prepare("
                    INSERT INTO investor_payments (investor_id, payment_type, amount, status) 
                    VALUES (?, 'messaging_access', 50.00, 'completed')
                ");
                $stmt->execute([$investor_id]);
                
                // Update investor messaging status
                $stmt = $pdo->prepare("UPDATE investors SET messaging_unlocked = 1 WHERE id = ?");
                $result = $stmt->execute([$investor_id]);
                
                echo json_encode(['success' => $result]);
                break;

            case 'send_message':
                if (!$investor['messaging_unlocked']) {
                    throw new Exception('Messaging not unlocked');
                }
                
                $recipient_id = filter_var($_POST['recipient_id'], FILTER_VALIDATE_INT);
                $subject = trim($_POST['subject']);
                $message = trim($_POST['message']);
                
                $stmt = $pdo->prepare("
                    INSERT INTO messages (sender_id, sender_type, recipient_id, recipient_type, subject, message)
                    VALUES (?, 'investor', ?, 'entrepreneur', ?, ?)
                ");
                $result = $stmt->execute([$investor_id, $recipient_id, $subject, $message]);
                
                echo json_encode(['success' => $result]);
                break;

            case 'update_personal':
                $stmt = $pdo->prepare("
                    UPDATE investors 
                    SET first_name = ?, last_name = ?, phone = ?, linkedin_profile = ?
                    WHERE id = ?
                ");
                $result = $stmt->execute([
                    $_POST['first_name'], $_POST['last_name'], $_POST['phone'], 
                    $_POST['linkedin_profile'], $investor_id
                ]);
                echo json_encode(['success' => $result]);
                break;
                
            case 'update_investment':
                $stmt = $pdo->prepare("
                    UPDATE investors 
                    SET company_name = ?, investment_focus = ?, investment_range = ?, 
                        geographic_preference = ?, website = ?
                    WHERE id = ?
                ");
                $result = $stmt->execute([
                    $_POST['company_name'], $_POST['investment_focus'], $_POST['investment_range'],
                    $_POST['geographic_preference'], $_POST['website'], $investor_id
                ]);
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

// Get statistics
$total_connections = 0;
$accepted_connections = 0;
$pending_connections = 0;
$unread_messages = 0;

try {
    if (isset($pdo)) {
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM investor_connections WHERE investor_id = ?");
        $stmt->execute([$investor_id]);
        $total_connections = $stmt->fetch()['count'];
        
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM investor_connections WHERE investor_id = ? AND status = 'accepted'");
        $stmt->execute([$investor_id]);
        $accepted_connections = $stmt->fetch()['count'];
        
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM investor_connections WHERE investor_id = ? AND status = 'pending'");
        $stmt->execute([$investor_id]);
        $pending_connections = $stmt->fetch()['count'];
        
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM messages WHERE recipient_id = ? AND recipient_type = 'investor' AND is_read = 0");
        $stmt->execute([$investor_id]);
        $unread_messages = $stmt->fetch()['count'];
    }
} catch (Exception $e) {
    error_log("Stats error: " . $e->getMessage());
}

// Get available gigs
$available_gigs = [];
try {
    if (isset($pdo)) {
        $stmt = $pdo->prepare("
            SELECT g.*, CONCAT(e.first_name, ' ', LEFT(e.last_name, 1), '.') as entrepreneur_name, 
                   e.business_name, GROUP_CONCAT(gi.image_filename ORDER BY gi.image_order LIMIT 1) as first_image,
                   ic.status as connection_status
            FROM gigs g 
            JOIN entrepreneurs e ON g.entrepreneur_id = e.id 
            LEFT JOIN gig_images gi ON g.id = gi.gig_id
            LEFT JOIN investor_connections ic ON g.id = ic.gig_id AND ic.investor_id = ?
            WHERE g.status = 'active' AND g.visibility = 'public'
            GROUP BY g.id
            ORDER BY g.created_at DESC 
            LIMIT 20
        ");
        $stmt->execute([$investor_id]);
        $available_gigs = $stmt->fetchAll();
    }
} catch (Exception $e) {
    error_log("Gigs error: " . $e->getMessage());
}

// Get investor connections
$investor_connections = [];
try {
    if (isset($pdo)) {
        $stmt = $pdo->prepare("
            SELECT ic.*, g.title as gig_title, CONCAT(e.first_name, ' ', e.last_name) as entrepreneur_name,
                   e.business_name
            FROM investor_connections ic
            LEFT JOIN gigs g ON ic.gig_id = g.id
            LEFT JOIN entrepreneurs e ON ic.entrepreneur_id = e.id
            WHERE ic.investor_id = ?
            ORDER BY ic.requested_at DESC
        ");
        $stmt->execute([$investor_id]);
        $investor_connections = $stmt->fetchAll();
    }
} catch (Exception $e) {
    error_log("Connections error: " . $e->getMessage());
}

// Get messages
$conversations = [];
try {
    if (isset($pdo)) {
        $stmt = $pdo->prepare("
            SELECT m.*, e.first_name, e.last_name, e.business_name
            FROM messages m
            LEFT JOIN entrepreneurs e ON m.sender_id = e.id AND m.sender_type = 'entrepreneur'
            WHERE (m.recipient_id = ? AND m.recipient_type = 'investor') 
               OR (m.sender_id = ? AND m.sender_type = 'investor')
            ORDER BY m.sent_at DESC
        ");
        $stmt->execute([$investor_id, $investor_id]);
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
    <title>Investor Dashboard - Elevator X</title>
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
            text-decoration: none;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-success { background: linear-gradient(45deg, #10b981, #34d399); }
        .btn-secondary { background: rgba(107, 114, 128, 0.3); }
        .btn-warning { background: linear-gradient(45deg, #f59e0b, #fbbf24); }

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

        .gigs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .gig-card {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 10px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .gig-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .gig-title { font-size: 18px; font-weight: 600; color: #60a5fa; margin-bottom: 8px; }
        .gig-entrepreneur { color: #cbd5e1; font-size: 14px; margin-bottom: 10px; }

        .gig-category {
            display: inline-block;
            background: rgba(59, 130, 246, 0.3);
            color: #60a5fa;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .gig-preview-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin: 10px 0;
        }

        .gig-funding {
            color: #34d399;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .unlock-notice {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: #fbbf24;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .connection-card {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 15px;
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

        @media (max-width: 768px) {
            .container { grid-template-columns: 1fr; }
            .gigs-grid { grid-template-columns: 1fr; }
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
                    <div class="user-name"><?php echo htmlspecialchars($investor['first_name'] . ' ' . $investor['last_name']); ?></div>
                    <div class="user-role">Investor</div>
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
                        <i class="fas fa-search"></i> Browse Gigs
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="showSection('connections')">
                        <i class="fas fa-handshake"></i> My Connections
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
                        <div class="stat-number"><?php echo $total_connections; ?></div>
                        <div class="stat-label">Total Connections</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $accepted_connections; ?></div>
                        <div class="stat-label">Active Connections</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $pending_connections; ?></div>
                        <div class="stat-label">Pending Requests</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?php echo $unread_messages; ?></div>
                        <div class="stat-label">New Messages</div>
                    </div>
                </div>

                <!-- Messaging Status -->
                <?php if (!$investor['messaging_unlocked']): ?>
                <div class="unlock-notice">
                    <h4><i class="fas fa-lock"></i> Unlock Messaging Access</h4>
                    <p>Connect with entrepreneurs and start negotiations by unlocking messaging for $50.</p>
                    <button class="btn btn-warning" onclick="unlockMessaging()">
                        <i class="fas fa-unlock"></i> Unlock Messaging - $50
                    </button>
                </div>
                <?php endif; ?>

                <!-- Quick Actions -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 20px;">
                    <div class="stat-card" style="cursor: pointer;" onclick="showSection('gigs')">
                        <i class="fas fa-search" style="font-size: 2rem; color: #60a5fa; margin-bottom: 10px;"></i>
                        <h3>Browse Gigs</h3>
                        <p style="color: #cbd5e1; font-size: 14px;">Find investment opportunities</p>
                    </div>
                    
                    <?php if ($investor['messaging_unlocked']): ?>
                    <div class="stat-card" style="cursor: pointer;" onclick="showSection('messages')">
                        <i class="fas fa-envelope" style="font-size: 2rem; color: #60a5fa; margin-bottom: 10px;"></i>
                        <h3>Messages</h3>
                        <p style="color: #cbd5e1; font-size: 14px;">Chat with entrepreneurs</p>
                    </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Browse Gigs Section -->
            <section id="gigs" class="section">
                <h2 class="section-title"><i class="fas fa-search"></i> Browse Gigs</h2>
                
                <!-- Filters -->
                <div style="display: flex; gap: 15px; margin-bottom: 15px; flex-wrap: wrap;">
                    <select id="categoryFilter" class="form-select" style="width: auto;">
                        <option value="">All Categories</option>
                        <option value="technology">Technology</option>
                        <option value="healthcare">Healthcare</option>
                        <option value="fintech">Fintech</option>
                        <option value="e-commerce">E-commerce</option>
                        <option value="education">Education</option>
                        <option value="sustainability">Sustainability</option>
                    </select>
                    <select id="fundingFilter" class="form-select" style="width: auto;">
                        <option value="">All Funding</option>
                        <option value="10k-50k">$10K - $50K</option>
                        <option value="50k-100k">$50K - $100K</option>
                        <option value="100k-250k">$100K - $250K</option>
                        <option value="250k-500k">$250K - $500K</option>
                        <option value="500k+">$500K+</option>
                    </select>
                </div>

                <div class="gigs-grid">
                    <?php if (empty($available_gigs)): ?>
                        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #cbd5e1;">
                            <i class="fas fa-search" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                            <h3>No gigs available</h3>
                            <p>Check back later for new investment opportunities!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($available_gigs as $gig): ?>
                        <div class="gig-card" data-category="<?php echo $gig['category']; ?>" data-funding="<?php echo $gig['funding_needed']; ?>">
                            <div class="gig-title"><?php echo htmlspecialchars($gig['title']); ?></div>
                            <div class="gig-entrepreneur">By: <?php echo htmlspecialchars($gig['entrepreneur_name']); ?></div>
                            <div class="gig-category"><?php echo ucfirst($gig['category']); ?></div>
                            
                            <!-- Preview Image -->
                            <?php if ($gig['first_image']): ?>
                            <img src="../uploads/gig_images/<?php echo htmlspecialchars($gig['first_image']); ?>" 
                                 class="gig-preview-image" onclick="openImageModal('<?php echo htmlspecialchars($gig['first_image']); ?>')">
                            <?php endif; ?>
                            
                            <div style="color: #fff; margin: 10px 0;">
                                <?php echo htmlspecialchars(substr($gig['description'], 0, 100)); ?>...
                            </div>
                            
                            <div class="gig-funding">
                                <i class="fas fa-dollar-sign"></i> <?php echo $gig['funding_needed']; ?>
                            </div>
                            
                            <div style="display: flex; gap: 8px;">
                                <?php if ($gig['connection_status'] === 'accepted'): ?>
                                    <button class="btn" onclick="viewFullGig(<?php echo $gig['id']; ?>)">
                                        <i class="fas fa-eye"></i> View Full Details
                                    </button>
                                    <?php if ($investor['messaging_unlocked']): ?>
                                    <button class="btn btn-success" onclick="sendMessage(<?php echo $gig['entrepreneur_id']; ?>)">
                                        <i class="fas fa-envelope"></i> Message
                                    </button>
                                    <?php endif; ?>
                                <?php elseif ($gig['connection_status'] === 'pending'): ?>
                                    <button class="btn btn-secondary" disabled>
                                        <i class="fas fa-clock"></i> Request Pending
                                    </button>
                                <?php elseif ($gig['connection_status'] === 'rejected'): ?>
                                    <button class="btn btn-secondary" disabled>
                                        <i class="fas fa-times"></i> Request Rejected
                                    </button>
                                <?php else: ?>
                                    <button class="btn" onclick="sendConnectionRequest(<?php echo $gig['entrepreneur_id']; ?>, <?php echo $gig['id']; ?>)">
                                        <i class="fas fa-handshake"></i> Connect
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Connections Section -->
            <section id="connections" class="section">
                <h2 class="section-title"><i class="fas fa-handshake"></i> My Connections</h2>
                
                <?php if (empty($investor_connections)): ?>
                    <div style="text-align: center; padding: 40px; color: #cbd5e1;">
                        <i class="fas fa-handshake" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                        <h3>No connections yet</h3>
                        <p>Start by browsing gigs and sending connection requests!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($investor_connections as $conn): ?>
                        <div class="connection-card">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                                <div>
                                    <h4 style="color: #60a5fa;"><?php echo htmlspecialchars($conn['gig_title'] ?? 'Direct Connection'); ?></h4>
                                    <div style="font-size: 12px; color: #cbd5e1;">
                                        Entrepreneur: <?php echo htmlspecialchars($conn['entrepreneur_name']); ?>
                                        <?php if ($conn['business_name']): ?>
                                            (<?php echo htmlspecialchars($conn['business_name']); ?>)
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <span style="padding: 4px 10px; border-radius: 15px; font-size: 11px; 
                                      background: rgba(<?php echo $conn['status'] === 'accepted' ? '34, 197, 94' : ($conn['status'] === 'pending' ? '245, 158, 11' : '239, 68, 68'); ?>, 0.2);
                                      color: <?php echo $conn['status'] === 'accepted' ? '#86efac' : ($conn['status'] === 'pending' ? '#fbbf24' : '#fca5a5'); ?>;">
                                    <?php echo ucfirst($conn['status']); ?>
                                </span>
                            </div>
                            
                            <div style="font-size: 12px; color: #cbd5e1;">
                                Requested: <?php echo date('M j, Y', strtotime($conn['requested_at'])); ?>
                            </div>
                            
                            <?php if ($conn['status'] === 'accepted' && $investor['messaging_unlocked']): ?>
                            <div style="margin-top: 10px;">
                                <button class="btn" onclick="sendMessage(<?php echo $conn['entrepreneur_id']; ?>)">
                                    <i class="fas fa-comments"></i> Chat
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <!-- Messages Section -->
            <section id="messages" class="section">
                <h2 class="section-title"><i class="fas fa-envelope"></i> Messages</h2>
                
                <?php if (!$investor['messaging_unlocked']): ?>
                    <div class="unlock-notice">
                        <h4><i class="fas fa-lock"></i> Messaging Not Unlocked</h4>
                        <p>Unlock messaging access to communicate with entrepreneurs.</p>
                        <button class="btn btn-warning" onclick="unlockMessaging()">
                            <i class="fas fa-unlock"></i> Unlock for $50
                        </button>
                    </div>
                <?php else: ?>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                        <div></div>
                        <button class="btn" onclick="showNewMessageForm()">
                            <i class="fas fa-plus"></i> New Message
                        </button>
                    </div>

                    <?php if (empty($conversations)): ?>
                        <div style="text-align: center; padding: 40px; color: #cbd5e1;">
                            <i class="fas fa-envelope-open" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                            <h3>No conversations yet</h3>
                            <p>Start conversations by connecting with entrepreneurs from gigs.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($conversations as $msg): ?>
                            <div class="connection-card <?php echo $msg['is_read'] ? '' : 'unread-message'; ?>" style="<?php echo !$msg['is_read'] ? 'border-left: 4px solid #60a5fa;' : ''; ?>">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                    <div>
                                        <h4 style="color: #60a5fa;"><?php echo htmlspecialchars($msg['subject']); ?></h4>
                                        <div style="font-size: 12px; color: #cbd5e1;">
                                            From: <?php echo htmlspecialchars(($msg['first_name'] ?? '') . ' ' . ($msg['last_name'] ?? 'Unknown')); ?>
                                            <?php if ($msg['business_name']): ?>
                                                (<?php echo htmlspecialchars($msg['business_name']); ?>)
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
                                style="color: #60a5fa;" download>
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
                                    
                                    <?php if ($msg['sender_type'] === 'entrepreneur'): ?>
                                    <button class="btn" onclick="replyToMessage(<?php echo $msg['sender_id']; ?>, 'Re: <?php echo htmlspecialchars($msg['subject'], ENT_QUOTES); ?>')">
                                        <i class="fas fa-reply"></i> Reply
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </section>

            <!-- Profile Section -->
            <section id="profile" class="section">
                <h2 class="section-title"><i class="fas fa-user"></i> Profile Settings</h2>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
                    <!-- Personal Information -->
                    <div>
                        <h3 style="margin-bottom: 15px;">Personal Information</h3>
                        <form id="personalForm">
                            <div class="form-group">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-input" value="<?php echo htmlspecialchars($investor['first_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-input" value="<?php echo htmlspecialchars($investor['last_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-input" value="<?php echo htmlspecialchars($investor['email']); ?>" readonly style="opacity: 0.6;">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Phone</label>
                                <input type="tel" name="phone" class="form-input" value="<?php echo htmlspecialchars($investor['phone']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">LinkedIn Profile</label>
                                <input type="url" name="linkedin_profile" class="form-input" value="<?php echo htmlspecialchars($investor['linkedin_profile']); ?>">
                            </div>
                            <button type="submit" class="btn">Update Personal Info</button>
                        </form>
                    </div>

                    <!-- Investment Information -->
                    <div>
                        <h3 style="margin-bottom: 15px;">Investment Information</h3>
                        <form id="investmentForm">
                            <div class="form-group">
                                <label class="form-label">Company Name</label>
                                <input type="text" name="company_name" class="form-input" value="<?php echo htmlspecialchars($investor['company_name']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Investment Focus</label>
                                <input type="text" name="investment_focus" class="form-input" value="<?php echo htmlspecialchars($investor['investment_focus']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Investment Range</label>
                                <select name="investment_range" class="form-select">
                                    <option value="10k-50k" <?php echo $investor['investment_range'] == '10k-50k' ? 'selected' : ''; ?>>$10K - $50K</option>
                                    <option value="50k-100k" <?php echo $investor['investment_range'] == '50k-100k' ? 'selected' : ''; ?>>$50K - $100K</option>
                                    <option value="100k-250k" <?php echo $investor['investment_range'] == '100k-250k' ? 'selected' : ''; ?>>$100K - $250K</option>
                                    <option value="250k-500k" <?php echo $investor['investment_range'] == '250k-500k' ? 'selected' : ''; ?>>$250K - $500K</option>
                                    <option value="500k+" <?php echo $investor['investment_range'] == '500k+' ? 'selected' : ''; ?>>$500K+</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Geographic Preference</label>
                                <input type="text" name="geographic_preference" class="form-input" value="<?php echo htmlspecialchars($investor['geographic_preference']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Website</label>
                                <input type="url" name="website" class="form-input" value="<?php echo htmlspecialchars($investor['website']); ?>">
                            </div>
                            <button type="submit" class="btn">Update Investment Info</button>
                        </form>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- Connection Request Modal -->
    <div id="connectionModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('connectionModal')">&times;</span>
            <h3><i class="fas fa-handshake"></i> Send Connection Request</h3>
            <form id="connectionForm">
                <input type="hidden" id="selectedEntrepreneurId">
                <input type="hidden" id="selectedGigId">
                <div class="form-group">
                    <label class="form-label">Message to Entrepreneur</label>
                    <textarea id="connectionMessage" class="form-textarea" placeholder="Introduce yourself and explain your interest in this project..." required></textarea>
                </div>
                <button type="submit" class="btn">Send Request</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal('connectionModal')">Cancel</button>
            </form>
        </div>
    </div>

    <!-- Full Gig Details Modal -->
    <div id="fullGigModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeModal('fullGigModal')">&times;</span>
            <div id="fullGigContent"></div>
        </div>
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
            <form id="messageForm">
                <div class="form-group">
                    <label class="form-label">To (Entrepreneur ID)</label>
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
                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn">Send Message</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal('newMessageModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
            document.getElementById(sectionId).classList.add('active');
            if (event.target) event.target.closest('.nav-link').classList.add('active');
        }

        function sendConnectionRequest(entrepreneurId, gigId) {
            document.getElementById('selectedEntrepreneurId').value = entrepreneurId;
            document.getElementById('selectedGigId').value = gigId;
            document.getElementById('connectionModal').style.display = 'block';
        }

        function unlockMessaging() {
            if (confirm('Unlock messaging access for $50? This will allow you to communicate with entrepreneurs.')) {
                showLoading('Processing payment...');
                
                const formData = new FormData();
                formData.append('action', 'unlock_messaging');
                
                fetch('', { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    hideLoading();
                    if (data.success) {
                        showMessage('Messaging unlocked successfully!', 'success');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showMessage('Failed to unlock messaging.', 'error');
                    }
                });
            }
        }

        function viewFullGig(gigId) {
            // This would show full gig details for accepted connections
            document.getElementById('fullGigContent').innerHTML = `
                <h3><i class="fas fa-lightbulb"></i> Full Gig Details</h3>
                <p style="margin: 20px 0; color: #cbd5e1;">
                    Complete gig information including all images, detailed business plan, 
                    financial projections, and contact information would be displayed here.
                </p>
                <p style="color: #fbbf24;">
                    <i class="fas fa-info-circle"></i> 
                    This feature shows full details only after entrepreneur accepts your connection request.
                </p>
            `;
            document.getElementById('fullGigModal').style.display = 'block';
        }

        function sendMessage(recipientId) {
            document.getElementById('recipientId').value = recipientId;
            document.getElementById('newMessageModal').style.display = 'block';
        }

        function replyToMessage(recipientId, subject) {
            document.getElementById('recipientId').value = recipientId;
            document.getElementById('messageSubject').value = subject;
            document.getElementById('newMessageModal').style.display = 'block';
        }

        function openImageModal(imageName) {
            document.getElementById('modalImage').src = '../uploads/gig_images/' + imageName;
            document.getElementById('imageModal').style.display = 'block';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            if (modalId === 'connectionModal') {
                document.getElementById('connectionForm').reset();
            }
        }

        function showNewMessageForm() {
            document.getElementById('newMessageModal').style.display = 'block';
        }

        function markAsRead(messageId) {
            const formData = new FormData();
            formData.append('action', 'mark_read');
            formData.append('message_id', messageId);
            
            fetch('', { method: 'POST', body: formData })
            .then(() => location.reload());
        }

        function showMessage(message, type) {
            const div = document.createElement('div');
            div.className = `alert alert-${type}`;
            div.innerHTML = message;
            div.style.position = 'fixed';
            div.style.top = '20px';
            div.style.right = '20px';
            div.style.zIndex = '10000';
            document.body.appendChild(div);
            setTimeout(() => div.remove(), 3000);
        }

        function showLoading(message) {
            const div = document.createElement('div');
            div.id = 'loading';
            div.style.cssText = `
                position: fixed; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(0,0,0,0.8); display: flex; align-items: center;
                justify-content: center; z-index: 10001; color: white; font-size: 1.2rem;
            `;
            div.innerHTML = `<div style="text-align: center;"><i class="fas fa-spinner fa-spin"></i><br>${message}</div>`;
            document.body.appendChild(div);
        }

        function hideLoading() {
            const loading = document.getElementById('loading');
            if (loading) loading.remove();
        }

        // Form handlers
        document.getElementById('connectionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('action', 'send_connection_request');
            formData.append('entrepreneur_id', document.getElementById('selectedEntrepreneurId').value);
            formData.append('gig_id', document.getElementById('selectedGigId').value);
            formData.append('message', document.getElementById('connectionMessage').value);
            
            showLoading('Sending request...');
            
            fetch('', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    showMessage('Connection request sent!', 'success');
                    closeModal('connectionModal');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showMessage('Failed to send request.', 'error');
                }
            });
        });

        document.getElementById('personalForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'update_personal');
            
            fetch('', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Profile updated!', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showMessage('Update failed.', 'error');
                }
            });
        });

        document.getElementById('investmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('action', 'update_investment');
            
            fetch('', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Investment info updated!', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showMessage('Update failed.', 'error');
                }
            });
        });

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
                    showMessage('Message sent!', 'success');
                    closeModal('newMessageModal');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showMessage('Failed to send message.', 'error');
                }
            });
        });

        // Filter functionality
        function filterGigs() {
            const category = document.getElementById('categoryFilter').value;
            const funding = document.getElementById('fundingFilter').value;
            
            document.querySelectorAll('.gig-card[data-category]').forEach(card => {
                const cardCategory = card.dataset.category;
                const cardFunding = card.dataset.funding;
                
                const matchesCategory = !category || cardCategory === category;
                const matchesFunding = !funding || cardFunding === funding;
                
                card.style.display = matchesCategory && matchesFunding ? 'block' : 'none';
            });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.style.display = 'none';
                });
            }, 5000);

            document.getElementById('categoryFilter').addEventListener('change', filterGigs);
            document.getElementById('fundingFilter').addEventListener('change', filterGigs);

            window.addEventListener('click', function(e) {
                if (e.target.classList.contains('modal')) {
                    e.target.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>