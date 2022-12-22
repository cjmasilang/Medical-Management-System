<?php

session_start();
	if(!isset($_SESSION['doctorID'])){
    header ("Location: Login.php");
		}
  include_once 'Header.php';
  include_once 'config/database.php';
  include_once 'classes/patient.php';  
  include_once 'classes/nationality.php';

  $database = new Database();
  $db = $database -> getConnection();

  $nationality = new Nationality($db);
  $stmtNationality = $nationality->readAllNationality();


  $patient = new Patient($db);

  $patientID = isset($_GET['patientID']) ? $_GET['patientID'] : die("ERROR: Missing ID");
  $patient->patientID=$patientID;
  
  $patient->readOnePatient();
  $patient->readDate();

  $month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
  $civilStatus = ["Single","Married","Widowed"];


if(isset($_POST['update'])){
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

	if($patient->updatePatient()){
		header("Location: index1.php");
	}
	else{
		echo "Fail to update";
	}
}
else if(isset($_POST['cancel'])){
	header("Location: index1.php");
}
?>

 <html>
 	<header>
 		<title>Patient Registration</title>
 	</header>
 	<body>
 		<form action='patientEdit.php?patientID=<?php echo $patient->patientID; ?>' method='post'>
	 		<table width = "100%" height = "50%">
	 		
			<tr>
			<td><label><b>First Name </b></label></td>
			<td><label><b>Middle Name </b></label></td>
			<td><label><b>Last Name </b></label></td>
			<td><label><b> surfix </b></label></td>
			</tr>
	 			
			<tr>
				<td>
	 				<input type="text" class="form-control col-md-11" name="firstName" value="<?php echo $patient->firstName; ?>">
	 			</td>
				<td>
	 				<input type="text" class="form-control col-md-11" name="middleName" value="<?php echo $patient->middleName; ?>">
				</td>
				<td>
	 				<input type="text" class="form-control col-md-11" name="lastName" value="<?php echo $patient->lastName; ?>">
				</td>
				<td>
	 				<input type="text" class="form-control col-md-11" name="suffix"  value="<?php echo $patient->suffix; ?>">
				</td>
			</tr>
	 		<tr>
	<td><label><b>Date of Birth</b></label></td>
	<td><label><b>Place of Birth</b></label></td>
	<td></td>
	<td><label><b>Gender</b></label></td>
		</tr>

	 	<td>
		 			<div class="form-row">
		 				
							<select class="form-control col-lg-4" name="month">
								<?php
									for($i=0;$i<count($month);$i++){
										if ($i+1 == $patient->month){
											echo "<option value = ".($i+1)." selected>".$month[$i]."</option>";
										}
										else{
											echo "<option value = ".($i+1).">".$month[$i]."</option>";
										}
									}
				 				?>
				 			</select>
					 

					 		<select name="day" class="form-control col-lg-3 ">
								<?php
					 				for($i=1;$i<32;$i++){
										if ($i == $patient->day){
											echo "<option value='".$i."' selected>".$i."</option>";
										}
										else{
											echo "<option value='".$i."'>".$i."</option>";
										}
									}
					 			?>
							</select>
						
					 		<select name="year" class="form-control col-lg-4">
							<?php
					 			for($i=date("Y");$i>date("Y")-70;$i--){										
					 				if ($i == $patient->year){
											echo "<option value='".$i."' selected>".$i."</option>";
										}
										else{
											echo "<option value='".$i."'>".$i."</option>";
										}
					 			}
					 		?>
							</select>
					
		</td>
		
		
				<td>
	 				<input type="text" class="form-control col-md-11" name="birthPlace" value="<?php echo $patient->birthPlace; ?>">
				</td>
				
				<td>
				</td>
					<td>
	 				<select name="gender" class="form-control col-md-11">
	 					<?php
	 						if($patient->gender == 'Male'){
	 							echo "<option selected>Male</option>;";
	 							echo "<option>Female</option>;";
	 						}
	 						else{
	 							echo "<option>Male</option>;";
	 							echo "<option selected>Female</option>;";
	 						}
	 					?>
	 				</select>
					</td>
					
					<tr>
					<td><label><b>Present Address</b></label></td>
					<td><label><b>Nationality</b></label></td>
					<td><label><b>Civil Status</b></label></td>
					</tr>
	  		
					<td><input type="text" class="form-control col-md-11" name="address" value="<?php echo $patient->address; ?>"></td>
	 			
					<td>
	 				<select name="nationality" class="form-control col-md-11">
						<?php
							while($row1 = $stmtNationality->fetch(PDO::FETCH_ASSOC)){
								extract($row1);
								if ($row1['nationality'] == $patient->nationality){
								    echo "<option value = '{$nationality}' selected>".$row1['nationality']."</option>";
								}
								else{
									echo "<option value = '{$nationality}'>".$row1['nationality']."</option>";
								}
							}
						?>
					</select>
					</td>

					<td>
	 				<select name="civilStatus" class="form-control col-md-11">
	 					<?php
	 						if($patient->civilStatus == 'Single'){
	 							echo "<option selected>Single</option>;";
	 							echo "<option>Married</option>;";
	 							echo "<option>Widowed</option>;";
	 						}
	 						elseif($patient->civilStatus == 'Married'){
	 							echo "<option>Single</option>;";
	 							echo "<option selected>Married</option>;";
	 							echo "<option>Widowed</option>;";

	 						}
	 						elseif($patient->civilStatus == 'Widowed'){
	 							echo "<option>Single</option>;";
	 							echo "<option>Married</option>;";
	 							echo "<option selected>Widowed</option>;";
	 						}
	 					?>
	 				</select>
					</td>
	 		<tr>
			<td><label><b>Email Address</b></label></td>
			<td><label><b>Mobile Number</b></label></td>
			<td><label><b>Telephone Number</b></label></td>
			<td><label><b>Patient ID</b></label></td>
			</tr>
	  		
	  		
	 				<td><input type="text" class="form-control col-md-11" name="emailAdd"  value="<?php echo $patient->emailAdd; ?>"></td>
	 			
	 				<td><input type="text" class="form-control col-md-11" name="mobileNum" value="<?php echo $patient->mobileNum; ?>"></td>
	 			
	 				<td><input type="text" class="form-control col-md-11" name="phoneNum" value="<?php echo $patient->phoneNum; ?>"></td>
				
					<td><input type="text" class="form-control col-md-11" name="patientID" value="<?php echo $patient->patientID; ?>"></td>
				
		<tr>
		<td colspan = "4">
	 
			<button  type = "submit" name = "cancel" style = "background-color:#3498DB;color : white; padding : 6px 16px; margin :6px 0 ; border :none ; cursor : pointer; float : right; margin-right :1%; " >Cancel</button>
				<button type = "submit" name="update" style = "background-color:#3498DB;color : white; padding : 6px 15px; margin :6px 0 ; border :none ; cursor : pointer; float : right; margin-right :1%;">Submit</button>
		</td>
		</tr>
			</table>
 		</form>
 	</body>
 	</html>