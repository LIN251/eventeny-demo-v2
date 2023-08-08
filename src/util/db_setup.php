<?php
require_once "db_connection.php";
function checkTable($tableName, $conn)
{
    $query = "SHOW TABLES LIKE '" . $conn->real_escape_string($tableName) . "'";
    $result = $conn->query($query);
    if (!$result) {
        echo "Error executing query: " . $conn->error;
        return false;
    }
    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}


// Function to add testing data for uses;
function addTestingDataForUsers($conn)
{
    $passwordHash = password_hash("admin", PASSWORD_DEFAULT);
    $username = "admin";
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$passwordHash', 'admin@gmail.com')";
    $conn->query($sql);

    $passwordHash = password_hash("testuser", PASSWORD_DEFAULT);
    $username = "testuser";
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$passwordHash', 'lzhang2510@gmail.com')";
    $conn->query($sql);


}

// Function to add testing data for products
function addTestingDataForProducts($conn)
{
    $sql = "INSERT INTO products (name, price, description, available, image, return_policy, user_id,sold,shipped,archive, cost_price, discount) VALUES
    ('Iphone14', 999, 'This is iphone14', 1, 
    'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-card-40-iphone14pro-202209_FMT_WHH?wid=508&hei=472&fmt=p-jpg&qlt=95&.v=1663611329204', 
    '30 days return policy', 1, 0, 0, 0, 599, 50),
    ('Apple Watch', 399, 'This is Apple Watch', 10,
    'https://assets-prd.ignimgs.com/2023/06/29/best-apple-watch-deals-2023-ign-1688052051470.png',
    '30 days return policy', 1, 0, 0, 0, 299, 10),
    ('Ipad', 799, 'This is ipad', 5, 
    'https://ss7.vzw.com/is/image/VerizonWireless/apple-ipad-pro-11-replacement-coleus-spacegray-2022?wid=700&hei=700&fmt=webp', 
    'No returns allowed', 1, 0, 0, 1, 599, 20),
    ('AirPods', 199, 'This is AirPods', 15,
    'https://i.insider.com/61d5c65a5a119b00184b1e1a?width=1136&format=jpeg',
    '30 days return policy', 1, 0, 0, 0, 99, 0),
    ('Macbook', 1599, 'This is macbook', 20, 
    'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/mbp-spacegray-select-202206?wid=640&hei=595&fmt=jpeg&qlt=95&.v=1664497359481', 
    '15 days return policy', 2, 0, 0, 0, 1399, 0),
    ('Apple TV', 149, 'This is Apple TV', 20,'','Free return', 2, 0, 0, 0, 99, 10)";
    $conn->query($sql);
}

if (!checkTable("users", $conn)) {
    require_once "users/create_users_table.php";
    addTestingDataForUsers($conn);
}
if (!checkTable("products", $conn)) {
    require_once "products/create_products_table.php";
    addTestingDataForProducts($conn);
}
if (!checkTable("purchases", $conn)) {
    require_once "products/create_purchases_table.php";
}

?>