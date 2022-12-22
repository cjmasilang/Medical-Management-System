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

  $month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
  $civilStatus = ["Single","Married","Widowed"];

if($_POST){
  $database = new Database();
  $db = $database->getConnection();

  $doctor = new Doctor($db);

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
  $doctor->doctorID = $_POST['doctorID'];

  if($doctor->createDoctor()){
  	echo "Successful";
}
  else
  	echo "Failure";
}
?>

<html>
	<header>
 		<title>Doctor Registration</title>
 	</header>

 	<body>
	
 		<form method='post' action='doctorAdd.php' >
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
	 				<input type="text" class="form-control col-md-11" name="address">
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

			</tr>
			
			<tr>
			<td><label><b>Department</b></label></td>
			<td><label><b>Specialization</b></label></td>
			<td><label><b>Doctor ID</b></label></td>
			</tr>
			
			<tr>
			<td>
	 				<select name="department" class="form-control col-md-11">
						<?php
							while($row2 = $stmtDepartment->fetch(PDO::FETCH_ASSOC)){
								extract($row2);
							    echo "<option>".$row2['department']."</option>";
							}
						?>
					</select>
	 		</td>

			<td>
	 				<select name="specialization" class="form-control col-md-11">
						<?php
							while($row3 = $stmtSpecialization->fetch(PDO::FETCH_ASSOC)){
								extract($row3);
							    echo "<option>".$row3['specialization']."</option>";
							}
						?>
					</select>
	 		</td>
			<td>
	 				<input type="text" class="form-control col-md-11" name="doctorID" placeholder="12345">
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
 	</body>
</html>