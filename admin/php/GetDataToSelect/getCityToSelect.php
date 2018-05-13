<?php  
	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="SELECT ID_City, Name FROM City";
	$result = mysqli_query($con,$sql);
	echo "<option value='' changed>Не обрано</option>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<option value=" .$row['ID_City'] . ">" . $row['Name'] . "</option>";
	}
	mysqli_close($con);
?>