<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register an Account</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/website_JavaScript.js" defer></script>
</head>

<body>

    <?php
    include 'include/header.php';
    ?>

    <h2>Register an Account</h2>
    <div class="formContainer">
        <form action="registerProcessing.php" method="post" class="registrationForm" accept-charset="UTF-8" onsubmit="validateForm(event)">
            <table class="registrationTable">
                <tr>
                    <td><label for="name">Name:</label></td>
                    <td><input type="text" id="name" name="name" class="inputText" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email" class="inputText" required></td>
                </tr>
                <tr>
                    <td><label for="phone">Phone Number:</label></td>
                    <td><input type="tel" id="phone" name="phone" class="inputText" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" id="password" name="password" class="inputText" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <input type="submit" value="Register" class="submitButton">
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <?php
    include 'include/footer.php';
    ?>

</body>

</html>