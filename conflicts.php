<?php
//BOOK ROOM

include("essential.php");
check_login();
if($_SESSION['level'] != 1)
{
        header("Location:error.php?msg=YOU ARE NOT AUTHENTICATED");
        die();
}
dbconnect();

$query = "select * from Booking where booking_id = ".$_GET['booking_id'].";";
$r = execute($query);
$booking = mysql_fetch_assoc($r);                                                                                             
$time_s = strtotime($booking['Start_Time']);                                                                                  
$time_e = strtotime($booking['End_Time']);                                                                                    
$date_s = strtotime($booking['Start_Date']);                                                                                  
$date_e = strtotime($booking['End_Date']);                                                                                    
$room_id = $booking['roomId'];  
$collision_result = collision($room_id, $date_s, $date_e, $time_s, $time_e, $booking['Repeat_Type']);

echo "<html>
	<head>
	<link rel ='stylesheet' type='text/css' href='static/style1.css'/>	
	</head>
	<body>
	<h2>Bookings Conflicting with Booking with Booking id ".$booking['booking_id']."</h2>
	<table class = 'center' border = 2>
	<tr>
	<td>Booking id</td>
	<td>User</td>
	<td>Start Date</td>
	<td> End Date</td>
	<td>Start Time</td>
	<td>End Time</td>
	<td>Repeat Type</td>
	</tr>
	";
foreach($collision_result as $row)
{
	if($row['booking_id'] == $booking['booking_id'])
	{
		continue;
	}
	else
	{
		echo"
			<tr>
			<td>".$row['booking_id']."</td>
			<td>".$row['user']."</td>
			<td>".$row['Start_Date']."</td>
			<td>".$row['End_Date']."</td>
			<td>".$row['Start_Time']."</td>
			<td>".$row['End_Time']."</td>
			<td>".$row['Repeat_Type']."</td>
			</tr>";

	}
}
echo"
	</table>
	<h href = 'confirmbooking.php target = 'content'>BACK</a>
	</body>
	</html>";




?>
