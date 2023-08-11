<?php
include_once "../util/db_operations.php";
include_once "../util/util_functions.php";
require "../util/db_connection.php";
// Fetch all products from the 'products' table
$result = findProductsByArchive($conn, 0);

function findUserData($user_id, $conn)
{
  $userResult = findUserByUserId($conn, $user_id);
  $user_data = array("username" => "", "email" => "");
  if ($userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
    $user_data["username"] = $userRow["username"];
    $user_data["email"] = $userRow["email"];
  }
  return $user_data;
}

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $buyer_id = "";
    // skip usre's products
    if (isset($_SESSION["user_id"])) {
      $buyer_id = $_SESSION["user_id"];
      if ($row["user_id"] == $_SESSION["user_id"]) {
        continue;
      }
    }
    $user_data = findUserData($row["user_id"], $conn);
    // Calculate the discounted price
    $discount = $row["discount"];
    $formatted_discounted_price = calculateDiscountedPrice($row["price"], $discount);

    echo '<div class="product" id="' . $row["product_id"] . '">';
    echo '<div class="product-image">';
    $imageURL = "https://via.placeholder.com/100";
    if (!empty($row["image"])) {
      $imageURL = $row["image"];
      echo '<img src="' . $imageURL . '" alt="Product Image">';
    } else {
      echo '<p class="no-image">Seller did not provide<br> a product image.<p>';
    }
    echo '</div>';
    echo '<div class="product-details">';
    echo '<h3> Product: ' . $row["name"] . '</h3>';
    if ($discount == 0) {
      echo '<p>Price: $' . $row["price"] . '</p>';
    } else {
      echo '<p><del>$' . $row["price"] . '</del> <a class="discountColor">(' . $discount . '% off)</a> -> <strong>Now: $' . $formatted_discounted_price . '</strong></p>';
      echo '<p >Description: ' . $row["description"] . '</p>';
    }
    echo '<p>Available: ' . $row["available"] . '</p>';
    echo '<p>Return Policy: ' . $row["return_policy"] . '</p>';
    echo '<p class="sellerInfo">Seller: ' . $user_data["username"] . '</p>';
    echo '<p class="sellerInfo">Contact Info: <a href="mailto:' . $user_data["email"] . '">' . $user_data["email"] . '</a></p>';
    if ($row["available"] > 0) {
      echo '<form action="../products/purchase_product.php" method="post">';
      echo '<input type="hidden" name="product_id" value="' . $row["product_id"] . '">';
      echo '<input type="hidden" name="user_id" value="' . $row["user_id"] . '">';
      echo '<input type="hidden" name="available" value="' . $row["available"] . '">';
      echo '<input type="hidden" name="name" value="' . $row["name"] . '">';
      echo '<input type="hidden" name="price" value="' . $formatted_discounted_price . '">';
      echo '<input type="hidden" name="description" value="' . $row["description"] . '">';
      echo '<input type="hidden" name="return_policy" value="' . $row["return_policy"] . '">';
      echo '<input type="hidden" name="image" value="' . $imageURL . '">';
      echo '<input type="hidden" name="buyer_id" value="' . $buyer_id . '">';
      echo '<input type="hidden" name="discount" value="' . $discount . '">';
      echo '<div class="purchase-button-container">';
      echo '<input type="submit" id="purchase" value="Purchase">';
      echo '</div>';
    } else {
      echo '<input style="background-color: grey;" type="submit" value="Out of Stock" disabled>';

    }
    echo '</form>';
    echo '</div>';
    echo '</div>';
  }
} else {
  echo '<p>No products are on sale.</p>';
}


?>