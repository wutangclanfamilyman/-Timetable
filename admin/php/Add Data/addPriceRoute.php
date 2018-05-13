<?php  

	$R = intval($_GET['R']);
	$D = intval($_GET['D']);
	$FS = intval($_GET['FS']);
	$ST = explode(",", $_GET['ST']);
	$P = explode(",", $_GET['P']);

	$con = mysqli_connect('localhost','root','','Transport');
	if (!$con) {
	    die('Could not connect: ' . mysqli_error($con));
	}
	mysqli_select_db($con,"ajax_demo");
	for ($i=0; $i <= count($ST)-1; $i++) { 
		$sql=$sql="INSERT INTO `Price`(`ID_Route`, `ID_Direction`, `ID_First_Stop`, `ID_Second_Stop`, `Money`) 
			VALUES (".$R.", '".$D."', ".$FS.", '".$ST[$i]."', ".$P[$i].")";
		$result = mysqli_query($con,$sql);
		if (!$result) {
			echo die("Не додано. Спробуйте пізніше.");
			return;
			}
	}
	 echo "Ціну додано!";

	mysqli_close($con);
?>