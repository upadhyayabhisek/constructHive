<?php
include_once 'include/sessionStart.php';
include_once 'include/databaseConnection.php';

if (!isset($_GET['service_id']) || !is_numeric($_GET['service_id']) || !isset($_GET['address']) || empty($_GET['address'])) {
    die("Invalid request. Service ID or address is missing.");
}

$service_id = (int) $_GET['service_id'];
$customer_id = $_SESSION['userID'];
$address = $conn->real_escape_string(trim($_GET['address']));

$sql_service = "
    SELECT service_id, service_title, price, category
    FROM services
    WHERE service_id = $service_id AND approval = 'accepted'
";

$result_service = $conn->query($sql_service);

if ($result_service === false) {
    die("Error: " . $conn->error);
}

if ($result_service->num_rows === 0) {
    die("Service not found or not approved.");
}

$service = $result_service->fetch_assoc();
$service_title = $service['service_title'];
$price = $service['price'];
$category = $service['category'];

$sql_insert_order = "
    INSERT INTO ordersDB (customer_id, service_id, status, customer_address)
    VALUES ($customer_id, $service_id, 'pending', '$address')
";

if ($conn->query($sql_insert_order) === TRUE) {
    $order_id = $conn->insert_id;
    header("Location: orderConfirmation.php?order_id=$order_id");
    exit();
} else {
    die("Error inserting order: " . $conn->error);
}

$conn->close();
