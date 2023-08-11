<?php
require_once "../util/db_connection.php";
include "../util/db_operations.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["purchase_id"])) {

    $purchase_id = $_POST["purchase_id"];
    $product_idResult = findPurchasesByPurchaseId($conn, $purchase_id);
    $product_idRow = $product_idResult->fetch_assoc();
    $product_id = $product_idRow["product_id"];

    // Delete the purchase
    deletePurchase($conn, $purchase_id);

    // Update the available count of the associated product
    updateProductSoldAndAvailableForCancel($conn, $product_id); 
}
?>