<?php
// Create the 'purchases' table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS purchases (
    purchase_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11) UNSIGNED NOT NULL DEFAULT 0,
    buyer_id INT(11) UNSIGNED NOT NULL DEFAULT 0,
    seller_id INT(11) UNSIGNED NOT NULL,
    execution_product_name VARCHAR(255) NOT NULL,
    execution_description TEXT NOT NULL,
    execution_discount DECIMAL(5, 2) NOT NULL DEFAULT 0,
    execution_price DECIMAL(12, 2) NOT NULL,
    execution_cost_price DECIMAL(10, 2) NOT NULL DEFAULT 0,
    address VARCHAR(255) NOT NULL,
    state VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL,
    postcode VARCHAR(20) NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    shipped TINYINT(1) NOT NULL DEFAULT 0,
    review_submitted TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    -- FOREIGN KEY (seller_id) REFERENCES users(user_id)
)";
$conn->query($sql);
?>