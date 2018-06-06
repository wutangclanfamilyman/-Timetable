<?php  

	$r = strval($_GET['r']);

	include "../../php/config.php";
	
	$sql="INSERT INTO `Route`(`Number`) VALUES ('".$r."')";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Маршрут не додано. Спробуйте пізніше.");
	}
	else{
		echo "Маршрут додано!";
	}

	mysqli_close($con);
?>