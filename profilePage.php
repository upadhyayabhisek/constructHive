<?php
include_once 'include/sessionStart.php';

// Ensure the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: homepage.php");
    exit();
}

// Get the user's type
$userType = $_SESSION['userType'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/profileStyles.css">
    <script src="js/mainJavaScript.js" defer></script>
</head>

<body>
    <?php include 'include/header.php'; ?>

    <h1 class="titleProfile">My profile</h1>

    <div class="container">
        <!-- Buttons Container -->
        <div class="buttons-container">
            <button onclick="showDiv('div1')">My Profile</button>
            <button onclick="showDiv('div2')">My Orders</button>

            <?php if ($userType == 'customer_seller'): ?>
                <button onclick="showDiv('div3')">My Services</button>
            <?php endif; ?>
        </div>

        <div id="div1" class="content-div">
            <h2>My Profile</h2>
            <p>This is the content for My Profile.</p>
        </div>

        <div id="div2" class="content-div">
            <h2>My Orders</h2>
            <p>This is the content for My Orders.</p>
        </div>

        <?php if ($userType == 'customer_seller'): ?>
            <div id="div3" class="content-div">
                <h2>My Services</h2>
                <p>This is the content for My Services.</p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>