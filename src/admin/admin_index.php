<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    // Redirect to login if the user is not logged in
    header("Location: ../login/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Products</title>
    <link rel="stylesheet" href="admin_index.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="admin_index.js" defer></script>
</head>

<body>
    <h1>Welcome,
        <?php echo $_SESSION["username"]; ?>!
    </h1>
    <button class="tablink" onclick="openTab('manage')" id="defaultOpen">Manage products</button>
    <button class="tablink" onclick="openTab('sold')" id="soldTab">Sold Products</button>
    <button class="tablink" onclick="openTab('archive')" id="archiveTab">Archived Templates</button>
    <button class="tablink" onclick="logout()">Log Out</button>


    <!-- Manage products tab -->
    <div id="manage" class="tabcontent">
        <h2>Manage products</h2>

        <?php
        // Include the database connection code
        require_once "../util/db_connection.php";
        include "../products/mamage_products.php";
        ?>
        <div class="add-product">
            <h2>Add New Product</h2>
            <form action="../products/add_product.php" method="post">
                <label for="name">Name:</label>
                <input type="text" name="name" required placeholder="Product Name (Required)">
                <label for="price">Price (Visible to customers):</label>
                <input type="number" name="price" step="0.01" required placeholder="Product Price (Required)">
                <label for="cost_price">Product Cost (Visible to you only):</label>
                <input type="number" name="cost_price" step="0.01" required placeholder="Product Cost (Required)">
                <label for="description">Description:</label>
                <textarea name="description" required placeholder="Product Description (Required)"></textarea>
                <label for="image">Image URL:</label>
                <input type="text" name="image" placeholder="One Image URL (Optional)">
                <label for="available">Available:</label>
                <input type="number" name="available" required placeholder="Quantity Available (Required)">
                <label for="return_policy">Return Policy:</label>
                <textarea name="return_policy" required placeholder="Return Policy (Required)"></textarea>
                <label for="discount">Discount (as a number):</label>
                <input type="number" name="discount" step="0.01" min="0" max="100" required
                    placeholder="Product Discount (0 ~ 100 Required)">
                <div class="center-container">
                    <input type="submit" value="Add Product">
                </div>
            </form>
        </div>
    </div>


    <!-- Sold products tab -->
    <div id="sold" class="tabcontent">
        <h1>Sold Products</h1>
        <?php
        include "../products/sold_products.php";
        ?>


    </div>

    <!-- Sold products tab -->
    <div id="archive" class="tabcontent">
        <h1>Archived Products</h1>
        <?php
        include "../products/archive_products.php";
        ?>
    </div>
</body>

</html>