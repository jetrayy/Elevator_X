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

    h2 {
        text-align: center;
        margin: 40px 0 20px 0;
    }

    .filters {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }

    .filters input[type="text"], 
    .filters select {
        padding: 10px 15px;
        border-radius: 8px;
        border: none;
        outline: none;
        font-size: 1rem;
        background-color: rgba(31, 31, 31, 0.9);
        color: #eee;
    }

    .filters input[type="text"]::placeholder {
        color: #ccc;
    }

    .mentors {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        margin-bottom: 50px;
    }

    .mentor {
        background-color: rgba(31, 31, 31, 0.9); /* transparent background for readability */
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        width: 250px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .mentor:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 15px rgba(76, 175, 80, 0.5);
    }

    .mentor img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
    }

    .mentor h3 {
        margin-bottom: 5px;
    }

    .mentor p {
        margin-bottom: 15px;
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
        .mentor {
            width: 45%;
        }
    }

    @media (max-width: 500px) {
        .mentor {
            width: 90%;
        }

        .filters {
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<h2>Our Mentors</h2>

<!-- Filters -->
<div class="filters">
    <input type="text" id="search-mentor" placeholder="Search mentors...">
    <select id="category-filter">
        <option value="">All Categories</option>
        <option value="web">Web Development</option>
        <option value="data">Data Science</option>
        <option value="mobile">Mobile Development</option>
    </select>
</div>

<!-- Mentors List -->
<div class="mentors" id="mentor-list">
    <!-- Web Development Mentors -->
    <div class="mentor" data-category="web">
        <img src="assets/images/mentor1.jpeg" alt="John Doe">
        <h3>John Doe</h3>
        <p>Web Development</p>
        <a href="free-sessions.php?mentor=John+Doe" class="btn">Book Session</a>
    </div>
    <div class="mentor" data-category="web">
        <img src="assets/images/mentor4.jpeg" alt="Alice Johnson">
        <h3>Alice Johnson</h3>
        <p>Web Development</p>
        <a href="free-sessions.php?mentor=Alice+Johnson" class="btn">Book Session</a>
    </div>
    <div class="mentor" data-category="web">
        <img src="assets/images/mentor5.jpeg" alt="David Kim">
        <h3>David Kim</h3>
        <p>Web Development</p>
        <a href="free-sessions.php?mentor=David+Kim" class="btn">Book Session</a>
    </div>

    <!-- Data Science Mentors -->
    <div class="mentor" data-category="data">
        <img src="assets/images/mentor2.jpeg" alt="Jane Smith">
        <h3>Jane Smith</h3>
        <p>Data Science</p>
        <a href="free-sessions.php?mentor=Jane+Smith" class="btn">Book Session</a>
    </div>
    <div class="mentor" data-category="data">
        <img src="assets/images/mentor6.jpeg" alt="Brian Wong">
        <h3>Brian Wong</h3>
        <p>Data Science</p>
        <a href="free-sessions.php?mentor=Brian+Wong" class="btn">Book Session</a>
    </div>
    <div class="mentor" data-category="data">
        <img src="assets/images/mentor7.jpeg" alt="Sara Patel">
        <h3>Sara Patel</h3>
        <p>Data Science</p>
        <a href="free-sessions.php?mentor=Sara+Patel" class="btn">Book Session</a>
    </div>

    <!-- Mobile Development Mentors -->
    <div class="mentor" data-category="mobile">
        <img src="assets/images/mentor3.jpeg" alt="Michael Lee">
        <h3>Michael Lee</h3>
        <p>Mobile Development</p>
        <a href="free-sessions.php?mentor=Michael+Lee" class="btn">Book Session</a>
    </div>
    <div class="mentor" data-category="mobile">
        <img src="assets/images/mentor8.jpeg" alt="Emma Davis">
        <h3>Emma Davis</h3>
        <p>Mobile Development</p>
        <a href="free-sessions.php?mentor=Emma+Davis" class="btn">Book Session</a>
    </div>
    <div class="mentor" data-category="mobile">
        <img src="assets/images/mentor9.jpeg" alt="Chris Brown">
        <h3>Chris Brown</h3>
        <p>Mobile Development</p>
        <a href="free-sessions.php?mentor=Chris+Brown" class="btn">Book Session</a>
    </div>
</div>

<!-- Scripts for Search & Category Filter -->
<script>
const searchInput = document.getElementById('search-mentor');
const categoryFilter = document.getElementById('category-filter');
const mentors = document.querySelectorAll('#mentor-list .mentor');

function filterMentors() {
    const search = searchInput.value.toLowerCase();
    const category = categoryFilter.value;
    
    mentors.forEach(m => {
        const matchesSearch = m.textContent.toLowerCase().includes(search);
        const matchesCategory = !category || m.dataset.category === category;
        m.style.display = (matchesSearch && matchesCategory) ? 'block' : 'none';
    });
}

searchInput.addEventListener('input', filterMentors);
categoryFilter.addEventListener('change', filterMentors);
</script>

<?php include 'M_includes/footer.php'; ?>
