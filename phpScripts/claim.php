<?php

require './db.php';

// Get JSON input sent from JavaScript
$input = json_decode(file_get_contents('php://input'), true);

// Check if data was received properly
if (isset($input['userId']) && isset($input['deceasedid'])) {
    $userId = $input['userId'];
    $deceasedId = $input['deceasedid'];

    try {
        $sql = "INSERT INTO lovedones (userid, deceasedid) VALUES (:userid, :deceasedid)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['userid' => $userId, 'deceasedid' => $deceasedId]);

        if ($stmt->rowCount() > 0) {
            $response = [
                "message" => 'Loved one successfully claimed.'
            ];
        } else {
            $response = [
                "message" => 'Error occurred, please try again.'
            ];
        }
    } catch (PDOException $e) {
        $response = [
            "message" => 'Database error: ' . $e->getMessage()
        ];
    }
} else {
    $response = [
        "message" => 'Invalid input data.'
    ];
}

// Return JSON response to JavaScript
header('Content-Type: application/json');
echo json_encode($response);
?>