<?php
include_once 'include/databaseConnection.php';
include_once 'include/sessionStart.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = trim($_POST['nameRegister']);
    $email = trim($_POST['emailRegister']);
    $password = trim($_POST['passwordRegister']);
    $mobile = trim($_POST['phoneRegister']);
    $phoneRegexValidation = '/^(?:\+977)?[9][6-9]\d{8}$/';
    $passwordRegexValidation = '/^(?=.*\d)[A-Za-z\d]{8,}$/';

    if (empty($fullName) || empty($email) || empty($password) || empty($mobile)) {
        header("Location: registerPage.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: registerPage.php");
        exit();
    }

    if (!preg_match($phoneRegexValidation, $mobile)) {
        header("Location: registerPage.php");
        exit();
    }

    if (!preg_match($passwordRegexValidation, $password)) {
        header("Location: registerPage.php");
        exit();
    }

    $checkEmailQuery = $conn->prepare("SELECT email FROM userbase WHERE email = ?");
    $checkEmailQuery->bind_param("s", $email);
    $checkEmailQuery->execute();
    $checkEmailQuery->store_result();

    if ($checkEmailQuery->num_rows > 0) {
        header("Location: registerPage.php?error=emailExists");
        exit();
    }

    //bcrypt 

    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sqlStatement = $conn->prepare("INSERT INTO userbase (fullname, password, mobile_number, email) VALUES (?, ?, ?, ?)");
    $sqlStatement->bind_param("ssss", $fullName, $encryptedPassword, $mobile, $email);

    if ($sqlStatement->execute()) {
        $userID = $conn->insert_id;
        $_SESSION['userID'] = $userID;
        $_SESSION['fullName'] = $fullName;
        $_SESSION['userType'] = "customer";
        header('Location: homepage.php');
        exit();
    } else {
        $errorMessage = "Database Insertion Error during registration: " . $sqlStatement->error . " " . date('Y-m-d H:i:s') . "\n";
        error_log($errorMessage, 3, __DIR__ . "/log/Login_Register.log");
        die("Database Insertion Error! Please try again later.");
    }
    $checkEmailQuery->close();
    $sqlStatement->close();
} else {
    echo "Invalid request.";
}
