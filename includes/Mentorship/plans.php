<?php include 'M_includes/header.php'; ?>

<!-- Internal CSS -->
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: url('assets/images/bg.jpg') no-repeat center center fixed;
        background-size: cover;
        color: #eee;
        margin: 0;
        padding: 0;
        line-height: 1.6;
        position: relative;
    }

    /* optional dark overlay for readability */
    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(18, 18, 18, 0.85); /* semi-transparent dark layer */
        z-index: -1;
    }

    h2 {
        text-align: center;
        margin: 40px 0 30px 0;
    }

    .plans {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-bottom: 50px;
    }

    .plan {
        background-color: rgba(31, 31, 31, 0.9);
        padding: 25px 20px;
        border-radius: 12px;
        width: 250px;
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .plan:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 15px rgba(76, 175, 80, 0.5);
    }

    .plan h3 {
        margin-bottom: 10px;
        font-size: 1.5rem;
    }

    .plan .price {
        font-size: 1.8rem;
        color: #4CAF50;
        margin: 10px 0;
    }

    .plan ul {
        text-align: left;
        margin: 15px 0;
        padding-left: 20px;
        list-style: disc;
    }

    .plan li {
        margin-bottom: 8px;
        color: #ccc;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        transition: background 0.3s;
    }

    .btn:hover {
        background-color: #45a049;
    }

    @media (max-width: 768px) {
        .plan {
            width: 45%;
        }
    }

    @media (max-width: 500px) {
        .plan {
            width: 90%;
        }
    }
</style>

<h2>Our Plans</h2>

<div class="plans">
    <!-- Basic Plan -->
    <div class="plan">
        <h3>Basic</h3>
        <p><strong>2 sessions/month</strong></p>
        <p class="price">$50</p>
        <ul>
            <li>Access to 1 mentor</li>
            <li>Email support</li>
            <li>Flexible scheduling</li>
            <li>Access to learning resources</li>
        </ul>
        <a href="free-sessions.php?plan=Basic" class="btn">Book Now</a>
    </div>

    <!-- Standard Plan -->
    <div class="plan">
        <h3>Standard</h3>
        <p><strong>4 sessions/month</strong></p>
        <p class="price">$90</p>
        <ul>
            <li>Access to 2 mentors</li>
            <li>Email & Chat support</li>
            <li>Flexible scheduling</li>
            <li>Recorded sessions available</li>
        </ul>
        <a href="free-sessions.php?plan=Standard" class="btn">Book Now</a>
    </div>

    <!-- Premium Plan -->
    <div class="plan">
        <h3>Premium</h3>
        <p><strong>8 sessions/month</strong></p>
        <p class="price">$150</p>
        <ul>
            <li>Access to all mentors</li>
            <li>Priority support (Email, Chat, Call)</li>
            <li>Flexible scheduling & session recordings</li>
            <li>1-on-1 mentorship guidance</li>
        </ul>
        <a href="free-sessions.php?plan=Premium" class="btn">Book Now</a>
    </div>

    <!-- Ultimate Plan -->
    <div class="plan">
        <h3>Ultimate</h3>
        <p><strong>Unlimited sessions</strong></p>
        <p class="price">$250</p>
        <ul>
            <li>Unlimited access to all mentors</li>
            <li>24/7 priority support</li>
            <li>Personalized mentorship & coaching</li>
            <li>Exclusive workshops & webinars</li>
        </ul>
        <a href="free-sessions.php?plan=Ultimate" class="btn">Book Now</a>
    </div>
</div>

<?php include 'M_includes/footer.php'; ?>
