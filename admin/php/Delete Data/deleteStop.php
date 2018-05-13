<?php  

	$S = intval($_GET['S']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="DELETE FROM `Stop` WHERE `Stop`.`ID_Stop` = '".$S."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Зупинка не видалена. Спробуйте пізніше.");
	}
	else{
		echo "Зупинка видалена!";
	}

	mysqli_close($con);
?>