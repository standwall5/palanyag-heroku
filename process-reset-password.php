<?php

require 'db.php';

$token = $_POST['token'];
$password = $_POST['password'];
$repeatPassword = $_POST['repeat-password'];

$token_hash = hash("sha256", $token);

$sql = "SELECT * FROM users WHERE reset_token_hash = :token";
$stmt = $pdo->prepare($sql);
$stmt->execute(['token' => $token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user === null) {
    die("token not found");
}

if (strtotime($user['reset_token_expires_at']) <= time()) {
    die("token has expired");
}

// echo "token is valid and hasn't expired.";


// Insert password encryption and process
if ($password != $repeatPassword) {
    header("Location: resetPassword.php?status=fail");
    $swalReg = "<script>Swal.fire({ title: 'Error', text: 'Passwords do not match', icon: 'error', showConfirmButton: false,
    timer: 1825});</script>";
} else {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
}

try {
    // Insert password into DB
    $sql  = "UPDATE users (password , reset_token_hash, reset_token_expires_at) VALUES (:password, null, null) WHERE userid = :userid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['password' => $hashedPassword, 'uerid' => $user['userid']]);

    header("Location: resetPassword.php?status=success");
    exit;
} catch (PDOException $e) {
    if ($e->getCode() == 23505) { // Unique constraint violation
        $messageReg = "Please enter a different password";
        $swalReg    = "<script>Swal.fire({ title: 'Error!', text: 'Use  different password already exists.', icon: 'error', showConfirmButton: false,
    timer: 1825});</script>";
    } else {
        $messageReg = "Error: " . $e->getMessage();
        $swalReg    = "<script>Swal.fire('Error!', '" . addslashes($messageReg) . "', 'error', showConfirmButton: false,
    timer: 1825);</script>";
    }
}