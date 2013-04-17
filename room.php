<?php
//BOOK ROOM

include("essential.php");
check_login();
dbconnect();
	echo "<html>
		<head>
		<script type='text/javascript' src='jquery.js'> </script>
		<link type='text/css' rel='stylesheet' href='static/style1.css'/>
		<script type='text/javascript' src='static/calendarDateInput.js'> </script>
		<script type='text/javascript'>
			function getbooking(date_s,date_e){
				var time_s = document.getElementById('time_start');
				time_s = time_s.options[time_s.selectedIndex].value;
				var time_e = document.getElementById('time_end');
				time_e = time_e.options[time_e.selectedIndex].value;
				var room = document.getElementById('thisRoom');
				param={};
				//alert(date_s);
				param['Start_Date']=date_s;
				param['End_Date']=date_e;
				param['End_Time']=time_e;
				param['Start_Time']=time_s;
				param['roomName']=room.innerHTML;
				//alert('pahucha');
				$.post('getbooking.php',param,function(ret_val){
				//	alert('adsfaf');
					alert(ret_val);
					$('#getbooking').html(ret_val);
				});
			}
		</script>
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
	echo "men.php";
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
        }*/
 echo"
                </ul>
                </div>
                <div id='leftmenu_bottom'></div>
                </div>
                <div id='content'>
                <div id = 'content_top'></div>
                <div id = 'content_main'>
                <h2 > Room Form</h2>
                ";

echo "

		<p id='time' > Server Time </p>
		";
	if($_GET['msg']) echo "<p style='background-color:#1C478E;font-size:14pt;color:#FFFFFF;text-align:right;'>" . $_GET['msg'] . "</p>";
	if($_GET['date']){
		$date = $_GET['date']; 
		$time = strtotime($date);
	}
	else $time = time();
	if(!isset($_GET['roomId'])){
		header('Location:rooms.php');
		die();
	}

	$roomId = $_GET['roomId'];
	$query = "select roomName from Room where roomId='".$roomId."';";
	$row = mysql_fetch_assoc(execute($query));
	$roomName = $row['roomName'];
	echo "<div id='thisRoom' >".$roomId."</div>";
	echo "<div style='text-align:center'>";

	echo "<a href='room.php?date=" . date("d-M-y",strtotime("-1 day",$time))."&roomId=".$roomId."'> Prev </a>";
	echo date("d-M-y",$time);
	echo "<a href='room.php?date=" . date("d-M-y",strtotime("+1 day",$time))."&roomId=".$roomId."'> Next </a></div>";

	echo "</br>";
	echo "</br>";
	$results = collision($roomId , $time , $time ,$time , strtotime('23:59:59'),'DAILY');
	
	$time_s = '00:00:00'; // initial start time
	$booking_start = 0; //to check for the first time it enters booking state
	$booking_start_time = '00:00:00';
	foreach ($results as $booking){
		if($booking['Start_Time'] != $time_s)  {
			if($booking_start){
				echo $booking_start_time . " BOOKED ". $time_s . "</br>";
				$booking_start = 0;
			}
			echo $time_s."<a href='"."bookroom.php?roomName=".$roomName."&Start_Date=".date("d-M-y",$time)."&End_Date=".date("d-M-y",$time)."&Start_Time=".$time_s."&End_Time=".$booking['Start_Time'] ."'> AVAILABLE </a>" .$booking['Start_Time']."</br>";
			$time_s = $booking['Start_Time'];
			$booking_start = 1;
			$booking_start_time = $booking['Start_Time'];
			$time_s = $booking['End_Time'];
		}
		else {
			$booking_start = 1;
			$time_s = $booking['End_Time'];
		}
	}
	if($booking_start){
				echo $booking_start_time . " BOOKED ". $time_s . "</br>";
	}
	if($time_s < '23:59:59'){
			echo $time_s."<a href='"."bookroom.php?roomName=".$roomName."&Start_Date=".date("d-M-y",$time)."&End_Date=".date("d-M-y",$time)."&Start_Time=".$time_s."&End_Time="."23:59:59" ."'> AVAILABLE </a>". "23:59:59</br>";
	}

	//date intervals to select
	echo "
		<form name='form1' >
		<table id='center'>
		<tr> <td>Start Date : </td>
		<td> <div id='sdivdate'> <script>DateInput('date_start', true,'YYYY-MM-DD')</script>   </div> </td>
		</tr>
		<tr> <td>End Date : </td>

		<td> <div id='edivdate'> <script>DateInput('date_end', true,'YYYY-MM-DD')</script>   </div> </td>
		<tr> <td>Start Timeslot : </td>
		<td> " . generate_timeslot("time_start") ."  </td>
		</tr>
		<tr> <td>End Timeslot : </td>
		<td> " . generate_timeslot("time_end") . " </td>
		</tr>
		</table>";
	echo "<input type='button' name='button' value='Slots' id='button' onClick='getbooking(this.form.date_start.value,this.form.date_end.value)'/>	";
	echo"
		</form>
		<p id='getbooking'> </p>
		</div>
                <div id = 'content_bottom'></div>
                <div id = 'footer><h3>Developed by: Bond With Bondas</h3></div>
                </div>
		</body>
		</html>";
?>
