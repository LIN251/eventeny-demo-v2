<?php
// Connect to the database
require_once "../util/db_connection.php";
$purchase_id = $_POST["purchase_id"];
// update shipped status in purchases table
$updateShipmentStmt = $conn->prepare("UPDATE purchases SET shipped = 1 WHERE purchase_id = ?");
$updateShipmentStmt->bind_param("i", $purchase_id);
$updateShipmentStmt->execute();
$updateShipmentStmt->close();

// update shipped status in products table
$updateShipmentStmt = $conn->prepare("UPDATE products SET shipped = shipped + 1 WHERE product_id = (SELECT product_id FROM purchases WHERE purchase_id = ?)");
$updateShipmentStmt->bind_param("i", $purchase_id);
$updateShipmentStmt->execute();
$updateShipmentStmt->close();


//close database connection
$conn->close();


?>