<?php
include("essential.php");
if(!isset($_SESSION['user']) || !isset($_SESSION['level']))
{
	header("location:error.php?msg=USER NOT DEFINED");
}
else{
	echo "
		<div id = 'leftmenu'>
		<ul>";

	
		



	if ($_SESSION['level'] == 0){
		echo"
			<li><a href='queryroom4.php' target='content'> QUERY Room </a></li>
			<li><a href='bookroom.php' target='content'> Book Room </a></li>
			<li><a href='mail.php' target='content'>SEND MAIL </a></li>
			<li><a href='profile.php' target='content'> View Profile </a></li>
			<li><a href='cancelbook.php' target='content'> Cancel Your Bookings </a></li>
			<li><a href='logout.php' target='_top'> LOGOUT </a></li>
			<li><a href ='rooms.php' target='content'>ROOMS</a></li>
			";

	}
	else if($_SESSION['level'] == 1)
	{
		echo"
			<li><a href='addroom.php' target='content'> Add Room </a></li>
			<li><a href='addBuilding.php' target='content'> Add Building </a></li>
			<li><a href = 'category.php' target = 'content'>Add Category</a></li>
			<li><a href='confirmbooking.php' target='content'> Confirm Room Bookings </a></li>
			<li><a href='queryroom4.php' target='content'> QUERY Room </a></li>
			<li><a href='mail.php' target='content'>SEND MAIL </a></li>
			<li><a href='bookroom.php' target='content'> Book Room </a></li>
			<li><a href='profile.php' target='content'> View Profile </a></li>
			<li><a href='cancelbook.php' target='content'> Cancel Bookings </a></li>
			<li><a href='logout.php' target='_top'> LOGOUT </a></li>";

	}
	else if($_SESSION['level'] == 2)
	{
		echo"
			<li><a href='queryroom4.php' target='content'> QUERY Room </a></li>
		        <li><a href='confirmbooking.php' target='content'> Confirm Room Bookings </a></li>
			<li><a href='bookroom.php' target='content'> Book Room </a></br>
			<li><a href='profile.php' target='content'> View Profile </a></br>
			<li><a href='mail.php' target='content'>SEND MAIL </a></br>
			<li><a href='cancelbook.php' target='content'> Cancel Your Bookings </a></li>
			<li><a href='logout.php' target='_top'> LOGOUT </a></li>";

		
		echo"

		
		</ul>";
	}
}
?>

