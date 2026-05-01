<?php
$servername = "localhost";
$username = "root";   // default username in XAMPP
$password = "";       // default password is blank
$dbname = "ai_academic_portal";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
