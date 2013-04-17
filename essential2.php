<?php
$con = 0;
function check_login(){
	if(!isset($_SESSION['user'])){
		header('Location:login.php');
		
		die();
	}
}
function generate_list($q,$x){
	$r = execute($q);
	$i=0;
	$rowcount = mysql_num_rows($r);
	$st = "<select name='" . $x . "' id='" . $x . "'>";
	$st .= "<option value='' >--Please select--</option>";
	while($row = mysql_fetch_array($r,MYSQL_NUM)){
	  $st .= "<option value='".$row[0]."' id='".$row[0]."'>".$row[0]."</option>";
	}
	$st .= "</select>";
	return $st;
}
function generate_timeslot(){
  	$st = "<select name='timeSlot' id='timeSlot'>";
	 $st .= "<option value='' id='fg'>Please Select</option>";
	for($i=0;$i<24;$i++){
	   $j = $i .':00';
	   
	   $st .= "<option value='".$j."' id='" . $j . "'>".$j."</option>";
	   $j = $i . ':30';
	   $st .= "<option value='".$j."' id='" . $j . "'>".$j."</option>";
	}
	$st .="</select>";
	return $st;
}
function execute($q){
	GLOBAL $con;
	if($con == 0 ){
		dbconnect();
	}
	$r = mysql_query($q,$con);

	if(!$r){
		die("Cannot execute the query".$q);
	}
	else{
		return $r;
	}
}

function dbconnect(){
	GLOBAL $con;
	$con = mysql_connect('localhost','root','yahspande');
	if(!$con){
		die("no connection");
	}
	else {
		$q = "use roomReser";
		$rv = mysql_query( $q , $con);
		if(!$rv){
			die("no database!");
		}

	}
}

function escape($x){
	$x = stripslashes($x);
	$x = mysql_real_escape_string($x);
	return ($x);
}


function make_array($a){
	$all = array();
	while($row = mysql_fetch_array($a))
	{
		$all[] = $row[0];
	}
	return $all;
}
?>
