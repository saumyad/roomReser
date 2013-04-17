<?php

include("essential.php");
check_login();

dbconnect();
$q = "select DISTINCT  from Building;";
$r = execute($q);
echo "
	<html>
	<head>
	</head>
	<body>
	<table>
	<tr>
	";




while($result = mysql_fetch_assoc($r))
{
	echo "
		
		<td><a href = 'room2.php?buildingID=".$result['buildID']."'>".$result['buildingName']."</a></td>";
}
echo
	"</tr></table>
	</head>
	</html>";



		



