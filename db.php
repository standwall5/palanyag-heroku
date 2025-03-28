<?php
$dsn      = "pgsql:host=cbec45869p4jbu.cluster-czrs8kj4isg7.us-east-1.rds.amazonaws.com;port=5432;dbname=dabs64njcvk9c8";
$user     = "u1u48arjb5sffg";
$password = "p64667689d7c7777924296c152922b136bd0232067d1350713e1e18031c7c3405";

try {
    $pdo = new PDO($dsn, $user, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
