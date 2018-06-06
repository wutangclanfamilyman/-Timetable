<?php  
	$id = intval($_GET['ID']);
	$span = strval($_GET['Span']);

	include "../../php/config.php";
	
	$sql="UPDATE `Complex_Route` SET `Span` = '".$span."' WHERE `ID_Complex_Route` = '".$id."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Інформація маршруту незмінена. Спробуйте пізніше.");
	}
	else{
		echo "Інформація маршруту змінено!";
	}

	mysqli_close($con);
?>