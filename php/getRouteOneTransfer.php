<?php  
	
	$F = intval($_GET['F']);
	$S = intval($_GET['S']);
	$From = [];
	$To = [];
	$FromStop;
	$ToStop;
	date_default_timezone_set("Europe/Kiev");
	$today = date("H:i");
	include "../php/config.php";
	
	$sql="SELECT `Stop`.`Name` AS Name FROM `Stop` WHERE `Stop`.`ID_Stop` = ".$F."";
	$result = mysqli_query($con,$sql);
	if (!$result) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	while($row = mysqli_fetch_array($result)) {
    	$FromStop = $row['Name'];
	}
	$sql="SELECT `Stop`.`Name` AS Name FROM `Stop` WHERE `Stop`.`ID_Stop` = ".$S."";
	$result = mysqli_query($con,$sql);
	if (!$result) {
	    die('Could not connect: ' . mysqli_error($result));
	}
	while($row = mysqli_fetch_array($result)) {
    	$ToStop = $row['Name'];
	}
	$sql="SELECT `Complex_Route`.`ID_Route` AS ID_Route_From FROM `Complex_Route` WHERE `Complex_Route`.`ID_Stop` = ".$F." ORDER BY ID_Route_From";
	$result = mysqli_query($con,$sql);
	if (!$result) {
	    die('Could not connect: ' . mysqli_error($result));
	}
	while($row = mysqli_fetch_array($result)) {
    	array_push($From, $row['ID_Route_From']);
	}
	$sql="SELECT `Complex_Route`.`ID_Route` AS ID_Route_To FROM `Complex_Route` WHERE `Complex_Route`.`ID_Stop` = ".$S." ORDER BY ID_Route_To";
	$result = mysqli_query($con,$sql);
	if (!$result) {
	    die('Could not connect: ' . mysqli_error($result));
	}
	while($row = mysqli_fetch_array($result)) {
    	array_push($To, $row['ID_Route_To']);
	}
	for ($i=0; $i < count($From); $i++) { 
		for ($j=0; $j < count($To); $j++) { 
			$sql="SELECT `Transfer`.`ID_Stop_From` AS FS_ID, s1.Name AS FS_Name, `Transfer`.`ID_Stop_To` AS SS_ID, s2.Name AS SS_Name, `Transfer`.`ID_Route_From` AS FR_ID, r1.Number AS FR_Number, `Transfer`.`ID_Route_To` AS SR_ID, r2.Number AS SR_Number FROM `Transfer`
				INNER JOIN `Stop` AS s1 ON s1.ID_Stop = `Transfer`.`ID_Stop_From`
				INNER JOIN `Stop` AS s2 ON s2.ID_Stop = `Transfer`.`ID_Stop_To`
				INNER JOIN `Route` AS r1 ON r1.ID_Route = `Transfer`.`ID_Route_From`
				INNER JOIN `Route` AS r2 ON r2.ID_Route = `Transfer`.`ID_Route_To`
				WHERE `Transfer`.`ID_Route_From` = ".$From[$i]." AND `Transfer`.`ID_Route_To` = ".$To[$j]."";
				$result = mysqli_query($con,$sql);
				if (!$result) {
				    die('Could not connect: ' . mysqli_error($con));
				}
				if (empty($result)) {
					echo "Немає результатів!";
					return;
				}
				while ($row = mysqli_fetch_array($result)) {
					$sqlS = "SELECT TIMESTAMPDIFF(MINUTE, MIN(`Complex_Route`.`Span`), MAX(`Complex_Route`.`Span`)) AS T, Secondtime.T AS ST, FPrice.M AS FMoney, SPrice.M AS SMoney, Dir.Direction AS Direction
						FROM `Complex_Route`, (SELECT TIMESTAMPDIFF(MINUTE, MIN(`Complex_Route`.`Span`), MAX(`Complex_Route`.`Span`)) AS T FROM `Complex_Route` WHERE `Complex_Route`.`ID_Route` = ".$row['SR_ID']." AND `Complex_Route`.`ID_Stop` IN (".$row['SS_ID'].",".$S.")) AS Secondtime, (SELECT Money AS M FROM Price WHERE ID_Route = ".$row['FR_ID']." AND ID_First_Stop = ".$F." AND ID_Second_Stop = ".$row['FS_ID'].") AS FPrice, (SELECT Money AS M FROM Price WHERE ID_Route = ".$row['SR_ID']." AND ID_First_Stop = ".$row['SS_ID']." AND ID_Second_Stop = ".$S.") SPrice, (SELECT `Complex_Route`.`ID_Direction` AS Direction FROM `Complex_Route` WHERE `Complex_Route`.`ID_Stop` = '".$F."') AS Dir WHERE `Complex_Route`.`ID_Route` = ".$row['FR_ID']." AND `Complex_Route`.`ID_Stop` IN (".$F.",".$row['FS_ID'].")";
					$results = mysqli_query($con,$sqlS);
					while ($rw = mysqli_fetch_array($results)){
						$time = $rw['T'] + $rw['ST'];
						$price = $rw['FMoney'] + $rw['SMoney'];
						if (empty($time) || empty($price)) {
							echo "Немає результатів!";
							return;
						}
						$sqlTime = "SELECT `Departure_Time`.`Time_Start` AS Start, `Complex_Route`.`Span` AS Span FROM `Departure_Time`, `Complex_Route` WHERE `Departure_Time`.`ID_Route` = '".$row["FR_ID"]."' AND `Complex_Route`.`ID_Stop` = '".$F."' AND `Departure_Time`.`ID_Direction` = '".$rw['Direction']."' AND `Departure_Time`.`Weekend` = 0";
						$resultTime = mysqli_query($con, $sqlTime);
						while ($rowTime = mysqli_fetch_array($resultTime)) {
							$span = strtotime($rowTime["Span"]) - strtotime("00:00:00"); // это просто время
							$start = strtotime($rowTime["Start"]);
    						$date = date("H:i", $start + $span) . "\n";
    						if ($today < $date) {
					    		echo "<div class='container-route-one-transfer'> 
		               <div class='row'>
		                <div class='col-sm-6 col-xs-6 col-md-6 route text-center'>
		                	<p class='time-start'>в ".$date."</p>
		                	<div class='row'><label class='label label-info'>".$FromStop."</label></div>
                      		<div class='row'><i class='fa fa-ellipsis-v'></i></div>
		                  <div class='row'>
		                    <button class='number' value='".$row['FR_ID']."' data-toggle='tab' href='#timetable' onclick='ShowDirection(value);'><i class='fa fa-bus'></i> ".$row['FR_Number']."</button>
		                  </div>
		                  <div class='row'> ".$rw['T']." хв <i class='fa fa-ellipsis-v'></i> ".$rw['FMoney']." грн</div>
		                  <div class='row'><label class='label label-danger'>".$row['FS_Name']."</label></div>
		                  <div class='row'>
		                    <i class='fa fa-long-arrow-alt-up'></i>
		                    <i class='fa fa-long-arrow-alt-down'></i>
		                  </div>
		                   <div class='row'><label class='label label-success'>".$row['SS_Name']."</label></div>
		                  <div class='row'> ".$rw['ST']." хв
		                    <i class='fa fa-ellipsis-v'></i> ".$rw['SMoney']." грн
		                  </div>
		                  <div class='row'>
		                    <button class='number' value='".$row['SR_ID']."' data-toggle='tab' href='#timetable' onclick='ShowDirection(value);'><i class='fa fa-bus'></i> ".$row['SR_Number']."</button>
		                  </div>
		                  <div class='row'><i class='fa fa-ellipsis-v'></i></div>
                      		<div class='row'><label class='label label-info'>".$ToStop."</label></div>
		                </div>
		                <div class='col-sm-6 col-xs-6 col-md-6 info'>
		                  <div class='row price text-right'>
		                    <label class='label label-success'><i class='fa fa-money-bill-alt'></i> ".$price." грн</label>
		                  </div>
		                  <div class='row time text-right'>
		                    <label class='label label-info'><i class='fa fa-stopwatch'></i> ".$time." хв</label>
		                  </div>
		                  <div class='row show text-right'>
		                    <a class='btn label-info' onclick='getPolylineForOneTransferFrom(".$row['FR_ID'].",".$row['SR_ID'].",".$row['FS_ID'].",".$row['SS_ID'].",".$F.",".$S.")'><i class='fa fa-map'></i> Показати</a>
		                  </div>
		                </div>
		               </div>
		             </div>";
					    		break;
					    		}
						}
						}
					}
				}
		}
	mysqli_close($con);
?>