<?php  
  $id = $_GET['id'];
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT `Users_Route`.ID_Users_Route AS ID, r.ID_Route AS Route, r.Number AS Num FROM `Users_Route` INNER JOIN `Route` AS r ON r.ID_Route = `Users_Route`.`ID_Route` WHERE `Users_Route`.`ID_User` = ".$id."";
	$result = mysqli_query($con,$sql);
	echo "<table class='table table-condensed'><thead>
                <tr>
                  <th>Маршрут</th>
                </tr>
              </thead>
              <tbody>";
  while ($row = mysqli_fetch_array($result)) {
   echo "<tr>
          	<td><button class='number' data-toggle='tab' href='#timetable' onclick='ShowDirection(this.value)' value=" . $row['Route'] . "><i class='fa fa-bus'></i> " . $row['Num'] . "</button></td>
            <th><a onclick='deleteRouteByUser(".$row['ID'].");' title='Видалити'><i class='fa fa-trash fa-2x'></i></a></th>
        </tr>";
  }
  echo "</tbody></table>";
	mysqli_close($con);
?>