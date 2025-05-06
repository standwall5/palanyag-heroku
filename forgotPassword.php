<?php
require 'db.php';

$email = trim($_POST["email"]);

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30); // times() seconds in 30 minutes

try {
    $sql = "UPDATE users SET reset_token_hash = :token, reset_token_expires_at = :expiry WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['token' => $token_hash, 'expiry' => $expiry, 'email' => $email]);    
    
    if ($stmt->rowCount() === 0) {
        // No rows updated, possibly invalid email
        echo "No user found with that email.";
        // exit;
    } else {
        // email $token to the user here
        echo 'successfully changed token';
    }
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage()); // Logs to the PHP error log
    echo "An error occurred. Please try again later."; // Optional user-facing message
}
?>