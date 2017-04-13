<?php
  include 'utils.php'; 
  $servername = "localhost";
  $username = "daw1002_heros";
  $password = "daw1002_heros";
  $dbname = "daw1002_heros";
  try{
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Get get hero id from hero table
    $hero_name = $_POST['heros'];
    $hero_id_select = $db->prepare("SELECT id FROM hero WHERE name = :heroname");
    $hero_id_select->bindParam(':heroname', $hero_name, PDO::PARAM_STR);
    $hero_id_select->execute([]);
    foreach( $hero_id_select->fetchAll() as $row ){
      $hero_id = $row['id'];
    }
    //Get item id from table
    $team_id_select = $db->prepare("SELECT id FROM team WHERE creator_user = ?");
    $team_id_select->execute([$_SESSION['userid']]);
    foreach( $team_id_select->fetchAll() as $row ){
      $team_id = $row['id'];
    }
    
    if( !empty(trim($_POST['heros'])) ){
      $team_item_delete = $db->prepare("DELETE FROM team_hero WHERE team = ?, hero = ?");
      $team_item_delete->execute([$_SESSION['userid'], $hero_id]);
    }
    }
  }catch(PDOException $e){ echo $e->getMessage();}
  header("Location: team.php");
  die(); 
    
?>

