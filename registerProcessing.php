<?php

include_once 'include/databaseConnection.php';
include_once 'include/sessionStart.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST['nameRegister']);
    $email = trim($_POST['emailRegister']);
    $password = trim($_POST['passwordRegister']);
    $mobile = trim($_POST['phoneRegister']);

    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (empty($fullName) || empty($email) || empty($password) || empty($mobile)) {
        header("Location: registerPage.php");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: registerPage.php");
    }

    $phoneRegexValidation = '/^(?:\+977)?[9][6-9]\d{8}$/';
    if (!preg_match($phoneRegexValidation, $mobile)) {
        header("Location: registerPage.php");
    }

    if (strlen($password) < 8) {
        header("Location: registerPage.php");
    }

    echo "Registration successful!<br>";
    echo "Name: " . htmlspecialchars($fullName) . "<br>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Phone: " . htmlspecialchars($mobile) . "<br>";
    echo "Password: " . htmlspecialchars($encryptedPassword) . "<br>";
} else {
    echo "Invalid request.";
}
