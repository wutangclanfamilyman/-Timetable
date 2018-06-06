<?php  

	$R = intval($_GET['R']);
	$D = intval($_GET['D']);
	$RD = intval($_GET['RD']);
	$P = strval($_GET['P']);
	$T = strval($_GET['T']);		

	include "../../php/config.php";
	
	$sql="INSERT INTO `Info_About_Route`(`ID_Route`, `ID_Direct`, `ID_Reverse`, `Max_Price`, `Work_Time`, `Update_Date`) VALUES (".$R.", ".$D.", ".$RD.", '".$P."', '".$T."', CURDATE());";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Інформація не додана. Спробуйте пізніше.");
		return;
		}
	echo "Інформація додана!";

	mysqli_close($con);
?>