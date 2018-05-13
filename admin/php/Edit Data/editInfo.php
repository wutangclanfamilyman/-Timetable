<?php  
	$id = intval($_GET['ID']);
	$route = intval($_GET['Route']);
	$direct = intval($_GET['Direct']);
	$reverse = intval($_GET['Reverse']);
	$time = strval($_GET['Time']);
	$price = strval($_GET['Price']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$sql="UPDATE `Info_About_Route` SET `ID_Route` = '".$route."',  `ID_Direct` = '".$direct."', `ID_Reverse` = '".$reverse."', `Work_Time` = '".$time."', `Max_Price` = '".$price."', `Update_Date` = CURDATE() WHERE `ID_IAR` = '".$id."'";
	$result = mysqli_query($con,$sql);
	if (!$result) {
		echo die("Інформація маршруту незмінена. Спробуйте пізніше.");
	}
	else{
		echo "Інформація маршруту змінено!";
	}

	mysqli_close($con);
?>