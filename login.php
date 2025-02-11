<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'airline');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'login';

    if ($action === 'signup') {
        // SIGNUP PROCESS
        $username = $conn->real_escape_string($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $name = $conn->real_escape_string($_POST['name'] ?? '');
        $surname = $conn->real_escape_string($_POST['surname'] ?? '');
        $dob = $conn->real_escape_string($_POST['dob'] ?? '');

        if (empty($username) || empty($password) || empty($name) || empty($surname) || empty($dob)) {
            $message = "All fields are required!";
            $message_type = 'error';
        } else {
            $check = $conn->query("SELECT * FROM users WHERE username='$username'");
            if ($check && $check->num_rows > 0) {
                $message = "Username already exists!";
                $message_type = 'error';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $insert = $conn->query("INSERT INTO users (username, password, name, surname, dob) 
                                      VALUES ('$username', '$hashed_password', '$name', '$surname', '$dob')");
                
                if ($insert) {
                    $message = "Signup successful! Please login.";
                    $message_type = 'success';
                } else {
                    $message = "Signup failed: " . $conn->error;
                    $message_type = 'error';
                }
            }
        }
    } else {
        // LOGIN PROCESS
        $username = $conn->real_escape_string($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $result = $conn->query("SELECT * FROM users WHERE username='$username'");
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: search.php");
                exit();
            } else {
                $message = "Invalid password!";
                $message_type = 'error';
            }
        } else {
            $message = "User not found!";
            $message_type = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Login</title>
    <link rel="stylesheet" href="common.css">
    <style>
        .signup-fields { display: none; }
        .signup-mode .signup-fields { display: block; }
        .toggle-text { margin-top: 15px; }
        a { color: #007BFF; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Airline System Login</h2>
        
        <?php if ($message): ?>
            <div class="message <?= $message_type ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="post" id="authForm">
            <input type="hidden" name="action" value="login" id="formAction">
            
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="signup-fields">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <input type="text" name="surname" placeholder="Surname" required>
                </div>
                <div class="form-group">
                    <input type="date" name="dob" required>
                </div>
            </div>

            <button type="submit" id="submitButton">Login</button>
            <div class="toggle-text">
                <span>Don't have an account? </span>
                <a href="#" onclick="toggleSignup(); return false;">Sign Up</a>
            </div>
        </form>
    </div>

    <script>
        function toggleSignup() {
            const form = document.getElementById('authForm');
            form.classList.add('signup-mode');
            document.getElementById('formAction').value = 'signup';
            document.getElementById('submitButton').textContent = 'Sign Up';
            
            document.querySelectorAll('.signup-fields input').forEach(input => {
                input.required = true;
            });
        }
    </script>
</body>
</html>