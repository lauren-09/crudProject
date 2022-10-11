<?php

session_start();
require 'dbconn.php';

$studentID = htmlspecialchars(trim($_GET['id']));
$firstname = htmlspecialchars(trim($_POST['firstname']));
$lastname = htmlspecialchars(trim($_POST['lastname']));
$email = htmlspecialchars(trim($_POST['email']));
$phone = htmlspecialchars(trim($_POST['phone']));
$course = htmlspecialchars(trim($_POST['course']));



if(empty($firstname) || empty($lastname) || empty($email) || empty($phone) || empty($course)) {
	echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>Oops!</strong> Please fill all frequired field bellow.
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
	';
}

else{
	$sql = "UPDATE students SET firstname = '$firstname', lastname = '$lastname', email = '$email', phone = '$phone', course = '$course' WHERE id = '$studentID'";
	
	if ($conn->query($sql) === TRUE) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Thank you!</strong> You successfullly add a student.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    } else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}
