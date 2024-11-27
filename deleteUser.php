<?php
include_once 'include/sessionStart.php';
include_once 'include/databaseConnection.php';

if (!isset($_SESSION['userID']) || $_SESSION['role'] != 'admin') {
    header("Location: homepage.php");
    exit();
}

if (isset($_POST['ban_user'])) {
    $userId = $_POST['user_id'];

    $checkContractorSql = "SELECT COUNT(*) FROM services WHERE user_id = ?";
    $stmt = $conn->prepare($checkContractorSql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($jobCount);
    $stmt->fetch();
    $stmt->close();

    if ($jobCount > 0) {
        $deleteImagesSql = "DELETE FROM jobImage WHERE service_id IN (SELECT service_id FROM services WHERE user_id = ?)";
        $stmt = $conn->prepare($deleteImagesSql);
        $stmt->bind_param("i", $userId);
        if (!$stmt->execute()) {
            echo "Failed to delete related images.";
            exit();
        }

        $deleteServicesSql = "DELETE FROM services WHERE user_id = ?";
        $stmt = $conn->prepare($deleteServicesSql);
        $stmt->bind_param("i", $userId);
        if (!$stmt->execute()) {
            echo "Failed to delete services.";
            exit();
        }

        $deleteContractorInfoSql = "DELETE FROM contractorInformation WHERE userbase_id = ?";
        $stmt = $conn->prepare($deleteContractorInfoSql);
        $stmt->bind_param("i", $userId);
        if (!$stmt->execute()) {
            echo "Failed to delete contractor information.";
            exit();
        }
    }

    $deleteUserSql = "DELETE FROM userbase WHERE id = ?";
    $stmt = $conn->prepare($deleteUserSql);
    $stmt->bind_param("i", $userId);
    if (!$stmt->execute()) {
        echo "Failed to delete user.";
        exit();
    }

    echo "User and all associated records have been deleted!";
    header("Location: adminDashboard.php");
    exit();
}
