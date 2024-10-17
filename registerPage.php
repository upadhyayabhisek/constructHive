<?php
include_once 'include/sessionStart.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register an Account</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/mainJavaScript.js" defer></script>
</head>

<body>

    <?php
    include 'include/header.php';

    $error = isset($_GET['error']) ? $_GET['error'] : '';
    ?>

    <h2>Register an Account</h2>
    <div class="formContainer">
        <?php if ($error === 'emailExists'): ?>
            <p style="color: red;">This email address is already registered!</p>
        <?php endif; ?>

        <form action="registerProcessing.php" method="post" class="registrationForm" accept-charset="UTF-8" onsubmit="validateForm(event)">
            <table class="registrationTable">
                <tr>
                    <td><label for="nameRegister">Name:</label></td>
                    <td><input type="text" id="nameRegister" name="nameRegister" class="inputText" required></td>
                </tr>
                <tr>
                    <td><label for="emailRegister">Email:</label></td>
                    <td><input type="email" id="emailRegister" name="emailRegister" class="inputText" required></td>
                </tr>
                <tr>
                    <td><label for="phoneRegister">Phone Number:</label></td>
                    <td><input type="tel" id="phoneRegister" name="phoneRegister" class="inputText" required></td>
                </tr>
                <tr>
                    <td><label for="passwordRegister">Password:</label></td>
                    <td>
                        <input type="password" id="passwordRegister" name="passwordRegister" class="inputText" required>
                        <img id="togglePassword" src="images/bxs-brush.svg" alt="Toggle Password Visibility" class="passwordToggleImage" onclick="togglePasswordVisibility()">
                    </td>
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