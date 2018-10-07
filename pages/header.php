<?php
require 'config.php';
require 'classes/usuarios.class.php';

 ?>


<html>
<head>
	<title>Classificados</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.bundle.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">

			<div class="navbar-brand">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				    <span class="navbar-toggler-icon"></span>
				 </button>
				<a href="./">Classificados</a>
			</div>

			<div class="collapse navbar-collapse justify-content-end" id="navbarNav">

				<?php 
					if (isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])) { //Verifica se o usuário está logado
				
			 			$u = new Usuario();
			 			$nome = $u->getNome($_SESSION['cLogin']); 

			 			?>
			 				<h5 style="color: white; margin-right: 50px;"><?php echo utf8_encode($nome); ?></h5>
			 			<?php
					}
				?>

				<ul class="navbar-nav">
			 	<?php if (isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])): ?> <!--Se o usuário estiver logado -->
			 		<li class="nav-item">
					   <a class="nav-link" href="meus_anuncios.php"><button class="btn btn-primary">Meus anuncios</button></a>
					</li>
					<li class="nav-item">
					   <a class="nav-link" href="sair.php"><button class="btn btn-primary">Sair</button></a>
					</li>
				<?php else: ?>
					<li class="nav-item">
					   <a class="nav-link" href="cadastro.php"><button class="btn btn-primary">Cadastrar</button></a>
					</li>
					<li class="nav-item">
					   <a class="nav-link" href="login.php"><button class="btn btn-primary">Login</button></a>
					</li>

				<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>