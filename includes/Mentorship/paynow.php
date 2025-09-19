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
    margin-bottom: 20px;
    font-size: 1.8rem;
    color: #fff;
}

.payment-details p {
    margin: 10px 0;
    font-size: 1.1rem;
}

.payment-methods {
    margin: 20px 0;
    text-align: left;
}

.payment-methods label {
    display: block;
    margin-bottom: 8px;
    cursor: pointer;
}

.payment-methods input[type="text"],
.payment-methods input[type="number"],
.payment-methods input[type="month"],
.payment-methods input[type="password"],
.payment-methods input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 12px;
    border-radius: 8px;
    border: none;
    box-sizing: border-box;
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
    transition: all 0.3s ease;
}

.btn:hover {
    background: linear-gradient(135deg, #45a049, #4CAF50);
    transform: translateY(-3px) scale(1.05);
}

.message {
    margin-top: 25px;
    font-size: 1.1rem;
    font-weight: bold;
    color: #4CAF50;
}
</style>

<?php
$name  = htmlspecialchars($_POST['name'] ?? $_GET['name'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? $_GET['email'] ?? '');
$plan  = htmlspecialchars($_POST['plan'] ?? $_GET['plan'] ?? '');

$amounts = [
    "Basic"    => 50,
    "Standard" => 100,
    "Premium"  => 150,
    "Ultimate" => 200
];
$amount = $amounts[$plan] ?? null;

// Check if form submitted
$isSubmitted = $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payment_method']);
?>

<div class="payment-box">
    <h2>Complete Your Payment</h2>

    <?php if ($amount): ?>
        <?php if ($isSubmitted): ?>
            <p class="message">✅ Top-up is under review. You will be notified once it is processed.</p>
            <script>
                // Redirect to index page after 5 seconds
                setTimeout(() => {
                    window.location.href = "M_index.php";
                }, 5000);
            </script>
        <?php else: ?>
            <form action="" method="POST">
                <input type="hidden" name="name" value="<?= $name; ?>">
                <input type="hidden" name="email" value="<?= $email; ?>">
                <input type="hidden" name="plan" value="<?= $plan; ?>">
                <input type="hidden" name="amount" value="<?= $amount; ?>">

                <div class="payment-methods">
                    <p><strong>Select Payment Method:</strong></p>
                    <label>
                        <input type="radio" name="payment_method" value="Credit/Debit Card" required> Credit/Debit Card
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="PayPal"> PayPal
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="Bank Transfer"> Bank Transfer
                    </label>

                    <!-- Credit/Debit Card Details -->
                    <div id="card-details" style="display:none;">
                        <input type="text" name="card_name" placeholder="Cardholder Name">
                        <input type="text" name="card_number" placeholder="Card Number">
                        <input type="month" name="expiry_date" placeholder="Expiry Date">
                        <input type="password" name="cvv" placeholder="CVV">
                    </div>

                    <!-- PayPal Details -->
                    <div id="paypal-details" style="display:none;">
                        <input type="email" name="paypal_email" placeholder="PayPal Email">
                    </div>

                    <!-- Bank Transfer Details -->
                    <div id="bank-details" style="display:none;">
                        <input type="text" name="bank_name" placeholder="Bank Name">
                        <input type="text" name="account_number" placeholder="Account Number">
                        <input type="text" name="account_holder" placeholder="Account Holder Name">
                    </div>
                </div>

                <button type="submit" class="btn">Pay Now</button>
            </form>

            <script>
                const cardRadio = document.querySelector('input[value="Credit/Debit Card"]');
                const paypalRadio = document.querySelector('input[value="PayPal"]');
                const bankRadio = document.querySelector('input[value="Bank Transfer"]');

                const cardDetails = document.getElementById('card-details');
                const paypalDetails = document.getElementById('paypal-details');
                const bankDetails = document.getElementById('bank-details');

                const radios = document.querySelectorAll('input[name="payment_method"]');

                radios.forEach(radio => {
                    radio.addEventListener('change', function() {
                        cardDetails.style.display = cardRadio.checked ? 'block' : 'none';
                        paypalDetails.style.display = paypalRadio.checked ? 'block' : 'none';
                        bankDetails.style.display = bankRadio.checked ? 'block' : 'none';
                    });
                });
            </script>
        <?php endif; ?>
    <?php else: ?>
        <p class="error">⚠ Invalid plan selected. Please go back and try again.</p>
    <?php endif; ?>
</div>

<?php include 'M_includes/footer.php'; ?>
