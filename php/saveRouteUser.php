<?php  

	$id = intval($_GET['id']);
	$route = intval($_GET['r']);
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql = "SELECT `Users_Route`.`ID_Users_Route` FROM `Users_Route` WHERE `Users_Route`.`ID_User` = ".$id." AND `Users_Route`.`ID_Route` = ".$route."";
	$res = mysqli_query($con,$sql);
	if ($res->num_rows > 0) {
		echo die("Данний маршрут вже збережений.");
	}
	$sql="INSERT INTO `Users_Route`(`ID_User`,`ID_Route`) VALUES ('".$id."', '".$route."') ";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Маршрут не збережений. Спробуйте пізніше.");
	}
	else{
		echo "Маршрут збережений!";
	}

	mysqli_close($con);
?>