<?php  
  $D = intval($_GET['D']);
  include "../../php/config.php";
  $sql="SELECT `Complex_Route`.`ID_Stop` AS ID, s.Name AS Name FROM `Complex_Route` INNER JOIN Stop AS s ON `Complex_Route`.`ID_Stop` = s.`ID_Stop` WHERE `Complex_Route`.`ID_Direction` = ".$D."";
  $result = mysqli_query($con,$sql);
  echo "<option value='' changed>Не обрано</option>";
  while ($row = mysqli_fetch_array($result)) {
    echo "<option value=" .$row['ID'] . ">" . $row['Name'] . "   (ID = ".$row['ID'].")</option>";
  }

  mysqli_close($con);
?>