<?php
session_start();
include "../db_conn.php";

$userType = $_SESSION['userType'];

function validate($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if (
	isset($_POST['uname'])
	&& isset($_POST['password'])
	&& isset($_POST['re_password'])
) {



	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	$re_pass = validate($_POST['re_password']);


	$user_data = 'uname=' . $uname . '&userType=' . $userType;


	if (empty($uname)) {
		header("Location: signup.php?error=User Name is required&$user_data");
		exit();
	} else if (empty($pass)) {
		header("Location: signup.php?error=Password is required&$user_data");
		exit();
	} else if (empty($re_pass)) {
		header("Location: signup.php?error=Re Password is required&$user_data");
		exit();
	} else if ($pass != $re_pass) {
		header("Location: signup.php?error=The confirmation password  does not match&$user_data");
		exit();
	} else {

		// hashing the password

		// $pass = md5($pass);

		$sql = "SELECT * FROM user WHERE user_id='$uname' ";
		$result = mysqli_query($connection, $sql);

		if (mysqli_num_rows($result) > 0) {
			header("Location: signup.php?error=The username is taken try another&$user_data");
			exit();
		} else {
			$sql2 = "INSERT INTO user(user_id, password, type) VALUES('$uname', '$pass', '$userType')";
			$result2 = mysqli_query($connection, $sql2);
			if ($result2) {
				header("Location: signInPage.php?success=Your account has been created successfully&$user_data");
				exit();
			} else {
				header("Location: signInPage.php?error=unknown error occurred&$user_data");
				exit();
			}
		}
	}
} else {
	header("Location: signup.php?$user_data");
	exit();
}
