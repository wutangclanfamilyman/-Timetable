<?php  
	$id = intval($_GET['ID']);
	$n = strval($_GET['Number']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="UPDATE `Route` SET `Number` = '".$n."' WHERE `ID_Route` = '".$id."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Номер маршруту незмінений. Спробуйте пізніше.");
	}
	else{
		echo "Номер маршруту змінено!";
	}

	mysqli_close($con);
?>