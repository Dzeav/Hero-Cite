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
    $hero = $_GET['id'];
     
    $stmt = $db->prepare("SELECT * FROM hero WHERE id = ?");
    $stmt->execute([$hero]);
    foreach( $stmt->fetchAll() as $row ){
      $description = $row['description'];
      $name = $row['name'];
      $ability = $row['ability'];
      $id = $row['id'];
      //echo "triggered";
      //echo $id;
      //echo $name;
    }
    //adjust tables
    $adjust_description = $_POST['description'];
    $adjust_ability = $_POST['ability'];
    $adjust_name = $_POST['name'];
    if( isset($_POST['character_submit']) ){
      $hero_delete = $db->prepare("DELETE FROM hero WHERE id = ?");
      $hero_delete->execute([$id]);
    
        header("Location: character.php");
        die();
      
    }else{
      if( !empty(trim($adjust_description)) && !empty(trim($name))
          && !empty(trim($adjust_ability)) ){    
        $adjust_table = $db->prepare("UPDATE hero SET name = ?, ability = ?, description = ? WHERE id = ?"); 
        $adjust_table->execute([ $adjust_name, $adjust_ability, $adjust_description, $id ]);
        //echo "First if triggered"; 
        if( $adjust_table->rowCount() != 0 ){
          header("Location: character.php" ); 
          die();
       }
      }else{
        $insert_table = $db->prepare("INSERT INTO hero( name, ability, description) VALUES( :name, :ability, :description ) ");
        $insert_table->bindParam( ':name', $hero);
        $insert_table->bindParam( ':ability', $adjust_ability);
        $insert_table->bindParam( ':description', $adjust_description );
        if( !empty(trim($adjust_description)) && !empty(trim($adjust_name)) && !empty(trim($adjust_ability)) ){
          $insert_table->execute();    
        }else{
          //echo "Triggered in the next life";
        }
      }
    }
  }catch(PDOException $e){}
  
   //<input type="text" name="location" size="200"value="<?=$description"/>
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
    <form method="post" action="form_edit.php" id="character_form">
      What's the name of the hero you want to adjust?<br/>
      <textarea rows="1" cols="15" name="name"><?=$name?></textarea><br/>
      What's the ability of this person?<br/>
      <textarea rows="3" cols="25" name="ability"><?=$ability?></textarea><br/>
      What's the description of this person?<br/>
      <textarea rows="6" cols="50" name="description"><?=$description?></textarea/><br/>
      <input type="submit" name="submit" value="Save"/>
      <button type="submit" form="character_form" name="character_submit">Delete</button>
    </form>
	</div>
</div>
</body>
</html>

