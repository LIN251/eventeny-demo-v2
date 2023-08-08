<!DOCTYPE html>
<html>

<head>
    <title>Shipping Cart</title>
    <link rel="stylesheet" href="../styles.css">
    <script>
        function changeCount(change) {
            let countInput = document.getElementById("count");
            let availableInput = document.getElementById("available");
            let count = parseInt(countInput.value);
            let available = parseInt(availableInput.value);
            change = parseInt(change);
            let newCount = count + change;

            // Ensure the new count is within the available quantity limits
            if (newCount >= 1 && newCount <= available) {
                countInput.value = newCount;
            } else if (newCount > available) {
                alert(`Invalid count. Only ${available} available.`);
            } else {
                alert(`Count can not be zero or negative.`);
            }
        }


        function validateForm(available) {
            let countInput = document.getElementById("count");
            let count = parseInt(countInput.value);

            // Check if the count is a valid positive integer
            if (count <= 0 || !Number.isInteger(count) || count > available) {
                alert(`Invalid count. Only ${available} available.`);
                return false;
            }
            return true;
        }


    </script>
</head>

<body>
    <div class="form-container">
        <h1 class="form-title">Shopping Cart</h1>
        <form action="process_purchase.php" method="post"
            onsubmit="return validateForm(<?php echo $_POST['available']; ?>)">
            <h3>Product Information</h3>
            <div class="form-group">
                <?php
                $available = $_POST['available'];
                $product_name = $_POST['name'];
                $product_price = $_POST['price'];
                $product_description = $_POST['description'];
                $product_return_policy = $_POST['return_policy'];
                $product_image = $_POST['image'];
                $product_discount = $_POST['discount'];

                // Display the product information
                echo '<h4>Product: ' . $product_name . '</h4>';
                if ($product_discount == 0) {
                    echo '<p>Price: $' . $product_price . '</p>';
                } else {
                    echo '<p>Price: $' . $product_price . ' <a class="discount">(After ' . $product_discount . '% Off)<a></p>';
                }
                // echo '<p>Price: $' . $product_price . ' <a class="discount">(After ' . $product_discount . '% Off)<a></p>';
                echo '<p>Description: ' . $product_description . '</p>';
                echo '<p>Available: ' . $available . '</p>';
                echo '<p>Return Policy: ' . $product_return_policy . '</p>';
                echo '<p>Image: </p>';
                echo '<img src="' . $product_image . '" alt="Product Image" style="width: 140px;">';
                ?>
                <p for="count">Purchase Count:</p>
                <input type="number" name="count" id="count" value="1" required>
                <div class="count-buttons">
                    <button type="button" onclick="changeCount(1)">+1</button>
                    <button type="button" onclick="changeCount(-1)">-1</button>
                </div>
            </div>
            <h3>Person Information</h3>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" required>
            </div>
            <div class="form-group">
                <label for="state">State:</label>
                <input type="text" name="state" required>
            </div>
            <div class="form-group">
                <label for="postcode">Postcode:</label>
                <input type="text" name="postcode" required>
            </div>
            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" name="country" required>
            </div>

            <h3>Payment Information</h3>
            <div class="form-group">
                <label for="card_number">Credit Card Number:</label>
                <input type="text" name="card_number" required>
            </div>
            <div class="form-group">
                <label for="expiry">Expiry Date:</label>
                <input type="text" name="expiry" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" name="cvv" required>
            </div>
            <input type="hidden" id="available" value="<?php echo $_POST['available']; ?>">
            <input type="hidden" name="product_id" value="<?php echo $_POST['product_id']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_POST['user_id']; ?>">
            <div class="form-group">
                <input type="submit" value="Submit Purchase" class="submit-btn">
            </div>
        </form>
    </div>
</body>

</html>