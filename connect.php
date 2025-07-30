<?php
$host = 'localhost';
$user = 'root';
$password = ''; 
$database = 'visitor_db'; 

$conn = new mysqli($host, $user, $password, $database);

// Error handling
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
