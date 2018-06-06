<?php  

	$R = intval($_GET['R']);

	include "../../php/config.php";
	
	$sql="DELETE FROM `Info_About_Route` WHERE `Info_About_Route`.`ID_IAR` = '".$R."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Інформація не видалена. Спробуйте пізніше.");
	}
	else{
		echo "Інформація видалена!";
	}

	mysqli_close($con);
?>