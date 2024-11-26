<?php
include_once 'include/sessionStart.php';
include_once 'include/databaseConnection.php';

if (!isset($_SESSION['userID'])) {
    header("Location: homepage.php");
    exit();
}

if (!isset($_GET['order_id']) || !is_numeric($_GET['order_id'])) {
    header("Location: homepage.php");
    exit();
}

$order_id = (int) $_GET['order_id'];

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

// Extract order data
$order_id = $order['order_id'];
$service_title = $order['service_title'];
$price = $order['price'];
$category = $order['category'];
$customer_name = $order['customer_name'];
$customer_phone = $order['customer_phone'];
$customer_email = $order['customer_email'];
$customer_address = $order['customer_address'];
$order_date = date('F j, Y', strtotime($order['order_date']));
$status = ucfirst($order['status']);

// Contractor details
$contractor_name = $order['contractor_name'];
$contractor_phone = $order['contractor_phone'];
$contractor_email = $order['contractor_email'];

// Close the database connection
$conn->close();

// Generate the HTML content for the receipt
$htmlContent = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Order Receipt - $order_id</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #f9f9f9;
            color: #333;
            line-height: 1.6;
            padding: 30px;
        }

        .receipt-container {
            width: 80%;
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #34495e;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 30px;
            color: #34495e;
            font-weight: bold;
        }

        .header p {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }

        .order-info, .service-info, .customer-info, .contractor-info {
            margin-top: 30px;
        }

        .order-info h2, .service-info h2, .customer-info h2, .contractor-info h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #34495e;
        }

        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            table-layout: fixed; /* Ensures that columns have equal width */
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            word-wrap: break-word;
        }

        th {
            background-color: #ecf0f1;
            color: #34495e;
            font-weight: 600;
        }

        td {
            color: #555;
        }

        td:first-child {
            font-weight: 600;
        }

        .total {
            font-size: 18px;
            color: #2c3e50;
            font-weight: 600;
            margin-top: 20px;
            text-align: right;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        .footer p {
            font-size: 16px;
            color: #333;
        }

        .footer-address {
            font-size: 12px;
            color: #555;
            text-align: center;
            margin-top: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .receipt-container {
                width: 100%;
                padding: 15px;
            }
            .header h1 {
                font-size: 24px;
            }
            .header p {
                font-size: 14px;
            }
            .order-info h2, .service-info h2, .customer-info h2, .contractor-info h2 {
                font-size: 16px;
            }
            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class='receipt-container'>
        <div class='header'>
            <h1>Order Receipt</h1>
            <p><strong>Order ID:</strong> $order_id</p>
            <p><strong>Order Date:</strong> $order_date</p>
            <p><strong>Status:</strong> $status</p>
        </div>

        <div class='order-info'>
            <h2>Order Details</h2>
            <table>
                <tr><th>Service Title</th><td>$service_title</td></tr>
                <tr><th>Price</th><td>NPr. " . number_format($price, 2) . "</td></tr>
                <tr><th>Category</th><td>$category</td></tr>
            </table>
        </div>

        <div class='customer-info'>
            <h2>Customer Information</h2>
            <table>
                <tr><th>Name</th><td>$customer_name</td></tr>
                <tr><th>Phone</th><td>$customer_phone</td></tr>
                <tr><th>Email</th><td>$customer_email</td></tr>
                <tr><th>Address</th><td>$customer_address</td></tr>
            </table>
        </div>

        <div class='contractor-info'>
            <h2>Contractor Information</h2>
            <table>
                <tr><th>Name</th><td>$contractor_name</td></tr>
                <tr><th>Phone</th><td>$contractor_phone</td></tr>
                <tr><th>Email</th><td>$contractor_email</td></tr>
            </table>
        </div>

        <div class='total'>
            <p><strong>Total Price: </strong>NPr. " . number_format($price, 2) . "</p>
        </div>

        <div class='footer'>
            <p>Thank you for your order!</p>
        </div>

        <div class='footer-address'>
            <p>For any inquiries, please contact us at <strong>support@constructhive.com</strong></p>
        </div>
    </div>
</body>
</html>
";


header('Content-Type: text/html');
header('Content-Disposition: attachment; filename="order_receipt_' . $order_id . '.html"');
echo $htmlContent;
