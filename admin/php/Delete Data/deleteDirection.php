<?php  

	$D = intval($_GET['D']);

	include "../../php/config.php";
	
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