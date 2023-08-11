<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once "../util/db_connection.php";
    // Get user inputs from the form
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        include "../users/invalid_user.php";
        InvalidUserRegister();
    } else {
        include "../users/add_user.php";
        include "../util/email_confirmation.php";
        include "../users/login_user.php";
        register_email_confirmation($username, $email);
        login($username, $password, $conn);
    }
    $conn->close();
}
?>