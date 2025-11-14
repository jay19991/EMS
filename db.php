<?php
$servername = "localhost";
$username = "root";  // Default WAMP MySQL username
$password = "";      // Default WAMP MySQL password (blank by default)
$dbname = "ems";     // Name of the database we created earlier

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
