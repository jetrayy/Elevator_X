# Elevator X - Platform for Entrepreneurs and Investors

##  Description

**Elevator X** is a platform designed to help entrepreneurs secure funding, mentorship, and educational resources to improve their business ideas. It connects entrepreneurs with potential investors who can view and evaluate business pitches, send requests, and offer support through mentorship or funding.

The system supports two types of users:
- **Entrepreneurs**: Can pitch their ideas through text and images, request mentorship, and access free knowledge platforms.
- **Investors**: Can view entrepreneur pitches (only partially before payment), send investment requests, and communicate with entrepreneurs once they unlock the messaging feature.

---

## Technologies Used

- **Frontend**: PHP, HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Local Development Environment**: XAMPP (Apache & MySQL)

---

##  Features

- **Two user types**: Entrepreneurs and Investors
- **Pitch system**: Entrepreneurs can submit their business ideas with images and text.
- **Investor Interaction**: Investors can view a partial pitch before unlocking the full idea by making a payment.
- **Mentorship & Learning**: Entrepreneurs can request paid mentorship or access free knowledge resources such as quizzes, tutorials, and forums.
- **Communication system**: Entrepreneurs and investors can communicate through the site once the messaging feature is unlocked.
- **Payment for unlocking messages**: Investors must pay to unlock the messaging feature and view the full pitch.

---

##  How to Run

### Prerequisites:

- Install **XAMPP Control Panel** (Apache & MySQL)
- **MySQL** database setup

### Steps:

1. **Install XAMPP**:
   - Download and install **XAMPP** (Apache and MySQL server) from the [official website](https://www.apachefriends.org/index.html).

2. **Start XAMPP Services**:
   - Open the **XAMPP Control Panel**.
   - Start the **Apache** and **MySQL** services.

3. **Setup MySQL Database**:
   - Open **phpMyAdmin** by clicking the **MySQL Admin** button in the XAMPP Control Panel.
   - In phpMyAdmin, click on **Import**.
   - Select the **elevator_X.sql** file (provided with the project) to import the database structure.

4. **Add the Project Files**:
   - Download or clone the project files.
   - Place the project files in the **htdocs** folder located in `C:\xampp\htdocs`.

5. **Access the Web Application**:
   - Open your browser and type in the following URL:
     ```text
     http://localhost/file_name
     ```
     (Replace `file_name` with the name of the project folder you placed inside **htdocs**).

---

## Future Improvements

- Integrate **payment gateway** for processing investor payments.
- Enhance **pitch visibility** with additional features like ratings, comments, and feedback from investors.
- Add **user profiles** for entrepreneurs and investors with detailed information, previous investments, and past pitches.
- Implement **notification system** to alert users about new messages, requests, and activities.
- Provide **video conferencing** capabilities for investors and entrepreneurs to discuss ideas.

---
