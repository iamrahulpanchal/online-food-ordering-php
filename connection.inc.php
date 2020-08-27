<?php 

$host = 'localhost';
$username = 'root';
$password = '';
$db_name = 'food_db';

date_default_timezone_set("Asia/Calcutta");

$con = new mysqli($host, $username, $password, $db_name);

if ($con -> connect_errno) {
        echo "Failed to connect to Database: " . $con -> connect_error;
        die();
}

?>