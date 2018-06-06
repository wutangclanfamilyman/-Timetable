<?php  

	$d = intval($_GET['d']);
	$w = intval($_GET['w']);
	date_default_timezone_set("Europe/Kiev");
	$today = date("H:i:s");
	$counter = 0;
	
	include "../php/config.php";

	$sql="SELECT `Departure_Time`.`Time_Start` AS Time FROM `Departure_Time` WHERE `Departure_Time`.`ID_Direction` = '".$d."' AND `Departure_Time`.`Weekend` = '".$w."'";
	
	$result = mysqli_query($con,$sql);

	while ($row = mysqli_fetch_array($result)) {
		if ($today < $row['Time']) {	
			if ($counter <= 2) {
				echo " <a class='now'> ".$row['Time']."</a>";
				$counter++;
			}
			else{
				echo " <a class='coming'> ".$row['Time']."</a>";
			}
		}
		else{
			echo " <a class='default'> ".$row['Time']."</a>";
		}
	}
	mysqli_close($con);
?>