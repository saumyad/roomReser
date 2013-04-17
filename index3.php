<?php
include("essential.php");
if(isset($_SESSION['user'])) header('Location:raw.html');

?>
<html>
	<body >
				<br />
	   <table >
	     <tr >
	       <td width="60%" style=" margin:20px;padding-right:150px;padding-left:30px">
			<div class="description">
				<div  class="bak"/>
				<br />
					<div  class="homeText" id="bakText"><strong> 
					<?php 
						echo 'Room Reservation Portal';
					?>
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

