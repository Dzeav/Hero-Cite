<?php
	if (empty(trim($_POST['firstname'])) || empty(trim($_POST['lastname'] ))
           || empty(trim($_POST['initialemail']) ) || empty(trim($_POST['username']) ) ||
	   empty(trim($_POST['initialpassword'] ) ) ) {
      	   echo "<p>You have not entered all the required details.<br />
                 Please go back and try again.</p>";
       exit;
    }
	
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$emailaddress = $_POST['initialemail'];
	$username = $_POST['username'];
	$password = $_POST['initialpassword'];


	@$db = new mysqli( 'localhost', 'daw1002_heros', 'daw1002_heros', 'daw1002_heros' );
	if( mysqli_connect_errno() ){
		echo "<p>Error: could not connect to the database. <br/>
			 Please try again later.</p>";
		exit;
	}
	//----------Checking if username/email is already in use------------
	$user_username = "SELECT username FROM user WHERE username = ?;";
	$stmt = $db->prepare($user_username);
	$stmt->bind_param('s', $username);
	$stmt->execute();

	while($stmt->fetch()){
		$stmt->store_result();
	}
	if($stmt->num_rows!=0)
	{
		echo "Username already in use! Try another";
		exit;
	}
	$user_email = "SELECT email FROM user WHERE email = ?;";
	$stmt = $db->prepare($user_email);
	$stmt->bind_param('s', $emailaddress);
	$stmt->execute();

	while($stmt->fetch()){
		$stmt->store_result();
	}
	if($stmt->num_rows!=0)
	{
		echo "Email already in use! Try another";
		exit;
	}
  $hash_pass = password_hash( $password, PASSWORD_BCRYPT  );
	//----------------------Inserting data into table --------------------------
	$query = " INSERT INTO user( username, password, firstname, lastname, email ) 
		   VALUES ( ?, ?, ?, ?, ? )";
	$stmt = $db->prepare($query);//prepares SQL query, reduces parsing time 	
	$stmt->bind_param( 'sssss', $username, $hash_pass, $firstname, $lastname, $emailaddress);
		//bound parameters minimize bandwidth to the server
	$stmt->execute();
	if( !empty($db->error_list) ){
		foreach($db->error_list as $error) {
			echo $error['error'];
		}
	}
	//print_r($db->error_list);

	if( $stmt->affected_rows > 0 ){
		echo "<p>Accout created!</p>";
	}else{
		echo "<p>Error: item(s) not added properly</p>";
		print_r($_POST );
	}	

	$db->close();
?>
