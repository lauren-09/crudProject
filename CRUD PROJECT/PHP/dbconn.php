<?php

$servername = "localhost";
$username = "root";
$password = 'asdf';
$db_name = "myDB";

$conn = mysqli_connect($servername, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

?>