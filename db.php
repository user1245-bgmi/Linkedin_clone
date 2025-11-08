<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$database = "linkedin_clone";

// $servername = "sql112.infinityfree.com";
// $username = "if0_40351902";
// $password = "MgKHWbHPH155r";
// $database = "if0_40351902_linkedin_clone";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
