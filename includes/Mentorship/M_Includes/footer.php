<style>
    footer {
        background-color: #1f1f1f;
        color: #ccc;
        padding: 40px 0 20px 0;
        font-size: 0.95rem;
    }

    footer a {
        color: #eee;
        text-decoration: none;
        display: block;
        margin-bottom: 8px;
        transition: color 0.3s;
    }

    footer a:hover {
        color: #4CAF50;
    }

    .footer-columns {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto 30px auto;
    }

    .footer-column {
        flex: 1 1 200px;
    }

    .footer-column h4 {
        color: #4CAF50;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }

    .footer-column p {
        line-height: 1.5;
        color: #ccc;
    }

    .social-links a {
        display: inline-block;
        margin-right: 10px;
        font-size: 1.2rem;
        transition: color 0.3s, transform 0.3s;
    }

    .social-links a:hover {
        color: #4CAF50;
        transform: translateY(-2px);
    }

    .footer-bottom {
        text-align: center;
        border-top: 1px solid #2a2a2a;
        padding-top: 15px;
        font-size: 0.85rem;
        color: #888;
    }

    @media (max-width: 768px) {
        .footer-columns {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .footer-column {
            margin-bottom: 20px;
        }

        .social-links a {
            margin-right: 15px;
            margin-bottom: 10px;
        }
    }
</style>

<footer>
    <div class="container">
        <!-- Footer Columns -->
        <div class="footer-columns">
            <div class="footer-column">
                <h4>About</h4>
                <p>Mentorship Platform connects learners with top mentors to help you achieve your goals.</p>
            </div>
            <div class="footer-column">
                <h4>Quick Links</h4>
                <a href="index.php">Home</a>
                <a href="mentors.php">Mentors</a>
                <a href="plans.php">Plans</a>
                <a href="free-sessions.php">Free Sessions</a>
            </div>
            <div class="footer-column">
                <h4>Support</h4>
                <a href="feedback.php">Feedback</a>
                <a href="contact.php">Contact Us</a>
                <a href="faq.php">FAQ</a>
            </div>
            <div class="footer-column">
                <h4>Follow Us</h4>
                <div class="social-links">
                    <a href="#" target="_blank">🌐 Website</a>
                    <a href="#" target="_blank">🐦 Twitter</a>
                    <a href="#" target="_blank">📘 Facebook</a>
                    <a href="#" target="_blank">📸 Instagram</a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; <?= date('Y'); ?> Mentorship Platform. All rights reserved.</p>
        </div>
    </div>
</footer>
<script src="assets/script.js"></script>
