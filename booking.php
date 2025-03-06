<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$flights = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $departure = $conn->real_escape_string($_POST['departure']);
    $destination = $conn->real_escape_string($_POST['destination']);

    $result = $conn->query("SELECT * FROM flights 
                          WHERE departure_city = '$departure' 
                          AND destination_city = '$destination'");
    $flights = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Flights - Air Voyager</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <img src="AirVoyagerLogo.jpg" class="header-logo">
    
    <div class="booking-container">
        <h1>Flight Search</h1>
        
        <form method="POST">
            <div class="form-group">
                <label>Departure City:</label>
                <select name="departure" required>
                    <option value="">Select departure city</option>
                    <?php include 'cities.php'; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Destination City:</label>
                <select name="destination" required>
                    <option value="">Select destination city</option>
                    <?php include 'cities.php'; ?>
                </select>
            </div>

            <button type="submit">Search Flights</button>
        </form>

        <?php if (!empty($_POST)): ?>
            <div class="results-container">
                <h2>Available Flights</h2>
                
                <?php if (!empty($flights)): ?>
                    <?php foreach ($flights as $flight): ?>
                        <div class="flight-card">
                            <h3>Flight <?= $flight['flight_number'] ?></h3>
                            <p>Route: <?= $flight['departure_city'] ?> → <?= $flight['destination_city'] ?></p>
                            <p>Price: ₹<?= number_format($flight['price'], 2) ?></p>
                            <form action="boarding_pass.php" method="POST">
                                <input type="hidden" name="flight_id" value="<?= $flight['id'] ?>">
                                <button type="submit" class="book-button">Book Now</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="message info">No flights found matching your criteria</div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
