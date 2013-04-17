<?php

include("essential.php");
check_login();

dbconnect();
$q = "select * from Building;";
$r = execute($q);
echo "
	<html>
	<head>
	<link type='text/css' rel='stylesheet' href='static/slickblue/style.css'/>

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
*/
echo"
                </ul>
                </div>
                <div id='leftmenu_bottom'></div>
                </div>
                <div id='content'>
                <div id = 'content_top'></div>
                <div id = 'content_main'>
                <h2 class='center'> View Rooms </h2>";

echo "

	<table class ='center' id  = tabletype>
	<tr>
	";




while($result = mysql_fetch_assoc($r))
{
	echo "
		
		<td><a href = 'rooms.php?building_id=".$result['buildId']."'>".$result['buildingName']."</a></td>";
}
echo
	"</tr>
	</table>
	";

	if(ISSET($_GET) && $_GET['building_id'] != '' && $_GET['building_id'] != null)
	{
		$q1 =  "select * from Room where buildingName = ".$_GET['building_id'].";";
		$row_c = 1;
		$r1 = execute($q1);
		echo "
			<br/><br/><br/>
			<h2>Rooms</h2><br/>	
			<table id='tabletype' align='center'>
 			<tr class='alt0'>";
			$y=1;

		while($rows = mysql_fetch_assoc($r1))
		{
			echo "
				<td> <a href = 'room.php?roomId=".$rows['roomId']."'>".$rows['roomName']."</a></td>";
			$row_c = $row_c + 1;
			if($row_c % 6 == 0)
			{
				$row_c = 0;
				echo "
					</tr>
					<tr class='alt".$y."'>";
					$y = ($y+1)%2;
			}
		}
	}


			
			
 
echo "</table>
</div>
                <div id = 'content_bottom'></div>
                <div id = 'footer><h3>Developed by: Bond With Bondas</h3></div>
                </div>

	</body>
	</html>";



		



