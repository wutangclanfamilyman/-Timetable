<?php  

	$ID = intval($_GET['ID']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="DELETE FROM `Complex_Route` WHERE `Complex_Route`.`ID_Complex_Route` = ".$ID."";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Інформація не видалена. Спробуйте пізніше.");
	}
	else{
		echo "Інформація видалена!";
	}

	mysqli_close($con);
?>