<?php include 'M_includes/header.php'; ?>

<style>
.payment-box {
    max-width: 500px;
    margin: 60px auto;
    padding: 35px 30px;
    background: #1f1f1f;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.7);
    text-align: center;
    color: #eee;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.payment-box h2 {
    margin-bottom: 30px;
    font-size: 1.8rem;
    color: #fff;
    letter-spacing: 0.5px;
}

.payment-details p {
    margin: 12px 0;
    font-size: 1.1rem;
}

.btn {
    padding: 14px 35px;
    background: linear-gradient(135deg, #4CAF50, #45a049);
    color: #fff;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 6px 15px rgba(0,0,0,0.4);
}

.btn:hover {
    background: linear-gradient(135deg, #45a049, #4CAF50);
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 10px 20px rgba(0,0,0,0.5);
}

.btn:active {
    transform: translateY(0) scale(0.98);
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}

.error {
    color: #ff4d4d;
    margin-top: 25px;
    font-weight: bold;
    font-size: 1.1rem;
}
</style>

<?php
$name  = htmlspecialchars($_GET['name'] ?? '');
$email = htmlspecialchars($_GET['email'] ?? '');
$plan  = htmlspecialchars($_GET['plan'] ?? '');

$amounts = [
    "Basic"    => 50,
    "Standard" => 100,
    "Premium"  => 150,
    "Ultimate" => 200
];
$amount = $amounts[$plan] ?? null;
?>

<div class="payment-box">
    <h2>Complete Your Payment</h2>

    <div class="payment-details">
        <p><strong>Name:</strong> <?= $name ?: "N/A"; ?></p>
        <p><strong>Email:</strong> <?= $email ?: "N/A"; ?></p>
        <p><strong>Plan:</strong> <?= $plan ?: "N/A"; ?></p>
        <p><strong>Amount:</strong> <?= $amount ? "$" . $amount : "N/A"; ?></p>
    </div>

    <?php if ($amount): ?>
        <form action="paynow.php" method="POST">
            <input type="hidden" name="name" value="<?= $name; ?>">
            <input type="hidden" name="email" value="<?= $email; ?>">
            <input type="hidden" name="plan" value="<?= $plan; ?>">
            <input type="hidden" name="amount" value="<?= $amount; ?>">
            <button type="submit" class="btn">Pay Now</button>
        </form>
    <?php else: ?>
        <p class="error">⚠ Invalid plan selected. Please go back and try again.</p>
    <?php endif; ?>
</div>

<?php include 'M_includes/footer.php'; ?>
