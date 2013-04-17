<?php
//BOOK ROOM

include("essential.php");
check_login();
dbconnect();
if(isset($_POST['submit'])){ //form is submitted

	//checking if any of the fields is empty.
	$flag=0;
	foreach ($_POST as $key=>$value){
		if($key == 'buildingName') continue;
		if($value=='' ||  $value==null){
			$flag=1;
		}
		echo "$key => $value</br>";
	}
	if($flag==1){
		header("Location:bookroom.php?msg='Form not fully filled'");
		die();
	}

	$status=1; //normal user...
	if($_SESSION['level']==0) $status=0; // set user to priveleged.

	//validating form
	$today_d = strtotime(date('Y-m-d',time()));
	$time = strtotime(date('H:i:s'));

	$time_s = strtotime($_POST['time_start']);
	$time_e = strtotime($_POST['time_end']);
	$date_s = strtotime($_POST['date_start']);
	$date_e = strtotime($_POST['date_end']);

	if( $time_s < $time) echo "YES </br>";
	if( $time_s >= $time_e || $date_s > $date_e || $date_s < $today_d || ($date_s == $today_d && $time_s < $time)){
		header("Location:error.php?msg='ERROR: Your Date and time limits are wrong!");
		die();
	}
	// check on the basis of 'DAily' or 'None'


	// get the room id for future use in queries.
	$room_query = "select roomId from Room where roomName='" .$_POST['roomName']. "'";
	$result = execute($room_query);
	$roomId = make_array($result); // returns array of the 0th elements of the query.
	$roomId = $roomId[0];
	echo "room id is $roomId";

	//getting userId 
	$userId_query = "select userId from User where name='" . $_SESSION['user'] . "'";
	$userId_result = execute($userId_query);
	$userId = make_array($userId_result); // returns array of the 0th elements of the query.
	$userId = $userId[0];
	echo "user id " . $userId . "</br>";

	//checking if there is a booking previously confirmed and overlaps with this...
	$collision_result = collision($roomId , $date_s,$date_e,$time_s , $time_e , $_POST['Repeat_type']);
	$exists_confirm = 0;
	$confirmed_booking = array();
	echo "all the conflicting arrays are : <br/>";
	foreach ($collision_result as $row){
		echo "$row <br/>";
		if($row['status'] == 1 ){
			$confirmed_booking = $row ;
			$exists_confirm = 1 ; break;
		}
		echo "rowUser " . $row['user'] . "userId " . $userId . "<br/>" ;
		if( (int)$row['user'] == $userId){
			header('Location:error.php?msg="You have requested for the same room previously that has timings clashing with your current request for the room."');
			die();
		}
	}

	if($exists_confirm){
		$msg = "There is a booking by confirmed for the room requested with the timeslots that overlaps with yours";
		header("Location:error.php?msg=$msg");
		die();
	}
	foreach ($collision_result as $row){
	   delete_mail($row['booking_id']);
	}


	$time_s = ($_POST['time_start']);
	$time_e = ($_POST['time_end']);
	$date_s = ($_POST['date_start']);
	$date_e = ($_POST['date_end']);

	/*	echo "$time </br>";
		echo "$time_s </br>";
		echo "$time_e </br>";
		echo "$date_s </br>";
		echo "$date_e </br>";
		echo "$today_d </br>";
	 */

	if($_SESSION['level'] != 0){ // if priveleged user then no need to confirm...
	  $_POST['confirmedBy'] = $_SESSION['user'];
	}
	echo "inserting";
	// inserting bookings....
	$query = "insert into Booking (user,confirmedBy,madeAt,madeOn , roomId , status , description , Start_Date,End_Date, Start_Time , End_Time ,Repeat_Type ) values"
		. "((select userId from User where name='" . $_SESSION['user'] . "'),"
		. "(select userId from User where name='" . $_POST['confirmedBy'] ."' ) ,"
		. "'". date('H:i:s') . "',"
		. "'". date('Y-m-d',time()). "'," 
		. "$roomId" . ","
		. "$status" . ","
		. "'". $_POST['description']."',"
		. "'".$_POST['date_start']."',"
		. "'".$_POST['date_end']."',"
		. "'".$_POST['time_start']."',"
		. "'" .$_POST['time_end']. "',"
		. "'" .$_POST['Repeat_type']."'"
		. " ) ;" ;

	$result = execute($query);

	//inserting in updates:
	$msg = ""
	.$_SESSION['user']
	." requested for Room "
	.$_POST['roomName']
	." for dates "
	.$_POST['date_start']
	." to "
	.$_POST['date_end']
	." from Hrs."
	.$_POST['time_start']
	." to "
	.$_POST['time_end']
	.".<br/> Description of activity : " 
	.$_POST['description'];
	$query = "insert into Updates ( description , up_time ) values ('" .$msg."','".time()."');" ;
	execute($query);
		
	
	header('Location:bookroom.php?msg="Room successfully booked"');
	die();
	/*	if($status == 1){
		call_function to delete all booking proposed to this...;
		}
	 *///	header("Location:bookroom.php?msg='Room is booked'");
	//die();

}
else{
	echo "<html>
		<head>
		<script type='text/javascript' src='jquery.js'> </script>
		 <link type='text/css' rel='stylesheet' href='static/slickblue/style.css'/>

		<script type='text/javascript' src='bookroom.js'> </script>
		<script type='text/javascript' src='server.js'> </script>

		<script type='text/javascript' src='static/calendarDateInput.js'> </script>
		<script LANGUAGE='javascript'>
			function setdefault(list){
			for(var i=0 ; i<list.options.length;i++){
			  //alert('asdfafs');
			  if(list.options[i].value == '". $_GET['roomName']."'){
			    list.options[i].selected = true;
 }
			}
			}

function toggleAlert(){
  toggleDisabled(document.getElementById('content3'));
  toggleDisabled(document.getElementById('content2'));
}
function toggleDisabled(el) {
  try {
    el.disabled = el.disabled ? false : true;
  }
  catch(E){
  }
  if (el.childNodes && el.childNodes.length > 0) {
    for (var x = 0; x < el.childNodes.length; x++) {
      toggleDisabled(el.childNodes[x]);
    }
  }
}



		</script>
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
                        <li><a href ='rooms.php' >ROOMS</a></li>
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
        }*/
