<?php
function InvalidUserLogin()
{
    echo '<link rel="stylesheet" href="../styles.css">';
    echo '<div class="purchase-success">';
    echo "<h1>User not found!</h1>";
    echo "<br>";
    echo "username or password incorrect!";
    echo "<br>";
    echo '<a href="../index.php" class="back-btn">Back to Home</a>';
    echo '</div>';
}


function InvalidUserRegister()
{
    echo '<link rel="stylesheet" href="../styles.css">';
    echo '<div class="purchase-success">';
    echo "<h1>User exists!</h1>";
    echo "<br>";
    echo "Username already exists. Please choose a different username.";
    echo "<br>";
    echo '<a href="../index.php" class="back-btn">Back to Home</a>';
    echo '</div>';
}


?>