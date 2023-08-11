<?php
// include "../util/db_operations.php";
include "../util/db_connection.php";
$user_id = $_SESSION["user_id"];
$result = findPurchasesByBuyerId($conn, $user_id );

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
            <th>Add Review</th>
            </tr>';

    while ($row = $result->fetch_assoc()) {
        $sellerStmtResult = findUserByUserId($conn, $row["seller_id"]);
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
        if ($row["shipped"] == 1) {
            echo '<td>Item already shipped</td>';
            if($row["review_submitted"] == 1){
                echo '<td>Thank you <br>for reviewing.</td>';
            }else{
                echo '<td><button onclick="showReviewForm(' . $row["purchase_id"] . ')">Add Review</button></td>';
            }
        } else {
            echo '<td><button onclick="cancelPurchase(' . $row["purchase_id"] . ')">Request</button></td>';
            echo '<td>Waiting to deliver</td>';
        }
        echo '</tr>';
    }
    echo '</table>';


    // <!-- hidden form for adding reviews -->
    echo "<div class='add-product' id='reviewFormContainer' style='display: none;'>";
    echo "<h2>Add Review</h2>";
    echo "<form class='add-product-form' action='../productReviews/add_product_review.php' method='post'> ";
    echo "<input type='hidden' name='purchase_id' id='purchaseId' value=''>";
    echo "<input type='hidden' name='user_id' value='" . $user_id . "'>"; 
    echo "<label for='review_text'>Review Text:</label>";
    echo "<input type='text' name='review_text' required placeholder='Add your review (Required)'>";
    echo "<label for='rating'>Rating:</label>";
    echo "<input type='number' name='rating' step='0.1' min='0' max='5' required placeholder='Rate the product (0-5 stars)'>";
    echo "<div class='center-container'>";
    echo "<input type='submit' value='Add Review'>";
    echo "</div>";
    echo "</form>";
    echo "</div>";

} else {
    echo '<p>No products found.</p>';
}
?>