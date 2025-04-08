# ✈️ Airline Reservation System (AirVoyager)

<p align="center">
  A full-stack Airline Reservation System using <strong>PHP</strong> and <strong>MySQL</strong>, integrated with real-time flight data via <strong>Amadeus API</strong>. Runs on <strong>XAMPP</strong>.
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
- Paste all project files (including `index.php`, `flight_updater.py`, etc.) into this folder.

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
- Import and run the SQL statements from `SQL_Query.txt` to create required tables (`flights`, `users`, etc.).

### 5️⃣ Set Up Python Environment (Optional for Live Flight Updates)
- Make sure Python is installed. Use Python 3.10 or later.
- Install dependencies:
  ```bash
  pip install mysql-connector-python amadeus schedule
  ```
- Update Amadeus credentials in `flight_updater.py`.
- Run:
  ```bash
  python flight_updater.py
  ```

### 6️⃣ Run the Project
- Open:
  ```
  http://localhost/airline/index.php
  ```

---

## 🗂 Project Structure

- `index.php` - Main UI for flight booking
- `login.php`, `register.php` - User authentication
- `flight_updater.py` - Fetches real-time prices using Amadeus API
- `SQL_Query.txt` - Contains SQL schema
- `config.php` - Database connection config

---

## ✅ Features

- ✈️ Book flights between major Indian cities
- 💰 Real-time flight pricing in INR using Amadeus API
- 👤 User registration and login with secure password hashing
- 🕒 Scheduled updates via Python for flight prices
- 📊 Simple database schema with clean UI

---

## 🛠 Technologies Used

- **Frontend:** HTML, CSS, Bootstrap
- **Backend:** PHP
- **Database:** MySQL
- **APIs:** Amadeus (for live flight data)
- **Python:** For automated updates
- **Server:** Apache (via XAMPP)

---

## 📜 License

Feel free to copy, modify, and distribute this project for educational or personal use.

---

<p align="center">💡 Developed as a DBMS project in the 2nd year of college.</p>
