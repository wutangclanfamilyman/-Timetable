<?php  

	$F = intval($_GET['F']);
	$S = intval($_GET['S']);
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT `Transfer`.`ID_Transfer`, `Transfer`.`ID_Stop_From` AS F, `Transfer`.`ID_Stop_To` AS T, s1.Name AS FSName, s2.Name AS SSName, r1.ID AS R1ID, r2.ID AS R2ID, r1.Num AS R1Num, r2.Num AS R2Num FROM (Transfer, (SELECT `Complex_Route`.`ID_Route` AS ID, route.Number AS Num FROM `Complex_Route` INNER JOIN Route AS route ON route.ID_Route = `Complex_Route`.`ID_Route` WHERE `Complex_Route`.`ID_Stop` = ".$F." LIMIT 1) AS r1, (SELECT `Complex_Route`.`ID_Route` AS ID, route.Number AS Num FROM `Complex_Route` INNER JOIN Route AS route ON route.ID_Route = `Complex_Route`.`ID_Route` WHERE `Complex_Route`.`ID_Stop` = ".$S." LIMIT 1) AS r2 ) INNER JOIN Stop AS s1 ON s1.ID_Stop = `Transfer`.`ID_Stop_From` INNER JOIN Stop AS s2 ON s2.ID_Stop = `Transfer`.`ID_Stop_To` WHERE `Transfer`.`ID_Route_From` = r1.ID AND `Transfer`.`ID_Route_To` = r2.ID";
	$result = mysqli_query($con,$sql);
	if (!$result) {
	    die('Could not connect: ' . mysqli_error($result));
	}
	while($row = mysqli_fetch_array($result)) {
    	echo "<div class='container-route' onclick=''> 
               <div class='row'>
                 <span class='price'>10 грн</span>
                 <span class='time'> хв</span>
               </div>
               <div class='row route'>
                 <button class='number' value='".$row['R1ID']."' href='#timetable' onclick='ShowDirection(value);'>".$row['R1Num']."</button>
                 <img src='img/arrow.png'></img>
                 <button class='number' value='".$row['R2ID']."' href='#timetable' onclick='ShowDirection(value);'>".$row['R2Num']."</button>
               </div>
               <div class='row transfer'>
               	<p>Пересадка з зупинки: <br> <button onclick='checkTransfer(this.innerHTML, ".$row['R1Num'].", ".$row['R2Num'].")'; class='resultStopFrom'>".$row['FSName']."</button> <br> на <br> <a class='resultStopTo'>".$row['SSName']."</a></p>
               </div>
             </div>"; 
             break;
	}
	mysqli_close($con);
?>