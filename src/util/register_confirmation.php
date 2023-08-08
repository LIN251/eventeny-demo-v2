<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Dotenv\Dotenv;

// Load the environment variables from the .env file
$dotenv = Dotenv::createImmutable(dirname(dirname(__DIR__)));
$dotenv->load();


$emailSender = $_ENV['EMAIL_SENDER'];
$username = $_POST['username'];
$to = $_POST['email'];

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
?>