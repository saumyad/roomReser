<?php include "essential.php";
check_login();
if(!isset($_SESSION['user'])){
	header("location:index.php?You are not logged in");
	die();
}
if(empty($_GET['del_id']) || $_GET['del_id'] == "")
{
	header("location:error.php?You cannot access the page");
	die();
}
dbconnect();
$delid = $_GET['del_id'];
$query2="select * from Booking where booking_id = ".$delid.";";
if(isset($_POST['submit']))
{
	foreach ($_POST as $key=>$value){
		if($value=='' ||  $value==null){
			$flag=1;
		}
	}
	if($flag==1){
		header("Location:error.php?msg='Form not fully filled'");
		die();
	}
	if($_POST['deltype'] == 'ent'){
		delete_mail($delid);
		//$query1="delete from Booking where booking_id ='".$delid."';";
		//execute($query1);
		header("Location:cancelbook.php?msg='The booking is deleted'");
		die();
	}
	if($_POST['deltype'] == 'sel'){
		$date_s = strtotime($_POST['date_start']);
		$date_e = strtotime($_POST['date_end']);
		$query2="select * from Booking where booking_id = ".$delid.";";
		$result1=execute($query2);
		$result1=mysql_fetch_assoc($result1);
			$dels = strtotime($result1['Start_Date']);
			$dele = strtotime($result1['End_Date']);
		if(empty($result1))
		{
			header("Location:error.php?msg='Booking Id does not exist'");
			die();
		}
		if(!($date_s >= $dels && $date_e <= $dele && $date_s <= $date_e))
		{
			header("Location:error.php?msg='There is something wrong with your date intervals'");
			die();
		}
		else
		{
			$dels = strtotime($result1['Start_Date']);
			$dele = strtotime($result1['End_Date']);
			$newds1 = $dels;		// start date 1st interval
			$newde1 = strtotime("-1 day",$date_s);
			$newds2 = strtotime("+1 day",$date_e);
			$newde2 = $dele;
			$newds1 = date("Y-m-d",$newds1);		// start date 1st interval
			$newde1 = date("Y-m-d",$newde1);		// end date 1st interval
			$newds2 = date("Y-m-d",$newds2);		// start date 2st interval
			$newde2 = date("Y-m-d",$newde2);		// end date 2st interval
			echo $newde2." ".$newde1." ".$newds2." ".$newds1;
			if(!($newds1 > $newde1 )){
			$newmadeat = date("H:i:s",getdate());
			$newmadeon = date("Y-m-d",getdate());
			$query3="insert into Booking(user,confirmedBy,madeAt,madeOn,roomId,status,description,Start_Date,End_Date,Start_Time,End_Time,Repeat_Type) values('".$result1['user']."','".$result1['confirmedBy']."'
								,'".$newmadeat."'
								,'".$newmadeon."'
								,'".$result1['roomId']."'
								,'".$result1['status']."'
								,'".$result1['description']."'
								,'".$newds1."'
								,'".$newde1."'
								,'".$result1['Start_Time']."'
								,'".$result1['End_Time']."'
								,'".$result1['Repeat_Type']."');";
								
			$result5 = execute($query3);

			}
			if(!($newds2 > $newde2 )){
			$newmadeat = date("H:i:s",getdate());
			$newmadeon = date("Y-m-d",getdate());
			$query4="insert into Booking(user,confirmedBy,madeAt,madeOn,roomId,status,description,Start_Date,End_Date,Start_Time,End_Time,Repeat_Type) values('".$result1['user']."'
								,'".$result1['confirmedBy']."'
								,'".$newmadeat."'
								,'".$newmadeon."'
								,'".$result1['roomId']."'
								,'".$result1['status']."'
								,'".$result1['description']."'
								,'".$newds2."'
								,'".$newde2."'
								,'".$result1['Start_Time']."'
								,'".$result1['End_Time']."'
								,'".$result1['Repeat_Type']."');";
								
			$result6 = execute($query4);
			}
			$query5 = "delete from Booking where booking_id=".$delid.";";
			$result7 = execute($query5);
			header("Location:cancelbook.php?msg='booking deleted'");

		}


	}

	
}
else{
echo "<html>
	<head>
	<link rel='stylesheet' type='text/css' href='static/style1.css'/>
	<script type='text/javascript' src='static/calendarDateInput.js'> </script>
	</head>
	<body>
	<h1 align='center'>Confirm Delete</h1></br></br>
	<form name = 'confirmdel' method = 'POST' action = ".$PHP_SELF.">
	<table class='center'>
	<tr><td>Booking Id :</td><td>".$delid."</td></tr>";
	$result1 = execute($query2);
	
	if(mysql_num_rows($result1) < 1){
		header("location:error.php?msg=Something went wrong.The booking id does not exist.");
		die();
	}
	$result1=mysql_fetch_assoc($result1);
	$result2= execute("select name from User where UserId = ".$result1['confirmedBy'].";");
	$result2=mysql_fetch_assoc($result2);
	echo"<tr><td>Confirmation By :</td><td>".$result2['name']."</td></tr>
	<tr><td>Made On :</td><td>".$result1['madeOn']."</td></tr>
	<tr><td>Start Date :</td><td>".$result1['Start_Date']."</td></tr>
	<tr><td>End_Date :</td><td>".$result1['End_Date']."</td></tr>
	<tr><td>description :</td><td>".$result1['description']."</td></tr>
	<tr><td>Repeat Type :</td><td>".$result1['Repeat_Type']."</td></tr>
	<tr><td>Status :</td><td>";
	if($result1['status']=='1') echo 'booked';
                         else echo 'Requested';
			 echo"</td></tr>
	<tr><td><input type='radio' name='deltype' value = 'sel' >Delete Instances</td> 
	<td> Delete From: </br>
	<div id='divroomName'> <script>DateInput('date_start', true, 'YYYY-MM-DD')</script>  </div></td>
	
	<td> To: 
	<div id='divroomName2'> <script>DateInput('date_end', true, 'YYYY-MM-DD')</script>  </div></td>
	</tr>
	<tr><td><input type='radio' name='deltype' value = 'ent' checked>Delete Entire Booking</td><td></td></tr>
	 <tr><td><input type='submit' name='submit' id='submit' value='Confirmdel'/></td></tr>
	 </table>
	 </form>
	 </body>
	 </html>";
}
