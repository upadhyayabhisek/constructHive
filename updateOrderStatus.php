<?php
include_once 'include/sessionStart.php';
include_once 'include/databaseConnection.php';

if (!isset($_SESSION['userID'])) {
    header("Location: homepage.php");
    exit();
}
if (!isset($_POST['order_id']) || !isset($_POST['status'])) {
    header("Location: homepage.php");
    exit();
}

$order_id = (int) $_POST['order_id'];
$status = $_POST['status'];

if (!in_array($status, ['completed', 'cancelled'])) {
    die("Invalid status.");
}

$sql_update_order = "
    UPDATE ordersDB
    SET status = ?
    WHERE order_id = ? AND status = 'pending'";

$stmt = $conn->prepare($sql_update_order);
$stmt->bind_param("si", $status, $order_id);

if ($stmt->execute()) {
    header("Location: profilePage.php");
    exit();
} else {
    die("Error updating order status: " . $conn->error);
}

$conn->close();
