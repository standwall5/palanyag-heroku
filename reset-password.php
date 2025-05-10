<?php

require 'db.php';

$token = $_GET['token'];

$token_hash = hash("sha256", $token);

$sql = "SELECT * FROM users WHERE reset_token_hash = :token";
$stmt = $pdo->prepare($sql);
$stmt->execute(['token' => $token_hash]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user === null) {
    die("token not found");
}

if (strtotime($user['reset_token_expires_at']) <= time()) {
    die("token has expired");
}

echo "token is valid and hasn't expired.";
?>