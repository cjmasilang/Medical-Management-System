<?php
	class Nationality{
		public $nationality;
		private $conn;

		function __construct($db){
			$this->conn = $db;
		}

		function readAllNationality(){
			$query = "SELECT * FROM nationality";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}

	}