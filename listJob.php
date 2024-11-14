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
    <title>List a Job &#128296;</title>
    <link rel="stylesheet" href="css/styles.css?v=1.5">
    <script src="js/mainJavaScript.js" defer></script>
</head>

<body>
    <?php include 'include/header.php'; ?>

    <main class="listProduct">
        <h2>Post a New Job</h2>
        <form action="listJobProcessing.php" method="POST" enctype="multipart/form-data" onsubmit="validateListForm(event)">
            <table>
                <tr>
                    <td><label for="serviceTitle">Job Title:</label></td>
                    <td><input type="text" id="serviceTitle" name="serviceTitle" class="inputText" required></td>
                </tr>

                <tr>
                    <td><label for="serviceDescription">Job Description:</label></td>
                    <td><textarea id="serviceDescription" name="serviceDescription" class="inputText" rows="4" required></textarea></td>
                </tr>

                <tr>
                    <td><label for="category">Category:</label></td>
                    <td>
                        <select id="category" name="category" class="inputText" required>
                            <option value="">Select Category</option>
                            <option value="contracting">Contracting</option>
                            <option value="bricklaying">Bricklaying</option>
                            <option value="plumbing">Plumbing</option>
                            <option value="carpenter">Carpenter</option>
                            <option value="electrician">Electrician</option>
                            <option value="painter">Painter</option>
                            <option value="steel_worker">Steel Worker</option>
                            <option value="labourer">Labourer</option>
                            <option value="interior_designer">Interior Designer</option>
                            <option value="building_inspection">Building Inspection</option>
                            <option value="qa_inspection">QA Inspection</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><label for="price">Price:</label></td>
                    <td><input type="number" id="price" name="price" step="100" class="inputText" required min="500"></td>
                </tr>

                <tr>
                    <td><label for="images">Upload Images (Max 5):</label></td>
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