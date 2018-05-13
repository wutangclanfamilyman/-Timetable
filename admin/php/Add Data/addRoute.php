<?php  

	$r = strval($_GET['r']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="INSERT INTO `Route`(`Number`) VALUES ('".$r."')";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Маршрут не додано. Спробуйте пізніше.");
	}
	else{
		echo "Маршрут додано!";
	}

	mysqli_close($con);
?>