<?php
include_once 'include/sessionStart.php';

if (!isset($_SESSION['userID'])) {
    header("Location: homepage.php");
    exit();
}

if ($_SESSION['userType'] == 'customer_seller') {
    header("Location: listJob.php");
    exit();
}
$fullName = $_SESSION['fullName'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css?v=1.3">
    <script src="js/mainJavaScript.js" defer></script>
</head>
<?php include 'include/header.php'; ?>

<div class="sellerRegistration">
    <h2>Welcome, <?php echo htmlspecialchars($fullName); ?>! Please complete your seller registration, to start listing jobs!</h2>

    <form action="sellerRegistrationFormProcessing.php" method="post" class="sellerForm" accept-charset="UTF-8" onsubmit="validateSellerForm(event)">
        <table class="sellerRegisterTable">
            <tr>
                <td><label for="businessName">Business Name (optional):</label></td>
                <td><input type="text" id="businessName" name="businessName" class="inputText" placeholder="Enter your business name"></td>
            </tr>

            <tr>
                <td><label for="yearsExperience">Years of Experience (required):</label></td>
                <td><input type="number" id="yearsExperience" name="yearsExperience" class="inputText" required placeholder="Enter years of experience"></td>
            </tr>

            <tr>
                <td><label for="expertiseArea">Area of Expertise (required):</label></td>
                <td>
                    <label>
                        <input type="checkbox" name="expertiseArea[]" value="General Contracting" class="inputText"> General Contracting
                    </label><br>
                    <label>
                        <input type="checkbox" name="expertiseArea[]" value="Bricklayer" class="inputText"> Bricklayer
                    </label><br>
                    <label>
                        <input type="checkbox" name="expertiseArea[]" value="Plumber" class="inputText"> Plumber
                    </label><br>
                    <label>
                        <input type="checkbox" name="expertiseArea[]" value="Carpenter" class="inputText"> Carpenter
                    </label><br>
                    <label>
                        <input type="checkbox" name="expertiseArea[]" value="Electricians" class="inputText"> Electricians
                    </label><br>
                    <label>
                        <input type="checkbox" name="expertiseArea[]" value="Painter" class="inputText"> Painter
                    </label><br>
                    <label>
                        <input type="checkbox" name="expertiseArea[]" value="Steel Workers" class="inputText"> Steel Workers
                    </label><br>
                    <label>
                        <input type="checkbox" name="expertiseArea[]" value="Interior Designers" class="inputText"> Interior Designers
                    </label><br>
                    <label>
                        <input type="checkbox" name="expertiseArea[]" value="Landscapers" class="inputText"> Landscapers
                    </label><br>
                    <label>
                        <input type="checkbox" name="expertiseArea[]" value="Building Inspectors" class="inputText"> Building Inspectors
                    </label><br>
                    <label>
                        <input type="checkbox" name="expertiseArea[]" value="QA Inspectors" class="inputText"> QA Inspectors
                    </label><br>
                </td>
            </tr>

            <tr>
                <td><label for="certifications">Certifications (optional):</label></td>
                <td><textarea id="certifications" name="certifications" class="inputText" placeholder="Enter details"></textarea></td>
            </tr>

            <tr>
                <td><label for="panCardNumber">PAN Card Number (required):</label></td>
                <td><input type="text" id="panCardNumber" name="panCardNumber" class="inputText" required placeholder="Enter PAN card number"></td>
            </tr>

            <tr>
                <td><label for="billingLocation">Billing Location (required):</label></td>
                <td>
                    <input type="text" id="billingLocation" name="billingLocation" class="inputText" required placeholder="Enter billing address">
                    <input type="text" id="billingCity" name="billingCity" class="inputText" required placeholder="City">
                    <select id="billingProvince" name="billingProvince" class="inputText" required>
                        <option value="" disabled selected>Select your province</option>
                        <option value="koshiProvince">Koshi Province</option>
                        <option value="madeshProvince">Madesh Province</option>
                        <option value="bagmatiProvince">Bagmati Province</option>
                        <option value="gandakiProvince">Gandaki Province</option>
                        <option value="lumbiniProvince">Lumbini Province</option>
                        <option value="karnaliProvince">Karnali Province</option>
                        <option value="sudurpashchimProvince">Sudurpashchim Province</option>
                    </select><br>
                </td>
            </tr>


            <tr>
                <td colspan="2">
                    <button type="submit" class="submitBtn">Register as Seller</button>
                </td>
            </tr>
        </table>
    </form>
</div>
<?php include 'include/footer.php'; ?>

</html>