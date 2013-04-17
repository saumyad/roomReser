<?php
include("essential.php");
check_login();
$header = "From: ".$_POST['from'] ;
if(!$_POST['subject'])
{
	$_POST['subject'] = '   ';
}
if(!$_POST['message'])
{
	$_POST['message'] = '    ';
}

$ret = mail($_POST['to'],$_POST['subject'], $_POST['message'], $header);
if ($ret)
{
	header("Location:./mail.php?msg='Your mail was sent successfully'");
}
else
{
	header('Location:./error.php');
}
?>
