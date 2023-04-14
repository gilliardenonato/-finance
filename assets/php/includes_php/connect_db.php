<?php
$servername = "localhost";
$username   = "root";
$password   = "0395";
$dbname     = "teste-de-faixa";

// Create connection
$connect = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

?>