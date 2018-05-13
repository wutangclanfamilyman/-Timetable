<?php  

	$T = intval($_GET['T']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="DELETE FROM `Transfer` WHERE `Transfer`.`ID_Transfer` = '".$T."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Пересадка не видалена. Спробуйте пізніше.");
	}
	else{
		echo "Пересадка видалена!";
	}

	mysqli_close($con);
?>