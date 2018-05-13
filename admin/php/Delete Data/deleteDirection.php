<?php  

	$D = intval($_GET['D']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="DELETE FROM `Direction` WHERE `Direction`.`ID_Direction` = '".$D."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Напрямок не видалено. Спробуйте пізніше.");
	}
	else{
		echo "Напрямок видалено!";
	}

	mysqli_close($con);
?>