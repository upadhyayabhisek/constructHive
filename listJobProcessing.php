<?php
include_once 'include/databaseConnection.php';
include_once 'include/sessionStart.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serviceTitle = htmlspecialchars($_POST['serviceTitle']);
    $serviceDescription = nl2br(htmlspecialchars($_POST['serviceDescription']));
    $category = htmlspecialchars($_POST['category']);
    $price = htmlspecialchars($_POST['price']);
    $userID = htmlspecialchars($_POST['user_id']);
} else {
    echo "<p>No data submitted.</p>";
}
