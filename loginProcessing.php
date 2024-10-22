<?php
include_once 'include/databaseConnection.php';
include_once 'include/sessionStart.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['emailLogin']);
    $password = trim($_POST['passwordLogin']);


    echo $email;
} else {
    echo "Invalid request.";
}
