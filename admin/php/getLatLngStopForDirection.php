<?php  
	$S = intval($_GET['S']);
	
	include "../php/config.php";
	
	$sql="SELECT Latitude AS Lat, Longitude AS Lng FROM Stop WHERE ID_Stop = '".$S."'";
	$result = mysqli_query($con,$sql);
	while ($row = mysqli_fetch_array($result)) {
		echo $row['Lat'].",".$row['Lng'];
	}
	mysqli_close($con);
?>