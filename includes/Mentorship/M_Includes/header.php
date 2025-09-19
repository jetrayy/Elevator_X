<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mentorship Platform</title>

<!-- Internal CSS -->
<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #121212;
        color: #eee;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
    }

    header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: transparent;
            backdrop-filter: none;
            color: white;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            transition: all 0.3s ease;
    }

    .logo {
        display: flex;
            align-items: center;
    }

    .logo img {
        height: 60px;
        width: auto;
        display: block;
    }

    nav {
        display: flex;
        gap: 20px;
        justify-content: flex-end;
        align-items: center;
    }

    nav a {
        color: #eee;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 6px;
        transition: background 0.3s, color 0.3s;
    }

    nav a:hover {
        background-color: #4c95afff;
        color: #fff;
    }

    #menu-toggle {
        display: none;
        flex-direction: column;
        justify-content: space-between;
        width: 25px;
        height: 20px;
        cursor: pointer;
    }

    #menu-toggle span {
        display: block;
        height: 3px;
        background-color: #eee;
        border-radius: 2px;
    }

    @media (max-width: 768px) {
        nav {
            position: absolute;
            top: 70px;
            right: 0;
            background-color: #1f1f1f;
            flex-direction: column;
            width: 200px;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }

        nav a {
            width: 100%;
            text-align: center;
            padding: 12px 0;
            border-bottom: 1px solid #2a2a2a;
        }

        nav.active {
            transform: translateX(0);
        }

        #menu-toggle {
            display: flex;
        }
    }

    main.container {
        padding: 30px 0;
    }
</style>
</head>
<body>

<header>
    <div class="container" style="display:flex; justify-content:space-between; align-items:center;">
    
        <a href="../../index.php" class="logo">
            <img src="assets/images/logo.png" alt="Mentorship Platform">

        </a>

        <div id="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <nav id="navbar">
            <a href="M_index.php">Mentorship Home</a>
            <a href="mentors.php">Mentors</a>
            <a href="plans.php">Plans</a>
            <a href="free-sessions.php">Free Sessions</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="feedback.php">Feedback</a>
        </nav>
    </div>
</header>

<main class="container">

</main>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const navbar = document.getElementById('navbar');

    menuToggle.addEventListener('click', () => {
        navbar.classList.toggle('active');
    });
</script>

</body>
</html>
