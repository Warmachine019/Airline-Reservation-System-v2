<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['flight'])) 
    header("Location: login.html");

$user = $_SESSION['user'];
$flight = $_SESSION['flight'];
$seat = rand(1, 40).chr(rand(65, 70));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boarding Pass</title>
    <link rel="stylesheet" href="common.css">
</head>
<body>
    <div class="boarding-pass">
        <h2>BOARDING PASS</h2>
        
        <div class="form-group">
            <strong>Passenger:</strong><br>
            <?php echo $user['name'] . ' ' . $user['surname']; ?>
        </div>

        <div class="form-group">
            <strong>Date of Birth:</strong><br>
            <?php echo date('d/m/Y', strtotime($user['dob'])); ?>
        </div>

        <div class="form-group">
            <strong>Flight Number:</strong><br>
            <?php echo $flight['flight_number']; ?>
        </div>

        <div class="form-group">
            <strong>Route:</strong><br>
            <?php echo $flight['departure_city'] . ' → ' . $flight['destination_city']; ?>
        </div>

        <div class="form-group">
            <strong>Seat:</strong><br>
            <?php echo $seat; ?>
        </div>

        <div class="message success">
            Boarding pass generated successfully!
        </div>
    </div>
</body>
</html>