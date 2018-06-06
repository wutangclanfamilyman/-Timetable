<?php  
	$C = intval($_GET['C']);
	include "../../php/config.php";
	$sql="SELECT ID_Stop, Name FROM Stop WHERE ID_City = '".$C."'";
	$result = mysqli_query($con,$sql);
	echo "<option value='' changed>Не обрано</option>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<option value='" .$row['ID_Stop'] . "'>" . $row['Name'] . "   (ID = ".$row['ID_Stop'].")</option>";
	}
	mysqli_close($con);
?>