<?php
$conn = new mysqli('localhost', 'MYSQL_USERNAME_HERE', 'MYSQL_PASSWORD_HERE', 'airline');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
