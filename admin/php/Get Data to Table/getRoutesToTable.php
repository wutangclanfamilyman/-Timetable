<?php  
	include "../../php/config.php";
	$sql="SELECT ID_Route AS ID, `Number` AS Number FROM Route";
	$result = mysqli_query($con,$sql);
	echo "<thead>
                <tr>
                  <th>ID</th>
                  <th>Номер</th>
                </tr>
              </thead>
              <tbody>";
  while ($row = mysqli_fetch_array($result)) {
    echo "<tr>
          <td>".$row['ID']."</td>
                  <td>".$row['Number']."</td>
                  <th><a value='".$row['ID']."' onclick='getValueRouteFromTable();' title='Редагувати'><i class='fa fa-edit fa-2x edit'></a></th>
                </tr>";
  }
  echo "</tbody>";
	mysqli_close($con);
?>