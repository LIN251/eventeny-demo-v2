<?php
// GET
function findUserByUsername($conn, $username)
{
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    return $stmt->get_result();
}

function findUserByUserId($conn, $user_id)
{
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result();

}

function findProductsByArchive($conn, $archive)
{
    $sql = "SELECT * FROM products WHERE archive = $archive";
    return $conn->query($sql);
}

function findProductByProductId($conn, $product_id)
{
    $sql = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    return $stmt->get_result();
}

function findPurchasesBySellerId($conn, $seller_id)
{
    $sql = "SELECT * FROM purchases WHERE seller_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $seller_id);
    $stmt->execute();
    return $stmt->get_result();
}

function findPurchasesByBuyerId($conn, $buyer_id)
{
    $sql = "SELECT * FROM purchases WHERE buyer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $buyer_id);
    $stmt->execute();
    return $stmt->get_result();
}

function findPurchasesByPurchaseId($conn, $purchase_id)
{
    $sql = "SELECT * FROM purchases WHERE purchase_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $purchase_id);
    $stmt->execute();
    return $stmt->get_result();
}

function findAllArchivedProductsForUser($conn, $user_id, $archive)
{
    $sql = "SELECT * FROM products WHERE user_id = '$user_id' AND archive = $archive";
    return $conn->query($sql);
}

// INSERT
function insertIntoProducts($conn, $name, $price, $description, $image, $available, $return_policy, $user_id, $cost_price, $discount)
{
    $sql = "INSERT INTO products (name, price, description, image, available, return_policy, user_id, cost_price, discount) 
    VALUES ('$name', '$price', '$description', '$image', '$available', '$return_policy', '$user_id', '$cost_price', '$discount')";
    $conn->query($sql);
}


function insertIntoUsers($conn, $username, $hashedPassword, $email)
{
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashedPassword', '$email')";
    $conn->query($sql);
}

function insertIntoPurchasesForLoginUser($conn, $seller_id, $name, $email, $address, $state, $country, $postcode, $product_name, $description, $product_discount, $execution_price, $cost_price, $product_id, $buyer_id)
{
    $stmt = $conn->prepare("INSERT INTO purchases (
        seller_id, name, email, address, state, country, postcode, 
        execution_product_name, execution_description, execution_discount, 
        execution_price, execution_cost_price, product_id, buyer_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "issssssssdssii",
        $seller_id,
        $name,
        $email,
        $address,
        $state,
        $country,
        $postcode,
        $product_name,
        $description,
        $product_discount,
        $execution_price,
        $cost_price,
        $product_id,
        $buyer_id
    );
    $stmt->execute();
    $stmt->close();
}

function insertIntoPurchasesForGuestUser($conn, $seller_id, $name, $email, $address, $state, $country, $postcode, $product_name, $description, $product_discount, $execution_price, $cost_price, $product_id)
{
    $stmt = $conn->prepare("INSERT INTO purchases (seller_id, name, email, address, state, country, postcode, execution_description, execution_discount, execution_price, execution_cost_price ,execution_product_name,product_id) VALUES (?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?)");
    $stmt->bind_param("isssssssiiisi", $seller_id, $name, $email, $address, $state, $country, $postcode, $description, $product_discount, $execution_price, $cost_price, $product_name, $product_id);
    $stmt->execute();
    $stmt->close();
}


// DELETE
function deleteProduct($conn, $product_id)
{
    $sql = "DELETE FROM products WHERE product_id = ? ";
    $deleteStmt = $conn->prepare($sql);
    $deleteStmt->bind_param("i", $product_id);
    $deleteStmt->execute();
    $deleteStmt->close();
}

function deletePurchase($conn, $purchase_id)
{
    $sql = "DELETE FROM purchases WHERE purchase_id = ?";
    $deletePurchaseStmt = $conn->prepare($sql);
    $deletePurchaseStmt->bind_param("i", $purchase_id);
    $deletePurchaseStmt->execute();
    $deletePurchaseStmt->close();
}


//UPDATE
function updateProduct($conn, $id, $name, $price, $available, $description, $return_policy, $cost_price, $discount)
{
    $sql = "UPDATE products 
            SET name = ?, price = ?, available = ?, description = ?, return_policy = ? , cost_price=?, discount=?
            WHERE product_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siissiii", $name, $price, $available, $description, $return_policy, $cost_price, $discount, $id);
    $stmt->execute();
    $stmt->close();
}

function updateProductArchive($conn, $product_id, $archive)
{
    $sql = "UPDATE products SET archive = ? WHERE product_id = ?";
    $updateArchiveStmt = $conn->prepare($sql);
    $updateArchiveStmt->bind_param("ii", $archive, $product_id);
    $updateArchiveStmt->execute();
    $updateArchiveStmt->close();
}

function updatePurchaseShipment($conn, $purchase_id)
{
    $sql = "UPDATE purchases SET shipped = 1 WHERE purchase_id = ?";
    $updateShipmentStmt = $conn->prepare($sql);
    $updateShipmentStmt->bind_param("i", $purchase_id);
    $updateShipmentStmt->execute();
    $updateShipmentStmt->close();

}

function updateProductShipment($conn, $purchase_id)
{
    $sql = "UPDATE products SET shipped = shipped + 1 WHERE product_id = (SELECT product_id FROM purchases WHERE purchase_id = ?)";
    $updateShipmentStmt = $conn->prepare($sql);
    $updateShipmentStmt->bind_param("i", $purchase_id);
    $updateShipmentStmt->execute();
    $updateShipmentStmt->close();
}


function updateProductSoldAndAvailableForCancel($conn, $product_id)
{
    $sql = "UPDATE products SET sold = sold - 1, available = available + 1 WHERE product_id = ?";
    $updateProductStmt = $conn->prepare($sql);
    $updateProductStmt->bind_param("i", $product_id);
    $updateProductStmt->execute();
    $updateProductStmt->close();
}

function updateProductSoldAndAvailableForPurchase($conn, $product_id, $count)
{
    $sql = "UPDATE products SET available = available - ? , sold = sold + ? WHERE product_id = ?";
    $updateProductStmt = $conn->prepare($sql);
    $updateProductStmt->bind_param("iii", $count, $count, $product_id);
    $updateProductStmt->execute();
    $updateProductStmt->close();
}
?>