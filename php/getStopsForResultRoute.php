<?php  

	$F = intval($_GET['F']);
  $S = intval($_GET['S']);
  $R = intval($_GET['R']);
  $outp = "[";
	
  include "../php/config.php";
  
	$sql="SELECT `Complex_Route`.`ID_Direction` AS D FROM `Complex_Route` WHERE `Complex_Route`.`ID_Route` = ".$R." AND `Complex_Route`.`ID_Stop` IN (".$F.",".$S.") LIMIT 1";
	
	$result = mysqli_query($con,$sql);

	while($row = mysqli_fetch_array($result)) {
    $sqlS="SELECT `Complex_Route`.`ID_Complex_Route` AS ID_Start, Second.ID_Finish AS ID_Finish FROM `Complex_Route`, (SELECT `Complex_Route`.`ID_Complex_Route` AS ID_Finish FROM `Complex_Route` WHERE `Complex_Route`.`ID_Direction` =".$row['D']." AND `Complex_Route`.`ID_Stop` = ".$F.") AS Second WHERE `Complex_Route`.`ID_Direction` = ".$row['D']." AND `Complex_Route`.`ID_Stop` = ".$S."";
    $resultS = mysqli_query($con,$sqlS);
    while ($res = mysqli_fetch_array($resultS)) {
        $sqlT = "SELECT s.Name AS Name, s.Latitude AS Lat, s.Longitude AS Lng FROM `Complex_Route` INNER JOIN `Stop` AS s ON s.`ID_Stop` = `Complex_Route`.`ID_Stop` WHERE `Complex_Route`.`ID_Complex_Route` >= ".$res['ID_Start']." AND `Complex_Route`.`ID_Complex_Route` <= ".$res['ID_Finish']."";
        $resultT = mysqli_query($con,$sqlT);
        while ($resT = mysqli_fetch_array($resultT)) {
            if ($outp != "[") {$outp .= ",";}
          $outp .= '{"id":"'.$rs["ID"].'",';  
          $outp .= '"lat":"'.$rs["Lat"].'",';
          $outp .= '"lng":"'.$rs["Lng"].'"}';
        }
      }
    }
  $outp .="]";
  echo $outp;
	mysqli_close($con);
?>