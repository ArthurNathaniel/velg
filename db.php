<?php
// $servername = "localhost";
// $username = "root"; // Change this if necessary
// $password = ""; // Change this if necessary
// $dbname = "velg"; // Change this to your database name


$servername = "veestravelandtour.com";
$username = "u500921674_velg"; // Change this if necessary
$password = "OnGod@123"; // Change this if necessary
$dbname = "u500921674_velg"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
