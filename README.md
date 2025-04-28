<h1 align="center">✈️ Airline Reservation System (AirVoyager)</h1>

<p align="center">
  A full-stack Airline Reservation System using <strong>PHP</strong>, <strong>MySQL</strong>, and <strong>Python</strong>, integrated with real-time flight data via <strong>Amadeus API</strong> and automatic email notifications. Runs on <strong>XAMPP</strong>.
</p>


---

## 📌 Installation Guide

### 1️⃣ Download & Setup XAMPP
- Download and install [XAMPP](https://www.apachefriends.org/index.html).
- Extract the files from this repository.

### 2️⃣ Configure Project Directory
- Navigate to the `htdocs` folder inside the XAMPP installation directory.
- Create a new folder named:
  ```bash
  airline
  ```
- Paste all project files (including `index.php`, `flight_updater.py`, `boarding_pass.php`, etc.) into this folder.

### 3️⃣ Start XAMPP Services
- Open `xampp-control.exe`.
- Start **Apache** and **MySQL** by clicking the **Start** buttons under **Actions**.

### 4️⃣ Create Database
- Visit:
  ```
  http://localhost/phpmyadmin/
  ```
- Create a new database named:
  ```sql
  airline
  ```
- Import and run the SQL statements from `SQL_Query.txt` to create required tables (`flights`, `users`, etc.). Ensure the `users` table has an `email` column.

### 5️⃣ Set Up Python Environment (for Live Flight Updates)
- Make sure Python is installed (Python 3.10 or later recommended).
- Install dependencies:
  ```bash
  pip install mysql-connector-python amadeus schedule
  ```
- Update Amadeus credentials in `flight_updater.py`.
- Run the updater:
  ```bash
  python flight_updater.py
  ```

### 6️⃣ Configure Email Sending (Optional)
- Download and set up [PHPMailer](https://github.com/PHPMailer/PHPMailer).
- Configure SMTP settings in `boarding_pass.php`.
- When a booking is completed, an automatic email will be sent with boarding pass details.

### 7️⃣ Run the Project
- Open:
  ```
  http://localhost/airline/index.php
  ```

---

## 🗂 Project Structure

- `index.php` - Main UI for flight booking
- `login.php`, `register.php` - User authentication with email capture
- `flight_updater.py` - Fetches real-time prices using Amadeus API
- `boarding_pass.php` - Generates boarding pass and sends email
- `SQL_Query.txt` - Contains SQL schema
- `config.php` - Database connection config
- `PHPMailer/` - For email notifications

---

## ✅ Features

- ✈️ Book flights between major Indian cities
- 💰 Real-time flight pricing in INR using Amadeus API
- 📧 Automated email of boarding pass after booking
- 👤 User registration with secure password hashing and email capture
- 🕒 Scheduled updates via Python for flight prices
- 📊 Clean and simple database schema with normalized tables

---

## 🛠 Technologies Used

- **Frontend:** HTML, CSS, Bootstrap
- **Backend:** PHP, Python
- **Database:** MySQL
- **APIs:** Amadeus (for live flight data)
- **Email Notifications:** PHPMailer
- **Server:** Apache (via XAMPP)

---

## 📜 License

Feel free to copy, modify, and distribute this project for educational or personal use.

---

<p align="center">💡 Developed as a DBMS + Integration Project in 2nd year CSE (AI/ML) at SRM Chennai.</p>
