<?php 
include "essential.php";
check_login();
dbconnect();

if(!isset($_SESSION['user']))
{
	header("Location:index.php?msg=You are logged out.");
	die();
}

$query1 = "select * from Booking";
if($_SESSION['level'] != 1)
{
	$query1=$query1." where user = ".$_SESSION['id'];
}
if(isset($_GET['st']))
	$mstart=$_GET['st'];
else
	$mstart=0;
$lim=5; 			// maximum number of elements you want in a page!!
$query1=$query1.";";
//$result1=paginate("cancelbook.php",$query1,$mstart,$lim);
$result1 = execute($query1);
echo"<html>
<head>
<link type='text/css' rel='stylesheet' href='static/slickblue/style.css'/>

<title>BOOKINGS</title>

</head>
<BODY>";
echo "
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
	include "men.php";
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
                <h2 class='center'> Cancel Booking </h2>";


echo"<br/><br/>
<TABLE class = 'tabletype' >
<tr class='alt0'>
<th>Room</th>
<th>Booking</th>

<th>Booked By</th>
<th>Reason</th>
<th>Start</th>
<th>End</th>
<th>From</th>
<th>Till</th>
<th>Repeat</th>
<th>Status</th>
</tr>";
$q=1;
while($row=mysql_fetch_assoc($result1)){
	echo "<tr class='alt".$q."'><td><font face = 'Arial, Helvetica, sans-serif'>";
	$rowname=$row['roomId'];
	$query3="select roomName from Room where roomId = ".$rowname.";";
	$result3=execute($query3);
	$result3=mysql_fetch_assoc($result3);
	echo $result3['roomName'];
	echo "</font></td>
		<td><font face = 'Arial, Helvetica, sans-serif'>";echo $row['booking_id']."
		<a href='confirmdel.php?del_id=".$row['booking_id']."' style='text-align:right'> Del</a>";
	$rowname=$row['user'];
	$query4="select name from User where userId = ".$rowname.";";
	$result4=execute($query4);
	$result4=mysql_fetch_assoc($result4);
	echo "</font></td>
		<td><font face = 'Arial, Helvetica, sans-serif'>";
	echo $result4['name'];
	echo "</font></td>
		<td><font face = 'Arial, Helvetica, sans-serif'>";
	echo $row['description']; 
	echo "</font></td>
		<td><font face = 'Arial, Helvetica, sans-serif'>";
	echo date("d-m-y",strtotime($row['Start_Date'])); 
	echo "</font></td>
		<td><font face = 'Arial, Helvetica, sans-serif'>";
	echo date("d-m-y",strtotime($row['End_Date'])); 
	echo "</font></td>
		<td><font face = 'Arial, Helvetica, sans-serif'>";
	echo date("G:i",strtotime($row['Start_Time'])); 
	echo "</font></td>
		<td><font face = 'Arial, Helvetica, sans-serif'>";
	echo date("G:i",strtotime($row['End_Time'])); 
	echo "</font></td>
		<td><font face = 'Arial, Helvetica, sans-serif'>";
	echo $row['Repeat_Type']; 
	echo "</font></td>
		<td><font face = 'Arial, Helvetica, sans-serif'>";
	if($row['status']=='1') echo "booked"; 
	else echo "Requested";
	echo "</font></td>
		</tr>";
	$q = ($q+1)%2;
} 
echo "</TABLE>
</div>
                <div id = 'content_bottom'></div>
                <div id = 'footer><h3>Developed by: Bond With Bondas</h3></div>
                </div>";


echo "</BODY>
</HTML>";
?>