echo"
                </ul>
                </div>
                <div id='leftmenu_bottom'></div>
                </div>
                <div id='content'>
                <div id = 'content_top'></div>
                <div id = 'content_main'>
                <h2 class='center'> Book Room </h2>";



echo "

		<p id='serverTime' > Server Time </p>
		";

	if($_GET['msg']) echo "<p style='background-color:#1C478E;font-size:14pt;color:#FFFFFF;text-align:right;'>" . $_GET['msg'] . "</p>";
	echo "		<form name='queryroom' style='text-align:center' method='POST'  action='" . $PHP_SELF . "'>" ;

	echo "<br/>";
		if(isset($_GET['roomName'])){
		  echo "
		  	<div id='content2'>
			<select name='roomName' id='roomName'>
			<option name='" .$_GET['roomName']. "' value='".$_GET['roomName']."'>".$_GET['roomName']."</option>
			</select> </div>
		   	I Know 	the room<input type='checkbox' value='' id='check' onclick='toggleAlert()' />
			";
		}
		echo"
		<div id='content3'>
		<table class='center'>
		<tr><td> Building: </td>
		<td> ". generate_list('select buildingName from Building','buildingName'). " </td></tr>
		<tr><td> Room: </td>
		<td><div id='divbuildingName'> </div></td>
		</tr>
		</table>
		</div>
		<table class='center'>
		<tr> <td>Start Date : </td>";
		if(isset($_GET['Start_Date'])) echo "<td> <div id='sdivdate'> <script>DateInput('date_start', true,'YYYY-MM-DD','".date('Y-m-d',strtotime($_GET['Start_Date']))."')</script>   </div> </td>";
		else echo "<td> <div id='sdivdate'> <script>DateInput('date_start', true,'YYYY-MM-DD')</script>   </div> </td>";
		echo "
		</tr>
		<tr> <td>End Date : </td>";
		if(isset($_GET['End_Date'])) echo "<td> <div id='edivdate'> <script>DateInput('date_end', true,'YYYY-MM-DD','" . date('Y-m-d', strtotime($_GET['End_Date']))."')</script>   </div> </td>";
		else  echo "<td> <div id='edivdate'> <script>DateInput('date_end', true,'YYYY-MM-DD')</script>   </div> </td>";
		echo "
		</tr>
		<tr> <td>Start Timeslot : </td>
		<td> " . generate_timeslot("time_start") ."  </td>
		</tr>
		<tr> <td>End Timeslot : </td>
		<td> " . generate_timeslot("time_end") . " </td>
		</tr>
		<script LANGUAGE='javascript'>
			var list = document.getElementById('time_start');
			for(var i=0 ; i<list.options.length;i++){
			  if(list.options[i].value == '". $_GET['Start_Time'] . "'){
			    list.options[i].selected = true;
			  }
			}
			var list = document.getElementById('time_end');
			for(var i=0 ; i<list.options.length;i++){
			  if(list.options[i].value == '".$_GET['End_Time']."'){
			    list.options[i].selected = true;
 }
			}

		</script>
		<tr> <td>Repeat Type : 	</td> 
		<td> <input type='radio' name='Repeat_type' value='DAILY' checked='true' /> Daily </td> </tr>
		<tr>
		<td></td><td>  <input type='radio' name='Repeat_type' value='WEEKLY' /> Weekly </td>
		</tr>

		";
	if($_SESSION['level']==0){
		echo "<tr> <td>Confirm from: </td>
			<td> <div id='priveleged_users'>";
		$query = "select name from User where level=1";
		$x = "confirmedBy";
		$st = generate_list($query ,$x,0);
		echo $st .  "</div> </td>
			</tr>";
	}
	echo "
		<tr> <td> Activity/Reason: </td><td></td></tr>
		</table>
		<input type='text' id='description' class='center' name='description' style='height:100px;width:300px'  /> <br/>
		<input type='submit' name='submit' id='submit' class='center' value='BookRoom'/>
		</form>
		 </div>
                <div id = 'content_bottom'></div>
                <div id = 'footer><h3>Developed by: Bond With Bondas</h3></div>

		</body>
		</html>";
}
?>
