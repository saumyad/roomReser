<?php


include("essential.php");
check_login();
dbconnect();

if(!isset($_SESSION['user'])){

		header("Location:index.php?msg='Logged out'");
		die();
}
if(isset($_POST['submit'])){
	foreach ($_REQUEST as $key=>$value){
	 	echo "$key => $value"."<br/>";
	}

	print_r($_POST['Category']);
	if(!(isset($_REQUEST['buildingName']) && !empty($_REQUEST['buildingName']))){
			 if(!(isset($_REQUEST['Category']) && !empty($_REQUEST['Category']))) 
					echo "'Building name' or 'Room Category' not specified";
	}
	$buildid = 1;
	$roomid=1;
	if (isset($_POST['buildingName']) && !empty($_POST['buildingName']))
	{
		$q1 = "select buildId from Building where buildingName='".$_REQUEST['buildingName']."';";
		$r = execute($q1);
		if(mysql_num_rows($r) != 1)
			die("row !=1 ");
		else{
			$row = mysql_fetch_array($r);
			$buildid = $row[0];
			//		print_r($row);
		}
	}

	// when we have to search
	if(empty($_POST['Category'])){
		if(!empty($_POST['buildingName'])){
			echo "You did not have any room Preferences.";
			$q3 = "select roomId from Room where buildingName=".$buildid." AND Capacity >= ".$_POST['cap'].";";
			$roomid = execute($q3);
		}
		else{
			$q4 = "select roomId from Room WHERE Capacity >= ".$_POST['cap'].";";
			$roomid = execute($q4);
		}
	}
	else
	{
		echo "i was here!";
		$cat_pref = array();
		$countcat = count($_POST['Category']);
		//		for($i=0; $i< $countcat; $i++)
		//		{
		//			$cat_pref[] = $_POST['Category'][$i];


		//		$cat_pref = implode(", ",$cat_pref);
		if(!empty($_POST['buildingName'])){
			$q5 = "select DISTINCT roomId from Room_Cat where roomId IN (SELECT DISTINCT roomId from Room where buildingName = ".$buildid.") AND roomId IN (select roomId from Room where Capacity >=".$_POST['cap'].")";
		}
		else
			$q5 = "select DISTINCT roomId from Room_Cat where roomId IN (select DISTINCT roomId from Room where Capacity >=".$_POST['cap'].")";

		//		}
		for($i=0; $i< $countcat; $i++)
		{
			$q5=$q5." AND roomId IN (select roomId from Room_Cat where catId = '".$_POST['Category'][$i]."')";
		}
		$q5=$q5.";";
		$roomid = execute($q5);


	}



	$a = mysql_num_rows($roomid);
	echo $a;

	if(mysql_num_rows($roomid) == 0)
	{

		header("Location:error.php?msg='NO such Rooms Available'");
		die();
	}
	$roomid = make_array($roomid);

	$roomid = implode(", ",$roomid);
	if(isset($_POST['check'])){
		echo"insidecheck";
		$today_d = date('Y-m-d');
		$time_s = strtotime($_POST['time_start']);
		$time_e = strtotime($_POST['time_end']);
		$date_s = strtotime($_POST['date_start']);
		$date_e = strtotime($_POST['date_end']);
		if($time_s >= $time_e || $date_s > $date_e || $date_s < $today_s){
			echo " time_s time_e date_s date_e ".$time_s." ".$time_e." ".$date_s." ".$date_e;
			header("Location:error.php?msg='ERROR: Your Date and time limits are wrong!");
		}
		else
		{
			$time_s = ($_POST['time_start']);
			$time_e = ($_POST['time_end']);
			$date_s = ($_POST['date_start']);
			$date_e = ($_POST['date_end']);


		}
		$query1 = "select Booking.roomId, Booking.Repeat_Type, Booking.status FROM Booking
WHERE (Booking.roomId IN (".$roomid.")) AND NOT (Booking.Start_Date >'" .$date_e. "' OR Booking.End_Date < '".$date_s. "') AND NOT (Booking.Start_Time >='".$time_e."' OR Booking.End_Time <='".$time_s."');";

$result=execute($query1);

$result1 = array();
$resultf = array();
while($row=mysql_fetch_array($result)){
echo "inside2";
if($row['status'] == 0){
	echo "sme ".$row['roomId'];
	$resultf[]=$row['roomId'];
}
if($row['Repeat_Type'] == 'WEEKLY')
{
	echo "inside3";
	$row_incrdate= strtotime($row['Start_Date']);
	$date_e = strtotime($date_e);
	$date_s = strtotime($date_s);
	While(!($row_incrdate <= $date_e && $row_incrdate >= $date_s) && $row_incrdate <= strtotime($row['End_Date']))
	{
		echo "inside4";
		echo date("Y-m-d",$row_incrdate);
		$row_incrdate = strtotime("+7 day",$row_incrdate);
		echo date("Y-m-d",$row_incrdate);

	}
	if(!($row_incrdate > strtotime($row['End_Date']))){
		echo "inside4";
		$result1[] = $row['roomId'];
	}
}
else
{
	$result1[] = $row['roomId'];
}
}
}
print_r($roomid);
//echo "dfifnn  ".$roomid;
echo"<html>
<head>
<link rel='stylesheet' type='text/css' href='static/slickblue/style.css' />
</head>
<BODY>
<div id = 'container'>
<div id = 'header'>
<h1>Room Reservation System</h1>
<h2>Welcome " . $_SESSION['user'] . "!!!</h2>
</div>
<div id='menu'>

<ul>

<li class='menuitem'><a href='#'>Home</a></li>
<li class='menuitem'><a href='mail.php'>Mail</a></li>
<li class='menuitem'><a href='profile.php'>Profile</a></li>
<li class ='menuitem'><a href='logout.php'>Logout</a></li>
</ul>
</div>";

echo "
<div id = 'leftmenu'>
<div id='leftmenu_top'></div>
<div id ='leftmenu_main'>
<h3>Links</h3>
<ul>";
echo include "men.php";
/*
if ($_SESSION['level'] == 0){
echo"
<li><a href='queryroom4.php' > Search Room </a></li>
<li><a href='bookroom.php' > Book Room </a></li>
<li><a href='cancelbook.php' > Cancel Your Bookings </a></li>
";
}
else if($_SESSION['level'] == 1)
{
echo"
<li><a href='queryroom4.php' > Search Room </a></li>
<li ><a href='addroom.php' > Add Room </a></li>
<li ><a href='addBuilding.php' > Add Building </a></li>
<li ><a href = 'category.php' >Add Category</a></li>
<li ><a href='confirmbooking.php' > Confirm Room Bookings </a></li>
<li ><a href='bookroom.php' > Book Room </a></li>
<li ><a href='cancelbook.php' > Cancel Bookings </a></li>";
}
else if($_SESSION['level'] == 2)
{
echo"
<li ><a href='queryroom4.php' > Search Room </a></li>
<li ><a href='confirmbooking.php' > Confirm Room Bookings </a></li>
<li ><a href='bookroom.php' target='content'> Book Room </a></br>
<li ><a href='cancelbook.php' target='content'> Cancel Your Bookings </a></li>";
}*/
echo"
</ul>
</div>
<div id='leftmenu_bottom'></div>
</div>
<div id='content'>
<div id = 'content_top'></div>
<div id = 'content_main'>
<h2 class='center'> Search Room </h2>";
echo "<h2 align=center>Room Search Results!</h2>";
$query2 = "select * from Room where roomId IN (".$roomid."); ";
$result9=execute($query2);
echo"
<TABLE id = 'tabletype'>
<tr class='alt0'><th>RoomID</th>
<th>RoomName</th>
<th>Building</th>
<th>Description</th>
<th>Capacity</th>
<th>Status</th>
</tr>";
$y=1;
while ($row3 = mysql_fetch_assoc($result9))
{
echo "<tr class='alt".$y."'><td><font face = 'Arial, Helvetica, sans-serif'>";
echo $row3['roomId'];
echo "</font></td>
<td><font face = 'Arial, Helvetica, sans-serif'>";
echo $row3['roomName'];
echo "</font></td>
<td><font face = 'Arial, Helvetica, sans-serif'>";
$query10 = "select buildingName from Building where buildId = ".$row3['buildingName'].";";
$result11=mysql_fetch_assoc(execute($query10));
echo $result11['buildingName'];
echo "</font></td>
<td><font face = 'Arial, Helvetica, sans-serif'>";
if($row3['description'] == null)
echo "----";
else
echo $row3['description']; 
echo "</font></td>
<td><font face = 'Arial, Helvetica, sans-serif'>";
echo $row3['Capacity']; 
echo "</font></td>
<td><font face = 'Arial, Helvetica, sans-serif'>";
if(in_array($row3['roomId'],$resultf))
echo "Requested";
else if(in_array($row3['roomId'],$result1))
echo "Booked";
else
echo "Available";	
$y= ($y+1)% 2;
}
echo "</table></div></body></html>";
}
else{
echo "<html>
<head>
<link type='text/css' rel='stylesheet' href='static/slickblue/style.css'/>
<script type='text/javascript' src='jquery.js'> </script>
<script type='text/javascript' src='static/calendarDateInput.js'> </script>
<script type='text/javascript' src='queryroom3.js' ></script>
</head>
<body>
<div id = 'container'>
<div id = 'header'>
<h1>Room Reservation System</h1>
<h2>Welcome " . $_SESSION['user'] . "!!!</h2>
</div>
<div id='menu'>

<ul>

<li class='menuitem'><a href='#'>Home</a></li>
<li class='menuitem'><a href='mail.php'>Mail</a></li>
<li class='menuitem'><a href='profile.php'>Profile</a></li>
<li class ='menuitem'><a href='logout.php'>Logout</a></li>
</ul>
</div>";
echo "
<div id = 'leftmenu'>
<div id='leftmenu_top'></div>
<div id ='leftmenu_main'>
<h3>Links</h3>
<ul>";
echo include "men.php";
/*
if ($_SESSION['level'] == 0){
echo"
<li><a href='queryroom4.php' > Search Room </a></li>
<li><a href='bookroom.php' > Book Room </a></li>
<li><a href='cancelbook.php' > Cancel Your Bookings </a></li>
<li><a href ='rooms.php' >ROOMS</a></li>
";
}
else if($_SESSION['level'] == 1)
{
echo"
<li><a href='queryroom4.php' > Search Room </a></li>
<li ><a href='addroom.php' > Add Room </a></li>
<li ><a href='addBuilding.php' > Add Building </a></li>
<li ><a href = 'category.php' >Add Category</a></li>
<li ><a href='confirmbooking.php' > Confirm Room Bookings </a></li>
<li ><a href='bookroom.php' > Book Room </a></li>
<li ><a href='cancelbook.php' > Cancel Bookings </a></li>";
}
else if($_SESSION['level'] == 2)
{
echo"
<li ><a href='queryroom4.php' target='content'> Search Room </a></li>
<li ><a href='confirmbooking.php' target='content'> Confirm Room Bookings </a></li>
<li ><a href='bookroom.php' target='content'> Book Room </a></br>
<li ><a href='cancelbook.php' target='content'> Cancel Your Bookings </a></li>";
}
*/
echo"
</ul>
</div>
<div id='leftmenu_bottom'></div>
</div>
<div id='content'>
<div id = 'content_top'></div>
<div id = 'content_main'>
<h2 class='center'> Add Room </h2>
";

echo "
<h2 class='center'> Query Room </h2>

<form name='queryroom' id ='queryname'  method='POST' action='" . $PHP_SELF . "'>" ;
$query = "select buildingName from Building";
$x = "buildingName";
$st =  generate_list($query,$x);
$query = "select Category.catId, Category.catName from Category ;";
$category = execute($query);


echo "<br/>
<table >
<tr><td> Building: </td>
<td> ". $st . " </td></tr>

</table>
<hr></hr>
<table class='center'>
<tr><td>
Enter Category:</td></tr> ";
if(!mysql_num_rows($category))
{
echo "<tr><td>No Available Categories</td></tr>";
}
else{

	
while($row = mysql_fetch_array($category)){
echo"<tr><td style='text-align:right'><input type='checkbox' name='Category[]' value='".$row['catId']."'></td><td style='text-align:left'>"  .$row['catName']. "
	</td>";
}}
echo"<tr><td>Capacity:</td> 
<td><input name='cap' type='number' min='0' max='2000' maxlength = 4 size = 4 value = 100></td></tr>
</table>
<hr></hr>
<br/<br/>

<div style='text-align:center'>
<p style='font-size:18px;text-align:center'><input type='checkbox' name='check' value='yes' align = 'center'/>Check Availability<br/></p></div>
<table>
<tr><td> Date Start: </td>
<td><div id='divroomName'> <script>DateInput('date_start', true, 'YYYY-MM-DD')</script>  </div></td>
</tr>
<tr><td> Date End: </td>
<td><div id='divroomName2'> <script>DateInput('date_end', true, 'YYYY-MM-DD')</script>  </div></td>
</tr>
<tr><td></br> Timeslot From: </td>
<td></br>".generate_timeslot('time_start') ."</td>
</tr>
<tr><td></br> Timeslot To: </td>
<td></br>".generate_timeslot('time_end') ."</td>
</tr>
<tr><td></td><td><br/>
<input type='submit' name='submit' id='submit' value='QueryRoom'/>
</td></tr></table>
</form>
</body>
</html>";
}


?>
