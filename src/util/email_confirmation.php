<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Dotenv\Dotenv;

// Load the environment variables from the .env file
$dotenv = Dotenv::createImmutable(dirname(dirname(__DIR__)));
$dotenv->load();
$emailSender = $_ENV['EMAIL_SENDER'];

function register_email_confirmation($username, $to)
{
    global $emailSender;
    // Email content
    $subject = "Confirmation Email";
    $message = '<html><body>';
    $message .= '<div style="font-family: Arial, sans-serif; font-size: 16px;">';
    $message .= "Dear $username,<br><br>Thank you for registering on our marketplace website.<br><br>";
    $message .= '<strong>Your account has been successfully created.</strong>';
    $message .= '</div>';
    $message .= '</body></html>';

    $headers = "From: $emailSender \r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Send the email
    mail($to, $subject, $message, $headers);
}


function purchase_email_confirmation($name, $toEmail, $productName, $productPrice, $quantity, $total, $address, $state, $country, $postcode, $conn)
{
    global $emailSender;
    // Set the timezone to New York
    date_default_timezone_set('America/New_York');
    $purchaseDate = date("Y-m-d H:i:s");
    // Email content
    $subject = "Purchase Confirmation";
    $message = '<html><body>';
    $message .= '<div style="font-family: Arial, sans-serif; font-size: 16px;">';
    $message .= "Dear $name,<br><br>Thank you for your purchase!<br><br>";
    $message .= '<strong>Product Information:</strong><br>';
    $message .= '<table>';
    $message .= '<tr><td>Product Name:</td><td>' . $productName . '</td></tr>';
    $message .= '<tr><td>Price:</td><td>$' . $productPrice . '</td></tr>';
    $message .= '<tr><td>Quantity:</td><td>' . $quantity . '</td></tr>';
    $message .= '<tr><td>Total Cost:</td><td>$' . $total . ' (no Tax)</td></tr>';
    $message .= '<tr><td>Purchase Date:</td><td>' . $purchaseDate . ' EST</td></tr>';
    $message .= '</table>';
    $message .= '<br><strong>Shipping Address:</strong><br>';
    $message .= '<table>';
    $message .= '<tr><td>Address:</td><td>' . $address . '</td></tr>';
    $message .= '<tr><td>State:</td><td>' . $state . '</td></tr>';
    $message .= '<tr><td>Country:</td><td>' . $country . '</td></tr>';
    $message .= '<tr><td>Postcode:</td><td>' . $postcode . '</td></tr>';
    $message .= '</table>';
    $message .= '</div>';
    $message .= '</body></html>';

    $headers = "From: $emailSender \r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    // Send the email
    mail($toEmail, $subject, $message, $headers);
}

?>