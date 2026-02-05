<?php
$host = "sql302.infinityfree.com";      
$user = "if0_41076210";     
$password = "toDIOT666";
$database = "if0_41076210_users";  

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
