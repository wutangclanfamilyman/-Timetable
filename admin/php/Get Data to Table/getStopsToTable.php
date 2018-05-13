<?php  
	$C = intval($_GET['C']);
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT `Stop`.`ID_Stop` AS ID, c.`Name` AS City, `Stop`.`Name` AS Name, `Stop`.`Latitude` AS Lat, `Stop`.`Longitude` AS Lng FROM `Stop` INNER JOIN `City` AS c ON c.ID_City = `Stop`.`ID_City` WHERE `Stop`.`ID_City` = ".$C."";
	$result = mysqli_query($con,$sql);
	echo "<thead>
                <tr>
                  <th>ID</th>
                  <th>Місто</th>
                  <th>Назва</th>
                  <th>Широта</th>
                  <th>Довгота</th>
                </tr>
              </thead>
              <tbody>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<tr>
				  <td>".$row['ID']."</td>
                  <td>".$row['City']."</td>
                  <td>".$row['Name']."</td>
                  <td>".$row['Lat']."</td>
                  <td>".$row['Lng']."</td>
                  <th><a onclick='stop_on_map(".$row['Lat'].",".$row['Lng'].")' data-toggle='modal' data-target='#mapStop' title='Показати на карті'><i class='fa fa-map-marker-alt fa-2x map'></a></th>
                  <th><a value='".$row['ID']."' onclick='getValueStopFromTable();' title='Редагувати'><i class='fa fa-edit fa-2x edit'></a></th>
                  <th><a onclick='deleteStopFromDB(".$row['ID'].");' title='Видалити'><i class='fa fa-trash fa-2x delete'></a></th>
                </tr>";
	}
	echo "</tbody>";
	mysqli_close($con);
?>