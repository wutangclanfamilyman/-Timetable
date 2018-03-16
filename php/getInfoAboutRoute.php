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

	$sql="SELECT c1.`Name` AS City, `Info_About_Route`.`ID_Route`, r1.`Number` AS Num, `Max_Price`, `Work_Time`, `Direction_Straight`, `Direction_Back`, `UPDATE_DATE` FROM `Info_About_Route` INNER JOIN `City` AS c1 ON c1.`ID_City` = `Info_About_Route`.`ID_City` INNER JOIN `Route` AS r1 ON r1.`ID_Route` = `Info_About_Route`.`ID_Route` WHERE `Info_About_Route`.`ID_Route` = '".$r."'";
	
	$result = mysqli_query($con,$sql);

	while($row = mysqli_fetch_array($result)) {
		echo "      <div class='row number_city'>
                  <p>Місто: <span>" .$row['City'] . "</span></p>
                </div>
                <div class='row number_route'>
                  <p>Маршрут №: <span>" .$row['Num'] . "</span></p>
                </div>
                <div class='row price'>
                  <p>Ціна за проїзд: <span>" .$row['Max_Price'] . " грн</span></p>
                </div>
                <div class='row time_work'>
                  <p>Час роботи: <span>" .$row['Work_Time'] . "</span></p>
                </div>
                <div class='row route_direct'>
                  <p>Маршрут (прямий): <span>" .$row['Direction_Straight'] . "</span></p>
                </div>
                <div class='row route_collision'>
                  <p>Маршрут (зворотній): <span>" .$row['Direction_Back'] . "</span></p>
                </div>
                <div class='row date_update'>
                  <p>Дата оновлення: <span>" .$row['UPDATE_DATE'] . "</span></p>
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