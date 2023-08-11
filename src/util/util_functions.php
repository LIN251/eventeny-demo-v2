<?php
function calculateDiscountedPrice($price, $discount){
    $discounted_price = $price * (1 - ($discount / 100));
    return number_format($discounted_price, 2);
}

?>