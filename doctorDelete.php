<?php
  include_once 'config/database.php';
  include_once 'classes/doctor.php';  

  if($_POST){
    $database = new Database();
    $db = $database -> getConnection();

    $doctor = new Doctor($db);

    $doctor->doctorID = $_POST['doctorID'];

    if($doctor->deleteDoc()){
    	echo "Object Deleted";
    }
    else{
    	echo "Unable to delete object";
    }
  }
?>
