<?php
include_once 'include/databaseConnection.php';
include_once 'include/sessionStart.php';

// update session userType after processing if customer becomes a seller

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $businessName    = trim($_POST['businessName']);
    $yearsExperience = trim($_POST['yearsExperience']);
    $expertiseArea   = array_map('trim', $_POST['expertiseArea']);
    $certifications  = trim($_POST['certifications']);
    $panCardNumber   = trim($_POST['panCardNumber']);
    $billingLocation = trim($_POST['billingLocation']);
    $billingCity     = trim($_POST['billingCity']);
    $billingProvince = trim($_POST['billingProvince']);

    echo '<pre>';
    print_r($expertiseArea);
    echo '</pre>';
} else {
    echo "Invalid request.";
}
