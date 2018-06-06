<?php  

	$T = intval($_GET['T']);

	include "../../php/config.php";
	
	$sql="DELETE FROM `Transfer` WHERE `Transfer`.`ID_Transfer` = '".$T."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Пересадка не видалена. Спробуйте пізніше.");
	}
	else{
		echo "Пересадка видалена!";
	}

	mysqli_close($con);
?>