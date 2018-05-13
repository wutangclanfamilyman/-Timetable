<?php  

	$P = intval($_GET['P']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="DELETE FROM `Price` WHERE `Price`.`ID_Price` = '".$P."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Ціна не видалена. Спробуйте пізніше.");
	}
	else{
		echo "Ціна видалена!";
	}

	mysqli_close($con);
?>