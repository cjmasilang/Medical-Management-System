<?php
	class Specialization{
		public $specialization;
		private $conn;

		function __construct($db){
			$this->conn = $db;
		}

		function readAllSpecialization(){
			$query = "SELECT * FROM specialization";
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}

	
	}