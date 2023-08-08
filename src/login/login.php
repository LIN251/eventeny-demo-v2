<?php
session_start();
require_once "../util/db_connection.php";

function InvalidUser()
{
    echo '<link rel="stylesheet" href="../styles.css">';
    echo '<div class="purchase-success">';
    echo "<h1>User not found!</h1>";
    echo "<br>";
    echo "username or password incorrect!";
    echo "<br>";
    echo '<a href="../index.php" class="back-btn">Back to Home</a>';
    echo '</div>';
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    // Validate user credentials
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            // Login successful, set session variable
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["username"] = $user["username"];
            header("Location: ../admin/admin_index.php");
            exit;
        } else {
            InvalidUser();
        }
    } else {
        InvalidUser();
    }
}

?>