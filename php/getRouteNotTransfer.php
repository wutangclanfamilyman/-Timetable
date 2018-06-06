<?php  

	$F = intval($_GET['F']);
  $S = intval($_GET['S']);
  date_default_timezone_set("Europe/Kiev");
  $today = date("H:i");
	
  include "../php/config.php";
  
  $sql="SELECT `Stop`.`ID_Stop` AS ID, `Stop`.`Name` AS Name FROM `Stop` WHERE `Stop`.`ID_Stop` = ".$F."";
  $result = mysqli_query($con,$sql);
  if (!$result) {
      die('Could not connect: ' . mysqli_error($con));
  }
  while($row = mysqli_fetch_array($result)) {
    $FromStop = $row['Name'];
  }
  $sql="SELECT `Stop`.`ID_Stop` AS ID, `Stop`.`Name` AS Name FROM `Stop` WHERE `Stop`.`ID_Stop` = ".$S."";
  $result = mysqli_query($con,$sql);
  if (!$result) {
      die('Could not connect: ' . mysqli_error($result));
  }
  while($row = mysqli_fetch_array($result)) {
    $ToStop = $row['Name'];
  }
	$sql="SELECT R.ID_Route AS ID, r1.Number AS Num FROM (
    SELECT `Complex_Route`.`ID_Route` AS ID_Route FROM `Complex_Route` WHERE `Complex_Route`.`ID_Stop`= '".$F."'
    UNION ALL
    SELECT `Complex_Route`.`ID_Route` FROM `Complex_Route` WHERE `Complex_Route`.`ID_Stop`= '".$S."') AS R INNER JOIN Route AS r1 ON r1.ID_Route = R.ID_Route 
    GROUP BY ID HAVING COUNT(*) > 1";
	
	$result = mysqli_query($con,$sql);

	while($row = mysqli_fetch_array($result)) {
    $sqlS="SELECT TIMESTAMPDIFF(MINUTE, MIN(`Complex_Route`.`Span`), MAX(`Complex_Route`.`Span`)) AS T, P.M AS Price FROM `Complex_Route`, (SELECT Money AS M FROM Price WHERE ID_Route = '".$row['ID']."' AND ID_First_Stop = '".$F."' AND ID_Second_Stop = '".$S."') AS P WHERE `Complex_Route`.`ID_Route` = '".$row['ID']."' AND `Complex_Route`.`ID_Stop` IN ('".$F."','".$S."')";
    $resultS = mysqli_query($con,$sqlS);
    while ($res = mysqli_fetch_array($resultS)) {
       $sqlDirection = "SELECT `Complex_Route`.`ID_Direction` AS Direction FROM `Complex_Route` WHERE `Complex_Route`.`ID_Route` = '".$row['ID']."' AND `Complex_Route`.`ID_Stop` = '".$F."'";
       $resultDirection = mysqli_query($con,$sqlDirection);
       while($rowDirection = mysqli_fetch_array($resultDirection)){
          $Direction = $rowDirection['Direction'];
          $sqlTime = "SELECT `Departure_Time`.`Time_Start` AS Start, `Complex_Route`.`Span` AS Span FROM `Departure_Time`, `Complex_Route` WHERE `Departure_Time`.`ID_Route` = '".$row["ID"]."' AND `Complex_Route`.`ID_Stop` = '".$F."' AND `Departure_Time`.`ID_Direction` = '".$Direction."' AND `Departure_Time`.`Weekend` = 0";
          $resultTime = mysqli_query($con, $sqlTime);
          while($time = mysqli_fetch_array($resultTime)) {
            $span = strtotime($time["Span"]) - strtotime("00:00:00"); // это просто время
            $start = strtotime($time["Start"]);
            $date = date("H:i", $start + $span) . "\n";
            if ($today < $date) {
              echo "<div class='container-route-not-transfer'>
               <div class='row'>
                <div class='col-sm-6 col-xs-6 col-md-6 route text-center'>
                <p class='time-start' placeholder='Час відправки'>в ".$date."</p>
                  <div class='row'><label class='label label-info'>".$FromStop."</label></div>
                          <div class='row'><i class='fa fa-ellipsis-v'></i></div>
                  <div class='row'>
                    <button class='number' value='".$row['ID']."' data-toggle='tab' href='#timetable' title='Номер маршруту' onclick='ShowDirection(value);'><i class='fa fa-bus'></i> ".$row['Num']."</button>
                  </div>
                  <div class='row'><i class='fa fa-ellipsis-v'></i></div>
                          <div class='row'><label class='label label-info'>".$ToStop."</label></div>
                </div>
                <div class='col-sm-6 col-xs-6 col-md-6 info'>
                  <div class='row price text-right'>
                    <label class='label label-success' title='Загальна сума'><i class='fa fa-money-bill-alt'></i> ".$res['Price']." грн</label>
                  </div>
                  <div class='row time text-right'>
                    <label class='label label-info' title='Загальний час'><i class='fa fa-stopwatch'></i> ".$res['T']." хв</label>
                  </div>
                  <div class='row show text-right'>
                    <a class='btn label-info' title='Показати на карті' onclick='getPolylineForNotTransfer(".$row['ID'].", ".$F.",".$S.")'><i class='fa fa-map'></i> Показати</a>
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
	mysqli_close($con);
?>