<?php
include_once 'include/sessionStart.php';
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

        <?php
        echo    $_SESSION['userID'];
        echo    $_SESSION['fullName'];
        echo    $_SESSION['userType'];

        ?>
    </main>


    <?php include 'include/footer.php'; ?>

</body>

</html>