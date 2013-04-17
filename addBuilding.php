<?php

include("essential.php");
check_login();
dbconnect();
if(!isset($_SESSION['user']))
{
	header("Location:index.php?msg=YOU ARE NOT AUTHENTICATED");
	die();
}
if($_SESSION['level'] != 1)
{
	header("Location:error.php?msg=YOU ARE NOT AUTHENTICATED");
	die();
}
if(isset($_POST['delete']))
{
	if(empty($_POST['bname']))
	{
		header("Location:addBuilding.php?msg=Give the building name");
		die();
	}
	$query2="delete from Building where buildingName = '".$_POST['bname']."';";
	execute($query2);
	header("Location:addBuilding.php?msg=Building Deleted");
	die();
}
if(isset($_POST['add'])){
if($_POST['Bname']){
	$building = escape($_POST['Bname']);
//	dbconnect();


	$q = "INSERT INTO Building (buildingName) VALUES('".$building."');";
	$r=execute($q);
	if (mysql_affected_rows()){

		header("Location:addBuilding.php?msg=Building Added");
		die();

	}
}
}
else echo"
<html>

<head>

<title>Add a Building</title>
<link type='text/css' rel='stylesheet' href='static/slickblue/style.css'/>

</head>
<body>
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
                <h2 class='center'> Add Building </h2>
                ";



if(isset($_GET['msg'])){
	echo "<p style='background-color:#1C478E;font-size:14pt;color:#FFFFFF;text-align:right;'>" . $_GET['msg'] . "</p>";
}
echo"
<form name='insert' action='".$PHP_SELF."' method='post'>
<table class='center'>
<tr><td>
Enter the new Building's Name : </td><td><input type='text' name = 'Bname' /></td>
</tr><tr><td></td><td><input type='submit' name='add' value='Add'/></td>
</tr></table>
</form>
<h2 class='center'> Delete Building </h2>
<form name='delete' action='".$PHP_SELF."' method='post'>
<table id='tabletype'>
<tr class='alt'><td>
Building Name: </td>";

$query = "select buildingName from Building;";
$r='bname';
$list1=generate_list($query,$r);

echo"
<td>".$list1."</td>
</tr><tr class='alt'><td></td><td><input type='submit' name='delete' value='Delete' /></td>
</tr></table>
</form>
</div>
                <div id = 'content_bottom'></div>
                <div id = 'footer><h3>Developed by: Bond With Bondas</h3></div>
                </div>



</body>
</html>
";
?>	 
