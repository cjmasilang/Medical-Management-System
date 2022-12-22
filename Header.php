<?php
ob_start();
include_once 'classes/doctor.php';
include_once 'config/database.php';
  $database = new Database();
  $db = $database -> getConnection();
  $doctor = new Doctor($db);
  $stmt = $doctor->readAllDoctor();
?>

<!DOCTYPE html> 

<html lang = "En">
  <head>
    <title>Medical Information System</title>
  	<meta charset="utf-8">
  	<meta name="viewpoint" content="width=device-width, initial-scale=1">

  	<link rel="stylesheet" href="assets/bootstrap/4.0.0/css/bootstrap.min.css">
  	<script src="assets/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  	<script src="assets/jquery/3.2.1/jquery-3.2.1.slim.min.js"></script>
  	<script src="assets/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="assets/jquery/3.3.1/jquery.min.js"></script>

  	<meta name="viewport" content="width=device-width, initial-scale=1">
  </head>



  <body>
    
    	<div class = "containers">
    		 <nav class="navbar navbar-expand-lg navbar navbar-dark bg-primary">
    		<a class = "navbar-brand" href='index.php'>Medical Information System </a>
    		<div class="col-lg-1"></div>

            <div class="col-lg-1">
              <a class = "navbar-brand" href='index.php'>Doctor</a>
            </div>
    	     
            <div class="col-lg-1">
              <a class = "navbar-brand" href='index1.php'>Patient</a>
            </div>
    	
            <div class="col-lg-5">
              <a class = "navbar-brand" href='#'>Consultation</a>
            </div>
			<div class = "col-lg-1">
				<?php ?>
			</div>
			   <div class="col-lg-1">
              <a class = "navbar-brand" href='log-out.php' name = "log-out">Log out</a>
		</nav>
		</div>
 



  </body>
</html>
