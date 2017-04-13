<?php 
  include 'utils.php'; 

  $servername = "localhost";
  $username = "daw1002_heros";
  $password = "daw1002_heros";
  $dbname = "daw1002_heros";
  try{
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
    /*foreach( $stmt->fetchAll() as $hero ){
      $initialArr[i][0] = $hero['name'];
      $initialArr[i][1] = $hero['ability'];
    }*/
    /*
    foreach( $initialArr as $hero ){
      $output = '<div class="hero">
                  <a href = "individual_character.php">
                    <div style= backgroud-image: url("'.$hero[0].'.jpg");>
                      <h4>'.$hero[0].'</h4>
                      <p>'.$hero[1].'</p>
                    </div>
                  </a>
                </div>';
    }*/
    $add_stmt = $db->prepare("INSERT INTO hero( name, ability, description ) VALUES ( :name, :ability, :description )");
    $add_stmt->bindParam(':name', $new_hero );    
    $add_stmt->bindParam(':ability', $new_ability );    
    $add_stmt->bindParam(':description', $new_description ); 
    $new_hero = "".$_POST['new_hero']."";   
    $new_ability = "".$_POST['new_ability']."";
    $new_description = "".$_POST['new_description']."";

    if( !empty(trim($new_hero)) && !empty(trim($new_ability)) &&
        !empty(trim($new_description))){
    $add_stmt->execute();
  }
    echo $new_hero;
    echo $new_ability;
    echo $new_description;

    $name = $_POST['hero'] ?: $_POST['new_hero'];
    $ability = $_POST['ability'] ?: $_POST['new_ability'];
    $description = $_POST['description'] ?: $_POST['new_description'];
    $update = "UPDATE hero SET  ability = ?, description = ? WHERE name = ?";
    $stmt = $db->prepare($update)->execute([ $ability, $description, $name]);
  
    $select = "SELECT * FROM hero";
    $newstmt = $db->prepare($select);
    $newstmt->execute();

    foreach($newstmt->fetchAll() as $row){
      $output = $output.'<tr><td><a class="hype"href="/form_edit.php?id='.$row['id'].'">Edit</a></td><td>'.$row['name'].'</td><td>'.$row['ability'].'</td></tr>';
        //$output = $output.'<a href="/form_edit.php?name=Thor">Edit</a>';

      //$output = $output.'<tr><td><form method="post" action="individual_character.php"><input type="submit" style="width:100%" name="zach" value="Edit"/></form></td><td>'.$row['name'].'</td><td>'.$row['ability'].'</td></tr>';
    }
  }catch(PDOException $e){echo "Error " . $e->getMessage();} 
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
  </div>
</div>
</body>
</html>


