<?php

require 'dbconn.php';

$studentID = htmlspecialchars(trim($_GET['id']));

$result = mysqli_query($conn, "SELECT * FROM `mydb`.`students` WHERE (`id` = '$studentID');");

$data = array(); 
while ($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}

echo json_encode($data);
// NOT FINISHED
?>