<?php

session_start();

include "../db_conn.php";

$userType = $_SESSION['user_type'];

function validate($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

if (isset($_POST['uname']) && isset($_POST['password'])) {

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	// checking if username and password are empty

	if (empty($uname)) {
		header("Location: signInPage.php?error=User Name is required&userType=$userType");
		exit();
	} else if (empty($pass)) {
		header("Location: signInPage.php?error=Password is required&userType=$userType");
		exit();
	} else {

		$q_loginUser = "SELECT * FROM user WHERE user_id ='$uname' AND password='$pass' AND type='$userType'";

		$res_loginUser = mysqli_query($connection, $q_loginUser);

		if (mysqli_num_rows($res_loginUser) == 1) {

			$row = mysqli_fetch_assoc($res_loginUser);

			if ($row['user_id'] == $uname && $row['password'] == $pass) {
				$_SESSION["username"] = $row['user_id'];

				// navigate to seeker's or provider's portal based on user type

				if ($userType == 'provider') {
					header("Location: ../jobProvider/providerProfile.php");
				} else if ($userType == 'seeker') {
					header("Location: ../jobSeeker/main.php");
				}

				exit();
			} else {
				header("Location: signInPage.php?error=Incorect User name or password&userType=$userType");
				exit();
			}
		} else {
			header("Location: signInPage.php?error=Incorect User name or password&userType=$userType");
			exit();
		}
	}
} else {
	header("Location: signInPage.php?userType=$userType");
	exit();
}
