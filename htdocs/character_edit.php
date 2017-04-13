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
<div id="top">
  <div id="nav"><ul>
	  <li><a href="home.php">Home Page</a></li>
  	<li><a href="team.php">Your Team</a></li>
  	<li><a href="character.php">Characters</a></li>
  	<li><a href="item.php">Items</a></li>
  	<li><a href="logout.php">Extra</a></li>
  	<li><a href="logout.php">Log Out</a></li>
  </ul></div>
  <div class="item_table">
  <form method="post" action="character.php">
		<table style="width:50%">
		    <tr>
			    <th>Hero Name: </th>
          <td><input type = "text" name = "hero"/></td>
	 	    </tr>
        <tr>
          <th>Ability: </th>
          <td><input type = "text" name = "ability"/></td>
        </tr>
        <tr>
          <th>Description: </th>
          <td><input type = "text" name = "description"/></td>
        </tr>
		</table>
    <input type="submit" value="Submit"/>
    </form>
	</div>
  <div class="item_table">
  <form method="post" action="character.php">
		<table style="width:50%">
		    <tr>
			    <th> Add Hero: </th>
          <td><input type = "text" name = "new_hero"/></td>
	 	    </tr>
        <tr>
          <th>Add Ability: </th>
          <td><input type = "text" name = "new_ability"/></td>
        </tr>
        <tr>
          <th>Add Description: </th>
          <td><input type = "text" name = "new_description"/></td>
        </tr>
		</table>
    <input type="submit" value="Submit"/>
    </form>
	</div>

</div>
</body>
</html>

