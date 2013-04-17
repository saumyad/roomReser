
<?php
/*
	session_start();
	$Code = $_REQUEST["Turing"]; 
	if ( !isset( $_SESSION['turing_string'] ) ) { $ok = 1; }
	else if ( strtoupper($_SESSION['turing_string']) == strtoupper($Code) ) { $ok = 1; }
		else { 
		$ok = 0;
		header('Location:./register.php?cap=1');
		die("hello");
		echo "<b><font color=red>The Captcha Code you entered is invalid. try again <a href='register.php'> here </a> </font></b><br>";
		return 1;
		 }

*/
include("essential.php");

$user = $_POST['username'];
$pwd = $_POST['password'];
$emailid = $_POST['email'];

function validate_username($input,$pattern = '[^A-Za-z0-9_]')
{
  return !ereg($pattern,$input);
}

  if(!(validate_username("$user")))
	{
	header('Location:./register.php');
	die("hello");
	}

;


if( strlen($user)==0   || strlen($pwd)==0 || strlen($emailid)==0){
	header('Location:./register.php?empty=1');
	die("hello");
}


if ( strpos($emailid, "@") && strpos($emailid, "iiit.ac.in"))
{
}
else
{
	header('Location:./register.php?email=1');
	die("hello");
}

$score = 0;

dbconnect();



$user = escape($user);
$pwd = escape($pwd);



$q = sprintf("INSERT INTO User (name,password,email) VALUES ('%s','%s','%s')",$user,$pwd,$emailid);
$rv = mysql_query( $q , $con);
if(!$rv){
	header('Location:./register.php?exits=1');
	die("hello");
}
else{
	$subject = "Thanks for registering to Room-Reservation";
	$txt = "Hey !! Dude Heaven is here....";
	$headers = "From: RoomReservation@no-reply.com"; 
	mail($emailid,$subject,$txt,$headers);
}
mysql_close( $con );
header('Location:./index.php');
die('hello');
?>
