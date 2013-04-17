<?php
session_start();
if ($_SESSION['level'] == 0){
                echo"
                        <li><a href='queryroom4.php' > QUERY Room </a></li>
                        <li><a href='bookroom.php' > Book Room </a></li>
                        <li><a href='cancelbook.php' > Cancel Your Bookings </a></li>
                        <li><a href ='rooms.php' >Room Info </a></li>
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
                        <li ><a href='cancelbook.php' > Cancel Bookings </a></li>
			<li><a href = 'rooms.php'>Room Info</a></li>";
        }
else if($_SESSION['level'] == 2)
        {
                echo"
                        <li ><a href='queryroom4.php' target='content'> QUERY Room </a></li>
                        <li ><a href='confirmbooking.php' target='content'> Confirm Room Bookings </a></li>
                        <li ><a href='bookroom.php' target='content'> Book Room </a></br>
                        <li ><a href='cancelbook.php' target='content'> Cancel Your Bookings </a></li>
			<li><a href ='rooms.php' >Room Info </a></li>";

        }
?>
