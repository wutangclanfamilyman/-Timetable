<?php  
	$id = intval($_GET['ID']);
	$n = strval($_GET['Number']);

	include "../../php/config.php";
	
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