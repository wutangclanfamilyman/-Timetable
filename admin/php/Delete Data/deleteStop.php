<?php  

	$S = intval($_GET['S']);

	include "../../php/config.php";
	
	$sql="DELETE FROM `Stop` WHERE `Stop`.`ID_Stop` = '".$S."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Зупинка не видалена. Спробуйте пізніше.");
	}
	else{
		echo "Зупинка видалена!";
	}

	mysqli_close($con);
?>