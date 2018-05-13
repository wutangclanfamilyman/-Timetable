<?php  
	$D = intval($_GET['D']);
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT `Price`.`ID_Price` AS ID, s1.Name AS FName, s2.Name AS SName, `Price`.`Money` AS Money FROM `Price` INNER JOIN Stop AS s1 ON s1.`ID_Stop` = `Price`.`ID_First_Stop` INNER JOIN Stop AS s2 ON s2.`ID_Stop` = `Price`.`ID_Second_Stop` WHERE `Price`.`ID_Direction` = ".$D."";
	$result = mysqli_query($con,$sql);
	echo "<thead>
                <tr>
                  <th>ID</th>
                  <th>Зупинка 1</th>
                  <th>Зупинка 2</th>
                  <th>Ціна (грн)</th>
                </tr>
              </thead>
              <tbody>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<tr>
				<td>".$row['ID']."</td>
	            <td>".$row['FName']."</td>
	            <td>".$row['SName']."</td>
	            <td>".$row['Money']."</td>
	            <th><a value='".$row['ID']."' onclick='getValuePriceFromTable();' title='Редагувати'><i class='fa fa-edit fa-2x edit'></a></th>
            	<th><a onclick='deletePriceFromDB(".$row['ID'].");' title='Видалити'><i class='fa fa-trash fa-2x delete'></a></th>
	          </tr>";
	}
	echo "</tbody>";
	mysqli_close($con);
?>