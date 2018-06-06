<?php  

	$c = intval($_GET['c']);
	
	include "../php/config.php";

	$sql="SELECT r1.ID_Route AS ID, r1.Number AS Num FROM `RouteByCity` INNER JOIN Route AS r1 ON r1.ID_Route = `RouteByCity`.`ID_Route` WHERE `RouteByCity`.`ID_City` = '".$c."'";
	
	$result = mysqli_query($con,$sql);

	while ($row = mysqli_fetch_array($result)) {
		echo "<button class='number' onclick='ShowDirection(this.value)' value=" . $row['ID'] . ">" . $row['Num'] . "</button>";
	}
	mysqli_close($con);
?>