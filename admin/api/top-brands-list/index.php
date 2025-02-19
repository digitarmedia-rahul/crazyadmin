<?php

// Allow only the same origin (Change to your domain)
$allowedOrigin = ["localhost"]; // Example: https://crazzyoffer.in

// Check if the request has an Origin header
if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $allowedOrigin)) {
    http_response_code(403); // Forbidden
    echo json_encode(["error" => "Access denied: Invalid origin"]);
    exit;
}
$indexOrigin =array_search($_SERVER['HTTP_HOST'], $allowedOrigin);
// Set headers for CORS (Allow only the same origin)
header("Access-Control-Allow-Origin: $allowedOrigin[$indexOrigin]");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Allow only GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Only GET requests are allowed"]);
    exit;
}

// Secure database connection
$mysqli = new mysqli("localhost", "root", "", "crazy_db");

// Check for database connection error
if ($mysqli->connect_error) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Server error"]);
    exit;
}

// Set charset to UTF-8
$mysqli->set_charset("utf8");

// Prepare secure query (Prevents SQL injection)
$stmt = $mysqli->prepare("SELECT brand_name as 'brand-name', image_url as 'Icon-URL', priority as 'view-priority' FROM `top_brand_list` WHERE status = 1");
$stmt->execute();
$result = $stmt->get_result();

$response = [];
while ($row = $result->fetch_assoc()) {
    $response[] = $row;
}

// Close the database connection
$stmt->close();
$mysqli->close();

// Return JSON response
if (!empty($response)) {
    http_response_code(200); // OK
    echo json_encode($response);
} else {
    http_response_code(404); // Not Found
    echo json_encode(["error" => "No data found"]);
}

exit;

?>
