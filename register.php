<?php
include("essential.php");
;

?>
<html>
	<head>
	<link rel='stylesheet' type='text/css' href='static/style1.css'/>
	</head>
	
        <body >

		<p>
		<table class ='center'>
		<tr>
		<td><img src ='static/logo.gif' alt=''/></td>
		<td style='font-size: 18pt'>ROOM RESERVATION SYSTEM</td>
		</tr>
		</table>
		</p>
           <table class ='center'>
             <tr >
               <td width="1%" style=" margin:2px;padding-right:15px;padding-left:3px">
                        <div class="description">
                                <div  class="bak"/>
                                </div>
                        </div>
               </td>
               <td width="35%">
                <div class="register_form">
                <form action="reg.php" method="POST">
                        <div class="bak"/>
                          <table class="homeText"  id="reg_table">
                          <br />
                                <tr>
                                <td > <strong >Username : </strong></td> <td> <input type="text" value="" name="username" id="username" /> </td>
                                </tr><tr>
                                <td> <strong> Password :</strong> </td> <td><input type="password" value="" name="password" id="password" /></td>
                                </tr><tr>
				<td><strong > Email : </strong> (*@*.iiit.ac.in) </strong></td> <td><input type="text" value="" name="email" id="email" /> </td>
				</tr>
				<!--<tr>
				<td> Captcha :  </td>
				<td>
<div>
<div style="float:left;"><img src="captcha/code.php" id="captcha"> </div>
<div>
<br />
<input type="text" name="Turing" value="" size="10">
[ <a href="#" onclick=" document.getElementById('captcha').src = document.getElementById('captcha').src + '?' + (new Date()).getMilliseconds()">Refresh Image</a> ]  
</div>
</div>
   </td>
</tr> -->
<tr>
			<td></td> <td> <input type="submit" value="Register"  style="margin:0 20px 0 0"/></td> 
			</tr>
		</table>
		<br/>
		</form>
		</div>
		</td>
	    </tr>

	 <table>
	</body>
</html>

