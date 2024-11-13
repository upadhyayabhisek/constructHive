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
    <title>Login to Your Account</title>
    <link rel="stylesheet" href="css/styles.css?v=1.1">
    <script src="js/mainJavaScript.js" defer></script>
</head>

<body>

    <?php
    $error = isset($_GET['error']) ? $_GET['error'] : '';
    ?>

    <h2>Login to Your Account</h2>
    <div class="loginFormContainer">
        <?php if ($error === 'invalidCredentials'): ?>
            <p class="loginErrorMessage">Invalid email or password!</p>
        <?php endif; ?>


        <form action="loginProcessing.php" method="post" class="loginForm" accept-charset="UTF-8" onsubmit="validateLoginForm(event)">
            <table class="loginTable">
                <tr>
                    <td><label for="emailLogin">Email:</label></td>
                    <td><input type="email" id="emailLogin" name="emailLogin" class="inputText" required></td>
                </tr>
                <tr>
                    <td><label for="passwordLogin">Password:</label></td>
                    <td>
                        <input type="password" id="passwordLogin" name="passwordLogin" class="inputText" required>
                        <img id="togglePasswordLogin" src="images/bxs-brush.svg" alt="Toggle Password Visibility" class="passwordToggleImage" onclick="toggleLoginPasswordVisibility()">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <input type="submit" value="Login" class="submitButton">
                    </td>
                </tr>
            </table>
        </form>
    </div>

</body>

</html>