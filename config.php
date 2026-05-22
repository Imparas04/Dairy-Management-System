<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = "127.0.0.1"; // "localhost" ki jagah ye use karna port 3307 ke liye best hai
$user = "root";
$password = ""; 
$database = "dairy_system";
$port = 3307; // <--- Yahan 'port' variable ka naam likh diya hai

// Connection setup (ab variables sahi hain)
$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>