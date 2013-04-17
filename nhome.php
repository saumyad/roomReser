<?php
//BOOK ROOM

include("essential.php");
check_login();
dbconnect();


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
		<li><a href='queryroom4.php' > Query Room </a></li>
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
<h2 class='center'> Room Reservation System </h2>
";
echo "</br>
<table>
<tr><h1><td>
Welcome to Room Reservation Portal. Here you can book your rooms in a faster,easier, and in a way convinient manner.</h1></td>
	<td><img src='static/homepic.jpg' ALT='Photo' width=320 height=320></td>
	</table>



";
echo " </div>
<div id = 'content_bottom'></div>
<div id = 'footer><h3>Developed by: Bond With Bondas</h3></div>
</div>
</body>
</html>";

?>
