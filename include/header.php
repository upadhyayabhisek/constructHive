<?php
$isLoggedIn = isset($_SESSION['userID']);
$isSeller = ($_SESSION['userType'] ?? '') !== 'customer';
?>

<header class="header">
    <div class="logo">
        <a href="homepage.php">
            <img src="images/logo.png" alt="Company Logo">
        </a>
    </div>

    <div class="searchBox">
        <!-- Form that will submit the search query -->
        <form action="homepage.php" method="get">
            <input type="text" name="search" class="searchInput" placeholder="Search..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
        </form>
    </div>

    <div class="buttonContainer">
        <?php if ($isLoggedIn): ?>
            <!-- logged in -->
            <button class="button"><?php echo htmlspecialchars($_SESSION['fullName']); ?></button>

            <?php if ($isSeller): ?>
                <!-- seller -->
                <a href="listJob.php" class="button">Post a Job</a>
            <?php else: ?>
                <!-- not seller -->
                <a href="sellerRegister.php" class="button">Become a Contractor</a>
            <?php endif; ?>

            <a href="include/logout.php" class="button">Logout</a>

        <?php else: ?>
            <!-- not logged in -->
            <a href="loginPage.php" class="button">Login</a>
            <a href="registerPage.php" class="button">Signup</a>
        <?php endif; ?>
    </div>
</header>