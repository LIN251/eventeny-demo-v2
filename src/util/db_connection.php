<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Dotenv\Dotenv;

// Load the environment variables from the .env file
$dotenv = Dotenv::createImmutable(dirname(dirname(__DIR__)));
$dotenv->load();

// Database connection parameters
$servername = $_ENV['DB_HOST'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];
$dbport = $_ENV['DB_PORT'];

// Create connection, use the default Mysql port 3306
$conn = new mysqli($servername, $username, $password, null, $dbport);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if (!$conn->query($sql) === true) {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db($dbname);

?>