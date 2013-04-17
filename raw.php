<?php

include("essential.php");
check_login();

if(isset ($_SESSION['user']) && !empty($_SESSION['user']) && $_SESSION['level'] != 1)
{
      header("Location:error.php?msg='YOU ARE NOT AUTHENTICATED'");
        die();
}



dbconnect();
	 
if($_POST){
	foreach ($_POST as $key=>$value){
		if($value=='' ||  $value==null){
			$flag=1;
		}
	}
	if($flag==1){
		header("Location:addroom.php?msg='Form not fully filled'");
		die();
	}

	if(isset($_POST['deleteroom']))
	{
		if(($_POST['dRoom']) == null || $_POST['dRoom'] == ''){
			header("Location:addroom.php?msg='Room name not specified'");
			die();
		}
		
		$query5 = "delete from Room where roomName = '".$_POST['dRoom']."';";
		execute($query5);
		header("Location:addroom.php?msg='Room Deleted'");
		die();
	}
	else{
	$q = "select buildId from Building where buildingName='".$_POST['buildingName']."';" ;
	$r = execute($q);
	if($_POST['a_u'] == 'add'){
		$r11=$_POST['roomName'];
		if(empty($r11)){
			header("Location:addroom.php?msg='Room name not specified'");
			die();
		}
		$rname=$_POST['roomName'];
	}
	else{
		if(empty($_POST['roomName'])){
			if(empty($_POST['Room'])){
				header("Location:addroom.php?msg='Room name not specified'");
				die();
			}
			$rname=$_POST['Room'];
		}
		else
			$rname=$_POST['roomName'];
	}

	if(mysql_num_rows($r)!=1) { 
	if($_POST['a_u'] == 'add'){
		header("Location:addroom.php?msg='Cannot insert.Cannot fetch proper building.'");
	}
	}
		$row = mysql_fetch_array($r);
		$id =  $row[0];
		if($_POST['description'] == '')
		{
			$_POST['description'] = 'EMPTY';
		}
		if($_POST['a_u'] == 'add'){
		$q = "insert into Room (roomName,buildingName,Capacity,description) values ('" . $rname . "','" . $id . "','".$_POST['cap']."','".$_POST['description']."');" ;
		execute($q);
		}
		$query3="select roomId from Room where roomName = '".$rname."';";
		$id2=execute($query3);
		$id2=mysql_fetch_array($id2);
		$id2=$id2[0];
		if($_POST['a_u'] == 'update' )
		{
			if(!empty($id))
			$q = "update Room set roomName='" .$rname. "', buildingName='" . $id . "', Capacity='".$_POST['cap']."', description='".$_POST['description']."' where roomName ='".$_POST['Room']."';";
			else
			$q = "update Room set roomName='" .$rname. "', Capacity='".$_POST['cap']."', description='".$_POST['description']."' where roomName ='".$_POST['Room']."';" ;
			execute($q);
			$del="delete from Room_Cat where roomId=".$id2.";";
			execute($del);	
		}
		if(empty($_POST['Category']))
		{
			
			header("Location:addroom.php?msg='Room inserted/updated successfully.You did not have category preferences.'");
			 die();
		}
		else{
			$count=count($_POST['Category']);
			for($i=0;$i<$count;$i++)
			{
				$query2="insert into Room_Cat values('".$id2."','" .$_POST['Category'][$i]. "');";
				execute($query2);
			}
			header("Location:addroom.php?msg='Room inserted/updated successfully.'");
			die();
		}
	}
	
}
else{
	$query = "select Category.catId, Category.catName from Category ;";
        $category = execute($query);
	$query4="select DISTINCT roomName from Room;";
	$r="Room";
	$list1=generate_list($query4,$r);
	echo "
		<html>
		<head>
		<script type='text/javascript' src='jquery.js'> </script>
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
                echo"
                </ul>
                </div>
                <div id='leftmenu_bottom'></div>
                </div>
                <div id='content'>
                <div id = 'content_top'></div>
                <div id = 'content_main'>
                <h2 class='center'> Add Room </h2>
                ";


	if(isset($_GET['msg'])){
		echo "<p style='background-color:#1C478E;font-size:14pt;color:#FFFFFF;text-align:right;'>" . $_GET['msg'] . "</p>";
	}
	echo "<form name='add_updateroom' method='POST' action='" . $PHP_SELF . "'>

		<table class='center'> 
		 <tr><td><input type='radio' name='a_u' value = 'add' checked>Add a new Room</td>
		 	<td><input type='radio' name='a_u' value = 'update' >Update an existing Room</br>".$list1."</br></td>
		 </tr>	
		<tr>
		<br/>
		<td><br/> Room Name(Add/New Name): </td>
		<td> <input type='text' name='roomName' id='room' value=''/></td>
		</tr>
		<tr>
		<td>Capacity: </td>
		 <td><input name='cap' type='number' min='0' max='2000' maxlength = 4 size = 4 value = 100></td>
		  </tr>
		  <tr><td>Description</td><td><input type='text' id='description' class='center' name='description' style='height:100px;width:300px' value='EMPTY' /> <br/></td>
		</tr>
		 <tr><td>Category: </td><td><br/> ";
			if(!mysql_num_rows($category))
			{
				echo "No Available Categories";
			}
			else{
			while($row = mysql_fetch_array($category)){
				echo"<input type='checkbox' name='Category[]' value='".$row['catId']."'>"  .$row['catName']. "
				<br/>";
			}}

		echo"</td><tr>
		<td> Select Building: </td><td>
		";
	$q = "select buildingName from Building";
	$x = "buildingName";
	$st =  generate_list($q,$x);
	echo $st . 

		"</td></tr><tr><td></td><td> <input type='submit' name='submit' id='submit' value='Add/UpdateRoom'/></td></tr>
		</table>
		</form> 
		";
	$r1='dRoom';
	$list2=generate_list($query4,$r1);
	echo "<form name='deleteroom' method='POST' action = '".$PHP_SELF."' >
		<h2 align='center'>Delete Room</h2>
		<table class='center'><tr><td>Select Room: </td>
			   <td>".$list2."</td></tr>
			   <tr><td></td><td><input type='submit' name='deleteroom' value='DeLeTe'/></td></tr>
		</table></form>
</div>
                <div id = 'content_bottom'></div>
                <div id = 'footer><h3>Developed by: Bond With Bondas</h3></div>
                </div>"

;
	echo "</body></html>
		";

}
?>
