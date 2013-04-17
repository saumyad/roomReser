<?php


include("essential.php");
check_login();
dbconnect();
if(isset($_POST['submit'])){
	foreach ($_REQUEST as $key=>$value){
	 	echo "$key => $value"."<br/>";
	}

/*	if($flag==0) header("Location:error.php");
	echo $st;
	$q = "select * from Booking where "; 
	if($_POST['buildingName']!='') $q .= "buildingName='" . $_POST['buildingName'] . "';" ;
	$r = execute($q);
	if(mysql_num_rows($r) != 1) die();
	else{
		$row = mysql_fetch_array($r);
		$id =  $row[0];
		echo "id:" . $id ;
	}*/
}
else{
	echo "<html>
		<head>
		<script type='text/javascript' src='jquery.js'> </script>
		<script type='text/javascript' src='static/calendarDateInput.js'> </script>
		<script type='text/javascript' src='queryroom3.js' ></script>
		</head>
		<body>
		<p> welcome " . $_SESSION['user'] . "</p>
		<form name='queryroom' id ='queryname'  method='POST' action='" . $PHP_SELF . "'>" ;
	$q = "select buildingName from Building";
	$x = "buildingName";
	$st =  generate_list($q,$x);
	echo "<br/>
	<table>
	  <tr><td> Building: </td>
	      <td> ". $st . " </td></tr>
	  <tr><td> Room: </td>
	      <td><div id='divbuildingName'> </div></td>
	   </tr>
	  <tr><td> Date: </td>
	      <td><div id='divroomName'> <script>DateInput('date', true, 'DD/MON/YYYY')</script>  </div></td>
	   </tr>
	  <tr><td> Timeslot: </td>
	      <td>".generate_timeslot() ."</td>
	   </tr>
	</table>
	<input type='submit' name='submit' id='submit' value='QueryRoom'/>
	</form>
	</body>
	</html>";
}
?>
