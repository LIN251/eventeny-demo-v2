<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["product_id"])) {
    // Connect to the database
    require_once "../util/db_connection.php";

    $product_id = $_POST["product_id"];
    // update shipped status in purchases table
    $deleteStmt = $conn->prepare("DELETE FROM products WHERE product_id = ? ");
    $deleteStmt->bind_param("i", $product_id);
    $deleteStmt->execute();
    $deleteStmt->close();
    // Close the database connection
    $conn->close();

}
?>