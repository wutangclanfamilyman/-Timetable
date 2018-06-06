<?php
 	$db_host = "localhost";
    $db_name = "Transport";
    $db_user = "root";
    $db_pass = "";
	$con = mysqli_connect($db_host,$db_user,$db_pass,$db_name);
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
?>