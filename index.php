<?php
if(0)
{
	header("location:index2.php");
}
else
{
	include_once("CAS.php");
	include_once("essential2.php");

	phpCAS::client(CAS_VERSION_2_0,"login.iiit.ac.in",443,"/cas");
	phpCAS::setNoCasServerValidation();
	phpCAS::setExtraCurlOption(CURLOPT_SSLVERSION,1);
	phpCAS::forceAuthentication();

	$email = phpCAS::getUser();
	if(empty($email))
	{
		phpCAS::logout();
	}
	else
	{
		dbconnect();
		$query = "SELECT * from User where email='".$email."'";
		$rv = execute($query);
		$num_rows = mysql_num_rows($rv);

		if($num_rows == 1){
			$row = mysql_fetch_assoc($rv);
			session_start();
			$_SESSION['user'] = $row['name'];
			$_SESSION['id'] = $row['userId'];
			$_SESSION['level'] = $row['level'];
			header("Location:raw.php");
		}
		else{
			header("Location:error.php");
		}
		mysql_close( $con );

	}
}
?>
