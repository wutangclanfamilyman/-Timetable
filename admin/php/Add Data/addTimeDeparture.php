<?php  

	$R = intval($_GET['R']);
	$D = intval($_GET['D']);
	$W = intval($_GET['W']);
	$T = explode(",", $_GET['T']);		

	include "../../php/config.php";
	
	for ($i=0; $i <= count($T)-1; $i++) { 
		$sql="INSERT INTO `Departure_Time`(`ID_Route`, `ID_Direction`, `Time_Start`, `Weekend`) VALUES (".$R.", ".$D.", '".$T[$i].":00', ".$W.");";
		$result = mysqli_query($con,$sql);
		if (!$result) {
			echo die("Не додано. Спробуйте пізніше.");
			return;
			}
	}
	echo "Розклад відправлень створений!";

	mysqli_close($con);
?>