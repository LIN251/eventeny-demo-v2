<?php
// Include database connection
include "../util/db_connection.php";

$purchase_id = $_POST["purchase_id"];
$user_id = $_POST["user_id"];
$review_text = $_POST["review_text"];
$rating = $_POST["rating"];


// Insert review data into the database
include "../util/db_operations.php";
insertIntoProductReviews($conn, $purchase_id, $user_id, $review_text, $rating);
updateReviewSubmitted($conn, $purchase_id);
header("Location: ../admin/admin_index.php");
$conn->close();
?>