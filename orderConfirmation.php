<?php
include_once 'include/sessionStart.php';
include_once 'include/databaseConnection.php';
if (!isset($_SESSION['userID'])) {
    header("Location: homepage.php");
    exit();
}

// Check if order_id is set and valid
if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    header("Location: homepage.php");
    exit();
}

$order_id = (int) $_GET['order_id'];

// Fetch order details, service details, and contractor details
$sql_order = "
    SELECT o.order_id, o.customer_id, o.service_id, o.status, o.order_date,
           s.service_title, s.price, s.category,
           u.fullname AS customer_name, u.mobile_number AS customer_phone, u.email AS customer_email, o.customer_address,
           c.fullname AS contractor_name, c.mobile_number AS contractor_phone, c.email AS contractor_email
    FROM ordersDB o
    JOIN services s ON o.service_id = s.service_id
    JOIN userbase u ON o.customer_id = u.id  -- Customer information
    JOIN userbase c ON s.user_id = c.id  -- Contractor information (who posted the job)
    WHERE o.order_id = $order_id
";

$result_order = $conn->query($sql_order);

if ($result_order === false) {
    die("Error: " . $conn->error);
}

if ($result_order->num_rows === 0) {
    die("Order not found.");
}

$order = $result_order->fetch_assoc();

$order_id = $order['order_id'];
$service_title = $order['service_title'];
$price = $order['price'];
$category = $order['category'];
$customer_name = $order['customer_name'];
$customer_phone = $order['customer_phone'];
$customer_email = $order['customer_email'];
$customer_address = $order['customer_address']; // Fetch customer address
$order_date = date('F j, Y', strtotime($order['order_date']));
$status = ucfirst($order['status']);

// Contractor details
$contractor_name = $order['contractor_name'];
$contractor_phone = $order['contractor_phone'];
$contractor_email = $order['contractor_email'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="css/orderPlace.css">
</head>

<body>

    <?php include 'include/header.php'; ?>

    <main>
        <div class="order-confirmation">
            <h1>Order Confirmed!</h1>

            <p>Thank you for your order! Below are the details of your purchase:</p>
            <hr>

            <h3>Order Details</h3>
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_id); ?></p>
            <p><strong>Order Date:</strong> <?php echo $order_date; ?></p>
            <p><strong>Status:</strong> <?php echo $status; ?></p>

            <h3>Service Details</h3>
            <p><strong>Service Name:</strong> <?php echo htmlspecialchars($service_title); ?></p>
            <p><strong>Price:</strong> NPr. <?php echo number_format($price, 2); ?></p>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($category); ?></p>

            <h3>Contractor Details</h3>
            <p><strong>Contractor Name:</strong> <?php echo htmlspecialchars($contractor_name); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($contractor_phone); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($contractor_email); ?></p>

            <h3>Customer Address</h3>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($customer_address); ?></p>

            <hr>

            <p>If you have any questions about your order, please contact the contractor directly using the information provided above.</p>
            <button
                onclick="window.location.href='orderReciept.php?order_id=<?php echo $order_id; ?>';"
                style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                Download Receipt
            </button>

        </div>

    </main>

    <?php include 'include/footer.php'; ?>

</body>

</html>