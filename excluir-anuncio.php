<?php 
	require 'classes/anuncios.class.php';
	require 'config.php';

	$a = new Anuncios();

	if (empty($_SESSION['cLogin'])) { //Verifica se o usuário está logado, se não, redireciona para o index
		header("Location: login.php");
		exit;
	} 

	if (isset($_GET['id']) && !empty($_GET['id'])) {
		$a->excluirAnuncio($_GET['id']);
	}

	header("Location: meus_anuncios.php");



 ?>