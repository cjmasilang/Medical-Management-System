<?php

session_start();
	if(!isset($_SESSION['doctorID'])){
    header ("Location: Login.php");
		}
  include_once 'Header.php';
  include_once 'config/database.php';
  include_once 'classes/patient.php';
  include_once 'classes/nationality.php';
  include_once 'classes/department.php';
  include_once 'classes/specialization.php';

  $database = new Database();
  $db = $database -> getConnection();
  $nationality = new Nationality($db);
  $stmtNationality = $nationality->readAllNationality();

  $month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
  $civilStatus = ["Single","Married","Widowed"];

if($_POST){
  $database = new Database();
  $db = $database->getConnection();

  $patient = new Patient($db);

  $month=$_POST['month'];
  $year=$_POST['year'];
  $day=$_POST['day'];
  $dateOfBirth="$year/$month/$day";

  $patient->firstName = $_POST['firstName'];
  $patient->middleName = $_POST['middleName'];
  $patient->lastName = $_POST['lastName'];
  $patient->suffix = $_POST['suffix'];
  $patient->birthDate = $dateOfBirth;
  $patient->birthPlace = $_POST['birthPlace'];
  $patient->gender = $_POST['gender'];
  $patient->address = $_POST['address'];
  $patient->nationality = $_POST['nationality'];
  $patient->civilStatus = $_POST['civilStatus'];
  $patient->emailAdd = $_POST['emailAdd'];
  $patient->mobileNum = $_POST['mobileNum'];
  $patient->phoneNum = $_POST['phoneNum'];
  $patient->patientID = $_POST['patientID'];


  if($patient->createPatient()){
  	echo "Successful";
  	header("Location: index1.php");
}
  else
  	echo "Duplicate Username<br>";
	
}
 ?>

 <html>
 	<header>
 		<title>Patient Registration</title>
 	</header>
 	<body>
 		<form action='patientAdd.php' method='post'>
	 		<table width = "100%" height = "50%">
	 		<tr>
			<td><label><b>First Name </b></label></td>
			<td><label><b>Middle Name </b></label></td>
			<td><label><b>Last Name </b></label></td>
			<td><label><b> surffix </b></label></td>
			</tr>
			<tr>
	 		<td><input type="text" class="form-control col-md-11" name="firstName" ></td>
	 		<td><input type="text" class="form-control col-md-11" name="middleName"></td>
	 		<td><input type="text" class="form-control col-md-11" name="lastName"></td>
	 		<td><input type="text" class="form-control col-md-11" name="suffix"></td>
	 		</tr>
			
			<tr>
			<td><label><b>Date of Birth</b></label></td>
			<td><label><b>Place of Birth</b></label></td>
			<td></td>
			<td><label><b>Gender</b></label></td>
			</tr>
		 		
			<tr>
			<td>
		 			<div class="form-row">
							<select name="month" class = "form-control col-lg-4" >
						<?php
							foreach ($month as $month){
							echo "<option value = ".($i+1).">".$month."</option>";
							}
							?>
							</select>
					 	

					
					 		<select name="day" class="form-control col-lg-3 ">
								<?php
					 				for($i=1;$i<32;$i++){
					 					echo "<option value='".$i."'>".$i."</option>";
					 				}
					 			?>
							</select>

						 	
					 		<select name="year" class="form-control col-lg-4">
							<?php
					 			for($i=date("Y");$i>date("Y")-70;$i--){
					 				echo "<option value='".$i."'>".$i."</option>";
					 			}
					 		?>
							</select>
					</div>
			</td>
			<td>
				<input type="text" class="form-control col-md-11" name="birthPlace" >
			</td>
	 		
			<td>
			</td>
			
			<td>
	 				<select name="gender" class="form-control col-md-11">
	 					<option>Male</option>
	 					<option>Female</option>
	 				</select>
	 		</td>
	
			<tr>
			<td><label><b>Present Address</b></label></td>
			<td><label><b>Nationality</b></label></td>
			<td><label><b>Civil Status</b></label></td>
			</tr>
	  		
			<tr>
			<td>
	 				<input type="text" class="form-control col-md-11" name="address" >
			</td>
			<td>
	 				<select name="nationality" class="form-control col-md-11	">
						<?php
							while($row1 = $stmtNationality->fetch(PDO::FETCH_ASSOC)){
								extract($row1);
							    echo "<option>".$row1['nationality']."</option>";
							}
						?>
					</select>
	 		</td>

	 		<td>
	 				<select name="civilStatus" class="form-control col-md-11">
						<?php
							for($i=0;$i<count($civilStatus);$i++){
								echo "<option>".$civilStatus[$i]."</option>";
							}
	 					?>
						</select>
	 				</select>
			</td>
			</tr>
	 		
			<tr>
			<td><label><b>Email Address</b></label></td>
			<td><label><b>Mobile Number</b></label></td>
			<td><label><b>Telephone Number</b></label></td>
			<td><label><b>Patient ID</b></label></td>
			</tr>
			
	  		<tr>	
	 				<td>
	 				<input type="text" class="form-control col-md-11" name="emailAdd" >
					</td>

					<td>
	 				<input type="text" class="form-control col-md-11" name="mobileNum" >
					</td>

					<td>
	 				<input type="text" class="form-control col-md-11" name="phoneNum" >
					</td>
					
					<td>
	 				<input type="text" class="form-control col-md-11" name="patientID" placeholder = "Username">
					</td>
			</tr>	
			<tr>
			<td>
			&nbsp;
			</td>
			</tr>
			
			<tr>
			<td colspan = "4">
	 		
	 			<button  type = "button" style = "background-color:#3498DB;color : white; padding : 6px 16px; margin :6px 0 ; border :none ; cursor : pointer; float : right; margin-right :1%; " >Cancel</button>
				<button type = "submit" name="save" style = "background-color:#3498DB;color : white; padding : 6px 15px; margin :6px 0 ; border :none ; cursor : pointer; float : right; margin-right :1%;">Submit</button>
	 		
			</td>
			</tr>
			</table>
 		</form>