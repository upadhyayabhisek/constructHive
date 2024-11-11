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
    <link rel="stylesheet" href="css/styles.css?v=1.2">
    <script src="js/mainJavaScript.js" defer></script>
</head>

<body>
    <?php include 'include/header.php'; ?>

    <main class="listProduct">
        <h2>Post a New Service</h2>
        <form action="submitService.php" method="POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <td><label for="serviceTitle">Service Title:</label></td>
                    <td><input type="text" id="serviceTitle" name="serviceTitle" class="inputText" required></td>
                </tr>

                <tr>
                    <td><label for="serviceDescription">Service Description:</label></td>
                    <td><textarea id="serviceDescription" name="serviceDescription" class="inputText" rows="4" required></textarea></td>
                </tr>

                <tr>
                    <td><label for="category">Category:</label></td>
                    <td><input type="text" id="category" name="category" class="inputText"></td>
                </tr>

                <tr>
                    <td><label for="price">Price:</label></td>
                    <td><input type="number" id="price" name="price" step="0.01" class="inputText" required></td>
                </tr>

                <tr>
                    <td><label for="images">Upload Images:</label></td>
                    <td><input type="file" id="images" name="images[]" class="inputFile" multiple></td>
                </tr>

                <tr style="display: none;">
                    <td><input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['userID']); ?>"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" name="submit">Post Service</button>
                    </td>
                </tr>
            </table>
        </form>
    </main>

    <?php include 'include/footer.php'; ?>
</body>

</html>