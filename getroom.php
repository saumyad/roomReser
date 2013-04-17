<?php
include("essential.php");
check_login();

dbconnect();

if(isset($_POST['buildingName'])){

	$q = '';
	if($_POST['buildingName'] != ''){
		$q = "select buildId from Building where buildingName='".$_POST['buildingName']."';" ;
		$r = execute($q);
		if(mysql_num_rows($r) != 1) die();
		else{
			$row = mysql_fetch_array($r);
			$id =  $row[0];
		}

		$q = "select roomName from Room where buildingName = '" . $id ."';" ; 
	}
	else{
		$q = "select roomName from Room"; 
	}
	$x = "roomName";
	$st =  generate_list($q,$x);
	echo $st;

}
else if(isset($_POST['roomName'])){
	$q = '';
	$qq = "select roomId from Room where roomName='".$_POST['roomName']."';" ;
	$rr = execute($qq);
	if(mysql_num_rows($rr) > 1)die();
	$rr = mysql_fetch_array($rr);
	$q = "select * from Booking where roomId='".$rr[0]."';";
	$r = execute($q);
	$booked = array();
	$bookedcount = 0;
	$st = "<select name='timeSlot' id='timeSlot'>";
	while($row = mysql_fetch_array($r)){	
		$booked[] = $row["timeSlot"];
	}
	for($i=0;$i<24;$i++){
	  $dig=0;
	  $k = $i;
	  while($k>0){
	    $k/=10;
	    $dig++;
	  }
	  $j = $i.'';
	  if($i<10){
	    $j = '0' . $j;
	  }
	  $j1 = $j.":00:00";
	  $j2 = $j.":30:00";
	  $flag1 = 0;
	  $flag2 = 0;
	  foreach ($booked as $time){
	    if($j1 == $time) $flag1 = 1;
	    if($j2 == $time) $flag2 = 1;
	  }
	  if($flag1 == 0) $st .= "<option value='" . $j1 . "' name='" . $j1 . "' id='" .$j1."'>".$j1."</option>";
	  if($flag2 == 0) $st .= "<option value='" . $j2 . "' name='" . $j2 . "' id='" .$j2."'>".$j2."</option>";
	  
	}
	$st .= "</select>";
	echo "$st";
}
else {
	$st = '';
	foreach ($_POST as $key=>$value){
		$st .= $key . "=>" .$value;
	}
	echo $st;
}
