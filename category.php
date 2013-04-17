<?php 
include("essential.php");
check_login();
if(isset ($_SESSION['user']) && !empty($_SESSION['user']) && $_SESSION['level'] != 1)
{
	header("Location:error.php?msg=YOU ARE NOT AUTHENTICATED");
	die();
}
dbconnect();
if(ISSET($_POST['add']) || ISSET($_POST['delete']))
{
	if( ISSET($_POST['delete']))
	{
		if(empty($_POST['cat_sel']))
		{
			header("Location:category.php?msg='category to be deleted is not selected'");
			die();
		}
		$q = "delete from Category where catName='".$_POST['cat_sel']."';";
		execute($q);
		header("Location:category.php?msg='category deleted successfully'");
		die();
	}
	else if(ISSET($_POST['add']))
	{
		echo $_POST['cat_name']."HI";
		echo $_POST['description']."THERE";
		$flag = 0;
		foreach( $_POST as $key => $value)
		{
			if($value == '' || $value == null)
			{
				$flag =1;
				//header("Location:category.php?msg=form is incomplete");
			}
		}
		if($flag == 1)
		{
			header("Location:category.php?msg=form is incomplete");
			die();
		}
		$q = "select catName from Category where catName = '".$_POST['cat_name']."';";
		$r = execute($q);
		if(mysql_num_rows($r) != 0)
		{
			header("Location:category.php?msg='Category already exists'");
			die();
		}
		$q = "insert into Category(catName, description) values ('".$_POST['cat_name']."', '".$_POST['description']."');";
		execute($q);
		header("Location:category.php?msg='Category successfully added!!!'");
		die();
	}
}
else
{
	echo "
		<html>
		<head>
		<link type='text/css' rel='stylesheet' href='static/slickblue/style.css'/>
		</head>
		<body>";
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
                ";


	if(ISSET($_GET['msg']))
	{
		echo "<p style='background-color:#1C478E;font-size:14pt;color:#FFFFFF;text-align:right;'>" . $_GET['msg'] . "</p>";

	}

	echo"
		<form name = 'add_category' method = 'POST' action = '".$PHP_SELF."'>
		<h2 align ='center' >ADD CATEGORY</h2>
		<table align = 'center'>
		<tr>
		<td>Category name</td>
		<td><input type = 'text' name = 'cat_name' />
		</tr>
		<tr>
		<td>Description:</td>
		<td>
		<textarea rows = '4' cols = '50' name = 'description'></textarea></td>
		</tr>
		<tr>
		<td></td>
		<td><input type = 'submit' name = 'add' value='Add Room'/>
		</table>
		</form>
		";
	echo "</br></br>";
	$q = "select catName from Category;";
	$r = execute($q);
	$x = "cat_sel";
	$list = generate_list($q, $x);

	echo "
		<h2 align = 'center'>Delete Category</h2>
		<form name = 'delete_category' method = 'POST' action = '".$PHP_SELF."'>
		<table align= 'center'>
		<tr>
		<td>Category name</td>
		<td>".$list."</td>
		</tr>
		<tr>
		<td></td>
		<td><input type = 'submit' name = 'delete' value = 'Delete Category'/></td>
		</tr>
		</table>
		</form>
		</div>
                <div id = 'content_bottom'></div>
                <div id = 'footer><h3>Developed by: Bond With Bondas</h3></div>
                </div>
                </body>
                </html>";

}



		

