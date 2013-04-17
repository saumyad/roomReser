<?php
//session_start();

include("essential.php");
if(isset($_POST['submit']))
{

}
else
{
	echo 
		"<html>
		<head>
		</head>
		<body>
		<form name='add_acc' method = 'POST' action = '". $PHP_SELF. "'>
		<table class = 'center'>
		<tr>
		<td>Name:</td>
		<td><input type = 'text' name = 'name' id = 'name'/></td>
		</tr>
		<tr>
		<td>Credit Limit:</td>
		<td><input type = 'text' name = 'c_lim' id = 'c_lim' value = '0.00'/></td>
		</tr>
		<tr>
		<td>Debit Limit</td>
		<td><input type = 'text' name = 'd_lim' id = 'd_lim' value = '0.00'/></td>
		</tr>
		<td>Balance</td>
		<td><input type = 'text' name = 'd_lim' id = 'balance' value = '0.00'/></td>
		</tr>
		<tr>
		<td></td>
		<td><input type = 'submit' name = 'submit' value = 'Add Account'/></td>
		</tr>
		</body>
		</html>";
}






