<?php require 'pages/header.php' ?>

<hr>

<div class="container">
	<h1>Login </h1>
	<hr>

	<?php 

		$user = new Usuario();

		if (isset($_POST['email'])) {

			if (!empty($_POST['email']) && !empty($_POST['senha'])) {
				$email = addslashes($_POST['email']);
				$senha = $_POST['senha'];

				if ($user->login($email, $senha)) { //Verifica o login
					?>
						<script type="text/javascript">window.location.href="./"</script> <!--Redireciona para o index -->
					<?php
				} else {
					?>
						<div class="alert alert-danger">Email e/ou Senha inválidos!!!</div>
					<?php
				}
			} else {
				?>
					<div class="alert alert-warning">Prencha os campos email e senha !!!</div>
				<?php
			}
		} 
	 ?>

	<form method="POST">

		<div class="form-group">
			<label for="email">Email: *</label>
			<input type="text" name="email" id="email" class="form-control">
		</div>

		<div class="form-group">
			<label for="senha">Senha: *</label>
			<input type="password" name="senha" id="senha" class="form-control">
		</div>

		<input type="submit" value="Entrar" class="btn btn-success">
	</form>

	<hr>
</div>