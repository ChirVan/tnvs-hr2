<?php
$servername = "sql12.freesqldatabase.com"; // FreeSQL host
$username = "sql12776979"; // FreeSQL username
$password = "en5rIZ6mna"; // FreeSQL password
$database = "sql12776979"; // FreeSQL database name
$port = 3306; // Default MySQL port

// Create connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>