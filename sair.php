<?php 
	session_start();
	session_unset($_SESSION['cLogin']);
	header("Location: ./");
 ?>