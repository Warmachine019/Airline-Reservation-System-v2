<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        handleLogin();
    } elseif (isset($_POST['signup'])) {
        handleSignup();
    }
}

function handleLogin() {
    global $conn;
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    
    if ($result->num_rows === 0) {
        header("Location: signup.php?error=user_not_found");
        exit();
    }
    
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        header("Location: booking.php");
        exit();
    } else {
        header("Location: login.php?error=wrong_password");
        exit();
    }
}

function handleSignup() {
    global $conn;
    $fields = ['username', 'password', 'name', 'surname', 'dob'];
    
    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            header("Location: signup.php?error=missing_fields");
            exit();
        }
    }
    
    $username = $conn->real_escape_string($_POST['username']);
    $check = $conn->query("SELECT * FROM users WHERE username='$username'");
    
    if ($check->num_rows > 0) {
        header("Location: signup.php?error=username_exists");
        exit();
    }
    
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $name = $conn->real_escape_string($_POST['name']);
    $surname = $conn->real_escape_string($_POST['surname']);
    $dob = $conn->real_escape_string($_POST['dob']);
    
    $conn->query("INSERT INTO users (username, password, name, surname, dob) 
                VALUES ('$username', '$password', '$name', '$surname', '$dob')");
    
    header("Location: login.php?success=signup_complete");
    exit();
}

if (isset($_GET['page'])) {
    switch ($_GET['page']) {
        case 'signup':
            showSignupPage();
            break;
        case 'booking':
            showBookingPage();
            break;
        default:
            showLoginPage();
    }
} else {
    showLoginPage();
}

function showLoginPage() {
    global $conn;
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Login - Air Voyager</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <img src="AirVoyagerLogo.jpg" class="header-logo">
        <div class="auth-container">
            <h1>Welcome to Air Voyager</h1>
            <?php showMessages(); ?>
            <form method="POST">
                <input type="hidden" name="login" value="1">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <p class="auth-link">New user? <a href="?page=signup">Create account</a></p>
        </div>
    </body>
    </html>
    <?php
}

function showSignupPage() {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Sign Up - Air Voyager</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <img src="AirVoyagerLogo.jpg" class="header-logo">
        <div class="auth-container">
            <h1>Create New Account</h1>
            <?php showMessages(); ?>
            <form method="POST">
                <input type="hidden" name="signup" value="1">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <input type="text" name="name" placeholder="First Name" required>
                </div>
                <div class="form-group">
                    <input type="text" name="surname" placeholder="Last Name" required>
                </div>
                <div class="form-group">
                    <input type="date" name="dob" required>
                </div>
                <button type="submit">Create Account</button>
            </form>
            <p class="auth-link">Already have an account? <a href="?page=login">Login here</a></p>
        </div>
    </body>
    </html>
    <?php
}

function showMessages() {
    $error = $_GET['error'] ?? '';
    $success = $_GET['success'] ?? '';
    
    if ($error) {
        echo '<div class="message error">';
        switch ($error) {
            case 'user_not_found': echo "Account not found. Please sign up."; break;
            case 'wrong_password': echo "Incorrect password. Please try again."; break;
            case 'missing_fields': echo "Please fill all required fields."; break;
            case 'username_exists': echo "Username already exists. Please choose another."; break;
        }
        echo '</div>';
    }
    
    if ($success === 'signup_complete') {
        echo '<div class="message success">Signup complete! Please login with your credentials.</div>';
    }
}
?>
