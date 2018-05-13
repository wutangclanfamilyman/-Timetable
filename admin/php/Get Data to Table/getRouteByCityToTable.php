<?php  
	$R = intval($_GET['R']);
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT `RouteByCity`.`ID_RbC` AS ID, c.`Name` AS Name FROM `RouteByCity` INNER JOIN `City` AS c ON `RouteByCity`.`ID_City` = c.`ID_City` WHERE `RouteByCity`.`ID_Route` = ".$R."";
	$result = mysqli_query($con,$sql);
	echo "<thead>
                <tr>
                  <th>ID</th>
                  <th>Місто</th>
                </tr>
              </thead>
              <tbody>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<tr>
				  <td>".$row['ID']."</td>
                  <td>".$row['Name']."</td>
               </tr>";
	}
	echo "</tbody>";
	mysqli_close($con);
?>