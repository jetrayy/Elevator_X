<?php
include 'M_includes/data.php';
include 'M_includes/header.php';

$prefill_plan = $_GET['plan'] ?? '';
$prefill_mentor = $_GET['mentor'] ?? '';

// List of mentors (could also come from data.php)
$mentors = [
    "John Doe", "Alice Johnson", "David Kim",
    "Jane Smith", "Brian Wong", "Sara Patel",
    "Michael Lee", "Emma Davis", "Chris Brown"
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $plan = trim($_POST['plan']);
    $mentor = trim($_POST['mentor']);
    $datebook = $_POST['date'];
    $date = date('Y-m-d H:i:s');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strtotime($datebook) < strtotime(date('Y-m-d'))) {
        $error = "Date cannot be in the past.";
    } else {
        $safe_name = htmlspecialchars($name, ENT_QUOTES);
        $safe_email = htmlspecialchars($email, ENT_QUOTES);
        $safe_plan = htmlspecialchars($plan, ENT_QUOTES);
        $safe_mentor = htmlspecialchars($mentor, ENT_QUOTES);

        // Save booking
        $line = "$safe_name,$safe_email,$safe_plan,$safe_mentor,$datebook,$date\n";
        file_put_contents('data/bookings.csv', $line, FILE_APPEND);

        // Redirect to payment page
        header("Location: payment.php?plan=$safe_plan&name=" . urlencode($safe_name) . "&email=" . urlencode($safe_email));
        exit;
    }
}
?>

<style>
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
       background-color: #121212;
       color: #eee; margin:0; 
       padding:0; line-height:1.6;
     }

h2 { text-align:center; 
     margin:30px 0 20px; 
   }

form { max-width:420px; margin:0 auto 50px; 
       display:flex; flex-direction:column; 
       gap:15px; background-color:#1f1f1f; 
       padding:25px; border-radius:12px; 
       box-shadow:0 0 15px rgba(0,0,0,0.5); 
       transition:0.3s; 
     }

form:hover { 
             box-shadow:0 0 20px rgba(76,175,80,0.4); 
           }

input[type="text"], input[type="email"], input[type="date"], select { 
    padding:12px 15px; border-radius:8px; 
    border:1px solid #333; outline:none; 
    font-size:1rem; background-color:#2a2a2a; 
    color:#eee; transition:border 0.3s; 
}

input:focus, select:focus { 
                            border-color:#4CAF50; 
                          }

.btn { 
    padding:12px 20px; 
    background-color:#4CAF50; 
    color:#fff; border:none; 
    border-radius:8px; cursor:pointer; 
    font-size:1rem; 
    transition:background 0.3s, transform 0.2s; 
}

.btn:hover { 
    background-color:#45a049;
    transform:scale(1.03); 
}

.error { 
    background-color:#e53935; 
    color:#fff; 
    padding:12px 15px; 
    border-radius:8px; 
    max-width:420px; 
    margin:15px auto; 
    text-align:center; 
    font-weight:bold; 
    }
</style>

<h2>Book a Session</h2>

<?php if (!empty($error)): ?>
    <p class="error"><?= $error; ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="email" name="email" placeholder="Email" required>

    <select name="plan" required>
        <option value="">Select Plan</option>
        <option value="Basic" <?= $prefill_plan=='Basic'?'selected':''; ?>>Basic</option>
        <option value="Standard" <?= $prefill_plan=='Standard'?'selected':''; ?>>Standard</option>
        <option value="Premium" <?= $prefill_plan=='Premium'?'selected':''; ?>>Premium</option>
        <option value="Ultimate" <?= $prefill_plan=='Ultimate'?'selected':''; ?>>Ultimate</option>
    </select>

    <!-- Mentor Dropdown -->
    <select name="mentor" required>
        <option value="">Select Mentor</option>
        <?php foreach ($mentors as $m): ?>
            <option value="<?= htmlspecialchars($m); ?>" <?= $prefill_mentor==$m?'selected':''; ?>><?= $m; ?></option>
        <?php endforeach; ?>
    </select>

    <input type="date" name="date" min="<?= date('Y-m-d'); ?>" required>
    <button type="submit" class="btn">Book & Pay</button>
</form>

<?php include 'M_includes/footer.php'; ?>
