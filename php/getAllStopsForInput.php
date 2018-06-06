<?php  
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	include "../php/config.php";
	 
	$sql="SELECT `Stop`.`ID_Stop` AS ID , `Stop`.`Name` AS NameStop, `Stop`.`Latitude` AS Latitude, `Stop`.`Longitude` AS Longitude, city.Name AS NameCity FROM Stop INNER JOIN City AS city ON city.`ID_City` = `Stop`.`ID_City`";
	$result = mysqli_query($con,$sql);
	while($rs = mysqli_fetch_array($result)) {
    	 echo "<option data-value=".$rs['ID'].">".$rs['NameStop']." (".$rs['NameCity'].")</option>";
	}
	mysqli_close($con);
?>