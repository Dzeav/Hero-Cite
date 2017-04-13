<?php
  session_destroy();	
	if( empty(trim($_POST['lusername'])) || 
	    empty(trim($_POST['lpassword'])) ){
		echo " <p>You have not entered all the required details.
		       <br/> Please go back and try again</p>";
		exit;
	}
	session_start();
	$lusername = $_POST['lusername'];
	$lpassword = $_POST['lpassword'];

/*	@$db = new mysqli( 'localhost', 'daw1002_heros', 'daw1002_heros', 'daw1002_heros' );
	if( mysqli_connect_errno() ){
		echo"<p>Error: could not connect to database. <br/>
		        Please try again later</p>";
		exit;
	}*/
  $servername = "localhost";
  $username = "daw1002_heros";
  $password = "daw1002_heros";
  $dbname = "daw1002_heros";

  $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//---------------Checking credentials---------------
	$user_username = "SELECT username FROM user WHERE username = :username";
	$stmt = $db->prepare($user_username);
	$stmt->bindParam(':username', $bound_username);
  $bound_username = "".$_POST['lusername']."";
	$stmt->execute();

	//while($stmt->fetch()){$stmt->store_result();}
	if($stmt->rowCount() == 0 || $stmt->rowCount() > 1 ){
		echo "Invalid username. Please try again ";
    echo $bound_username;
		exit;
	}
	$user_password = "SELECT password, id FROM user WHERE username = :username";
	$stmt = $db->prepare($user_password);
	$stmt->bindParam(':username', $boundUsername);
  $boundUsername = "".$_POST['lusername']."";
  
	//$stmt->bind_result($rpassword);
  //$stmt->bind_result($user_id);
	$stmt->execute();
  foreach( $stmt->fetchAll() as $row ){
    $rpassword = $row['password'];
    $user_id = $row['id'];
  }  
  
	//while($stmt->fetch()){$stmt->store_result();}
	if( !password_verify( $lpassword, $rpassword ) ){
		echo "This password is incorrect ";
    echo $password;
		die();
	}else{
		echo $user_password;
		echo $_POST['lpassword'];
		echo $rpassword;
	}
  
	$_SESSION['userid'] = $user_id;
	header("Location: home.php");
	die();
?>
