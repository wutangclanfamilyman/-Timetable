<?php  

	$r = intval($_GET['r']);
	
	include "../php/config.php";

	$sql="SELECT `Direction`.`ID_Direction`, s1.`Name` AS First_Stop, s2.`Name` AS Second_Stop FROM `Direction` 
			INNER JOIN `Stop` AS s1 ON s1.`ID_Stop` = `Direction`.`ID_Start_Stop`
			INNER JOIN `Stop` AS s2 ON s2.`ID_Stop` = `Direction`.`ID_Finish_Stop` WHERE `Direction`.`ID_Route` = '".$r."'";
	
	$result = mysqli_query($con,$sql);
	while ($row = mysqli_fetch_array($result)) {
		echo "<option value=" . $row['ID_Direction'] . ">" . $row['First_Stop'] . " - " . $row['Second_Stop'] . "</option>";
	}
	mysqli_close($con);
?>