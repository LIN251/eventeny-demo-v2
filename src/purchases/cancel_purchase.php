<?php
require_once "../util/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["purchase_id"])) {
    
    $purchase_id = $_POST["purchase_id"];
    
    $product_idStmt = $conn->prepare("SELECT product_id FROM purchases WHERE purchase_id = ?");
    $product_idStmt->bind_param("i", $purchase_id);
    $product_idStmt->execute();
    $product_idResult = $product_idStmt->get_result();
    $product_idRow = $product_idResult->fetch_assoc();
    $product_id = $product_idRow["product_id"];

    // Delete the purchase
    $deletePurchaseStmt = $conn->prepare("DELETE FROM purchases WHERE purchase_id = ?");
    $deletePurchaseStmt->bind_param("i", $purchase_id);
    $deletePurchaseStmt->execute();


    // Update the available count of the associated product
    $updateProductStmt = $conn->prepare("UPDATE products SET available = available + 1, sold = sold - 1 WHERE product_id = ?");
    $updateProductStmt->bind_param("i", $product_id);
    $updateProductStmt->execute();
}
?>