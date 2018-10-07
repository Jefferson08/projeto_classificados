<?php require 'pages/header.php' ?>

<hr>

<div class="container">
	<h1>Cadastre-se </h1>
	<hr>


	<?php 

		$user = new Usuario();

		if (isset($_POST['nome']) && !empty($_POST['nome'])) {

			$nome = addslashes($_POST['nome']);
			$email = addslashes($_POST['email']);
			$telefone = addslashes($_POST['telefone']);
			$senha = $_POST['senha'];

			if (!empty($nome) && !empty($email) && !empty($senha)) {
				if ($user->cadastrar($nome, $email, $telefone, $senha)) {
					?>
						<div class="alert alert-success">Cadastrado com sucesso!!! <a href="login.php">Faça o login aqui</a></div>
					<?php
				} else {
					?>
						<div class="alert alert-danger">Esse usuário já existe!!!</div>
					<?php
				}
			} else {
				?>
					<div class="alert alert-warning">Preencha os campos!!!</div>
				<?php
			}
		}
	 ?>

	<form method="POST">

		<div class="form-group">
			<label for="nome">Nome: *</label>
			<input type="text" name="nome" id="nome" class="form-control">
		</div>

		<div class="form-group">
			<label for="email">Email: *</label>
			<input type="text" name="email" id="email" class="form-control">
		</div>

		<div class="form-group">
			<label for="telefone">Telefone: </label>
			<input type="text" name="telefone" id="telefone" class="form-control">
		</div>

		<div class="form-group">
			<label for="senha">Senha: *</label>
			<input type="password" name="senha" id="senha" class="form-control">
		</div>

		<h4>(*) campos obrigatórios</h4>

		<input type="submit" value="Cadastrar" class="btn btn-success">
	</form>

	<hr>
</div>