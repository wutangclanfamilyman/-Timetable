<?php  

	$RF = intval($_GET['RF']);
	$RT = intval($_GET['RT']);
	$DF = intval($_GET['DF']);
	$DT = intval($_GET['DT']);
	$SF = intval($_GET['SF']);
	$ST = intval($_GET['ST']);	

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo"); 
	$sql="INSERT INTO `Transfer`(`ID_Route_From`, `ID_Route_To`, `ID_Direction_From`, `ID_Direction_To`, `ID_Stop_From`, `ID_Stop_To`) 
	VALUES (".$RF.", ".$RT.", ".$DF.", ".$DT.", ".$SF.", ".$ST.");";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Не додано. Спробуйте пізніше.". mysqli_error($con));
		return;
	}
	echo "Дані додані!";

	mysqli_close($con);
?>