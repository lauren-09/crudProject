<?php

require 'dbconn.php';

$result = mysqli_query($conn, "SELECT * FROM students");

$data = array(); 
while ($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}

echo json_encode($data);
// DONE
?>

