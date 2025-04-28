<?php
session_start();
require 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (!isset($_SESSION['user']) || !isset($_POST['flight_id'])) {
    header("Location: login.php");
    exit();
}

$flight_id = $conn->real_escape_string($_POST['flight_id']);
$result = $conn->query("SELECT * FROM flights WHERE id = '$flight_id'");
$flight = $result->fetch_assoc();

$seat_number = rand(1, 40) . chr(rand(65, 70));

$user = $_SESSION['user'];
$userEmail = $user['email'];
$passengerName = $user['name'] . ' ' . $user['surname'];
$departureCity = $flight['departure_city'];
$destinationCity = $flight['destination_city'];
$flightNumber = $flight['flight_number'];
$departureDate = date('d/m/Y');

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'your_MAIL_ID@gmail.com';
    $mail->Password   = 'your_app_password';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('your_email@gmail.com', 'AirVoyager');
    $mail->addAddress($userEmail, $passengerName);

    $mail->isHTML(true);
    $mail->Subject = 'Your AirVoyager Boarding Pass';
    $mail->Body    = "
        <h2>Hi {$passengerName},</h2>
        <p>Your boarding pass has been successfully generated. Below are your flight details:</p>
        <ul>
            <li><strong>Flight Number:</strong> {$flightNumber}</li>
            <li><strong>From:</strong> {$departureCity}</li>
            <li><strong>To:</strong> {$destinationCity}</li>
            <li><strong>Seat:</strong> {$seat_number}</li>
            <li><strong>Date:</strong> {$departureDate}</li>
        </ul>
        <p>Safe travels and thank you for choosing AirVoyager! 🛫</p>
    ";

    $mail->send();
    $emailStatus = "<p style='color:lightgreen'>Email sent successfully to $userEmail</p>";
} catch (Exception $e) {
    $emailStatus = "<p style='color:red'>Email failed: {$mail->ErrorInfo}</p>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Boarding Pass - Air Voyager</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <img src="AirVoyagerLogo.jpg" class="header-logo">

    <div class="boarding-pass-container">
        <h1>Boarding Pass</h1>

        <div class="pass-details">
            <div class="pass-section">
                <h3>Passenger Information</h3>
                <p>Name: <?= $passengerName ?></p>
                <p>Date of Birth: <?= date('d/m/Y', strtotime($user['dob'])) ?></p>
            </div>

            <div class="pass-section">
                <h3>Flight Details</h3>
                <p>Flight Number: <?= $flightNumber ?></p>
                <p>Route: <?= $departureCity ?> → <?= $destinationCity ?></p>
                <p>Seat: <?= $seat_number ?></p>
            </div>

            <div class="barcode">
                <img src="sample_barcode.jpg" alt="Boarding Pass Barcode" class="barcode-image">
            </div>

            <?= $emailStatus ?>
        </div>
    </div>
</body>
</html>
