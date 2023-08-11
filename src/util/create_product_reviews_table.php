<?php

// Create the 'product_reviews' table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS product_reviews (
    review_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    purchase_id INT(11) UNSIGNED NOT NULL,
    user_id INT(11) UNSIGNED NOT NULL,
    review_text TEXT NOT NULL,
    rating INT(11) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (purchase_id) REFERENCES purchases(purchase_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
)";

$conn->query($sql);
?>