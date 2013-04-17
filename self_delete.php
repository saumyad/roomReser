<?php
include("essential.php");
$today = date('Y-m-d',time());
//echo "today is ".$today;
dbconnect();
$q = "delete from Booking where End_Date < '".$today."';";
execute($q);


?>

