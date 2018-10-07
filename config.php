<?php 
	session_start();

	//header("Content-type: text/html; charset=utf-8; language=pt-br;");
	global $pdo;

	$drv = "mysql:dbname=projeto_classificados;host=localhost";
	$user = "root";
	$pass = "";

	try {
		$pdo = new PDO($drv, $user, $pass);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	} catch (PDOException $e) {
		echo "Erro: ".$e->getMessage();
	}

 ?>