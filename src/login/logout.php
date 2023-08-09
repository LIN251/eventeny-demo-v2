<?php
// Clear the session data and log out the user
session_unset();
session_destroy();
// setcookie(session_name(), '', time() - 3600);
header("Location: ../index.php");
exit;
?>
