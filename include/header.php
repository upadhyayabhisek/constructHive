<?php
$isLoggedIn = isset($_SESSION['userID']);
$isSeller = ($_SESSION['userType'] ?? '') !== 'customer';  // Check if the user is a seller
$isAdmin = ($_SESSION['role'] ?? '') === 'admin'; // Check if the user is an admin
?>

<header class="header">
    <!-- Logo that redirects based on user role -->
    <div class="logo">
        <a href="<?php echo $isAdmin ? 'adminDashboard.php' : 'homepage.php'; ?>">
            <img src="images/logo.png" alt="Company Logo">
        </a>
    </div>

    <?php if (!$isAdmin): ?> <!-- Only show the search bar if the user is not an admin -->
        <div class="searchBox">
            <form action="homepage.php" method="get">
                <input type="text" name="search" class="searchInput" placeholder="Search..." value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
            </form>
        </div>
    <?php endif; ?>

    <div class="buttonContainer">
        <?php if ($isLoggedIn): ?>
            <!-- User Profile Button -->
            <button class="button" onclick="window.location.href='profilePage.php';">
                <?php echo htmlspecialchars($_SESSION['fullName']); ?>
            </button>

            <?php if ($isSeller && !$isAdmin): ?>
                <!-- For Sellers who are not admins -->
                <a href="listJob.php" class="button">Post a Job</a>
            <?php elseif (!$isSeller && !$isAdmin): ?>
                <!-- For users who are not sellers or admins -->
                <a href="sellerRegister.php" class="button">Become a Contractor</a>
            <?php endif; ?>

            <?php if ($isAdmin): ?>
                <!-- Admin Buttons -->
                <button class="button" onclick="toggleSection('manageUsers')">Manage Users</button>
                <button class="button" onclick="toggleSection('managePendingJobs')">Manage Pending Jobs</button>
                <button class="button" onclick="toggleSection('contractorInformation')">Contractor Information</button>
            <?php endif; ?>

            <!-- Logout Button -->
            <a href="include/logout.php" class="button">Logout</a>

        <?php else: ?>
            <!-- For Users who are not logged in -->
            <a href="loginPage.php" class="button">Login</a>
            <a href="registerPage.php" class="button">Signup</a>
        <?php endif; ?>
    </div>
</header>