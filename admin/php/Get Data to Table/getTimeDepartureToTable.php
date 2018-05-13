<?php 
  
  $D = intval($_GET['D']);
  $W = intval($_GET['W']);

  $con = mysqli_connect('localhost','root','','Transport');
  if (!$con) {
      die('Could not connect: ' . mysqli_error($con));
  }
  mysqli_select_db($con,"ajax_demo");
  $sql="SELECT ID_Time_Departure AS ID ,Time_Start AS Time FROM Departure_Time WHERE `Departure_Time`.`ID_Direction` = ".$D." AND `Departure_Time`.`Weekend` = ".$W."";
  $result = mysqli_query($con,$sql);
  echo "<thead>
                <tr>
                  <th>ID</th>
                  <th>Час відправлення</th>
                </tr>
              </thead>
              <tbody>";
  while ($row = mysqli_fetch_array($result)) {
    echo "<tr>
            <td>".$row['ID']."</td>
            <td>".$row['Time']."</td>
            <th><a onclick='' data-toggle='modal' data-target='#mapStop' title='Показати на карті'><i class='fa fa-map-marker-alt fa-2x map'></a></th>
             <th><a value='".$row['ID']."' onclick='getValueCityFromTable();' title='Редагувати'><i class='fa fa-edit fa-2x edit'></a></th>
          </tr>";
  }
  echo "</tbody>";
  mysqli_close($con);
?>