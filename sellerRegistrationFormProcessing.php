<?php
include_once 'include/databaseConnection.php';
include_once 'include/sessionStart.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $businessName    = mysqli_real_escape_string($conn, trim($_POST['businessName']));
    $yearsExperience = mysqli_real_escape_string($conn, trim($_POST['yearsExperience']));
    $expertiseArea   = array_map('trim', $_POST['expertiseArea']);
    $expertiseAreaSerialized = mysqli_real_escape_string($conn, implode(", ", $expertiseArea));
    $certifications  = mysqli_real_escape_string($conn, trim($_POST['certifications']));
    $panCardNumber   = mysqli_real_escape_string($conn, trim($_POST['panCardNumber']));
    $billingLocation = mysqli_real_escape_string($conn, trim($_POST['billingLocation']));
    $billingCity     = mysqli_real_escape_string($conn, trim($_POST['billingCity']));
    $billingProvince = mysqli_real_escape_string($conn, trim($_POST['billingProvince']));

    if (empty($yearsExperience) || empty($expertiseArea) || empty($panCardNumber)) {
        header("Location: sellerRegister.php");
        exit();
    }

    $userID = $_SESSION['userID'];

    $insertContractorQuery = "
        INSERT INTO contractorInformation 
        (userbase_id, business_name, years_of_experience, area_of_expertise, certifications, 
         billing_location, billing_city, billing_province)
        VALUES ('$userID', '$businessName', '$yearsExperience', '$expertiseAreaSerialized', '$certifications', 
                '$billingLocation', '$billingCity', '$billingProvince')
    ";


    if ($conn->query($insertContractorQuery)) {

        $_SESSION['userType'] = 'customer_seller';

        $updateRoleQuery = "
            UPDATE userbase 
            SET user_type = 'customer_seller' 
            WHERE id = '$userID'
        ";

        if ($conn->query($updateRoleQuery)) {
            header("Location: listJob.php");
            exit();
        } else {
            error_log("Error updating role_type for user ID: $userID: " . $conn->error . "\n", 3, __DIR__ . "/log/Contractor_Form.log");
            die('Error updating role_type: ' . $conn->error);
        }
    } else {
        error_log("Error inserting contractor data for user ID: $userID: " . $conn->error . "\n", 3, __DIR__ . "/log/Contractor_Form.log");
        header("Location: sellerRegister.php");
        exit();
    }
} else {
    echo "Invalid request.";
}
