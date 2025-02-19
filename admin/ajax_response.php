<?php
if (empty($_POST) || !isset($_POST['location']) || empty($_POST['location'])) {
    echo json_encode(['error' => true, 'msg' => 'Ajax Call in Wrong way...']);
}

include('login_check.php');
include_once 'includes/general.class.php';
$general = new General;
$general->set_connection($mysqli);
$admin_name = $_SESSION['ADMIN_USERNAME'];
$location = $_POST['location'];
$target = $_POST['target'];
date_default_timezone_set('Asia/Kolkata');
switch ($location) {
    case 'manage-bob.php':
        if ($target == 'replaceIMGbrand') {
            $uploadDir = "uploads/bob"; 
            // Ensure the uploads directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Check if file and redirect link are provided
            if (!isset($_FILES["imageURL"]) || !isset($_POST["redirectLink"])) {
                echo json_encode(["error" => true, "msg" => "Missing required data!"]);
                exit;
            }

            $redirectLink = $_POST["redirectLink"];
            $image = $_FILES["imageURL"];

            // Validate URL
            if (!filter_var($redirectLink, FILTER_VALIDATE_URL)) {
                echo json_encode(["error" => true, "msg" => "Invalid URL format!"]);
                exit;
            }

            // Validate file type
            $allowedTypes = ["jpg", "jpeg", "png"];
            $fileExtension = strtolower(pathinfo($image["name"], PATHINFO_EXTENSION));

            if (!in_array($fileExtension, $allowedTypes)) {
                echo json_encode(["error" => true, "msg" => "Only JPG, JPEG, and PNG files are allowed!"]);
                exit;
            }

            // Move file to uploads directory
            $newFileName = uniqid("IMG_") . "." . $fileExtension;
            $targetFile = $uploadDir . $newFileName;

            if (move_uploaded_file($image["tmp_name"], $targetFile)) {
                $output= json_encode([
                    "error" => false,
                    "msg" => "File uploaded successfully!",
                    "imagePath" => "http://148.135.136.15/crazyadmin/admin".$targetFile,
                    "redirectLink" => $redirectLink
                ]);
            } else {
                echo json_encode(["error" => true, "msg" => "File upload failed!"]);
            }

            $q = "INSERT INTO best_of_brands_img (brand_id, heading, card_img, redirect, created_by, created_at) VALUES ('" . trim($_POST['brand']) . "', '" . trim($_POST['heading']) . "', '" . $carouselLink . "', '" . $redirectLink . "', '" . $_SESSION['ADMINUSERID'] . "', '" . date('Y-m-d H:i:s') . "')";
            $mysqli->query($q);
            $mysqli->close();
            echo $output;
        }
        break;
    default:
    $mysqli->close();
}
