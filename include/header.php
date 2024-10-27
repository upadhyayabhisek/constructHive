<?php
session_start();
$isLoggedIn = isset($_SESSION['userID']);
?>


<header class="header">
    <div class="logo">
        <a href="homepage.php">
            <img src="images/logo.png" alt="Company Logo">
        </a>
    </div>

    <div class="searchBox">
        <input type="text" class="searchInput" placeholder="Search...">
    </div>

    <div class="buttonContainer">
        <?php if ($isLoggedIn): ?>
            <button class="button"><?php echo htmlspecialchars($_SESSION['fullName']); ?></button>
            <button class="button">List a Job</button>
            <button class="button"><a href="include/logout.php" class="link">Logout</a></button>
        <?php else: ?>
            <button class="button"><a href="loginPage.php" class="link">Login</a></button>
            <button class="button"><a href="registerPage.php" class="link">Signup</a></button>
        <?php endif; ?>
    </div>


</header>