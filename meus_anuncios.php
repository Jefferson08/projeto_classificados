<?php require 'pages/header.php'; ?>

<?php 
	if (empty($_SESSION['cLogin'])) { //Verifica se o usuário está logado, se não, redireciona para o login.php
		?>
			<script type="text/javascript">
				window.location.href="login.php";
			</script>
		<?php
		exit;
	}
 ?>
<hr>

<div class="container">
	<h1>Meus Anúncios</h1>
	<hr> 

	<table class="table table-bordered text-center bg-light">
		<thead>
			<tr>
				<th>Foto</th>
				<th>Título</th>
				<th>Valor</th>
				<th>Ações</th>
			</tr>
		</thead>
		
		<?php 
			require 'classes/anuncios.class.php';

			$a = new Anuncios();
			$anuncios = $a->getMeusAnuncios();

			foreach ($anuncios as $item): ?>
				<tr>
					<td>
						<?php if(!empty($item['url'])): ?>
							<img src="assets/images/anuncios/<?php echo $item['url']; ?>" width="50" height="50">
						<?php else: ?>
							<img src="assets/images/anuncios/default-image.png" width="50" height = "50">
						<?php endif; ?>
					</td>
					<td class="align-middle"><?php echo $item ['titulo']; ?></td>
					<td class="align-middle">R$ <?php echo number_format($item['valor'], 2); ?></td>
					<td class="align-middle">
						<a href="editar-anuncio.php?id=<?php echo $item['id']; ?>"><button class="btn btn-primary">Editar</button></a>
						<a href="excluir-anuncio.php?id=<?php echo $item['id']; ?>"><button class="btn btn-danger">Excluir</button></a>
					</td>
				</tr>
			<?php
			endforeach;
			
		 ?>
	</table>

	<a href="add_anuncio.php"><button class="btn btn-secondary">Novo Anúncio</button></a>
</div>