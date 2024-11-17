<?php
include_once 'include/sessionStart.php';
include_once 'include/databaseConnection.php';

// Check if service_id is passed and is numeric
if (!isset($_GET['service_id']) || !is_numeric($_GET['service_id'])) {
    header('Location: homepage.php');
    exit();
}

$service_id = (int) $_GET['service_id'];

// Query to fetch the service details by service_id and approval status
$sql_service = "
    SELECT s.service_id, s.service_title, s.service_description, s.category, s.price, 
           s.created_at, s.approval, s.user_id
    FROM services s
    WHERE s.service_id = $service_id
";

$result_service = $conn->query($sql_service);

if ($result_service === false) {
    die('SQL Error: ' . $conn->error);
}

if ($result_service->num_rows === 0) {
    header('Location: homepage.php');
    exit();
}

$service = $result_service->fetch_assoc();
$contractor_user_id = $service['user_id']; // Store the user_id for contractor

// Query to fetch contractor information from the userbase and contractorInformation tables
$sql_contractor = "
    SELECT u.fullname, u.email, u.mobile_number, ci.billing_location
    FROM userbase u
    LEFT JOIN contractorInformation ci ON u.id = ci.userbase_id
    WHERE u.id = $contractor_user_id
";

$result_contractor = $conn->query($sql_contractor);

if ($result_contractor === false) {
    die('Error fetching contractor information: ' . $conn->error);
}

$contractor = $result_contractor->fetch_assoc();

$sql_images = "SELECT file_path FROM jobImage WHERE service_id = $service_id";
$result_images = $conn->query($sql_images);

if ($result_images === false) {
    die('Error fetching images: ' . $conn->error);
}

$images = [];
while ($row = $result_images->fetch_assoc()) {
    $images[] = $row['file_path'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($service['service_title']); ?></title>
    <link rel="stylesheet" href="css/styles.css?v=1.4">
    <script src="js/mainJavaScript.js"></script>
</head>

<body>

    <?php include 'include/header.php'; ?>


    <main>
        <div class="product-details">
            <h1><?php echo htmlspecialchars($service['service_title']); ?></h1>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($service['category']); ?></p>
            <p><strong>Created at:</strong> <?php echo date('F j, Y', strtotime($service['created_at'])); ?></p>

            <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($service['service_description'])); ?></p>
            <p><strong>Price:</strong> NPr. <?php echo number_format($service['price'], 2); ?></p>

            <div class="product-images">
                <h3>Service Images:</h3>
                <?php if (count($images) > 0): ?>
                    <div class="image-gallery">
                        <?php foreach ($images as $image): ?>
                            <div class="image-item">
                                <img src="<?php echo htmlspecialchars($image); ?>" alt="Service Image" class="product-img">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No images available for this service.</p>
                <?php endif; ?>
            </div>
            <p><strong>Status:</strong> Pending Approval</p>
            <p>This service is pending approval and cannot be purchased at the moment.</p>

            <!-- Contractor Information Section -->
            <div class="contractor-details">
                <h3>Contractor Information:</h3>
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($contractor['fullname']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($contractor['email']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($contractor['mobile_number']); ?></p>
                <p><strong>Billing Location:</strong> <?php echo htmlspecialchars($contractor['billing_location'] ?? 'Not Available'); ?></p>
            </div>


        </div>
    </main>

    <?php include 'include/footer.php'; ?>

</body>

</html>