<?php
include "../util/db_operations.php";
include "../util/util_functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Include the database connection code
    require_once "../util/db_connection.php";
    // Get the submitted data from the form
    $product_id = $_POST["product_id"];
    $seller_id = $_POST["user_id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $state = $_POST["state"];
    $country = $_POST["country"];
    $postcode = $_POST["postcode"];
    $count = $_POST["count"];
    $buyer_id = $_POST["buyer_id"];
    

    // Check the availability of the product and get current product information.
    $availabilityResult = findProductByProductId($conn,$product_id);
    $availabilityRow = $availabilityResult->fetch_assoc();
    $product_name = $availabilityRow["name"];
    $availableQuantity = $availabilityRow["available"];
    $cost_price = $availabilityRow["cost_price"];
    $description = $availabilityRow["description"];
    $product_discount = $availabilityRow["discount"];
    $product_id = $availabilityRow["product_id"];

    // Calculate the discounted price
    $product_price = calculateDiscountedPrice( $availabilityRow["price"], $product_discount);
    $execution_price = floatval(str_replace(',', '', $product_price));

    if ($availableQuantity == 0) {
        echo "This product is currently out of stock.";
    } else {
        // Reduce availability and update sold count
        updateProductSoldAndAvailableForPurchase( $conn, $product_id, $count);

        
        if ($buyer_id == "") {
            for ($i = 0; $i < $count; $i++) {
                insertIntoPurchasesForGuestUser($conn, $seller_id, $name, $email, $address, $state, $country, $postcode, $product_name, $description, $product_discount, $execution_price, $cost_price, $product_id);
            }
        }else{
            for ($i = 0; $i < $count; $i++) {
                insertIntoPurchasesForLoginUser($conn, $seller_id, $name, $email, $address, $state, $country, $postcode, $product_name, $description, $product_discount, $execution_price, $cost_price, $product_id, $buyer_id);

            }
        }

        echo '<link rel="stylesheet" href="../styles.css">';
        echo '<div class="purchase-success">';
        echo "<h1>Thank you for your purchase!</h1>";
        echo "<br>";
        echo "<h4>An email receipt will be sent to you shortly.</h4>";
        echo "<br>Please check you <strong>Spam folder</strong>.";
        echo "<br>";
        echo "<br>";
        echo "Please note that we do not store any credit card information. <br>All credit card transactions are securely processed by a trusted <br>third-party payment processor.";
        echo "<br>";
        echo "<br>";
        echo "<br>";
        
        if ($buyer_id != "") { 
            echo '<a href="../admin/admin_index.php" class="back-btn">Back to Purchases</a>';
        }else{
            echo '<a href="../index.php" class="back-btn">Back to Home</a>';
        }

        include "../util/email_confirmation.php";
        $total = floatval($execution_price) * $count;
        purchase_email_confirmation($name, $email, $product_name, $product_price, $count, $total, $address, $state, $country, $postcode, $conn);
    }

    // Close the database connection
    $conn->close();
}
?>