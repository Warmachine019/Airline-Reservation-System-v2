<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user']) || !isset($_POST['flight_id'])) {
    header("Location: login.php");
    exit();
}

$flight_id = $conn->real_escape_string($_POST['flight_id']);
$result = $conn->query("SELECT * FROM flights WHERE id = '$flight_id'");
$flight = $result->fetch_assoc();

$seat_number = rand(1, 40) . chr(rand(65, 70));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boarding Pass - Air Voyager</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <img src="/images/AirVoyagerLogo.jpg" class="header-logo">
    
    <div class="boarding-pass-container">
        <h1>Boarding Pass</h1>
        
        <div class="pass-details">
            <div class="pass-section">
                <h3>Passenger Information</h3>
                <p>Name: <?= $_SESSION['user']['name'] ?> <?= $_SESSION['user']['surname'] ?></p>
                <p>Date of Birth: <?= date('d/m/Y', strtotime($_SESSION['user']['dob'])) ?></p>
            </div>

            <div class="pass-section">
                <h3>Flight Details</h3>
                <p>Flight Number: <?= $flight['flight_number'] ?></p>
                <p>Route: <?= $flight['departure_city'] ?> → <?= $flight['destination_city'] ?></p>
                <p>Seat: <?= $seat_number ?></p>
            </div>

            <div class="barcode">
                <img src="/images/sample_barcode.jpg" alt="Boarding Pass Barcode" class="barcode-image">
            </div>
        </div>
    </div>
</body>
</html>
