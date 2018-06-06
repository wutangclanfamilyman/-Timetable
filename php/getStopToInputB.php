<?php  

	$s = intval($_GET['s']);
	
	include "../php/config.php";

	$sql="SELECT `Stop`.`Name` AS Name FROM `Stop` WHERE `Stop`.`ID_Stop` = ".$s."";
	
	$result = mysqli_query($con,$sql);
	while ($row = mysqli_fetch_array($result)) {
		echo $row["Name"];
	}
	mysqli_close($con);
?>