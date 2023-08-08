<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Connect to the database
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

    // Check if cost_price is empty and set it to 0 if it is
    $cost_price = empty($cost_price) ? 0 : $cost_price;

    // Insert the new product into the database
    $sql = "INSERT INTO products (name, price, description, image, available, return_policy, user_id, cost_price, discount) 
            VALUES ('$name', '$price', '$description', '$image', '$available', '$return_policy', '$user_id', '$cost_price', '$discount')";
    $conn->query($sql);
    header("Location: ../admin/admin_index.php");

    // Close the MySQL connection
    $conn->close();
}
?>