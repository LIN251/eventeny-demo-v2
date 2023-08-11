<?php
include "../util/db_operations.php";
// Insert the new user into the database
insertIntoUsers( $conn, $username, $hashedPassword, $email);
?>