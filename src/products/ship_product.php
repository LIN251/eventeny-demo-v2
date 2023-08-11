<?php
// Connect to the database
require_once "../util/db_connection.php";
include "../util/db_operations.php";

$purchase_id = $_POST["purchase_id"];
// update shipped status in purchases table
updatePurchaseShipment($conn, $purchase_id);

// update shipped status in products table
updateProductShipment($conn, $purchase_id);

//close database connection
$conn->close();
?>