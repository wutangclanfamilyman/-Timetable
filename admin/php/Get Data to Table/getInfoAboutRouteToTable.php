<?php  
	$R = intval($_GET['R']);
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT `Info_About_Route`.`ID_IAR` AS ID, `Info_About_Route`.`ID_Route` AS ID_Route, `Info_About_Route`.`ID_Direct` AS ID_Direct, `Info_About_Route`.`ID_Reverse` AS ID_Reverse, Dir.FStop AS FStop, Dir.SStop AS SStop, `Info_About_Route`.`Max_Price` AS Price, `Info_About_Route`.`Work_Time` AS Time, `Info_About_Route`.`Update_Date` AS Date FROM `Info_About_Route`,(SELECT `ID_Direction` AS ID, s1.ID_Stop AS ID_FStop, s1.ID_City AS ID_FStop_City, s2.ID_City AS ID_SStop_City, s2.ID_Stop AS ID_SStop, s1.Name AS FStop, s2.Name AS SStop FROM `Direction` 
INNER JOIN Stop AS s1 ON `Direction`.`ID_Start_Stop` = s1.`ID_Stop`
INNER JOIN Stop AS s2 ON `Direction`.`ID_Finish_Stop` = s2.`ID_Stop` 
WHERE `Direction`.`ID_Route` = ".$R.") AS Dir
WHERE `Info_About_Route`.`ID_Route` = ".$R." LIMIT 1";
	$result = mysqli_query($con,$sql);
	echo "<thead>
                <tr>
                  <th>ID</th>
                  <th>Прямий маршрут</th>
                  <th>Зворотній маршрут</th>
                  <th>Ціна</th>
                  <th>Час роботи</th>
                  <th>Останнє оновлення</th>
                  <th>Редагувати</th>
                  <th>Видалити</th>
                </tr>
              </thead>
              <tbody>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<tr>
				  <td>".$row['ID']."</td>
                  <td>".$row['FStop']." - ".$row['SStop']."</td>
                  <td>".$row['SStop']." - ".$row['FStop']."</td>
                  <td>".$row['Price']."</td>
                  <td>".$row['Time']."</td>
                  <td>".$row['Date']."</td>
                  <th><a value='".$row['ID']."' onclick='getValueInfoAboutRouteFromTable(".$row['ID'].", ".$row['ID_Route'].", `".$row['Time']."`, `".$row['Price']."`, `".$row['Date']."`);' title='Редагувати'><i class='fa fa-edit fa-2x edit'></a></th>
                  <th><a value='".$row['ID']."' onclick='deleteInfoAboutRouteFromDB(".$row['ID'].");' title='Видалити'><i class='fa fa-trash fa-2x delete'></a></th>
               </tr>";
	}
	echo "</tbody>";
	mysqli_close($con);
?>