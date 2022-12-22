<?php
session_start();
	if(!isset($_SESSION['doctorID'])){
    header ("Location: Login.php");
		}
  include_once 'Header.php';
  include_once 'config/database.php';
  include_once 'classes/doctor.php';  
  include_once 'classes/nationality.php';
  include_once 'classes/department.php';
  include_once 'classes/specialization.php';

  $database = new Database();
  $db = $database -> getConnection();

  $nationality = new Nationality($db);
  $stmtNationality = $nationality->readAllNationality();

  $department = new Department($db);
  $stmtDepartment = $department->readAllDepartment();

  $specialization = new Specialization($db);
  $stmtSpecialization = $specialization->readAllSpecialization();

  $doctor = new Doctor($db);

  $doctorID = isset($_GET['doctorID']) ? $_GET['doctorID'] : die("ERROR: Missing ID");
  $doctor->doctorID=$doctorID;
  
  $doctor->readOneDoctor();
  $doctor->readDate();

  $month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
  $civilStatus = ["Single","Married","Widowed"];


if(isset($_POST['update'])){
	$month=$_POST['month'];
	$year=$_POST['year'];
	$day=$_POST['day'];
	$dateOfBirth="$year/$month/$day";

	$doctor->firstName = $_POST['firstName'];
	$doctor->middleName = $_POST['middleName'];
	$doctor->lastName = $_POST['lastName'];
	$doctor->suffix = $_POST['suffix'];
	$doctor->birthDate = $dateOfBirth;
	$doctor->birthPlace = $_POST['birthPlace'];
	$doctor->gender = $_POST['gender'];
	$doctor->address = $_POST['address'];
	$doctor->nationality = $_POST['nationality'];
	$doctor->civilStatus = $_POST['civilStatus'];
	$doctor->emailAdd = $_POST['emailAdd'];
	$doctor->mobileNum = $_POST['mobileNum'];
	$doctor->phoneNum = $_POST['phoneNum'];
	$doctor->department = $_POST['department'];
	$doctor->specialization = $_POST['specialization'];

	if($doctor->updateDoctor()){
		header("Location: index.php");
	}
	else{
		echo "Fail to update";
	}
}
else if(isset($_POST['cancel'])){
	header("Location: index.php");
}
?>

<html>
 	<header>
 		<title>Doctor Registration</title>
 	</header>

 	<body>
 		<form action='doctorEdit.php?doctorID=<?php echo $doctor->doctorID; ?>'	 method='post'>
		<table width = "100%" height = "50%">
	 		
			<tr>
			<td><label><b>First Name </b></label></td>
			<td><label><b>Middle Name </b></label></td>
			<td><label><b>Last Name </b></label></td>
			<td><label><b> surfix </b></label></td>
			</tr>
	 			
			<tr>
				<td>
	 				<input type="text" class="form-control col-md-11" name="firstName" value="<?php echo $doctor->firstName; ?>">
	 			</td>
				<td>
	 				<input type="text" class="form-control col-md-11" name="middleName" value="<?php echo $doctor->middleName; ?>">
				</td>
				<td>
	 				<input type="text" class="form-control col-md-11" name="lastName" value="<?php echo $doctor->lastName; ?>">
				</td>
				<td>
	 				<input type="text" class="form-control col-md-11" name="suffix"  value="<?php echo $doctor->suffix; ?>">
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
										if ($i+1 == $doctor->month){
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
										if ($i == $doctor->day){
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
					 				if ($i == $doctor->year){
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
	 				<input type="text" class="form-control col-md-11" name="birthPlace" value="<?php echo $doctor->birthPlace; ?>">
				</td>
				
				<td>
				</td>
					<td>
	 				<select name="gender" class="form-control col-md-11">
	 					<?php
	 						if($doctor->gender == 'Male'){
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
	  		
					<td><input type="text" class="form-control col-md-11" name="address" value="<?php echo $doctor->address; ?>"></td>
	 			
					<td>
	 				<select name="nationality" class="form-control col-md-11">
						<?php
							while($row1 = $stmtNationality->fetch(PDO::FETCH_ASSOC)){
								extract($row1);
								if ($row1['nationality'] == $doctor->nationality){
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
	 						if($doctor->civilStatus == 'Single'){
	 							echo "<option selected>Single</option>;";
	 							echo "<option>Married</option>;";
	 							echo "<option>Widowed</option>;";
	 						}
	 						elseif($doctor->civilStatus == 'Married'){
	 							echo "<option>Single</option>;";
	 							echo "<option selected>Married</option>;";
	 							echo "<option>Widowed</option>;";

	 						}
	 						elseif($doctor->civilStatus == 'Widowed'){
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
			</tr>
	  		
	  		
	 				<td><input type="text" class="form-control col-md-11" name="emailAdd"  value="<?php echo $doctor->emailAdd; ?>"></td>
	 			
	 				<td><input type="text" class="form-control col-md-11" name="mobileNum" value="<?php echo $doctor->mobileNum; ?>"></td>
	 			
	 				<td><input type="text" class="form-control col-md-11" name="phoneNum" value="<?php echo $doctor->phoneNum; ?>"></td>
	 	
				<tr>
				<td><label><b>Department</b></label></td>
				<td><label><b>Specialization</b></label></td>
				<td><label><b>Doctor ID</b></label></td>
				</tr>
	 	
				<td>
	 				<select name="department" class="form-control col-md-11">
	 					<?php
							while($row2 = $stmtDepartment->fetch(PDO::FETCH_ASSOC)){
								extract($row2);
								if ($row2['department'] == $doctor->department){
								    echo "<option value = '{$department}' selected>".$row2['department']."</option>";
								}
								else{
									echo "<option value = '{$department}'>".$row2['department']."</option>";
								}
							}
						?>
					</select>
	 			</td>
				
				<td>
	 				<select name="specialization" class="form-control col-md-11">
	 					<?php
							while($row3 = $stmtSpecialization->fetch(PDO::FETCH_ASSOC)){
								extract($row3);
								if ($row3['specialization'] == $doctor->specialization){
								    echo "<option value = '{$specialization}' selected>".$row3['specialization']."</option>";
								}
								else{
									echo "<option value = '{$specialization}'>".$row3['specialization']."</option>";
								}
							}
						?>

					</select>
	 			</td>
	 				
	 				<td><input type="text" class="form-control col-md-11" name="doctorID" value="<?php echo $doctor->doctorID; ?>"></td>
	 	
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