<?php  

	$R = intval($_GET['R']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="DELETE FROM `Info_About_Route` WHERE `Info_About_Route`.`ID_IAR` = '".$R."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Інформація не видалена. Спробуйте пізніше.");
	}
	else{
		echo "Інформація видалена!";
	}

	mysqli_close($con);
?>