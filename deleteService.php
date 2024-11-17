<?php

include_once 'include/sessionStart.php';
include_once 'include/databaseConnection.php';

if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 'customer_seller') {
    header("Location: homepage.php");
    exit();
}
if (isset($_POST['service_id']) && is_numeric($_POST['service_id'])) {
    $serviceID = $_POST['service_id'];
    $userID = $_SESSION['userID'];
    $sql = "SELECT user_id FROM services WHERE service_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $serviceID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $service = $result->fetch_assoc();
        if ($service['user_id'] == $userID) {
            $deleteJobImageSql = "DELETE FROM jobImage WHERE service_id = ?";
            $deleteJobImageStmt = $conn->prepare($deleteJobImageSql);
            $deleteJobImageStmt->bind_param("i", $serviceID);

            if ($deleteJobImageStmt->execute()) {
                $deleteServiceSql = "DELETE FROM services WHERE service_id = ? AND user_id = ?";
                $deleteServiceStmt = $conn->prepare($deleteServiceSql);
                $deleteServiceStmt->bind_param("ii", $serviceID, $userID);

                if ($deleteServiceStmt->execute()) {
                    header("Location: profilePage.php");
                    exit();
                } else {
                    echo "Error deleting the service: " . $deleteServiceStmt->error;
                }
            } else {
                echo "Error deleting related job images: " . $deleteJobImageStmt->error;
            }
        } else {
            echo "You are not authorized to delete this service.";
        }
    } else {
        echo "Service not found.";
    }
} else {
    echo "Invalid service ID.";
    exit();
}
