<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$databaseName = "construction";

$conn = new mysqli($serverName, $userName, $password, $databaseName);

if ($conn->connect_error) {
    $errorMessage = "Connection Failed: " . $conn->connect_error . date(' Y-m-d H:i:s') . "\n";
    error_log($errorMessage, 3, __DIR__ . "/../log/ConnectionError.log");
    die("Connection failed! Please try again later.");
}
