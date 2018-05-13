<?php  

	$n = strval($_GET['n']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="INSERT INTO `City`(`Name`) VALUES ('".$n."')";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Місто не додано. Спробуйте пізніше.");
	}
	else{
		echo "Місто додано!";
	}

	mysqli_close($con);
?>