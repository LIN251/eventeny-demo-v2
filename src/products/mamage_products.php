<?php
$user_id = $_SESSION["user_id"];
// Fetch all products for the current user from the 'product' table
$sql = "SELECT * FROM products WHERE user_id = '$user_id' AND archive = '0'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table class="product-table table">';
    echo '<tr><th>Name</th><th>Image</th><th>Description</th><th>Original Price($)</th><th>Discount<br>(0-100)%</th><th>Discounted price($)</th><th>Product Cost($)</th><th>Available</th><th>Return Policy</th><th>Sold</th><th>Shipped</th><th>Edit</th><th>Archive</th><th>Delete</th></tr>';
    while ($row = $result->fetch_assoc()) {
        // Calculate the discounted price
        $discount = $row["discount"];
        $discounted_price = $row["price"] * (1 - ($discount / 100));
        $formatted_discounted_price = number_format($discounted_price, 2);

        echo '<tr data-id="' . $row["product_id"] . '">';
        echo '<td class="editable name">' . $row["name"] . '</td>';
        // Check if the image is empty
        if (!empty($row["image"])) {
            echo '<td><img src="' . $row["image"] . '" alt="Product Image" style="width: 100%;"></td>';
        } else {
            echo '<td>No image provided</td>';
        }
        echo '<td class="editable description">' . $row["description"] . '</td>';
        echo '<td class="editable price">$' . $row["price"] . '</td>';
        echo '<td class="editable discount">' . $row["discount"] . '%</td>';
        echo '<td class="sell_price" style="color: red;">$' . $formatted_discounted_price . '</td>';
        echo '<td class="editable cost_price">$' . $row["cost_price"] . '</td>';
        echo '<td class="editable available">' . $row["available"] . '</td>';
        echo '<td class="editable return_policy">' . $row["return_policy"] . '</td>';
        echo '<td class="sold">' . $row["sold"] . '</td>';
        echo '<td class="shipped">' . $row["shipped"] . '</td>';
        echo '<td><button class="edit-btn" onclick="editProduct(' . $row["product_id"] . ')">Edit</button></td>';
        echo '<td><button onclick="processArchive(' . $row["product_id"] . ', 1)">Archive</button></td>';
        // Check if sold is greater than shipped
        if ($row["sold"] > $row["shipped"]) {
            echo '<td>You need to <br> ship all sold <br>items before<br> deleting.</td>';
        } else {
            // Show delete button
            echo '<td><button onclick="deleteProduct(' . $row["product_id"] . ')">Delete</button></td>';
        }
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo '<p>No products found.</p>';
}
?>