<?php
session_start();
require_once "../util/db_connection.php";
function login($username, $password, $conn)
{
    // Validate user credentials
    $result = findUserByUsername($conn, $username);
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            // Login successful, set session variable
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["username"] = $user["username"];
            header("Location: ../admin/admin_index.php");
            exit;
        } else {
            InvalidUserLogin();
        }
    } else {
        InvalidUserLogin();
    }
}
?>