<?php require 'pages/header.php' ?>

<?php 
	require 'classes/anuncios.class.php';

	$a = new Anuncios();
	$u = new Usuario();

	if (isset($_GET['id']) && !empty($_GET['id'])) {
		$info = $a->getAnuncio($_GET['id']);
	} else {
		?>
			<script type="text/javascript">
				window.location.href="index.php";
			</script>
		<?php
		exit;
	}
	
 ?>
 	<hr>

	<div class="container">
		
		<div class="row">
			<div class="col-sm-4" style="border: 1px solid;">
				<div id="slide_show" class="slide carousel" data-ride="carousel">

					<ol class="carousel-indicators">
				    	<li data-target="#slide_show" data-slide-to="0" class="active"></li>

					<?php for ($i=1; $i < count($info['fotos']) ; $i++) { ?>
						<li data-target="#slide_show" data-slide-to="<?php echo($i); ?>"></li>
					<?php } ?>
					</ol>

					<div class="carousel-inner">

						<?php if(empty($info['fotos'])): ?>
							<div class="carousel-item active">
								<img src="assets/images/anuncios/default-image-2.png">
							</div>
						<?php else: ?>
							<?php foreach ($info['fotos'] as $chave => $foto): ?>
						 	<div style="margin: auto; width: 348px; height: 348px;" class="carousel-item <?php echo($chave == 0)?'active':''; ?>">
								<img src="assets/images/anuncios/<?php echo($foto['url']); ?>" class="w-100">
							</div>
							 <?php endforeach; ?>
						<?php endif; ?>

					</div>
				</div>

				<a class="carousel-control-prev" href="#slide_show" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				</a>

				<a class="carousel-control-next" href="#slide_show" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
				</a>
			</div>
			<div class="col-sm-8">
				<br>
				<h1><?php echo $info['titulo']; ?></h1>
				<h4>Em: <?php echo utf8_encode($info['categoria']); ?></h4>
				<p><?php echo $info['descricao']; ?></p>
				<br>
				<h3>RS: <?php echo number_format($info['valor'], 2, ',', '.'); ?></h3>
				<h4>Contato: <?php echo $info['telefone']; ?></h4>
			</div>
				
		</div>
	</div>

	
</body>
</html>