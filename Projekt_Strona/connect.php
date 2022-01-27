<?php



$configs = include('config.php');

$conn = new mysqli($configs['host'], $configs['username'], $configs['password'], $configs['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}
?>