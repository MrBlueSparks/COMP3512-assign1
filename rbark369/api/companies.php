<?php
//returns all the companies/stocks or specific company/stocks
header("Content-Type: application/json");


try {
include '../includes/db.inc.php';

//checks if there is ref parameter

if (isset($GET['ref'])){
    $symbol = $_GET['ref'];
    $sql = "SELECT * FROM companies WHERE symbol = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $symbol);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} 
//return all companies
 else {
    $sql = "SELECT * FROM companies";
    $stmt= $conn->query($sql);
    $result = $stmt->fetchAll();
    echo json_encode($result);
}
}
catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>