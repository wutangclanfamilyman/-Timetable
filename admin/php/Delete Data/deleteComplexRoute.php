<?php  

	$ID = intval($_GET['ID']);

	include "../../php/config.php";
	
	$sql="DELETE FROM `Complex_Route` WHERE `Complex_Route`.`ID_Complex_Route` = ".$ID."";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Інформація не видалена. Спробуйте пізніше.");
	}
	else{
		echo "Інформація видалена!";
	}

	mysqli_close($con);
?>