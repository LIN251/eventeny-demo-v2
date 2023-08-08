<?php
// Include the database connection code
require_once "../util/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get the product ID from the query parameters
    $id = $_GET["id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $available = $_POST["available"];
    $description = $_POST["description"];
    $return_policy = $_POST["return_policy"];
    $cost_price = $_POST["cost_price"];
    $discount = $_POST["discount"];

    // Prepare the SQL statement to update the product record
    $sql = "UPDATE products 
            SET name = ?, price = ?, available = ?, description = ?, return_policy = ? , cost_price=?, discount=?
            WHERE product_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siissiii", $name, $price, $available, $description, $return_policy, $cost_price, $discount, $id);
    $stmt->execute();
    $stmt->close();
}

// Close the database connection
$conn->close();
?>