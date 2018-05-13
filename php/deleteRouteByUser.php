<?php  

	$id = intval($_GET['id']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="DELETE FROM `Users_Route` WHERE `Users_Route`.`ID_Users_Route` = '".$id."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Маршрут не видалено. Спробуйте пізніше.");
	}
	else{
		echo "Маршрут видалено!";
	}

	mysqli_close($con);
?>