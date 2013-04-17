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


if(isset($_POST['submit']))
{
	foreach( $_POST as $key => $value)
	{
		if($key == 'submit')
		{
			continue;
		}
		else
		{
			if($value == 'reject')
			{//	$ret = delete_mail($id1);
				$id1 = (int)$key;
				delete_mail($id1);
				//$query1 = "delete from Booking where booking_id = ".$id1.";";
				//execute($query1);
			}
			elseif($value == 'confirm')
			{
				$id = (int)$key;
				$q = "select * from Booking where booking_id = ".$id.";";
				echo "$q \n";	
				$r = execute($q);
				if(mysql_num_rows($r) == 0)
				{
					continue;
				}
				else
				{
					$booking = mysql_fetch_assoc($r);
					$time_s = strtotime($booking['Start_Time']);
					$time_e = strtotime($booking['End_Time']);	
					$date_s = strtotime($booking['Start_Date']);
					$date_e = strtotime($booking['End_Date']);
					$room_id = $booking['roomId'];
					echo "Booking to confirm details
						from $time_s </br>
						till $time_e </br>
						start date $date_s </br>
						end date $date_e </br>

						roomid $room_id </br>
						repeat type
						".$booking['Repeat_Type'];
					$collision_result = collision($room_id, $date_s, $date_e, $time_s, $time_e, $booking['Repeat_Type']);
					//$conf = array();
					$s_1 = 0;
					foreach($collision_result as $row)
					{
						echo "inside collision result foreach\n";
						echo "booking id is ".$row['booking_id'];
						if($row['booking_id'] == $booking['booking_id'])
						{
							continue;
						}
						elseif($row['status'] == 1)
						{

							$query1 = "delete from Booking where booking_id = ".$booking['booking_id'].";";
							execute($query1);
							header("Location: confirmbooking.php?msg='Your Booking could not be confirmed as it conflicts with a booking of user ".$row['user']." and booking id = ".$row['booking_id']." Contact the above mentioned user to resolve the conflict. Your current booking request is rejected. Please select bookings again.");
							die();

						}
						elseif($row['status'] == 0)
						{		
							echo " conflicting booking id is ".$row['booking_id'];
							//delete wasn't implemented.
							delete_mail($row['booking_id']);
							//$conf[] = $row;

						}
					}
					$q2 = "update Booking set status = 1 where booking_id = ".$booking['booking_id'].";";
					confirmation_mail($booking['booking_id']);
					execute($q2);
				}
			}

		}
	}

	header("Location:confirmbooking.php?msg='Actions performed successfully");
	die();

}
else{
	echo "<html>
		<head>
		<link type='text/css' rel='stylesheet' href='static/slickblue/style.css'/>
		<script type='text/javascript' src='jquery.js'> </script>
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
	include "men.php";
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
                        <li ><a href='bookroom.php' > Book Room </a></br>
                        <li ><a href='cancelbook.php' > Cancel Your Bookings </a></li>";
        }*/
 echo"
                </ul>
                </div>
                <div id='leftmenu_bottom'></div>
                </div>
                <div id='content'>
                <div id = 'content_top'></div>
                <div id = 'content_main'>
                <h2 class='center'> Confirm Booking Form </h2>
                ";

echo "
	<div class = 'form'>";
	if(ISSET($_GET['msg']))
	{
	}


	echo "
		<form name='confirmroom' method='POST' action='" . $PHP_SELF . "'>" ;

	$q = "select User.name, Booking.booking_id ,Room.roomName, Booking.Start_Date,Booking.End_Date, Booking.Start_Time, Booking.End_Time,Booking.Repeat_Type, Booking.description "
		. " FROM User, Booking, Room"
		. " WHERE confirmedBy=(select userId from User where name="
		. "'" . $_SESSION['user']. "')"
		. " and Booking.user=User.userId and Room.roomId=Booking.roomId "
		. " and status=0 "
		. ";";
	$r = execute($q);

	echo "<h3> You have " .mysql_num_rows($r)." requests to confirm. </h3><br/>";

	echo "<table  class='tabletype' >";
	echo "<tr>";


	echo "<th>Request by </th>";
	/*echo "<th> ID</th>";*/
	echo "<th>ROOM: </th>";
	echo "<th>START</th>";
	echo "<th>END</th>";
	echo "<th>FROM</th>";
	echo "<th>TILL</th>";
	echo "<th>Repeat</th>";
	echo "<th>Reason</th>";	
	echo "<th>YES</th>";
	echo "<th>NO</th>";
	echo "<th>LATER</th>";
	echo "<th>CONFLICTS</th>";

	
	echo "</tr>";

	$p = 1;	
	while($row = mysql_fetch_array($r)){
		echo "<tr class = 'alt".$p."'>";

		echo "<td><a href = 'mail.php?to_dec=".$row[0]."'> " . $row[0] ."</a></td>";
		/*echo "<td> " . $row[1] ."</td>";*/
		echo "<td> " . $row[2] ."</td>";
		echo "<td> " . date("d-m-y",strtotime($row[3])) ."</td>";
		echo "<td> " . date("d-m-y",strtotime($row[4])) ."</td>";
		echo "<td> " . date("G:i",strtotime($row[5])) ."</td>";
		echo "<td> " . date("G:i",strtotime($row[6])) ."</td>";
		echo "<td> " . $row[7] ."</td>";
		echo "<td> " . $row[8] ."</td>";	
		echo "<td> <input type = 'radio' name = '".$row[1]."' value = 'confirm'/> ";
		echo "<td> <input type = 'radio' name = '".$row[1]."' value = 'reject'/>";
		echo "<td> <input type = 'radio' name = '".$row[1]."' value = 'none'/>";
		echo "<td><a href = conflicts.php?booking_id=".$row[1]." target = 'content'>Conflicts</a></td>";


		echo "</tr>";
		$p = ($p+1)%2;

	}
	echo "</table></div><br/><br/>";
	echo "<input type = 'submit' name = 'submit' id = 'submit' value = 'Confirm/Reject Selected Bookings'/>";
echo " </div>
                <div id = 'content_bottom'></div>
                <div id = 'footer><h3>Developed by: Bond With Bondas</h3></div>
                </div>
                </body>
                </html>";

	/*	echo "<br/>
		<table>
		<tr><td> Building: </td>
		<td>  </td></tr>
		<tr><td> Room: </td>
		<td><div id='divbuildingName'> </div></td>
		</tr>
		<tr> <td>Date : </td>
		<td> <div id='divroomName'> <script>DateInput('date', true,'YYYY-MM-DD' )</script>   </div> </td>
		</tr>
		<tr> <td>Timeslot : </td>
		<td> <div id='divdate'> </div> </td>
		</tr>
		</table>
		<input type='submit' name='submit' id='submit' value='BookRoom'/>
		</form>
		</body>
		</html>";*/
}
?>
