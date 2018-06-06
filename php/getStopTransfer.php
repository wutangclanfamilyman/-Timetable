<?php  

	$a = intval($_GET['a']);
	$b = intval($_GET['b']);
	
	include "../php/config.php";
	
	$sql="SELECT `Complex_Route`.`ID_Route` AS Route FROM `Complex_Route` WHERE `Complex_Route`.`ID_Stop` IN ('".$a."','".$b."')";
	$arr = array();
	$result = mysqli_query($con,$sql);
	if (!$result) {
	    die('Could not connect: ' . mysqli_error($result));
	}
	while ($routes = mysqli_fetch_array($result)) {
		array_push($arr, $routes["Route"]);
	}
	$query = "SELECT StopByRoute.Stop AS Stops FROM ( SELECT `Complex_Route`.`ID_Stop` AS Stop FROM `Complex_Route` WHERE `Complex_Route`.`ID_Route` = '".$arr[0]."' OR `Complex_Route`.`ID_Route` = '".$arr[1]."' ) AS StopByRoute GROUP BY StopByRoute.Stop HAVING count(*)>1 ORDER BY Stops DESC LIMIT 1 ";

	$res = mysqli_query($con, $query);
	if (!$res) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	while ($stops = mysqli_fetch_array($res)) {
		echo $stops["Stops"];
	}
	mysqli_close($con);
?>