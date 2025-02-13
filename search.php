<?php
session_start();
if (!isset($_SESSION['user'])) header("Location: login.html");

$cities = ['Mumbai', 'Delhi', 'Bangalore', 'Kolkata', 'Chennai', 'Hyderabad', 
          'Pune', 'Jaipur', 'Ahmedabad', 'Surat', 'Lucknow', 'Kanpur', 
          'Nagpur', 'Visakhapatnam', 'Indore', 'Thane', 'Bhopal', 'Patna', 
          'Vadodara', 'Ghaziabad'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Flights</title>
    <link rel="stylesheet" href="common.css">
</head>
<body>
    <div class="container">
        <h2>Search Flights</h2>
        <form action="booking.php" method="post">
            <div class="form-group">
                <label>Depart From:</label>
                <select name="departure" required>
                    <?php foreach ($cities as $city) echo "<option>$city</option>"; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Destination:</label>
                <select name="destination" required>
                    <?php foreach ($cities as $city) echo "<option>$city</option>"; ?>
                </select>
            </div>

            <button type="submit" name="search">Search Flights</button>
        </form>
    </div>
</body>
</html>