<?php
header('Content-Type: application/json');

require 'db.php';
try {
    $sql = "SELECT * FROM deceased;";
    $stmt = $pdo->query($sql);
    $deceasedRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $jsonDeceasedData = json_encode($deceasedRecords);
} catch (PDOException $e) {
    echo "Error " . $e->getMessage();
};

echo $jsonDeceasedData;