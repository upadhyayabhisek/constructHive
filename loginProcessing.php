<?php
include_once 'include/databaseConnection.php';
include_once 'include/sessionStart.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['emailLogin']);
    $password = trim($_POST['passwordLogin']);


    if (empty($email) || empty($password)) {
        header("Location: loginPage.php");
    }

    $checkEmailQuery = $conn->prepare("SELECT id, password, fullname, role, user_type from userbase where email = ?");
    $checkEmailQuery->bind_param("s", $email);
    $checkEmailQuery->execute();
    $checkEmailQuery->store_result();

    if ($checkEmailQuery->num_rows == 0) {
        header("Location: loginPage.php?error=invalidCredentials");
        exit();
    }

    $checkEmailQuery->bind_result($userID, $hashedPassword, $fullName, $role, $userType);
    $checkEmailQuery->fetch();

    if (password_verify($password, $hashedPassword)) {
        $_SESSION['userID'] = $userID;
        $_SESSION['fullName'] = $fullName;
        $_SESSION['role'] = $role;
        $_SESSION['userType'] = $userType;

        if ($role === 'admin') {
            header('Location: adminDashboard.php');
        } else {
            header('Location: homepage.php');
        }
        exit();
    } else {
        $errorMessage = "Login Error: Invalid password attempt for email: " . htmlspecialchars($email) . " on " . date('Y-m-d H:i:s') . "\n";
        error_log($errorMessage, 3, __DIR__ . "/log/Login_Register.log");
        header("Location: loginPage.php?error=invalidCredentials");
        exit();
    }
    $checkEmailQuery->close();
} else {
    echo "Invalid request.";
}
