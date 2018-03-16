<?php  	
	$r = intval($_GET['r']);
	$d = intval($_GET['d']);
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");

	$sql="SELECT s1.Latitude AS Lat, s1.Longitude AS Lng FROM `Complex_Route` INNER JOIN `Stop` AS s1 ON s1.ID_Stop = `Complex_Route`.`ID_Stop` WHERE `Complex_Route`.`ID_Route` = '".$r."' AND `Complex_Route`.`ID_Direction` = '".$d."'";
	
	$result = mysqli_query($con,$sql);
	$outp = "[";
	while($rs = mysqli_fetch_array($result)) {
    	if ($outp != "[") {$outp .= ",";}
    	$outp .= '{"lat":"'   . $rs["Lat"]        . '",';
    	$outp .= '"lng":"'. $rs["Lng"]     . '"}'; 
	}
	$outp .="]";
	echo $outp;
	mysqli_close($con);
?>