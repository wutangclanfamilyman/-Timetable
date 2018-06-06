<?php  

	$R = intval($_GET['R']);
	$D = intval($_GET['D']);

	$S = explode(",", $_GET['S']);
	$P = explode(",", $_GET['P']);		
	
	include "../../php/config.php";
	
	for ($i=0; $i < count($S); $i++) { 
		
		$sql="INSERT INTO `Complex_Route`(`ID_Route`, `ID_Direction`, `ID_Stop`, `Span`, `Priority`) 
		VALUES (".$R.", '".$D."', ".$S[$i].", '".$P[$i]."', ".($i+1).")";	
		$result = mysqli_query($con,$sql);
		if (!$result) {
			echo die('Маршрут не створений. Спробуйте пізніше.'. mysqli_error($con));
			return;
			}
	}

	 echo "Маршрут створений!";

	mysqli_close($con);
?>