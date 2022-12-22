<?php
  $page_title = "Medical Information System";
 
  include_once 'classes/doctor.php';

	session_start();
	session_destroy();
		header("Location: Login.php");
	