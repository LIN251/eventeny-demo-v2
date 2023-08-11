<?php

// Create the 'products' table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS products (
    product_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255), 
    cost_price DECIMAL(10, 2) NOT NULL DEFAULT 0,
    discount DECIMAL(5, 2) NOT NULL DEFAULT 0,
    available INT(11) NOT NULL DEFAULT 0,
    sold INT(11) NOT NULL DEFAULT 0,
    shipped INT(11) NOT NULL DEFAULT 0,
    archive TINYINT(1) NOT NULL DEFAULT 0,
    return_policy TEXT,
    user_id INT(11) UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
)";
$conn->query($sql);
?>