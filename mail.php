<?php
// MAILING FORM
include("essential.php");
check_login();

$query = " select email from User where name = '".$_SESSION['user']."';";
$result = execute($query);

//echo  $_GET['to_dec'];
$add = mysql_fetch_array($result);
//echo $add[0];
if($_GET['to_dec'])
{
	$query2 = " select email from User where name = '".$_GET['to_dec']."';";
	$result2 = execute($query2);
	$T = mysql_fetch_array($result2);
	$TO = $T[0];
	}
else
{
	$TO = "";
}

echo " <html>
	<head>
		<link type='text/css' rel='stylesheet' href='static/slickblue/style.css'/>
		<script type = 'text/javascript'>
			function validate_form()
			{
				var to_addr = document.forms['mail']['to'].value;
				var sub = document.forms['mail']['subject'].value;
				var msg = document.forms['mail']['message'].value;
				var ret_val = true;
				if(to_addr == null)
				{
					alert('No sending address filled');
					return false;
				}
				else 
				{
					var atpos = to_addr.indexOf('@');
					var dotpos = to_addr.lastIndexOf('.');
					if(atpos <1 || dotpos < atpos+2 || dotpos+2 >to_addr.length)
					{
						alert('Email address not valid');
						return false;
					}
				}
				if(!sub)
				{
					if(!confirm('send message withoout a subject?'))
					{
						return false;
					}
				}
				if(!msg)
				{
					if(!confirm('send message without any text?'))
					{
						return false;
					}
				}
				return true;
			}

	</script>				
							

				
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
                        <li><a href='queryroom4.php' > QUERY Room </a></li>
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
                <h2 class='center'> Mail  </h2>
                ";



	if($_GET['msg'])
	{
		echo "<p class = 'center' style =background-color:yellow>".$_GET['msg']."</p>";

	}  
echo "		 
	<form name = 'mail' , method = 'POST' action = 'mail_send.php' onsubmit = 'return validate_form()' >	
	<table class = 'center' >
	<tr>
	<td> To:</td>
	<td><input type = 'text' name = 'to' id ='to' value = '".$TO."' /></td>

	</tr>
	<tr>
	<td>Subject: </td>
	<td><input type = 'text' name = 'subject' id = 'subject'/></td> 
	</tr>
	<tr>
	<td>From:</td>
	<td><input type = 'text' name = 'from' id = 'from' value = '".$add[0]."' readonly ='readonly'/>
	<tr>
	<td></td>
	<td><textarea name = 'message' id = 'message' rows = 20 cols = 60></textarea>
	</td>
	</tr>
	<tr>
	<td></td>
	<td>
	<input type='submit' name='send' id='send' class='center' value='send'/>
	</table>
	</form>
	</div>
	<div id = 'content_bottom'></div>
	<div id = 'footer><h3>Developed by: Bond With Bondas</h3></div>

	</body>
	</html>";
?>

