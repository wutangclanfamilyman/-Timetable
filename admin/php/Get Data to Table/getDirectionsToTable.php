<?php  

  $R = strval($_GET['R']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT `ID_Direction` AS ID, s1.ID_Stop AS ID_FStop, s1.ID_City AS ID_FStop_City, s2.ID_City AS ID_SStop_City, s2.ID_Stop AS ID_SStop, r.Number AS Route, s1.Name AS FStop, s2.Name AS SStop FROM `Direction` INNER JOIN Route AS r ON `Direction`.`ID_Route` = r.`ID_Route` INNER JOIN Stop AS s1 ON `Direction`.`ID_Start_Stop` = s1.`ID_Stop` INNER JOIN Stop AS s2 ON `Direction`.`ID_Finish_Stop` = s2.`ID_Stop` WHERE `Direction`.`ID_Route` = ".$R."";
	$result = mysqli_query($con,$sql);
	echo "<thead>
                <tr>
                  <th>ID</th>
                  <th>№ Маршруту</th>
                  <th>Початок</th>
                  <th>Кінець</th>
                </tr>
              </thead>
              <tbody>";
  while ($row = mysqli_fetch_array($result)) {
    echo "<tr>
          <td>".$row['ID']."</td>
          <td>".$row['Route']."</td>
          <td>".$row['FStop']." (".$row['ID_FStop'].")</td>
          <td>".$row['SStop']." (".$row['ID_SStop'].")</td>
          <th><a onclick='deleteDirectionFromDB(".$row['ID'].");' title='Видалити'><i class='fa fa-trash fa-2x delete'></a></th>
        </tr>";
  }
  echo "</tbody>";
	mysqli_close($con);
?>