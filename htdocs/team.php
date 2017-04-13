<?php
  include 'utils.php';
  $servername = "localhost";
  $username = "daw1002_heros";
  $password = "daw1002_heros";
  $dbname = "daw1002_heros";
  try{
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $select = "SELECT * FROM team";
    $newstmt = $db->prepare($select);
    $newstmt->execute();
    $output = "hold it right there";

    $add_team = $db->prepare("INSERT INTO team(creator_user, name, location) VALUES( :creator_user, :name, :location )");
    $add_team->bindParam( ':creator_user', $creator_user );
    $add_team->bindParam( ':name', $team_name );
    $add_team->bindParam( ':location', $team_location );
    $creator_user = $_SESSION['userid'];
    $team_name = $_POST['team_name'];
    $team_location = $_POST['team_location'];
    if( !empty(trim($creator_user)) && !empty(trim($team_name)) && 
        !empty(trim($team_location)) ){
        $add_team->execute();
    }

    $team_user_id = $_SESSION['userid'] + 1;
    foreach( $newstmt->fetchAll() as $row ){
      $user = $_SESSION['userid'];
      if( $row['creator_user'] == $_SESSION['userid'] ){
         $teamname = $row['name'];
         $location = $row['location'];
         $output = '<form method="post" action="team.php"><div><label>Add Hero: </label><input type="text" name="add_hero"/><></div></form>';  
         break; 
      }
    }
    //finding the hero id
    $hero_name = $_POST['heros'];
    $hero_id_select = $db->prepare("SELECT id FROM hero WHERE name = :heroname");
    $hero_id_select->bindParam(':heroname', $hero_name, PDO::PARAM_STR);
    $hero_id_select->execute();
    foreach( $hero_id_select->fetchAll() as $row ){
      $hero_id = $row['id'];
    }
    //finding team id
    $team_id_select = $db->prepare("SELECT id FROM team WHERE creator_user = ?");
    $team_id_select->execute([$_SESSION['userid']]);
    foreach( $team_id_select->fetchAll() as $row ){
      $team_id = $row['id'];
  //    echo "team_id_select triggered ".$team_id ;
    }
    
    //finding item id
    $item_id_select = $db->prepare("SELECT id FROM item WHERE name = ?");
    $item_id_select->execute([$_POST['items']]);
    foreach( $item_id_select->fetchAll() as $row ){
      $item_id = $row['id'];
//      echo "item_id_select triggered ".$team_id ;
    }
    //time to delete 
    if( isset($_POST['team_submit']) ){
      $hero_delete = $db->prepare("DELETE FROM team_hero WHERE hero = ? and team = ?");
      $hero_delete->execute([$hero_id, $_SESSION['userid']]);

      $item_delete = $db->prepare("DELETE FROM team_item WHERE item = ? and team = ?");
      $item_delete->execute([$item_id, $team_user_id]);
    }else{
      //inserting into the team_hero table
      $team_hero_insert = $db->prepare("INSERT INTO team_hero( team, hero ) VALUES ( :team, :hero ) ");
      $team_hero_insert->bindParam( ':team', $user_id );
      $team_hero_insert->bindParam( ':hero', $hero_id );
      $user_id = $_SESSION['userid'];
      if( !empty(trim($hero_id)) && !empty(trim($team_id)) ){
        try{
          $team_hero_insert->execute();
        }catch(PDOException $e){}
      }
      //inserting into the team_item table
      $team_item_insert = $db->prepare("INSERT INTO team_item( team, item, hero ) VALUES ( :team, :item, :hero ) ");
      $team_item_insert->bindParam( ':team', $team_id );
      $team_item_insert->bindParam( ':hero', $hero_id );
      $team_item_insert->bindParam( ':item', $item_id );
      if( !empty(trim($team_id)) 
          && !empty(trim($item_id))){
        try{
         $team_item_insert->execute();
       }catch(PDOException $e){}
        //echo "ITEM INSERTED";
      //  echo $hero_id.$item_id.$team_id;
      }
  }
    //creating select drop down
    $hero_list = "SELECT name FROM hero";
    $hero_stmt = $db->prepare($hero_list);
    $hero_stmt->execute();
    foreach( $hero_stmt->fetchAll() as $row ){
      $option .= '<option value="'.$row['name'].'">'.$row['name'].'</option>';
    }  
    $drop_select = '<select name="heros" size="4">'.$option.'</select><br/>'; 

  //item drop down 
    $item_list = "SELECT name FROM item";
    $item_stmt = $db->prepare($item_list);
    $item_stmt->execute();
    foreach( $item_stmt->fetchAll() as $row ){
      $option_item = $option_item.'<option value="'.$row['name'].'">'.$row['name'].'</option>';
//id where value is*******************
    }  
    $drop_select_item = '<select name="items" size="4">'.$option_item.'</select><br/>'; 
    
    //gimme dah rostah mahn
    $roster_list = $db->prepare("SELECT name, ability FROM hero JOIN team_hero ON hero.id = team_hero.hero WHERE team_hero.team = ?"); 
    $roster_list->execute([$_SESSION['userid']]);
    //$roster = '<ul>';
    foreach( $roster_list as $row ){
        $roster .= '<p><strong>'.$row['name'].'</strong>'.$row['ability'].'</p>';
    }
  //checking if items are on the team/belong to any heros
    $item_list = $db->prepare("SELECT name FROM item JOIN team_item ON item.id = team_item.item WHERE team_item.team = (SELECT id FROM team WHERE creator_user = ?)");
    $item_list->execute([$_SESSION['userid']]);
    foreach( $item_list as $row ){
      $item_name .= '<p>'.$row['name'].'</p>';
    }
    //checking if user has a team
    $team_check = $db->prepare("SELECT creator_user FROM team WHERE creator_user = ?");
    $team_check->execute([$_SESSION['userid']]);
  }catch(PDOException $e){ echo "Error: " . $e->getMessage();}
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
  <div class="roster_set"> 
    <h3>Roster</h3>
    <p><?php echo $roster; ?></p>
    <h3>Inventory</h3>
    <p><?php echo $item_name; ?></p>
    <form method="post" action="team.php" id="team_form">
      <p><?php echo $drop_select ?></p>
      <p><?php echo $drop_select_item ?></p>
      <input type="submit" value="Add"/>
      <button type="submit" form="team_form" name="team_submit">Delete</button>
    </form>
  </div>
</div>
</body>
</html>

