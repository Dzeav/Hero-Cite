<?php 
   session_destroy();
?>

<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="main.css"/>
<title>Login Page</title>
</head>
<body>
<div class="lounge"><h1>Game Lounge</h1></div>
<h2>Login</h2>
<div class="login">
<form method="post" action = "enter.php">
<table style="width:25%">
    <tr>
	<th>Username:</th>
	<td><input type = "text" name = "lusername"></td>
    </tr>
    <tr>
 	<th>Password:</th>
	<td><input type = "password" name = "lpassword"></td>
    </tr>
    <tr>
	<td></td>
	<td><input type = "submit" value = "Submit"/></td>
    </tr>
</table></form>
</div>

<div class="creation">
<h2>Create Account</h2>
<form method="post" action = "login.php">
<table style="width:25%">
    <tr>
	<th>First Name:</th>
	<td><input type = "text" name = "firstname"></td>
    </tr>
    <tr>
 	<th>Last Name:</th>
	<td><input type = "text" name = "lastname"></td>
    </tr>
    <tr>
	<th>Email Address:</th>
	<td><input type = "text" name = "initialemail"></td>
    </tr>
    <tr>
 	<th>Username:</th>
	<td><input type = "text" name = "username"></td>
    </tr>
    <tr>
	<th>Password:</th>
	<td><input type = "password" name = "initialpassword"></td>
    </tr>
    <tr>
	<td></td>
	<td><input type = "submit" value = "Submit"/></td>
    </tr>
</table></form>
</div>
</body>
</html>
