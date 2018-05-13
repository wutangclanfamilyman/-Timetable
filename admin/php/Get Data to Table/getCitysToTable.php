<?php  
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT ID_City AS ID, Name AS Name FROM City";
	$result = mysqli_query($con,$sql);
	echo "<thead>
                <tr>
                  <th>ID</th>
                  <th>Назва</th>
                </tr>
              </thead>
              <tbody>";
  while ($row = mysqli_fetch_array($result)) {
    echo "<tr>
          <td>".$row['ID']."</td>
                  <td>".$row['Name']."</td>
                  <th><a onclick='' data-toggle='modal' data-target='#mapStop' title='Показати на карті'><i class='fa fa-map-marker-alt fa-2x map'></a></th>
                  <th><a value='".$row['ID']."' onclick='getValueCityFromTable();' title='Редагувати'><i class='fa fa-edit fa-2x edit'></a></th>
                </tr>";
  }
  echo "</tbody>";
	mysqli_close($con);
?>