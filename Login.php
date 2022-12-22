<?php

  include_once 'config/database.php';
  include_once 'classes/doctor.php';

session_start();
	if($_POST){
		$database = new Database();
  		$db = $database -> getConnection();

  		$doctor = new Doctor($db);

  		$doctor->doctorID = $_POST['doctorID'];
  		$doctor->password = $_POST['password'];

  		if($doctor->login()){
  			header("Location: index.php");
  		}
  		else{
  			echo "Incorrect ID or password";
  		}
	}
?>

<html>
<head>
<link rel="stylesheet" href="assets/bootstrap/4.0.0/css/bootstrap.min.css">
  	<script src="assets/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class = "containers">
<h1><center>Log In</center></h1>
<form action='Login.php' method='post'>
	 <div class="container">
	 	<div>
	 		<label for="doctorID">Doctor ID</label>
	 		<input type="text" class="form-control" name="doctorID">
	 	</div>
	 	<div>
	 		<label for="password">password</label>
	 		<input type="password" class="form-control" name="password">
	 	</div>
	 	<br/>
	 	<button type = "submit" name="login" style = "background-color:#3498DB;color : white; padding : 6px 15px; margin :6px 0 ; border :none ; cursor : pointer; float : right; margin-right :1%;">Submit</button>
	</form> 
	</div>
</body>
</html>