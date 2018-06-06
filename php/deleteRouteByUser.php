<?php  

	$id = intval($_GET['id']);

	include "../php/config.php";
	
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