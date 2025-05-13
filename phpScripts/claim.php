<?php
// Prevent any accidental output before headers
ob_start();

require './db.php';

header('Content-Type: application/json'); // Set header early

$response = []; // Default response

try {
    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate input
    if (isset($input['userId']) && isset($input['deceasedid'])) {
        $userId = $input['userId'];
        $deceasedId = $input['deceasedid'];

        // Insert into database
        $sql = "INSERT INTO lovedones (userid, deceasedid) VALUES (:userid, :deceasedid)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['userid' => $userId, 'deceasedid' => $deceasedId]);

        $response['message'] = ($stmt->rowCount() > 0)
            ? 'Loved one successfully claimed.'
            : 'Error occurred, please try again.';
    } else {
        $response['message'] = 'Invalid input data.';
    }
} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
}

// Return JSON response
echo json_encode($response);
ob_end_flush(); // End output buffering
?>