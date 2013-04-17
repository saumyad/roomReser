<?php
include("essential.php");
check_login();
dbconnect();
$st = "parag";

	$time_s = strtotime($_POST['Start_Time']);
	$time_e = strtotime($_POST['End_Time']);
	$date_s = strtotime($_POST['Start_Date']);
	$date_e = strtotime($_POST['End_Date']);
$result = array();
$result = collision($_POST['roomName'] , $date_s , $date_e , $time_s , $time_e,'DAILY');
echo '<table border=2>';
/*
foreach($result as $booking){
	$flag = 1;
	 echo '<tr>';
		foreach ($booking as $key=>$val){
			echo '<td>';
			echo $val;
			echo '</td>';

		}
	echo "</tr>";
}*/
if(count($result)==0){
	$query = "select roomName from Room where roomId='".$_POST['roomName']."';";
	$row = mysql_fetch_assoc(execute($query));
	$roomName = $row['roomName'];

	echo "<a href='bookroom.php?roomName=".$roomName."&Start_Date=".date("d-M-y",$date_s)."&End_Date=".date("d-M-y",$date_e)."&Start_Time=".date("H:i:s",$time_s)."&End_Time=".date("H:i:s",$time_e) ."'> AVAILABLE </a></br>";
}
else {
  echo "Its BOOKED !! Sorry";
 }
echo  "</table>";
?>
