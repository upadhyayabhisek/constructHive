<?php
session_start();
$isLoggedIn = isset($_SESSION['userID']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="css/styles.css?v=1.1">
    <script src="js/mainJavaScript.js" defer></script>
</head>

<body>

    <?php include 'include/header.php'; ?>

    <main>
        <?php if ($isLoggedIn): ?>
            <p>Welcome, User ID: <?php echo htmlspecialchars($_SESSION['userID']); ?></p>
            <a href="include/logout.php">Logout</a>
        <?php else: ?>
            <p>Please <a href="login.php">login</a>.</p>
        <?php endif; ?>
    </main>

    <?php include 'include/footer.php'; ?>

</body>

</html>