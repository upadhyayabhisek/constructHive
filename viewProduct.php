<?php
include_once 'include/sessionStart.php';
include_once 'include/databaseConnection.php';
$isLoggedIn = isset($_SESSION['userId']);
if (!isset($_GET['service_id']) || !is_numeric($_GET['service_id'])) {
    header('Location: homepage.php');
    exit();
}

$service_id = (int) $_GET['service_id'];
$sql_service = "
    SELECT s.service_id, s.service_title, s.service_description, s.category, s.price, 
           s.created_at, s.user_id, u.fullname
    FROM services s
    LEFT JOIN userbase u ON s.user_id = u.id
    WHERE s.service_id = $service_id AND s.approval = 'accepted'
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

$sql_contractor = "
    SELECT ci.business_name, ci.years_of_experience, ci.certifications
    FROM contractorInformation ci
    WHERE ci.userbase_id = " . $service['user_id'];

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
    <?php include 'include/categorySidebar.php'; ?>


    <main>
        <div class="product-details">
            <h1><?php echo htmlspecialchars($service['service_title']); ?></h1>
            <p><strong>Category:</strong> <?php echo htmlspecialchars($service['category']); ?></p>
            <p><strong>Posted by:</strong> <?php echo htmlspecialchars($service['fullname']); ?> (User ID: <?php echo htmlspecialchars($service['user_id']); ?>)</p>
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

            <div class="contractor-details">
                <h3>Contractor Information:</h3>
                <p><strong>Business Name:</strong> <?php echo htmlspecialchars($contractor['business_name'] ?? 'Not Available'); ?></p>
                <p><strong>Years of Experience:</strong> <?php echo htmlspecialchars($contractor['years_of_experience']); ?> years</p>
                <p><strong>Certifications:</strong> <?php echo nl2br(htmlspecialchars($contractor['certifications'] ?? 'No certifications provided')); ?></p>
            </div>

            <?php if ($isLoggedIn): ?>

                <a href="viewProductBuyProcessing.php?service_id=<?php echo $service_id; ?>"
                    class="button"
                    onclick="return confirmPurchase();">
                    Buy service
                </a>
            <?php else: ?>
                <a href="loginPage.php" class="button">
                    Please log in to buy service
                </a>
            <?php endif; ?>


        </div>
    </main>


    <?php include 'include/footer.php'; ?>

</body>

</html>