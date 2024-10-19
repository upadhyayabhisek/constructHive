<?php
include_once 'include/sessionStart.php';

if (isset($_SESSION['userID'])) {
    header("Location: homepage.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="css/styles.css?v=1.1">
    <script src="js/mainJavaScript.js" defer></script>
</head>

<body>

</body>

</html>