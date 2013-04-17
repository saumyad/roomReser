<?php
//BOOK ROOM

include("essential.php");
check_login();
if($_SESSION['level'] != 1)
{
        header("Location:error.php?msg=YOU ARE NOT AUTHENTICATED");
        die();
}
dbconnect();
if(isset($_POST['submit'])){

	$st = '';
	$flag=0;
	foreach ($_POST as $key=>$value){
		echo "$key=>$value" . "</br>";
		if($value==''){
			$flag=1;
		}
	}
	echo "flag" . $flag . "</br>";
	if($flag==1){
		header("Location:bookroom.php");
	}
	$q = "insert into Booking (user,status,madeOn,madeAt,date) values"
		. "((select userId from User where name='" . $_SESSION['user'] . "'),"
		. "1,"
		. "'". date('Y-m-d',time()). "'," 
		. "'". date('H:i:s') . "',"
		. "'". $_POST['date']. "'"
		. " ) ;" ;

	echo $q;
	$r = execute($q);
}
else{
	echo "<html>
		<head>
		<script type='text/javascript' src='jquery.js'> </script>
		</head>
		<body>
		<p> welcome '" . $_SESSION['user'] . "' to the Room Reservation System</p>
		<form name='confirmroom' method='POST' action='" . $PHP_SELF . "'>" ;

		$q = "select User.name ,Room.roomName, Booking.date,Booking.timeSlot"
		     . " FROM User, Booking, Room"
		     . " WHERE confirmedBy=(select userId from User where name="
		     . "'" . $_SESSION['user']. "')"
		     . " and Booking.user=User.userId and Room.roomId=Booking.roomId "
		     . " and status=0 "
		     . ";";
		$r = execute($q);

		echo "You have " .mysql_num_rows($r)." requests to confirm";
		echo "<table>";
		while($row = mysql_fetch_array($r)){
		  echo "<tr>";
		  $count = sizeof($row);
		  for($i=0;$i<$count;$i++){
		    echo "<td>" . $row[$i] ."</td>";
		   
		    
		  }
		  echo "<td><input type='checkbox' name='confirmbookings' value=''/></td> ";
		  echo "</tr>";
		}
		echo "</table>";

/*	echo "<br/>
		<table>
		<tr><td> Building: </td>
		<td>  </td></tr>
		<tr><td> Room: </td>
		<td><div id='divbuildingName'> </div></td>
		</tr>
		<tr> <td>Date : </td>
		<td> <div id='divroomName'> <script>DateInput('date', true,'YYYY-MM-DD' )</script>   </div> </td>
		</tr>
		<tr> <td>Timeslot : </td>
		<td> <div id='divdate'> </div> </td>
		</tr>
		</table>
		<input type='submit' name='submit' id='submit' value='BookRoom'/>
		</form>
		</body>
		</html>";*/
}
?>
