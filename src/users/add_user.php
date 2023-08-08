<?php
// Insert the new user into the database
$sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashedPassword', '$email')";
$conn->query($sql);
?>