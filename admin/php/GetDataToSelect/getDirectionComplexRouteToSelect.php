<?php  

	$R = intval($_GET['R']);
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT `ID_Direction` AS ID, s1.`Name` AS FStop, s2.`Name` AS SStop FROM `Direction` INNER JOIN `Stop` AS s1 ON `Direction`.`ID_Start_Stop` = s1.`ID_Stop` INNER JOIN `Stop` AS s2 ON `Direction`.`ID_Finish_Stop` = s2.`ID_Stop` WHERE `Direction`.`ID_Route` = '".$R."'";
	$result = mysqli_query($con,$sql);
	echo "<option value='' changed>Не обрано</option>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<option value=" .$row['ID'] . ">" . $row['FStop'] . " - ". $row['SStop'] ."</option>";
	}
	mysqli_close($con);
?>