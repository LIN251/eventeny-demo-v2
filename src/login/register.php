<?php
function InvalidUser()
{
    echo '<link rel="stylesheet" href="../styles.css">';
    echo '<div class="purchase-success">';
    echo "<h1>User exists!</h1>";
    echo "<br>";
    echo "Username already exists. Please choose a different username.";
    echo "<br>";
    echo '<a href="../index.php" class="back-btn">Back to Home</a>';
    echo '</div>';
}
function login($username, $password, $conn)
{
    // Validate user credentials
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();
    if (password_verify($password, $user["password"])) {
        session_start();
        // Login successful, set session variable
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["username"] = $user["username"];
        header("Location: ../admin/admin_index.php");
        exit;
    }
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once "../util/db_connection.php";

    // Get user inputs from the form
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Perform some basic validation
    if (empty($username) || empty($password)) {
        echo "Please fill in all required fields.";
    } else {
        // Check if the username is already taken
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            InvalidUser();
        } else {
            // Insert the new user into the database
            include "../users/add_user.php";
            include "../util/register_confirmation.php";
            login($username, $password, $conn);
        }
    }

    // Close the database connection
    $conn->close();
}
?>