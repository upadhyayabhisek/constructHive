<?php
include_once 'include/sessionStart.php';

if (!isset($_SESSION['userID'])) {
    header("Location: homepage.php");
    exit();
}

$userID = $_SESSION['userID'];
$userType = $_SESSION['userType'];

include_once 'include/databaseConnection.php';

$sql = "SELECT fullname, mobile_number, email, date_of_creation 
        FROM userbase 
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$userResult = $stmt->get_result();

if ($userResult->num_rows > 0) {
    $user = $userResult->fetch_assoc();
} else {
    header("Location: homepage.php");
    exit();
}

$sql = "SELECT o.order_id, o.order_date, o.status, s.service_title, s.service_description, s.price
        FROM ordersDB o
        JOIN services s ON o.service_id = s.service_id
        WHERE o.customer_id = ?
        ORDER BY o.order_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$orderResult = $stmt->get_result();

if ($orderResult->num_rows > 0) {
    $orders = $orderResult->fetch_all(MYSQLI_ASSOC);
} else {
    $orders = [];
}

$sql = "SELECT * FROM services WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$serviceResult = $stmt->get_result();

if ($serviceResult->num_rows > 0) {
    $services = $serviceResult->fetch_all(MYSQLI_ASSOC);
} else {
    $services = [];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="css/profileStyles.css?v=1.1">
    <script src="js/mainJavaScript.js" defer></script>
</head>

<body>
    <?php include 'include/header.php'; ?>

    <h1 class="titleProfile">My Profile</h1>

    <div class="container">
        <div class="buttons-container">
            <button onclick="showDiv('div1')">My Profile</button>
            <button onclick="showDiv('div2')">My Orders</button>

            <?php if ($userType == 'customer_seller'): ?>
                <button onclick="showDiv('div3')">My Services</button>
                <button onclick="showDiv('div4')">Received Orders</button>
            <?php endif; ?>
        </div>

        <div id="div1" class="content-div">
            <h2>My Profile</h2>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['fullname']); ?></p>
            <p><strong>Mobile Number:</strong> <?php echo htmlspecialchars($user['mobile_number']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Date of Creation:</strong> <?php echo date("F j, Y", strtotime($user['date_of_creation'])); ?></p>
        </div>

        <div id="div2" class="content-div">
            <h2>My Orders</h2>
            <?php if (!empty($orders)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Service Title</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['service_title']); ?></td>
                                <td><?php echo htmlspecialchars($order['service_description']); ?></td>
                                <td>NPr<?php echo number_format($order['price'], 2); ?></td>
                                <td><?php echo htmlspecialchars($order['status']); ?></td>
                                <td><?php echo date("F j, Y", strtotime($order['order_date'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You have no orders yet.</p>
            <?php endif; ?>
        </div>

        <?php if ($userType == 'customer_seller'): ?>
            <div id="div3" class="content-div">
                <h2>My Services</h2>
                <?php if (!empty($services)): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Service Title</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($services as $service): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($service['service_title']); ?></td>
                                    <td><?php echo htmlspecialchars($service['category']); ?></td>
                                    <td>NPr.<?php echo number_format($service['price'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($service['approval']); ?></td>
                                    <td>
                                        <a href="viewProduct.php?service_id=<?php echo $service['service_id']; ?>" class="view-link">View Product</a>
                                    </td>
                                    <td>
                                        <form action="deleteService.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                            <input type="hidden" name="service_id" value="<?php echo $service['service_id']; ?>">
                                            <button type="submit" class="delete-button">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>You have not listed any services yet.</p>
                <?php endif; ?>
            </div>

            <div id="div4" class="content-div">
                <h2>Received Orders</h2>
                <?php
                $sql_received_orders = "
        SELECT o.order_id, o.customer_id, o.order_date, o.status, u.fullname AS customer_name, 
               u.mobile_number AS customer_phone, u.email AS customer_email, o.customer_address
        FROM ordersDB o
        JOIN userbase u ON o.customer_id = u.id
        JOIN services s ON o.service_id = s.service_id
        WHERE s.user_id = ? 
        ORDER BY o.order_date DESC
    ";

                $stmt_received_orders = $conn->prepare($sql_received_orders);
                $stmt_received_orders->bind_param("i", $userID);
                $stmt_received_orders->execute();
                $received_order_result = $stmt_received_orders->get_result();

                if ($received_order_result->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer Name</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Order Date</th>
                                <th>Actions</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($order = $received_order_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_phone']); ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                    <td><?php echo htmlspecialchars($order['customer_address']); ?></td>
                                    <td><?php echo ucfirst(htmlspecialchars($order['status'])); ?></td>
                                    <td><?php echo date("F j, Y", strtotime($order['order_date'])); ?></td>
                                    <td>
                                        <?php if ($order['status'] == 'pending'): ?>
                                            <form action="updateOrderStatus.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                <button type="submit" name="status" value="completed" class="complete-button">Complete</button>
                                            </form>

                                            <form action="updateOrderStatus.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                                                <button type="submit" name="status" value="cancelled" class="cancel-button">Cancel</button>
                                            </form>
                                        <?php else: ?>
                                            <span>completed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="orderConfirmation.php?order_id=<?php echo $order['order_id']; ?>" class="view-link">View</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>You have not received any orders yet.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function showDiv(divId) {
            const divs = ['div1', 'div2', 'div3', 'div4'];
            divs.forEach(function(div) {
                let element = document.getElementById(div);
                if (element) {
                    element.style.display = 'none';
                }
            });

            let selectedDiv = document.getElementById(divId);
            if (selectedDiv) {
                selectedDiv.style.display = 'block';
            }
        }

        showDiv('div1');
    </script>
</body>

</html>