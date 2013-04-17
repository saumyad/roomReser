<?php


include("essential.php");
check_login();
dbconnect();
if(isset($_POST['submit'])){

	$st = '';
	$flag=0;
	foreach ($_POST as $key=>$value){
		if($key!='submit' && $value!=''){
		  $flag=1;
		  break;
		}
	}
	if($flag==0) header("Location:error.php");
	echo $st;
	$q = "select * from Booking where "; 
	if($_POST['buildingName']!='') $q .= "buildingName='".$_POST['buildingName']."';" ;
	$r = execute($q);
	if(mysql_num_rows($r) != 1) die();
	else{
		$row = mysql_fetch_array($r);
		$id =  $row[0];
		echo "id:" . $id ;
	}
}
else{
	echo "<html>
		<head>
		<link rel='stylesheet' type='text/css' href='static/style1.css'/>
		<script type='text/javascript' src='jquery.js'> </script>
		<script type='text/javascript'>
		$(document).ready(function(){
				ajax_search();
				$('table').addClass('center');

				$('#buildingName').change(function(){
					ajax_search();
					});
			  	function ajax_search(){
				  	var b = $('#buildingName').val();
					var param ={};
					param['buildingName'] = b;
					$.post('getroom.php',param,function(data){
					    $('#divbuildingName').html(data);
					});
				}


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
	</table>
	<input type='submit' name='submit' id='submit' value='QueryRoom'/>
	</form>
	</body>
	</html>";
}
?>
