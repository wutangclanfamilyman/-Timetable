<?php  

	$F = intval($_GET['F']);
  $S = intval($_GET['S']);
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
  
	$sql="SELECT R.ID_Route AS ID, r1.Number AS Num FROM (
    SELECT `Complex_Route`.`ID_Route` AS ID_Route FROM `Complex_Route` WHERE `Complex_Route`.`ID_Stop`= '".$F."'
    UNION ALL
    SELECT `Complex_Route`.`ID_Route` FROM `Complex_Route` WHERE `Complex_Route`.`ID_Stop`= '".$S."') AS R INNER JOIN Route AS r1 ON r1.ID_Route = R.ID_Route 
    GROUP BY ID HAVING COUNT(*) > 1";
	
	$result = mysqli_query($con,$sql);

	while($row = mysqli_fetch_array($result)) {
    $sqlS="SELECT TIMESTAMPDIFF(MINUTE, MIN(`Complex_Route`.`Span`), MAX(`Complex_Route`.`Span`)) AS T FROM `Complex_Route` WHERE `Complex_Route`.`ID_Route` = '".$row['ID']."' AND `Complex_Route`.`ID_Stop` IN ('".$F."','".$S."')";
    $resultS = mysqli_query($con,$sqlS);
    while ($res = mysqli_fetch_array($resultS)) {
       echo "<div class='container-route' onclick=''> 
               <div class='row'>
                 <span class='price'>10 грн</span>
                 <span class='time'>".$res['T']." хв</span>
               </div>
               <div class='row route'>
                 <button class='number' value='".$row['ID']."' href='#timetable' onclick='ShowDirection(value);'>".$row['Num']."</button>
               </div>
             </div>"; 
             break;
    }
		
	}
	mysqli_close($con);
?>