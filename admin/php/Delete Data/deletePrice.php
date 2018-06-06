<?php  

	$P = intval($_GET['P']);

	include "../../php/config.php";
	
	$sql="DELETE FROM `Price` WHERE `Price`.`ID_Price` = '".$P."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Ціна не видалена. Спробуйте пізніше.");
	}
	else{
		echo "Ціна видалена!";
	}

	mysqli_close($con);
?>