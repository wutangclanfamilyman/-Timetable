<?php  

	$s = intval($_GET['s']);
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");

	$sql="SELECT `Stop`.`Name` AS Name FROM `Stop` WHERE `Stop`.`ID_Stop` = ".$s."";
	
	$result = mysqli_query($con,$sql);
	while ($row = mysqli_fetch_array($result)) {
		echo $row["Name"];
	}
	mysqli_close($con);
?>