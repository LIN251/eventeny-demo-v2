<?php
// Clear the session data and log out the user
session_unset();
session_destroy();
header("Location: ../index.php");
exit;
?>
