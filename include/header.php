<?php
$isLoggedIn = isset($_SESSION['userID']);
$isSeller = ($_SESSION['userType'] ?? '') !== 'customer';
$isAdmin = ($_SESSION['role'] ?? '') === 'admin';
?>

<header class="header">
    <div class="logo">
        <a href="<?php echo $isAdmin ? 'adminDashboard.php' : 'homepage.php'; ?>">
            <img src="images/logo.png" alt="Company Logo">
        </a>
    </div>

    <?php if (!$isAdmin): ?>
        <div class="searchBox">
            <form action="homepage.php" method="get">
                <input type="text" name="search" class="searchInput" placeholder="Search..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            </form>
        </div>
    <?php endif; ?>

    <?php if ($isAdmin): ?>
        <a href="homepage.php" style="display: inline-block; text-decoration: none;">
            <img src="images/bxs-home.svg" alt="homePage" style="width: 40px; height: 40px; margin:10px;" />
        </a>
    <?php endif; ?>

    <div class="buttonContainer">
        <?php if ($isLoggedIn): ?>
            <button class="button" onclick="window.location.href='profilePage.php';">
                <?php echo htmlspecialchars($_SESSION['fullName']); ?>
            </button>

            <?php if ($isSeller && !$isAdmin): ?>
                <a href="listJob.php" class="button">Post a Job</a>
            <?php elseif (!$isSeller && !$isAdmin): ?>
                <a href="sellerRegister.php" class="button">Become a Contractor</a>
            <?php endif; ?>

            <?php if ($isAdmin): ?>
                <button class="button" onclick="toggleSection('manageUsers')">Manage Users</button>
                <button class="button" onclick="toggleSection('managePendingJobs')">Manage Pending Jobs</button>
                <button class="button" onclick="toggleSection('contractorInformation')">Contractor Information</button>
            <?php endif; ?>
            <a href="include/logout.php" class="button">Logout</a>

        <?php else: ?>
            <a href="loginPage.php" class="button">Login</a>
            <a href="registerPage.php" class="button">Signup</a>
        <?php endif; ?>
    </div>
</header>