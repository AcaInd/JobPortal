<!DOCTYPE html>
<html>

<head>
	<title>WELCOME</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

	<h1> &nbsp &nbsp Online Job Portal &nbsp &nbsp </h1>

	<div class='container'>
		<form action="login.php" method="post">
			<h2>Job Seeker</h2>
			<font color='green'>✔</font> Add your qualifications<br>
			<font color='green'>✔</font> Find matching job profiles<br>
			<font color='green'>✔</font> Filter job profiles<br>
			<font color='green'>✔</font> Update your profile<br>
			<p>


				<a href="signInPage.php?userType=seeker" class="ca">Continue as Job Seeker</a>
		</form>
		&nbsp &nbsp



		<form action="login.php" method="post">
			<h2> Job Provider</h2>



			<font color='green'>✔</font> Add job profiles<br>
			<font color='green'>✔</font> Edit job profiles<br>
			<font color='green'>✔</font> Remove job profiles<br>
			<font color='green'>✔</font> Manage company profile<br>

			<p>


				<a href="signInPage.php?userType=provider" class="ca">Continue as Job Provider</a>
		</form>

	</div>
</body>




</html>