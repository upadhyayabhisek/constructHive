<?php
include_once 'include/sessionStart.php';
include_once 'include/databaseConnection.php';

if (!isset($_SESSION['userID']) || $_SESSION['role'] != 'admin') {
    header("Location: homepage.php");
    exit();
}

if (isset($_POST['promote_user'])) {
    $userId = $_POST['user_id'];
    $sql = "UPDATE userbase SET role = 'admin' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        echo "User has been promoted to admin!";
    } else {
        echo "Failed to promote user.";
    }
}

if (isset($_POST['ban_user'])) {
    $userId = $_POST['user_id'];
    $sql = "DELETE FROM userbase WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        echo "User has been banned (deleted)!";
    } else {
        echo "Failed to ban user.";
    }
}

$sqlUsers = "SELECT id, fullname, email, role FROM userbase WHERE role != 'admin'";
$usersResult = $conn->query($sqlUsers);

$sqlJobs = "SELECT s.service_id, s.service_title, s.service_description, s.price, s.approval, u.fullname, u.email 
            FROM services s
            JOIN userbase u ON s.user_id = u.id
            WHERE s.approval = 'pending'";
$jobsResult = $conn->query($sqlJobs);

if (isset($_POST['approve_job'])) {
    $serviceId = $_POST['service_id'];
    $updateQuery = "UPDATE services SET approval = 'accepted' WHERE service_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $serviceId);
    $stmt->execute();
    header("Location: adminDashboard.php");
    exit();
}


if (isset($_POST['reject_job'])) {
    $serviceId = $_POST['service_id'];
    $updateQuery = "UPDATE services SET approval = 'rejected' WHERE service_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("i", $serviceId);
    $stmt->execute();
    header("Location: adminDashboard.php");
    exit();
}


$sql_contractors = "
    SELECT u.id AS user_id, u.fullname, u.email, u.mobile_number, ci.business_name, ci.years_of_experience, 
           ci.area_of_expertise, ci.certifications, ci.billing_location, ci.billing_city, ci.billing_province
    FROM userbase u
    LEFT JOIN contractorInformation ci ON u.id = ci.userbase_id
    WHERE u.user_type = 'customer_seller' AND u.role = 'customer'
";

$result_contractors = $conn->query($sql_contractors);
if ($result_contractors === false) {
    die('Error fetching contractor information: ' . $conn->error);
}

$contractors = [];
while ($row = $result_contractors->fetch_assoc()) {
    $contractors[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/profileStyles.css">
    <link rel="stylesheet" href="css/adminPage.css">
</head>

<body>
    <?php include 'include/header.php'; ?>

    <main class="main-container">
        <div id="manageUsers" class="adminSection">
            <h2>Manage Users</h2>
            <p>Here you can view and manage all users in the system.</p>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $usersResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo $user['role']; ?></td>
                            <td>

                                <?php if ($user['role'] != 'admin'): ?>
                                    <form action="adminDashboard.php" method="post" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" name="promote_user" class="button">Promote to Admin</button>
                                    </form>
                                <?php endif; ?>

                                <form action="adminDashboard.php" method="post" style="display:inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" name="ban_user" class="button" onclick="return confirm('Are you sure you want to ban (delete) this user?')">Ban (Delete)</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div id="managePendingJobs" class="adminSection">
            <h2>Manage Pending Jobs</h2>
            <p>Here you can view and approve or reject pending jobs posted by users.</p>

            <table>
                <thead>
                    <tr>
                        <th>Service ID</th>
                        <th>Service Title</th>
                        <th>Service Description</th>
                        <th>Price</th>
                        <th>User</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($job = $jobsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $job['service_id']; ?></td>
                            <td><?php echo htmlspecialchars($job['service_title']); ?></td>
                            <td><?php echo htmlspecialchars($job['service_description']); ?></td>
                            <td><?php echo htmlspecialchars($job['price']); ?></td>
                            <td><?php echo htmlspecialchars($job['fullname']) . ' (' . htmlspecialchars($job['email']) . ')'; ?></td>
                            <td>

                                <form action="adminDashboard.php" method="post" style="display:inline;">
                                    <input type="hidden" name="service_id" value="<?php echo $job['service_id']; ?>">
                                    <button type="submit" name="approve_job" class="button">Approve</button>
                                </form>

                                <form action="adminDashboard.php" method="post" style="display:inline;">
                                    <input type="hidden" name="service_id" value="<?php echo $job['service_id']; ?>">
                                    <button type="submit" name="reject_job" class="button" onclick="return confirm('Are you sure you want to reject this job?')">Reject</button>
                                </form>

                                <form action="viewProductDemo.php" method="get" style="display:inline;">
                                    <input type="hidden" name="service_id" value="<?php echo $job['service_id']; ?>">
                                    <button type="submit" class="button">View Product</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Contractor Information Section -->
        <div id="contractorInformation" class="adminSection">
            <h2>Contractor Information</h2>
            <p>View contractor details including business information, certifications, and more.</p>

            <?php if (count($contractors) > 0): ?>
                <div class="contractorInformation">
                    <?php foreach ($contractors as $contractor): ?>
                        <div class="contractor-card">
                            <h3><?php echo htmlspecialchars($contractor['fullname']); ?></h3>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($contractor['email']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($contractor['mobile_number']); ?></p>
                            <p><strong>Business Name:</strong>
                                <?php echo htmlspecialchars($contractor['business_name'] ?? '<span class="not-available">Not Available</span>'); ?>
                            </p>
                            <p><strong>Years of Experience:</strong>
                                <?php echo htmlspecialchars($contractor['years_of_experience']); ?> years
                            </p>
                            <p><strong>Area of Expertise:</strong> <?php echo htmlspecialchars($contractor['area_of_expertise']); ?></p>
                            <p><strong>Certifications:</strong>
                                <?php echo nl2br(htmlspecialchars($contractor['certifications'] ?? '<span class="not-available">Not Available</span>')); ?>
                            </p>
                            <p><strong>Billing Location:</strong>
                                <?php echo htmlspecialchars($contractor['billing_location'] ?? '<span class="not-available">Not Available</span>'); ?>
                            </p>
                            <p><strong>City:</strong>
                                <?php echo htmlspecialchars($contractor['billing_city'] ?? '<span class="not-available">Not Available</span>'); ?>
                            </p>
                            <p><strong>Province:</strong>
                                <?php echo htmlspecialchars($contractor['billing_province'] ?? '<span class="not-available">Not Available</span>'); ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No contractors found.</p>
            <?php endif; ?>
        </div>
    </main>
    <script>
        function toggleSection(sectionId) {
            const sections = document.querySelectorAll('.adminSection');
            sections.forEach(function(section) {
                section.style.display = 'none';
            });
            const selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.style.display = 'block';
            }
        }
    </script>
</body>

</html>