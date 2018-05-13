<?php  

	$c = intval($_GET['c']);
	$n = strval($_GET['n']);
	$lat = strval($_GET['lat']);
	$lng = strval($_GET['lng']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="INSERT INTO `Stop`(`ID_City`, `Name`, `Latitude`, `Longitude`) VALUES ('".$c."', '".$n."', '".$lat."', '".$lng."')";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Зупинка не додана. Спробуйте пізніше.");
	}
	else{
		echo "Зупинка додана!";
	}

	mysqli_close($con);
?>