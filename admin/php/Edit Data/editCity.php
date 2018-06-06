<?php  
	$id = intval($_GET['ID']);
	$n = strval($_GET['Name']);

	include "../../php/config.php";

	$sql="UPDATE `City` SET `Name` = '".$n."' WHERE `ID_City` = '".$id."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Назва незмінена. Спробуйте пізніше.");
	}
	else{
		echo "Назву міста змінено!";
	}

	mysqli_close($con);
?>