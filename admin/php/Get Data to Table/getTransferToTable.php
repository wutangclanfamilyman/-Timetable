<?php  
	$R = intval($_GET['R']);
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT  `Transfer`.`ID_Transfer` AS ID,s1.Name AS F, s2.Name AS T, r1.Number AS R, `Transfer`.`ID_Stop_From` AS ID_From, `Transfer`.`ID_Stop_To` AS ID_To  FROM `Transfer` 
INNER JOIN Stop AS s1 ON s1.`ID_Stop` = `Transfer`.`ID_Stop_From`
INNER JOIN Stop AS s2 ON s2.`ID_Stop` = `Transfer`.`ID_Stop_To`
INNER JOIN Route AS r1 ON r1.`ID_Route` = `Transfer`.`ID_Route_To`
WHERE `Transfer`.`ID_Route_From` = ".$R." LIMIT 11;";
	$result = mysqli_query($con,$sql);
	echo "<thead>
                <tr>
                  <th>ID</th>
                  <th>На маршрут</th>
                  <th>Пересадка з</th>
                  <th>На</th>
                </tr>
              </thead>
              <tbody>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<tr>
				<td>".$row['ID']."</td>
	            <td>".$row['R']."</td>
	            <td>".$row['F']." (ID = ".$row['ID_From'].")</td>
	            <td>".$row['T']." (ID = ".$row['ID_To'].")</td>
	            <th><a onclick='deleteTransferFromDB(".$row['ID'].");' title='Видалити'><i class='fa fa-trash fa-2x delete'></a></th>
	          </tr>";
	}
	echo "</tbody>";
	mysqli_close($con);
?>