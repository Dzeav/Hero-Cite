<?php
  include 'utils.php';


$servername = "localhost";
  $username = "daw1002_heros";
  $password = "daw1002_heros";
  $dbname = "daw1002_heros";
  try{
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $item = $_POST['zach'];
   
    $stmt = $db->prepare("SELECT * FROM hero WHERE name = ?");
    $stmt->execute([$item]);

    foreach( $stmt->fetchAll() as $row ){
      $description = $row['description'];
      $name = '<strong>'.$row['name'].'</strong>';
      $ability = $row['ability'];
    }
  }catch(PDOException $e){ echo $e->getMessage();}
    
    
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
      <div><p><?php echo $name  ?> <?php echo $description ?></p></div>
      <div><p><?php echo $appearance  ?></p></div>
  </div>
</div>
</body>
</html>

