<?php
include_once 'include/sessionStart.php';
include_once 'include/databaseConnection.php';

if (!isset($_SESSION['userID']) || $_SESSION['role'] != 'admin') {
    header("Location: homepage.php");
    exit();
}

if (isset($_POST['promote_user'])) {
    $userId = $_POST['user_id'];

    $sql = "UPDATE userbase SET role = 'admin', user_type = 'customer_seller' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        header("Location: adminDashboard.php");
        exit();
    } else {
        echo "Failed to promote user.";
    }
}

$conn->close();
