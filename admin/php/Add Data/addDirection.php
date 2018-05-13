<?php  

	$R = strval($_GET['R']);
	$F = strval($_GET['F']);
	$S = strval($_GET['S']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="INSERT INTO `Direction`(`ID_Route`, `ID_Start_Stop`, `ID_Finish_Stop`) VALUES ('".$R."', '".$F."', '".$S."')";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Напрямок не додано. Спробуйте пізніше.");
	}
	else{
		echo "Напрямок додано!";
	}

	mysqli_close($con);
?>