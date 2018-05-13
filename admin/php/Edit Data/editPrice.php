<?php  
	$id = intval($_GET['ID']);
	$price = intval($_GET['Price']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="UPDATE `Price` SET `Price`.`Money` = '".$price."' WHERE `Price`.`ID_Price` = ".$id."";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Ціна маршруту незмінена. Спробуйте пізніше.");
	}
	else{
		echo "Ціна маршруту змінено!";
	}

	mysqli_close($con);
?>