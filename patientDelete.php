<?php
  include_once 'config/database.php';
  include_once 'classes/patient.php';  

  if($_POST){
    $database = new Database();
    $db = $database -> getConnection();

    $patient = new Patient($db);

    $patient->patientID = $_POST['patientID'];

    if($patient->deletePat()){
    	echo "Object Deleted";
    }else{
    	echo "Unable to delete object";
    }
  }
?>
