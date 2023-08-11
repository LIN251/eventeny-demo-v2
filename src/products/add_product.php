<?php
include "../util/db_operations.php";

session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once "../util/db_connection.php";
    // Get the form data
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $image = $_POST["image"];
    $available = $_POST["available"];
    $return_policy = $_POST["return_policy"];
    $user_id = $_SESSION["user_id"];
    $cost_price = $_POST["cost_price"];
    $discount = $_POST["discount"];
    $cost_price = empty($cost_price) ? 0 : $cost_price;

    insertIntoProducts($conn, $name, $price, $description, $image, $available, $return_policy, $user_id, $cost_price, $discount);
    header("Location: ../admin/admin_index.php");
    $conn->close();
}
?>