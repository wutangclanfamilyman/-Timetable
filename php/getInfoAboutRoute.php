<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>


<?php  

	$r = intval($_GET['r']);
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");

	$sql="SELECT `Info_About_Route`.`ID_IAR` AS ID, `Info_About_Route`.`ID_Route` AS ID_Route, `Info_About_Route`.`ID_Direct` AS ID_Direct, `Info_About_Route`.`ID_Reverse` AS ID_Reverse, Dir.FStop AS FStop, Dir.SStop AS SStop, `Info_About_Route`.`Max_Price` AS Price, `Info_About_Route`.`Work_Time` AS Time, `Info_About_Route`.`Update_Date` AS Date FROM `Info_About_Route`, (SELECT `ID_Direction` AS ID, s1.ID_Stop AS ID_FStop, s1.ID_City AS ID_FStop_City, s2.ID_City AS ID_SStop_City, s2.ID_Stop AS ID_SStop, s1.Name AS FStop, s2.Name AS SStop FROM `Direction` 
INNER JOIN Stop AS s1 ON `Direction`.`ID_Start_Stop` = s1.`ID_Stop`
INNER JOIN Stop AS s2 ON `Direction`.`ID_Finish_Stop` = s2.`ID_Stop` 
WHERE `Direction`.`ID_Route` = ".$r.") AS Dir WHERE `Info_About_Route`.`ID_Route` = ".$r." LIMIT 1";
	
	$result = mysqli_query($con,$sql);

	while($row = mysqli_fetch_array($result)) {
		echo "      <div class='row price'>
                  <p>Ціна за проїзд: <span>" .$row['Price'] . " грн</span></p>
                </div>
                <div class='row time_work'>
                  <p>Час роботи: <span>" .$row['Time'] . "</span></p>
                </div>
                <div class='row route_direct'>
                  <p>Маршрут (прямий): <span>".$row['FStop']." - ".$row['SStop']."</span></p>
                </div>
                <div class='row route_collision'>
                  <p>Маршрут (зворотній): <span>".$row['FStop']." - ".$row['SStop']."</span></p>
                </div>
                <div class='row date_update'>
                  <p>Дата оновлення: <span>" .$row['Date'] . "</span></p>
                </div>
                <div class='row buttons'>
                  <a href='' value=" .$row['ID_Route'] . " id='btnInfoOfStops'></a>
                  <a href='' value=" .$row['ID_Route'] . " id='btnSaveNumberRoute'></a>
                </div>";
	}
	mysqli_close($con);
?>

</body>
</html>