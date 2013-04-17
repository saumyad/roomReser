<?php include "essential.php";
check_login();
dbconnect();
if(!isset($_SESSION['user']))
{
	header("Location:index.php?msg=You are logged out");
}
$query1="select * from User where name = '".$_SESSION['user']."';";
$result1=execute($query1);
if(mysql_num_rows($result1) > 1)
{
	header("location:error.php?There is some internal error");
}
$result1=mysql_fetch_assoc($result1);
$id=$result1['userId'];
$query2="select * from Booking where user = ".$id.";";
$result2=execute($query2);
$count=mysql_num_rows($result2);
$date1=date('m/d/Y h:i:s');
echo"<html>
	<head>
	<link type='text/css' rel='stylesheet' href='static/slickblue/style.css'/>

	</head><body>
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

        if ($_SESSION['level'] == 0){
                echo"
                        <li><a href='queryroom4.php' > QUERY Room </a></li>
                        <li><a href='bookroom.php' > Book Room </a></li>
                        <li><a href='cancelbook.php' > Cancel Your Bookings </a></li>
                        <li><a href ='rooms.php' >ROOMS</a></li>
                        ";
        }
        else if($_SESSION['level'] == 1)
        {
                echo"
			<li><a href='queryroom4.php' > QUERY Room </a></li>
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
                        <li ><a href='queryroom4.php' target='content'> QUERY Room </a></li>
                        <li ><a href='confirmbooking.php' target='content'> Confirm Room Bookings </a></li>
                        <li ><a href='bookroom.php' target='content'> Book Room </a></br>
                        <li ><a href='cancelbook.php' target='content'> Cancel Your Bookings </a></li>";
        }
                echo"
                </ul>
                </div>
                <div id='leftmenu_bottom'></div>
                </div>
                <div id='content'>
                <div id = 'content_top'></div>
                <div id = 'content_main'>
                <h2 class='center'> Profile </h2>
                ";

echo "


	<table><tr><td><h2>Name: </h2></td>
			<td><h2>".$result1['name']."</h2></td></tr>
		<tr><td><h2>Email: </h2></td>
			<td><h2>".$result1['email']."</h2></td></tr>
	</table>
	
		<h3>Your Bookings :".$count."</h3>";
		echo"
		<TABLE BORDER=2 class='center' >
		<tr><th>RoomID</th>
		<th>RoomName</th>
		<th>Description</th>
		<th>Start_Date</th>
		<th>End_Date</th>
		<th>Start_Time</th>
		<th>End_Time</th>
		<th>Repeat_Type</th>
		<th>Status</th>
		</tr>";

		while($row=mysql_fetch_assoc($result2)){
			echo "<tr><td><font face = 'Arial, Helvetica, sans-serif'>";
			echo $row['roomId'];
			$rowname=$row['roomId'];
			$query3="select roomName from Room where roomId = ".$rowname.";";
			$result3=execute($query3);
			$result3=mysql_fetch_assoc($result3);
			echo "</font></td>
				<td><font face = 'Arial, Helvetica, sans-serif'>";
			echo $result3['roomName'];
			echo "</font></td>
				<td><font face = 'Arial, Helvetica, sans-serif'>";
			echo $row['description'];
			echo "</font></td>
				<td><font face = 'Arial, Helvetica, sans-serif'>";
			echo $row['Start_Date'];
			echo "</font></td>
				<td><font face = 'Arial, Helvetica, sans-serif'>";
			echo $row['End_Date'];
			echo "</font></td>
				<td><font face = 'Arial, Helvetica, sans-serif'>";
			echo $row['Start_Time'];
			echo "</font></td>
				<td><font face = 'Arial, Helvetica, sans-serif'>";
			echo $row['End_Time'];
			echo "</font></td>
				<td><font face = 'Arial, Helvetica, sans-serif'>";
			echo $row['Repeat_Type'];
			echo "</font></td>
				<td><font face = 'Arial, Helvetica, sans-serif'>";
			if($row['status']=='1') echo "booked";
			else echo "Requested";
			echo "</font></td>
				</tr>";
		}
	echo"</table>
		</body>
		</html>";
?>
