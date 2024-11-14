<?php
// Include session start and database connection
include_once 'include/sessionStart.php';
include_once 'include/databaseConnection.php';

// Query to fetch services and associated images from the database
$sql = "SELECT s.service_id, s.service_title, s.service_description, s.category, s.price, 
               ji.file_path AS image_path 
        FROM services s 
        LEFT JOIN jobImage ji ON s.service_id = ji.service_id
        WHERE s.approval = 'accepted'"; // Only show accepted services

$result = $conn->query($sql);  // Execute the query

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="css/styles.css?v=1.4">
    <script src="js/mainJavaScript.js" defer></script>
</head>

<body>

    <?php include 'include/header.php'; ?>
    <?php include 'include/categorySidebar.php'; ?>

    <main>
        <div class="product-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product-block">
                        <div class="product-image">
                            <!-- Display the image for the product -->
                            <?php if (!empty($row['image_path'])): ?>
                                <img src="<?php echo $row['image_path']; ?>" alt="<?php echo $row['service_title']; ?>" class="product-img">
                            <?php else: ?>
                                <img src="default-image.jpg" alt="Default Image" class="product-img"> <!-- Default image -->
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <h3><?php echo htmlspecialchars($row['service_title']); ?></h3>
                            <p class="product-description"><?php echo htmlspecialchars($row['service_description']); ?></p>
                            <!-- <p class="product-category">Category: <?php echo htmlspecialchars($row['category']); ?></p> -->
                            <p class="product-price">NPr. <?php echo number_format($row['price'], 2); ?></p>
                            <a href="viewProduct.php?service_id=<?php echo $row['service_id']; ?>" class="view-details-btn">View Details</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </main>

    <?php include 'include/footer.php'; ?>

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>