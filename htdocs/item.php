<?php
  include 'utils.php';
  
  $servername = "localhost";
  $username = "daw1002_heros";
  $password = "daw1002_heros";
  $dbname = "daw1002_heros";
  try{
  $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password );
  //set the PDO error mode to exception
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //variables for added data 
  $add_stmt = $db->prepare( "INSERT INTO item( name, ability, description, appearance, initial_location  ) VALUES( :name, :ability, :description, :appearance, :initial_location  )" );
  $add_stmt->bindParam( ':name', $new_item ); 
  $add_stmt->bindParam( ':ability', $new_ability );
  $add_stmt->bindParam( ':description', $new_description ); 
  $add_stmt->bindParam( ':initial_location', $new_location ); 
  $add_stmt->bindParam( ':appearance', $new_appearance );

  $new_item = "".$_POST['new_item']."";
  $new_ability = "".$_POST['new_ability']."";
  $new_description = "".$_POST['new_description']."";
  $new_location = "".$_POST['new_location']."";
  $new_appearance = "".$_POST['new_appearance']."";
  if( !empty(trim($new_item)) && !empty(trim($new_ability)) &&
      !empty(trim($new_location)) && !empty(trim($new_description)) &&
      !empty(trim($new_appearance))){
    $add_stmt->execute();
  }
}catch(PDOException $e){echo "Error : " . $e->getMessage();}
//variables for updated data and output
try{
  $gem = $_POST['gem'] ?: $_POST['new_item'];
  $ability = $_POST['ability'] ?: $_POST['new_ability'];
  $description = $_POST['description'] ?: $_POST['new_description'];
  $location = $_POST['location'] ?: $_POST['new_location'];
  $appearance = $_POST['appearance'] ?: $_POST['new_appearance'];
  
  $update = "UPDATE item SET ability = ?, initial_location = ?, description = ?, appearance = ? WHERE name = ?";    
  
  $stmt = $db->prepare($update)->execute([$ability, $location, $description, $appearance, $gem]);
  
	$select = "SELECT * FROM item";
	$newstmt = $db->prepare($select);
  $newstmt->execute();
	foreach( $newstmt->fetchAll() as $row ){
		$output = $output.'<tr><td><form method="post" action="detailed.php"><input type="submit" style="width:100%" name="zach" value="'.$row['name'].'"/></form></td><td>'.$row['name'].'</td><td>'.$row['ability'].'</td><td>'.$row['initial_location'].'</td></tr>';
	}
}catch(PDOException $e){echo "Error2 " . $e->getMessage();}
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
	  <table><?php echo $output ?></table>
    <form method="post" action="edit.php">
      <input type="submit" name="Edit" value="Edit"/>
    </form>
	</div>
</div>
</body>
</html>

