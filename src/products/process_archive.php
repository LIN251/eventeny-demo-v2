<?php
include "../util/db_operations.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["product_id"])) {
    // Connect to the database
    require_once "../util/db_connection.php";

    updateProductArchive($conn, $_POST["product_id"], $_POST["archive"]);
    $conn->close();
}
?>