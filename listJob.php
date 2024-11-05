<?php
include_once 'include/sessionStart.php';

if (!isset($_SESSION['userID'])) {
    header("Location: homepage.php");
    exit();
}

if ($_SESSION['userType'] == 'customer') {
    header("Location: sellerRegister.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List a Job &#128296</title>
    <link rel="stylesheet" href="css/styles.css?v=1.1">
    <script src="js/mainJavaScript.js" defer></script>
</head>

<body>
    <?php include 'include/header.php'; ?>

    <main class="listProduct">
        <h2>List a Job!</h2>
    </main>

    <?php include 'include/footer.php'; ?>
</body>

</html>