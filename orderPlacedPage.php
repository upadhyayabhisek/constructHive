<?php
include_once 'include/sessionStart.php';
include_once 'include/databaseConnection.php';

// Ensure the service_id is passed via URL and is numeric
if (!isset($_GET['service_id']) || !is_numeric($_GET['service_id'])) {
    die("Invalid request. Service ID is missing or invalid.");
}

$service_id = (int) $_GET['service_id'];

// Fetch service details (service_id, service_title, price, category, contractor_id, user_id)
$sql_service = "
    SELECT s.service_id, s.service_title, s.price, s.category, s.user_id AS contractor_id, u.id AS user_id,
           u.phone_number, u.email
    FROM services s
    LEFT JOIN userbase u ON s.user_id = u.id
    WHERE s.service_id = $service_id AND s.approval = 'accepted'
";

$result_service = $conn->query($sql_service);

if ($result_service === false) {
    die("Error: " . $conn->error);
}

if ($result_service->num_rows === 0) {
    die("Service not found or not approved.");
}

$service = $result_service->fetch_assoc();

// Extracting the required details
$contractor_id = $service['contractor_id'];
$user_id = $service['user_id'];
$service_title = $service['service_title'];
$price = $service['price'];
$category = $service['category'];
$phone_number = $service['phone_number'];
$email = $service['email'];

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Purchase Processing</title>
    <link rel="stylesheet" href="css/styles.css?v=1.4">
</head>

<body>

    <?php include 'include/header.php'; ?>

    <main>
        <div class="purchase-details">
            <h1>Purchase Service Details</h1>

            <p><strong>Service ID:</strong> <?php echo htmlspecialchars($service_id); ?></p>
            <p><strong>Contractor ID:</strong> <?php echo htmlspecialchars($contractor_id); ?></p>
            <p><strong>User ID (Customer):</strong> <?php echo htmlspecialchars($user_id); ?></p>

            <h3>Service Details</h3>
            <p><strong>Service Name:</strong> <?php echo htmlspecialchars($service_title); ?></p>
            <p><strong>Price:</strong> NPr. <?php echo number_format($price, 2); ?></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($category); ?></p>

            <h3>Contractor Contact</h3>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($phone_number); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>

            <p>These IDs represent the service you are attempting to purchase, the contractor providing the service, and the customer (you) making the purchase request.</p>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>

</body>

</html>