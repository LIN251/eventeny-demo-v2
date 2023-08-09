<?php
$user_id = $_SESSION["user_id"];
// Fetch all products for the current user from the 'product' table
$sql = "SELECT * FROM purchases WHERE buyer_id = '$user_id' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="product-table table">';
    echo '<tr>
            <th>Seller</th>
            <th>Product Name</th>
            <th>Product Description</th>
            <th>Product Price($)</th>
            <th>Address</th>
            <th>State</th>
            <th>Country</th>
            <th>Postcode</th>
            <th>Email</th>
            <th> Order At</th>
            <th>Updated At</th>
            <th>Request to Cancel Order</th>
            </tr>';

    while ($row = $result->fetch_assoc()) {
        $sellerStmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
        $sellerStmt->bind_param("i", $row["seller_id"]);
        $sellerStmt->execute();
        $sellerStmtResult = $sellerStmt->get_result();
        $sellerRow = $sellerStmtResult->fetch_assoc();
        $seller = $sellerRow["username"];


        echo '<tr data-id="' . $row["purchase_id"] . '">';
        echo '<td class="name">' . $seller . '</td>';
        echo '<td class="execution_product_name">' . $row["execution_product_name"] . '</td>';
        echo '<td class="execution_description">' . $row["execution_description"] . '</td>';
        echo '<td class="execution_price">' . $row["execution_price"] . '</td>';
        echo '<td class="address">' . $row["address"] . '</td>';
        echo '<td class="state">' . $row["state"] . '</td>';
        echo '<td class="country">' . $row["country"] . '</td>';
        echo '<td class="postcode">' . $row["postcode"] . '</td>';
        echo '<td class="email">' . $row["email"] . '</td>';
        echo '<td class="created_at">' . $row["created_at"] . '</td>';
        echo '<td class="updated_at">' . $row["updated_at"] . '</td>';
        if ( $row["shipped"] == 1) {
            echo '<td>Item already shipped.</td>';
        } else {
            echo '<td><button onclick="cancelPurchase(' . $row["purchase_id"] . ')">Request</button></td>';
        }
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>No products found.</p>';
}
?>