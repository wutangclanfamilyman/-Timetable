<?php  

	$R = intval($_GET['R']);
	$C = explode(",", $_GET['C']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	$del = "DELETE FROM `RouteByCity` WHERE `RouteByCity`.`ID_Route` = '".$R."'";
	$res_del = mysqli_query($con, $del);
	for ($i=0; $i < count($C); $i++) { 
		$sql="INSERT INTO `RouteByCity`(`ID_Route`, `ID_City`) VALUES ('".$R."', '".$C[$i]."');";
		$result = mysqli_query($con,$sql);
		if (!$result) {
			echo die("Не спрацювало. Спробуйте пізніше.");
			return;
		}
	}
	echo "Дані занесені!";
	mysqli_close($con);
?>