<?php
session_start();
if (!isset($_SESSION['user'])) header("Location: login.html");
$conn = new mysqli('localhost', 'root', '', 'airline');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    
    $result = $conn->query("SELECT * FROM flights 
        WHERE departure_city='$departure' 
        AND destination_city='$destination'");
    
    if ($result->num_rows > 0) {
        $flight = $result->fetch_assoc();
        $_SESSION['flight'] = $flight;
        header("Location: boarding_pass.php");
    } else {
        echo "No flights found!";
    }
}
?>