<?php
// Only start session if one doesn't exist already
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "127.0.0.1";
$user = "root";
$pass = "";
$dbname = "blog";
$port = 3307;

$conn = mysqli_connect($host, $user, $pass, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>