<?php
include("essential.php");
if(isset($_SESSION['user'])){
 header('Location:raw.php');
}
?>
<html>
	<head>
	<link rel='stylesheet' type='text/css' href='static/style1.css'/>
	<body >
	<p>
	<table class = 'center'>
	<tr>
	<td><img src='static/logo.gif' alt=''></td>
	<td style = 'font-size: 18pt'>ROOM RESERVATION SYSTEM</td>
	</tr>
	</table>
	</p>
				

	   <table  class = 'center'>
	     <tr >
	       <td width="1%" style=" margin:2px;padding-right:15px;padding-left:3px">
			<div class="description">
				<div  class="bak"/>
				<br />
					<div  class="homeText" id="bakText"><strong> 
					 </strong> 
					</div>
				</div>
			</div>
	       </td>
	       <td width="25%" style="position:relative;right:12px;top:0px">
		<div class="register_form">
		<form action="log.php" method="POST">
			<div class="bak"/>
			<br />  
			<table class="homeText"  id="reg_table">
				<tr>
				<td > <strong >Username : </strong></td> <td> <input type="text" value="" name="username" id="username" /> </td>
				</tr><tr> 
				<td> <strong> Password :</strong> </td> <td><input type="password" value="" name="password" id="password" /></td>
				</tr><tr>
				<td></td>
				<td>  <input type="submit" value="Login" style="margin:0 20px 0 0"/>  <a href="./register.php">Register</a> </td>
				</tr>
		          </table>
			  <br />
			</div>
		</form>
		</div>
		</td>
	    </tr>
	 <table>

	</body>
</html>

