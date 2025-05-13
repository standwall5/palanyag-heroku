<?php
session_start();
$fullName  = $_SESSION['name'];
$nameParts = explode(" ", $fullName);

// Get the first two words (if available)
if (count($nameParts) === 3) {
    $shortName = $nameParts[0] . " " . $nameParts[1]; // Get only the first two words
} else {
    $shortName = $fullName; // Keep the original name if it's not exactly 3 words
}

  $response = [
    "shortName" => $shortName,
    "userId" => $_SESSION['user_id']
];

header('Content-Type: application/json');
echo json_encode($response);