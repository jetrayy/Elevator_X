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
        margin: 40px 0 20px 0;
        font-size: 1.8rem;
        color: #4CAF50;
    }

    .table-container {
        overflow-x: auto;
        margin: 0 auto 50px auto;
        max-width: 95%;
        background: #1a1a1a;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.6);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 600px;
        border-radius: 12px;
        overflow: hidden;
    }

    th, td {
        padding: 14px 16px;
        border-bottom: 1px solid #2a2a2a;
        text-align: left;
    }

    th {
        background-color: #1f1f1f;
        color: #4CAF50;
        font-weight: bold;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    tr:nth-child(even) {
        background-color: #1c1c1c;
    }

    tr:hover {
        background-color: #2a2a2a;
        transition: background 0.3s ease-in-out;
    }

    td {
        font-size: 0.95rem;
        color: #ddd;
    }

    /* Responsive */
    @media (max-width: 768px) {
        th, td {
            padding: 10px;
            font-size: 0.9rem;
        }
    }
</style>

<!-- Bookings Table -->
<h2>📌 Bookings</h2>
<div class="table-container">
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Plan</th>
            <th>Mentor</th>
            <th>Booked Date</th>
            <th>Timestamp</th>
        </tr>
        <?php
        if(file_exists('data/bookings.csv')) {
            $bookings = file('data/bookings.csv');
            foreach ($bookings as $row) {
                $data = str_getcsv($row);
                $name = $data[0] ?? '';
                $email = $data[1] ?? '';
                $plan = $data[2] ?? '';
                $mentor = $data[3] ?? '';
                $datebook = $data[4] ?? '';
                $timestamp = $data[5] ?? '';
                echo "<tr>
                        <td>{$name}</td>
                        <td>{$email}</td>
                        <td>{$plan}</td>
                        <td>{$mentor}</td>
                        <td>{$datebook}</td>
                        <td>{$timestamp}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align:center;'>No bookings found.</td></tr>";
        }
        ?>
    </table>
</div>

<!-- Feedback Table -->
<h2>💬 Feedback</h2>
<div class="table-container">
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Rating</th>
            <th>Message</th>
            <th>Timestamp</th>
        </tr>
        <?php
        if(file_exists('data/feedback.csv')) {
            $feedbacks = file('data/feedback.csv');
            foreach ($feedbacks as $row) {
                $data = str_getcsv($row);
                $name = $data[0] ?? '';
                $email = $data[1] ?? '';
                $rating = $data[2] ?? '';
                $message = $data[3] ?? '';
                $timestamp = $data[4] ?? '';
                echo "<tr>
                        <td>{$name}</td>
                        <td>{$email}</td>
                        <td>{$rating}</td>
                        <td>{$message}</td>
                        <td>{$timestamp}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5' style='text-align:center;'>No feedback found.</td></tr>";
        }
        ?>
    </table>
</div>

<?php include 'M_includes/footer.php'; ?>
