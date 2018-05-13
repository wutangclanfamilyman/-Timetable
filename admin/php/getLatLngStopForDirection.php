<?php  
	$S = intval($_GET['S']);
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT Latitude AS Lat, Longitude AS Lng FROM Stop WHERE ID_Stop = '".$S."'";
	$result = mysqli_query($con,$sql);
	while ($row = mysqli_fetch_array($result)) {
		echo $row['Lat'].",".$row['Lng'];
	}
	mysqli_close($con);
?>