<?php


include("essential.php");
check_login();
dbconnect();
if(isset($_POST['submit'])){

	$st = '';
	$flag=0;
	foreach ($_POST as $key=>$value){
	 	echo "$key => $value";
	}
/*	if($flag==0) header("Location:error.php");
	echo $st;
	$q = "select * from Booking where "; 
	if($_POST['buildingName']!='') $q .= "buildingName='" . $_POST['buildingName'] . "';" ;
	$r = execute($q);
	if(mysql_num_rows($r) != 1) die();
	else{
		$row = mysql_fetch_array($r);
		$id =  $row[0];
		echo "id:" . $id ;
	}*/
}
else{
	echo "<html>
		<head>
		<script type='text/javascript' src='jquery.js'> </script>
		<script type='text/javascript' src='static/calendarDateInput.js'> </script>
		<script type='text/javascript'>
		$(document).ready(function(){
			  	function ajax_search(){
				  	var b = $('#buildingName').val();
					var param ={};
					param['buildingName'] = b;
					$.post('getroom.php',param,function(data){
					    $('#divbuildingName').html(data);
					});
				}
				function addOption(myparent,val){
				  var opt = document.createElement('option');
				  opt.text = val;
				  opt.value = val;
				  opt.id = val;
				  myparent.options.add(opt);
				}
				function generate_all_timeSlots(){
					var time = $(document.createElement('select')).attr('id','timeSlot');
					time.insertBefore('#fake');
					var list = document.getElementById('timeSlot');
					var half = ':30';
					var full = ':00';
					for( i=0 ; i<24 ; i++){
					  j=''+i;
					  addOption(list,j+full);
					  addOption(list,j+half);
					}
				}
				$('#buildingName').change(function(){
					ajax_search();
				});
				ajax_search();
				generate_all_timeSlots();


		});
	</script>
		</head>
		<body>
		<p> welcome " . $_SESSION['user'] . "</p>
		<form name='queryroom' method='POST' action='" . $PHP_SELF . "'>" ;
	$q = "select buildingName from Building";
	$x = "buildingName";
	$st =  generate_list($q,$x);
	echo "<br/>
	<table>
	  <tr><td> Building: </td>
	      <td> ". $st . " </td></tr>
	  <tr><td> Room: </td>
	      <td><div id='divbuildingName'> </div></td>
	   </tr>
	  <tr><td> Date: </td>
	      <td><div id='divroomName'> <script>DateInput('date', true, 'DD/MON/YYYY')</script>  </div></td>
	   </tr>
	  <tr><td> Timeslot: </td>
	      <td><div id='divdate'>  <div id='fake'> </div></div></td>
	   </tr>
	</table>
	<input type='submit' name='submit' id='submit' value='QueryRoom'/>
	</form>
	</body>
	</html>";
}
?>
