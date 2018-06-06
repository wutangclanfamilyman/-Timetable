<?php  
	$id = intval($_GET['ID']);
	$price = intval($_GET['Price']);

	include "../../php/config.php";
	
	$sql="UPDATE `Price` SET `Price`.`Money` = '".$price."' WHERE `Price`.`ID_Price` = ".$id."";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Ціна маршруту незмінена. Спробуйте пізніше.");
	}
	else{
		echo "Ціна маршруту змінено!";
	}

	mysqli_close($con);
?>