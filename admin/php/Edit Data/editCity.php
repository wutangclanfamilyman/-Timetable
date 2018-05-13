<?php  
	$id = intval($_GET['ID']);
	$n = strval($_GET['Name']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="UPDATE `City` SET `Name` = '".$n."' WHERE `ID_City` = '".$id."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Назва незмінена. Спробуйте пізніше.");
	}
	else{
		echo "Назву міста змінено!";
	}

	mysqli_close($con);
?>