<?php
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

    include "../util/db_operations.php";
    updateProduct($conn, $id, $name, $price, $available, $description, $return_policy, $cost_price, $discount);
}
$conn->close();
?>