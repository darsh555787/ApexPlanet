<?php
// Enable error reporting to see if anything goes wrong
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "127.0.0.1"; 
$user = "root";
$pass = ""; 
$dbname = "blog"; 
$port = 3307; // MySQL port from your XAMPP

// Establish the connection
$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "<h1 style='color:green'>ApexPlanet Database Connected Successfully!</h1>";
}
?>