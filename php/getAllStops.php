<?php  
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT `Stop`.`ID_Stop` AS ID , `Stop`.`Name` AS NameStop, `Stop`.`Latitude` AS Latitude, `Stop`.`Longitude` AS Longitude, city.Name AS NameCity FROM Stop INNER JOIN City AS city ON city.`ID_City` = `Stop`.`ID_City`";
	$result = mysqli_query($con,$sql);
	$outp = "[";
	while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    	if ($outp != "[") {$outp .= ",";}
    	$outp .= '{"id":"'  . $rs["ID"] . '",';
    	$outp .= '"title":"'  . $rs["NameStop"] . '",';
    	$outp .= '"city":"'  . $rs["NameCity"] . '",';
    	$outp .= '"lat":"'   . $rs["Latitude"]        . '",';
    	$outp .= '"lng":"'. $rs["Longitude"]     . '"}'; 
	}
	$outp .="]";
	echo $outp;
	mysqli_close($con);
?>