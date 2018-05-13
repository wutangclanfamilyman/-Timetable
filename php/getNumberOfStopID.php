<?php  
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	$s = intval($_GET['s']);
	$allID=array();
	date_default_timezone_set("Europe/Kiev");
	$today = date("H:i");
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT r1.`ID_Route` AS ID, r1.`Number` AS Num, `Complex_Route`.`ID_Direction` AS Direction FROM `Complex_Route` INNER JOIN Route AS r1 ON r1.ID_Route = `Complex_Route`.`ID_Route` WHERE `Complex_Route`.`ID_Stop` = '".$s."'";
	// $sql="SELECT `Departure_Time`.`Time_Start` AS Start, `Complex_Route`.`Span` AS Span FROM `Departure_Time`, `Complex_Route` WHERE `Departure_Time`.`ID_Route` = 1 AND `Complex_Route`.`ID_Stop` = '".$s."'";
	$result = mysqli_query($con,$sql);
	//echo $today;
	while($row = mysqli_fetch_array($result)) {
		$dir = $row["Direction"];
		$query = "SELECT `Departure_Time`.`Time_Start` AS Start, `Complex_Route`.`Span` AS Span, dir.St AS Finish FROM `Departure_Time`, `Complex_Route`, (SELECT S.Name AS St FROM `Direction` INNER JOIN `Stop` AS S ON S.ID_Stop = `Direction`.ID_Finish_Stop WHERE `Direction`.ID_Direction = '".$dir."') AS dir WHERE `Departure_Time`.`ID_Route` = '".$row["ID"]."' AND `Complex_Route`.`ID_Stop` = '".$s."' AND `Departure_Time`.`ID_Direction` = '".$dir."' AND `Departure_Time`.`Weekend` = 0";
		$res = mysqli_query($con, $query);
    	while($time = mysqli_fetch_array($res)) {
    	$span = strtotime($time["Span"]) - strtotime("00:00:00"); // это просто время
		$start = strtotime($time["Start"]);
    	$date = date("H:i", $start + $span) . "\n";
    	if ($today < $date) {
    		echo "<div class='numbersWindow'><button id='number' data-toggle='tab' href='#timetable' value='".$row["ID"]."' onclick='ShowDirection(value);'>".$row["Num"]."</button><span> Отправление в  ".$date."</span><input type='hidden' id='dirNumber' value='".$dir."'></div>";
    		break;
    		}
		}
		echo "<span> (на ".$time["Finish"].")</span>";
	}
	echo "<div class='buttonsForInput'><button id='pointA' data-toggle='tab' href='#route' value='".$s."' onclick='toInputA(this.value, ".$dir.")'>Маршрут звідси</button><button id='pointB' data-toggle='tab' href='#route' value='".$s."' onclick='toInputB(this.value)'>Маршрут сюди</button></div>";
	mysqli_close($con);
?>