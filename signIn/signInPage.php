<!-- previously index.php -->


<!DOCTYPE html>
<html>
<?php

session_start();
$userType = $_GET['userType'];
$_SESSION['user_type'] = $_GET['userType'];
?>

<head>
	<title>LOGIN</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div class='container'>

		<form action="login.php" method="post">
			<h2><?php echo "Job " . $userType ?> <br> LOGIN</h2>

			<!-- Print error message -->

			<?php if (isset($_GET['error'])) { ?>
				<p class="error"><?php echo $_GET['error']; ?></p>
			<?php } ?>

			<!-- Print success message -->

			<?php if (isset($_GET['success'])) { ?>
				<p class="success"><?php echo $_GET['success']; ?></p>
			<?php } ?>


			<label>User Name</label>
			<input type="text" name="uname" placeholder="User Name"><br>

			<label>Password</label>

			<input type="password" name="password" placeholder="Password"><br>

			<button type="submit">Login</button>

			<a href="<?php echo "signup.php?userType=$userType" ?>" ,class="ca">Create an account</a>
		</form>
	</div>
</body>



</html>