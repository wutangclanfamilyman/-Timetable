<?php  
	$D = intval($_GET['D']);
	include "../../php/config.php";
	$sql="SELECT `Complex_Route`.`ID_Complex_Route` AS ID, s.Name AS Name, `Complex_Route`.`Priority` AS Priority, `Complex_Route`.`Span` AS Span
  FROM `Complex_Route` INNER JOIN `Stop` AS s ON s.`ID_Stop` = `Complex_Route`.`ID_Stop` WHERE `Complex_Route`.`ID_Direction` = ".$D." ORDER BY  `Complex_Route`.`Priority`";
	$result = mysqli_query($con,$sql);
	echo "<thead>
                <tr>
                  <th>ID</th>
                  <th>Зупинка</th>
                  <th>Пріоритет</th>
                  <th>Інтервал</th>
                </tr>
              </thead>
              <tbody>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<tr>
				    <td>".$row['ID']."</td>
            <td>".$row['Name']."</td>
            <td>".$row['Priority']."</td>
            <td>".$row['Span']."</td>
            <th><a value='".$row['ID']."' onclick='getValueComplexRouteFromTable();' title='Редагувати'><i class='fa fa-edit fa-2x edit'></a></th>
            <th><a onclick='deleteStopFromComplexRoute(".$row['ID'].");' title='Видалити'><i class='fa fa-trash fa-2x delete'></a></th>
          </tr>";
	}
	echo "</tbody>";
	mysqli_close($con);
?>