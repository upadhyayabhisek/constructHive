<?php
include_once 'include/sessionStart.php';
include_once 'include/databaseConnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $serviceTitle = htmlspecialchars($_POST['serviceTitle']);
    $serviceDescription = nl2br(htmlspecialchars($_POST['serviceDescription']));
    $category = htmlspecialchars($_POST['category']);
    $price = htmlspecialchars($_POST['price']);
    $userID = $_SESSION['userID'];

    $stmt = $conn->prepare("INSERT INTO services (user_id, service_title, service_description, category, price) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssd", $userID, $serviceTitle, $serviceDescription, $category, $price);
    if ($stmt->execute()) {
        $serviceID = $stmt->insert_id;
        echo "<p>Service posted successfully with ID: " . $serviceID . "</p>";
    } else {
        echo "<p>Error inserting service: " . $conn->error . "</p>";
    }

    $uploadDirectory = "uploadsJobs/";
    $uploadedFiles = [];

    if (!file_exists($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    if (isset($_FILES['images']) && count($_FILES['images']['name']) > 0) {
        for ($i = 0; $i < count($_FILES['images']['name']); $i++) {
            $fileName = $_FILES['images']['name'][$i];
            $fileTmpName = $_FILES['images']['tmp_name'][$i];
            $fileError = $_FILES['images']['error'][$i];
            $fileSize = $_FILES['images']['size'][$i];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileExt, $allowedExtensions)) {
                $newFileName = uniqid('', true) . "." . $fileExt;
                $fileDestination = $uploadDirectory . $newFileName;

                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $stmt = $conn->prepare("INSERT INTO jobImage (service_id, user_id, file_path) 
                                           VALUES (?, ?, ?)");
                    $stmt->bind_param("iis", $serviceID, $userID, $fileDestination);
                    if ($stmt->execute()) {
                        $uploadedFiles[] = $fileDestination;
                        echo "<p>File " . ($i + 1) . " uploaded and path saved in database: " . $fileDestination . "</p>";
                        header("Location: homepage.php");
                    } else {
                        echo "<p>Error saving file path in the database: " . $conn->error . "</p>";
                    }
                } else {
                    echo "<p>Error uploading file " . ($i + 1) . ": " . $fileName . "</p>";
                }
            } else {
                echo "<p>File " . ($i + 1) . ": " . $fileName . " is not a valid image type.</p>";
            }
        }
    } else {
        echo "<p>No images were uploaded.</p>";
    }
} else {
    echo "<p>No data submitted.</p>";
}
$conn->close();
