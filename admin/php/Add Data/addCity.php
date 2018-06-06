<?php  

	$n = strval($_GET['n']);

	include "../../php/config.php";
	
	$sql="INSERT INTO `City`(`Name`) VALUES ('".$n."')";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Місто не додано. Спробуйте пізніше.");
	}
	else{
		echo "Місто додано!";
	}

	mysqli_close($con);
?>