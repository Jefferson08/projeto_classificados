<?php require 'pages/header.php'; ?>

<?php 
	if (empty($_SESSION['cLogin'])) { //Verifica se o usuário está logado, se não, redireciona para o index
		?>
			<script type="text/javascript">
				window.location.href="./";
			</script>
		<?php
		exit;
	}

	require 'classes/anuncios.class.php';

	$a = new Anuncios();

	if (isset($_POST['titulo']) && !empty($_POST['titulo'])) {

		$titulo = addslashes($_POST['titulo']);
		$categoria = addslashes($_POST['categoria']);
		$valor = addslashes($_POST['valor']);
		$descricao = addslashes($_POST['descricao']);
		$estado = addslashes($_POST['estado']);

		$a->addAnuncio($titulo, $categoria, $valor, $descricao, $estado);

		header("Location: meus_anuncios.php");

		?>
			<div class="alert alert-success">Anúncio adicionado com sucesso !!!</div>
		<?php
	} else {
		
	}
 ?>



<hr>
 <div class="container">
 	<h1>Novo Anúncio</h1>
 	<hr>

 	<form method="POST" enctype="multipart/form-data">
 		<div class="form-group">
 			<label for="categoria">Categoria:</label>
 			<select name="categoria" id="categoria" class="form-control">
 				<?php 
 					require 'classes/categorias.class.php';

 					$cat = new Categorias();
 					$lista = $cat->getCategorias();

 					foreach($lista as $item): ?>

 					<option value="<?php echo $item['id']; ?>"><?php echo utf8_encode($item['nome']); ?></option>

 				<?php endforeach; ?>
 			</select>
 		</div>

 		<div class="form-group">
 			<label for="titulo">Título:</label>
 			<input type="text" name="titulo" id="titulo" class="form-control">
 		</div>

 		<div class="form-group">
 			<label for="valor">Valor:</label>
 			<input type="text" name="valor" id="valor" class="form-control">
 		</div>

 		<div class="form-group">
 			<label for="descricao">Descrição:</label>
 			<textarea class="form-control" name="descricao"></textarea>
 		</div>

 		<div class="form-group">
 			<label for="estado">Estado de conservação:</label>
 			<select name="estado" id="estado" class="form-control">
 				<option value="1">Ruim</option>
 				<option value="2">Bom</option>
 				<option value="3">Ótimo</option>
 			</select>
 		</div>

 		 <input type="submit" name="enviar" value="Adicionar anúncio" class="btn btn-success">

 	</form>
 </div>