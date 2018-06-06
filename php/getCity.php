<?php  

	include "../php/config.php";
	
	$sql="SELECT ID_City, Name FROM City";
	$result = mysqli_query($con,$sql);
	echo "<option value='' class='active'>Не обрано</option>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<option value=".$row['ID_City'].">".$row['Name']."</option>";
	}
	mysqli_close($con);
?>