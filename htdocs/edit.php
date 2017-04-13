<?php
  include 'utils.php';	
?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="main.css"/>
	<title>Home Page</title>
</head>
<body>
<div class="lounge"><h1>Comic Lounge</h1></div>

<div>
	<div><ul>
		<li><a href="home.php">Home Page</a></li>
		<li><a href="team.php">Your Team</a></li>
		<li><a href="character.php">Characters</a></li>
		<li><a href="item.php">Items</a></li>
		<li><a href="logout.php">Extra</a></li>
		<li><a href="logout.php">Log Out</a></li>
	</ul></div>
	<div id="edit">
  <form method="post" action="item.php">
		<table style="width:50%">
		    <tr>
			    <th>Item Name: </th>
          <td><input type = "text" name = "gem"/></td>
	 	    </tr>
        <tr>
          <th>Ability: </th>
          <td><input type = "text" name = "ability"/></td>
        </tr>
        <tr>
          <th>Description: </th>
          <td><input type = "text" name = "description"/></td>
        </tr>
        <tr>
          <th>Appearance: </th>
          <td><input type = "text" name = "appearance"/></td>
        </tr>
        <tr>
          <th>Location: </th>
          <td><input type = "text" name = "location"/></td>
        </tr>
		</table>
    <input type="submit" value="Submit"/>
    </form>
	</div>
  

<div id="edit">
  <form method="post" action="item.php">
		<table style="width:50%">
		    <tr>
			    <th> Add Item: </th>
          <td><input type = "text" name = "new_item"/></td>
	 	    </tr>
        <tr>
          <th>Add Ability: </th>
          <td><input type = "text" name = "new_ability"/></td>
        </tr>
        <tr>
          <th>Add Description: </th>
          <td><input type = "text" name = "new_description"/></td>
        </tr>
         <tr>
          <th>Appearance: </th>
          <td><input type = "text" name = "new_appearance"/></td>
        </tr>

        <tr>
          <th>Add Location </th>
          <td><input type = "text" name = "new_location"/></td>
        </tr>
		</table>
    <input type="submit" value="Submit"/>
    </form>
	</div>
</div>
</body>
</html>

