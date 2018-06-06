<?php  
	include "../../php/config.php";
	$sql="SELECT ID_Route AS ID, Number as Num FROM Route";
	$result = mysqli_query($con,$sql);
	echo "<option value='' changed>Не обрано</option>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<option value=" .$row['ID'] . ">" . $row['Num'] . "</option>";
	}
	mysqli_close($con);
?>