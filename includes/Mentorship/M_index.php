<?php include 'M_includes/data.php'; ?>
<?php include 'M_includes/header.php'; ?>

<!-- Internal CSS -->
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: url('assets/images/bg.jpg') no-repeat center center fixed;
        background-size: cover;
        color: #eee;
        line-height: 1.6;
        margin: 0;
        padding: 0;
    }

    .hero {
        text-align: center;
        padding: 80px 20px;
        background: rgba(31, 31, 31, 0.85);
        border-radius: 12px;
        margin: 20px auto;
        max-width: 900px;
    }

    .hero h2 {
        font-size: 2.5rem;
        margin-bottom: 15px;
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 25px;
    }

    .btn {
        display: inline-block;
        padding: 12px 25px;
        background-color: #4c9dafff;
        color: #fff;
        text-decoration: none;
        border-radius: 8px;
        transition: background 0.3s;
    }

    .btn:hover {
        background-color: #3979a0ff;
    }

    .stats {
        margin: 50px 0;
    }

    .stats .container {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .stat-card {
        background: rgba(31, 31, 31, 0.9);
        padding: 20px;
        border-radius: 12px;
        width: 200px;
        text-align: center;
    }

    .stat-card h3 {
        font-size: 2rem;
        margin-bottom: 10px;
        color: #4CAF50;
    }

    .mentors {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 20px;
    }

    .mentor {
        background: rgba(31, 31, 31, 0.9);
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        width: 250px;
        transition: transform 0.3s;
    }

    .mentor:hover {
        transform: translateY(-5px);
    }

    .mentor img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
    }

    .mentor h4 {
        margin-bottom: 5px;
    }

    .mentor p {
        margin-bottom: 15px;
        color: #ccc;
    }

    h3 {
        text-align: center;
        margin-top: 40px;
        margin-bottom: 20px;
    }
</style>

<!-- Hero Section -->
<section class="hero">
    <h2>Welcome to Mentorship Platform</h2>
    <p>Connect with top mentors and achieve your goals with personalized guidance.</p>
    <a href="free-sessions.php" class="btn">Book a Free Session</a>
</section>

<!-- Quick Stats Section -->
<section class="stats">
    <div class="container">
        <div class="stat-card">
            <h3>50+</h3>
            <p>Mentors</p>
        </div>
        <div class="stat-card">
            <h3>200+</h3>
            <p>Sessions</p>
        </div>
        <div class="stat-card">
            <h3>150+</h3>
            <p>Happy Students</p>
        </div>
    </div>
</section>

<!-- Featured Mentors Section -->
<h3>Featured Mentors</h3>
<div class="mentors">
    <div class="mentor">
        <img src="assets/images/mentor1.jpeg" alt="Mentor 1">
        <h4>John Doe</h4>
        <p>Web Development</p>
        <a href="free-sessions.php?mentor=John+Doe" class="btn">Book Session</a>
    </div>
    <div class="mentor">
        <img src="assets/images/mentor4.jpeg" alt="Mentor 2">
        <h4>Jane Smith</h4>
        <p>Data Science</p>
        <a href="free-sessions.php?mentor=Jane+Smith" class="btn">Book Session</a>
    </div>
    <div class="mentor">
        <img src="assets/images/mentor7.jpeg" alt="Mentor 3">
        <h4>Michael Lee</h4>
        <p>Mobile Development</p>
        <a href="free-sessions.php?mentor=Michael+Lee" class="btn">Book Session</a>
    </div>
</div>

<?php include 'M_includes/footer.php'; ?>
