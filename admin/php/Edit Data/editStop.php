<?php  
	$id = intval($_GET['ID']);
	$n = strval($_GET['Name']);
	$lat = strval($_GET['lat']);
	$lng = strval($_GET['lng']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="UPDATE `Stop` SET `Name` = '".$n."', `Latitude` = '".$lat."', `Longitude` = '".$lng."' WHERE `ID_Stop` = '".$id."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Зупинка не додана. Спробуйте пізніше.");
	}
	else{
		echo "Зупинку відредаговано!";
	}

	mysqli_close($con);
?>