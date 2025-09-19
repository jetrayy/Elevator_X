<?php include 'M_includes/data.php'; ?>
<?php include 'M_includes/header.php'; ?>

<!-- Internal CSS -->
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #121212;
        color: #eee;
        margin: 0;
        padding: 0;
        line-height: 1.6;
    }

    h2 {
        text-align: center;
        margin: 30px 0 20px 0;
    }

    form {
        max-width: 500px;
        margin: 0 auto 50px auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
        background-color: #1f1f1f;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.5);
    }

    input[type="text"],
    input[type="email"],
    select,
    textarea {
        padding: 12px 15px;
        border-radius: 8px;
        border: none;
        outline: none;
        font-size: 1rem;
        background-color: #2a2a2a;
        color: #eee;
    }

    textarea {
        resize: none;
        min-height: 100px;
    }

    label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .btn {
        padding: 12px 20px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1rem;
        transition: background 0.3s;
    }

    .btn:hover {
        background-color: #45a049;
    }

    .success {
        background-color: #4CAF50;
        color: #fff;
        padding: 10px 15px;
        border-radius: 8px;
        max-width: 500px;
        margin: 15px auto;
        text-align: center;
    }

    @media (max-width: 500px) {
        form {
            width: 90%;
            padding: 20px;
        }
    }
</style>

<h2>Feedback</h2>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $rating = $_POST['rating'];
    $message = htmlspecialchars($_POST['message']);
    $date = date('Y-m-d H:i:s');

    // Escape commas in message to avoid breaking CSV format
    $safeMessage = str_replace(",", ";", $message);

    $file = 'data/feedback.csv';
    $newFile = !file_exists($file);

    $line = "$name,$email,$rating,$safeMessage,$date\n";

    // Add headers if file doesn't exist
    if ($newFile) {
        file_put_contents($file, "Name,Email,Rating,Message,Date\n", FILE_APPEND);
    }
    file_put_contents($file, $line, FILE_APPEND);

    echo "<p class='success'>Thank you, <strong>$name</strong>! You rated us <strong>$rating ★</strong>.</p>";
}
?>

<form method="POST">
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="email" name="email" placeholder="Email" required>
    
    <label for="rating">Rating:</label>
    <select name="rating" id="rating" required>
        <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
        <option value="4">⭐⭐⭐⭐ Good</option>
        <option value="3">⭐⭐⭐ Average</option>
        <option value="2">⭐⭐ Poor</option>
        <option value="1">⭐ Very Bad</option>
    </select>
    
    <textarea name="message" placeholder="Your Message" required></textarea>
    
    <button type="submit" class="btn">Submit Feedback</button>
</form>

<?php include 'M_includes/footer.php'; ?>
