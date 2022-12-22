<?php
	class Patient{
		public $patientID;
		public $firstName;
		public $lastName;
		public $middleName;
		public $suffix;
		public $birthPlace;
		public $gender;
		public $address;
		public $nationality;
		public $civilStatus;
		public $emailAdd;
		public $mobileNum;
		public $phoneNum;
		public $birthDate;
		private $conn;
		public $tableName = "patient";
		public $month;
		public $day;
		public $year;

		function __construct($db){
			$this->conn = $db;
		}

		function readAllPatient(){
			$query = "SELECT * FROM patient";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}

		function createPatient(){
			$query = "INSERT INTO patient SET firstName=?, middleName=?, lastName=?, suffix=?, birthPlace=?, gender=?, address=?, nationality=?, civilStatus=?, emailAdd=?, mobileNum=?, phoneNum=?, patientID=?, birthDate=?";
			$stmt = $this->conn->prepare($query);

			$stmt->bindparam(1,$this->firstName);
			$stmt->bindparam(2,$this->middleName);
			$stmt->bindparam(3,$this->lastName);
			$stmt->bindparam(4,$this->suffix);
			$stmt->bindparam(5,$this->birthPlace);
			$stmt->bindparam(6,$this->gender);
			$stmt->bindparam(7,$this->address);
			$stmt->bindparam(8,$this->nationality);
			$stmt->bindparam(9,$this->civilStatus);
			$stmt->bindparam(10,$this->emailAdd);
			$stmt->bindparam(11,$this->mobileNum);
			$stmt->bindparam(12,$this->phoneNum);
			$stmt->bindparam(13,$this->patientID);
			$stmt->bindparam(14,$this->birthDate);


			if($stmt->execute())
				return true;
			else
				return false;
		}

		function readOnePatient(){

			$query = "SELECT * FROM " . $this->tableName . " WHERE patientID = ? LIMIT 0,1";

			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(1, $this->patientID);
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->firstName = $row['firstName'];
			$this->middleName = $row['middleName'];
			$this->lastName = $row['lastName'];
			$this->suffix = $row['suffix'];
			$this->birthPlace = $row['birthPlace'];
			$this->address = $row['address'];
			$this->emailAdd = $row['emailAdd'];
			$this->mobileNum = $row['mobileNum'];
			$this->phoneNum = $row['phoneNum'];
			$this->patientID = $row['patientID'];
			$this->gender = $row['gender'];
			$this->nationality = $row['nationality'];
			$this->civilStatus = $row['civilStatus'];

		}

		function readDate(){
			
			$queryDate = "SELECT YEAR(birthDate), MONTH(birthDate), DAY(birthDate) FROM " . $this->tableName . " WHERE patientID = ? LIMIT 0,1";

			$stmtDate = $this->conn->prepare($queryDate);
			$stmtDate->bindParam(1, $this->patientID);
			$stmtDate->execute();

			$rowDate = $stmtDate->fetch(PDO::FETCH_ASSOC);

			$this->month = $rowDate['MONTH(birthDate)'];
			$this->year = $rowDate['YEAR(birthDate)'];
			$this->day = $rowDate['DAY(birthDate)'];

		}

		function updatePatient(){
			$queryUpdate = "UPDATE patient SET firstName = ?, middleName=?, lastName=?, suffix=?, birthPlace=?, gender=?, address=?, nationality=?, civilStatus=?, emailAdd=?, mobileNum=?, phoneNum=?, birthDate=?  WHERE patientID = ?";

			$stmtUpdate = $this->conn->prepare($queryUpdate);

			$stmtUpdate->bindparam(1,$this->firstName);
			$stmtUpdate->bindparam(2,$this->middleName);
			$stmtUpdate->bindparam(3,$this->lastName);
			$stmtUpdate->bindparam(4,$this->suffix);
			$stmtUpdate->bindparam(5,$this->birthPlace);
			$stmtUpdate->bindparam(6,$this->gender);
			$stmtUpdate->bindparam(7,$this->address);
			$stmtUpdate->bindparam(8,$this->nationality);
			$stmtUpdate->bindparam(9,$this->civilStatus);
			$stmtUpdate->bindparam(10,$this->emailAdd);
			$stmtUpdate->bindparam(11,$this->mobileNum);
			$stmtUpdate->bindparam(12,$this->phoneNum);
			$stmtUpdate->bindparam(13,$this->birthDate);
			$stmtUpdate->bindparam(14,$this->patientID);


			if($stmtUpdate->execute())
				return true;
			else
				return false;

		}

		function deletePat(){
			$query = "DELETE FROM patient WHERE patientID = ?";

			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(1, $this->patientID);
			
			if($result = $stmt->execute()){
				return true;
			}else{
				return false;
			}
		}

		function login(){
			$query = "SELECT * FROM " . $this->tableName . " WHERE patientID = ? AND password = ?";
			$stmt = $this->conn->prepare($query);

			$stmt->bindParam(1, $this->patientID);
			$stmt->bindParam(2, $this->password);

			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$num = $stmt->rowCount();

			if($num > 0){
				session_start();
				$_SESSION['patientID'] = $row['patientID'];
				return true;
			}else{
				return false;
			}
		}

		function logout(){
			session_destroy();
			unset($_SESSION['patientID']);
			return true;
		}
	}
?>