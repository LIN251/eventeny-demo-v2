<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["product_id"])) {
    // Connect to the database
    require_once "../util/db_connection.php";

    // Check if the product_id is defined and not empty
    $product_id = $_POST["product_id"];
    $archive = $_POST["archive"];
    if (!empty($product_id)) {
        // Update the archive status in the products table
        $sql = "UPDATE products SET archive = ? WHERE product_id = ?";
        $updateArchiveStmt = $conn->prepare($sql);
        if ($updateArchiveStmt) {
            $updateArchiveStmt->bind_param("ii", $archive, $product_id);
            $updateArchiveStmt->execute();
            $updateArchiveStmt->close();
            echo "Product archived successfully.";
        } else {
            echo "Failed to prepare the SQL statement.";
        }
    }

    $conn->close();
}
?>