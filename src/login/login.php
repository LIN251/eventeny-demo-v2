<?php
include "../util/db_operations.php";
include "../users/login_user.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    login($username, $password, $conn);
}
?>