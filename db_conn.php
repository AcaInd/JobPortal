<?php

$dbuser = "root";
$dbhost = "localhost";
$dbname = "job_portal";
$dbpass = "";

$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$connection) {
	die("Not connected" . mysqli_connect_error());
}
