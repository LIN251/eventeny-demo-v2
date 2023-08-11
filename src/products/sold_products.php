<?php
$seller_id = $_SESSION["user_id"];
$result_sold = findPurchasesBySellerId($conn, $seller_id);

// Initialize the total earnings variable
$total_earnings = 0;

if ($result_sold->num_rows > 0) {
    echo '<table class="product-table table">';
    echo '<tr><th>Product Name</th><th>Execution<br> Description</th><th>Execution<br> Discount</th><th>Execution<br> Price</th><th>Execution<br> Product Cost</th><th>Earn</th><th>Address</th><th>State</th><th>Postcode</th><th>Country</th><th>Name</th><th>Email</th><th>Purchased At</th><th>Shipment</th></tr>';
    while ($sold_row = $result_sold->fetch_assoc()) {
        $earn = $sold_row["execution_price"] - $sold_row["execution_cost_price"];
        $total_earnings += $earn;
        if ($sold_row["shipped"]) {
            echo '<tr purchase_id="' . $sold_row["purchase_id"] . '" class="marked-row">';
        } else {
            echo '<tr purchase_id="' . $sold_row["purchase_id"] . '">';
        }
        echo '<td>' . $sold_row["execution_product_name"] . '</td>';
        echo '<td>$' . $sold_row["execution_description"] . '</td>';
        echo '<td>' . $sold_row["execution_discount"] . '%</td>';
        echo '<td>$' . $sold_row["execution_price"] . '</td>';
        echo '<td>$' . $sold_row["execution_cost_price"] . '</td>';
        echo '<td class="earn-column" style="color: red;">$' . $earn . '</td>';
        echo '<td>' . $sold_row["address"] . '</td>';
        echo '<td>' . $sold_row["state"] . '</td>';
        echo '<td>' . $sold_row["postcode"] . '</td>';
        echo '<td>' . $sold_row["country"] . '</td>';
        echo '<td>' . $sold_row["name"] . '</td>';
        echo '<td>' . $sold_row["email"] . '</td>';
        echo '<td>' . $sold_row["created_at"] . '</td>';
        if ($sold_row["shipped"]) {
            echo '<td><input type="checkbox" ' . 'checked' . ' disabled></td>';
        } else {
            echo '<td><input type="checkbox" onclick="handleCheckboxClick(this,' . $sold_row["purchase_id"] . ');"></td>';
        }
        echo '</tr>';
    }
    echo '</table>';
    echo '<br>';
    echo '<div class="add-product">';
    echo '<h2>Total Earn: $' . number_format($total_earnings, 2) . '</h2>';
    echo '</div>';

} else {
    echo '<p>No products are sold.</p>';
}
?>