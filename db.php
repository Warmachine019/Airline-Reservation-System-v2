<?php
$conn = new mysqli('localhost', 'root', 'root', 'airline');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>