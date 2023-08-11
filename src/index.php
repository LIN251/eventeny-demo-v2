<!DOCTYPE html>
<html>

<head>
    <title>Marketplace</title>
    <link rel="stylesheet" href="styles.css">
    <script src="index.js" defer></script>
</head>


<body>
    <h1>Marketplace</h1>
    <button class="tablink" onclick="openTab('products')" id="defaultOpen">All Products</button>
    <button class="tablink" id="defaultOpen" onclick="openTab('login')">User Login</button>
    <button class="tablink" id="guestregister" onclick="openTab('register')">User Register</button>
    <?php
    include "util/db_setup.php";
    ?>
    <div id="products" class="tabcontent">
        <div class="show-products-container">
            <h1 class="form-title">All Products On Sale</h1>
            <div class="products-container">
                <?php
                // Include the database connection code
                require_once "util/db_connection.php";
                include "products/show_products_guest.php";
                ?>
            </div>
        </div>
    </div>

    <div id="login" class="tabcontent">
        <h1>Admin Login</h1>
        <form action="./login/login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <input type="submit" value="Login">
        </form>

        <!-- Add a Register button that redirects to the registration page -->
        <!-- <form action="./login/register.php">
            <input type="submit" value="Register">
        </form> -->
    </div>

    <div id="register" class="tabcontent">
        <h1>Admin Register</h1>
        <form action="./login/register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <p>You will receive an email confirmation <br>once the account is created.</p>
            <input type="submit" value="Register">
        </form>
    </div>

</body>
</html>