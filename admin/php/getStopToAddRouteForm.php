<?php  

	$city = intval($_GET['city']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT `Stop`.`ID_Stop` AS ID, `Stop`.`Name` AS Name FROM Stop WHERE `Stop`.`ID_City` = ".$city."";
	$result = mysqli_query($con,$sql);
	while ($row = mysqli_fetch_array($result)) {
		echo "<option value=" .$row['ID'] . ">" . $row['Name'] . "</option>";
	}

	mysqli_close($con);
?>