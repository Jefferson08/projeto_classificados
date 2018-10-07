<?php 
	class Anuncios{

		function getTotalAnuncios($filtros){
			global $pdo;

			$string_filtros = array('1=1'); //Se não houver nenhum filtro, ainda sim executa a query (WHERE 1 = 1)

			if (!empty($filtros['categoria'])) {
				$string_filtros[] = "anuncios.id_categoria = :id_categoria";
			}

			if (!empty($filtros['preco'])) {
				$string_filtros[] = "anuncios.valor BETWEEN :valor1 AND :valor2";
			}

			if (!empty($filtros['estado'])) {
				$string_filtros[] = "anuncios.estado = :estado";
			}

			$sql = "SELECT COUNT(*) as tot_anuncios_filtro, (SELECT COUNT(*) FROM anuncios) as total_anuncios FROM anuncios WHERE ".implode(' AND ', $string_filtros);

			$sql = $pdo->prepare($sql);

			if (!empty($filtros['categoria'])) {
				$sql->bindValue(":id_categoria", $filtros['categoria']);
			}

			if (!empty($filtros['preco'])) {
				$range = explode("-", $filtros['preco']);
				$sql->bindValue(":valor1", $range[0]);
				$sql->bindValue(":valor2", $range[1]);
			}

			if (!empty($filtros['estado'])) {
				$sql->bindValue(":estado", $filtros['estado']);
			}

			$sql->execute();

			$row = $sql->fetch();

			return $row;
		}

		function getUltimosAnuncios($pag_atual, $itens_por_pagina, $filtros){
			global $pdo;

			$offset = (($pag_atual - 1) * $itens_por_pagina);

			$array = array();

			$string_filtros = array('1=1');

			if (!empty($filtros['categoria'])) {
				$string_filtros[] = "anuncios.id_categoria = :id_categoria";
			}

			if (!empty($filtros['preco'])) {
				$string_filtros[] = "anuncios.valor BETWEEN :valor1 AND :valor2";
			}

			if (!empty($filtros['estado'])) {
				$string_filtros[] = "anuncios.estado = :estado";
			}

			$sql = "SELECT *, (SELECT anuncios_imagens.url FROM anuncios_imagens WHERE anuncios_imagens.id_anuncio = anuncios.id limit 1) as url, (SELECT categorias.nome FROM categorias WHERE categorias.id = anuncios.id_categoria) as categoria FROM anuncios WHERE ".implode(' AND ', $string_filtros)." ORDER BY id DESC LIMIT $offset, $itens_por_pagina";

			$sql = $pdo->prepare($sql);

			if (!empty($filtros['categoria'])) {
				$sql->bindValue(":id_categoria", $filtros['categoria']);
			}

			if (!empty($filtros['preco'])) {
				$range = explode("-", $filtros['preco']);
				$sql->bindValue(":valor1", $range[0]);
				$sql->bindValue(":valor2", $range[1]);
			}

			if (!empty($filtros['estado'])) {
				$sql->bindValue(":estado", $filtros['estado']);
			}
			
			$sql->execute();

			if ($sql->rowCount() > 0) {
				$array = $sql->fetchAll();
			}

			return $array;
		}

		function getMeusAnuncios(){
			global $pdo;

			$array = array();

			$sql = "SELECT *, (SELECT anuncios_imagens.url FROM anuncios_imagens WHERE anuncios_imagens.id_anuncio = anuncios.id limit 1) as url FROM anuncios WHERE id_usuario = :id";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":id", $_SESSION['cLogin']);
			$sql->execute();

			if ($sql->rowCount() > 0) {
				$array = $sql->fetchAll();
			}

			return $array;
		}

		function getAnuncio($id){
			global $pdo;
			$array = array();

			$sql = "SELECT *, (SELECT categorias.nome FROM categorias WHERE categorias.id = anuncios.id_categoria) as categoria, (SELECT usuarios.telefone FROM usuarios WHERE usuarios.id = anuncios.id_usuario) as telefone FROM anuncios WHERE id = :id";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":id", $id);
			$sql->execute();

			if ($sql->rowCount() > 0) {
				$array = $sql->fetch();
				$array['fotos'] = array();

				$sql = $pdo->prepare("SELECT id, url FROM anuncios_imagens WHERE id_anuncio = :id_anuncio");
				$sql->bindValue(":id_anuncio", $id);
				$sql->execute();

				if ($sql->rowCount() > 0) {
					$array['fotos'] = $sql->fetchAll();
				}
			}

			return $array;
		}

		function addAnuncio($titulo, $categoria, $valor, $descricao, $estado){
			global $pdo;

			$sql = "INSERT INTO anuncios SET id_usuario = :id, id_categoria = :id_categoria, titulo = :titulo, descricao = :descricao, valor = :valor, estado = :estado";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":id", $_SESSION['cLogin']);
			$sql->bindValue(":id_categoria", $categoria);
			$sql->bindValue(":titulo", $titulo);
			$sql->bindValue(":descricao", $descricao);
			$sql->bindValue(":valor", $valor);
			$sql->bindValue(":estado", $estado);

			$sql->execute();
		}

		function editarAnuncio($titulo, $categoria, $valor, $descricao, $estado, $fotos, $id){
			global $pdo;

			$sql = "UPDATE anuncios SET id_usuario = :id_usuario, id_categoria = :id_categoria, titulo = :titulo, descricao = :descricao, valor = :valor, estado = :estado WHERE id = :id_anuncio";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":id_usuario", $_SESSION['cLogin']);
			$sql->bindValue(":id_categoria", $categoria);
			$sql->bindValue(":titulo", $titulo);
			$sql->bindValue(":descricao", $descricao);
			$sql->bindValue(":valor", $valor);
			$sql->bindValue(":estado", $estado);
			$sql->bindValue(":id_anuncio", $id);

			$sql->execute();

			if (!empty($fotos['tmp_name'][0])) {
				echo "Tem fotos";

				for($i = 0; $i < count($fotos['tmp_name']); $i++){
					
					$tipo = $fotos['type'][$i];

					if (in_array($tipo, array('image/jpeg', 'image/png'))) {
						
						$tmp_name = md5(time().rand(0, 9999)).'.jpg';

						echo $tmp_name;

						move_uploaded_file($fotos['tmp_name'][$i], 'assets/images/anuncios/'.$tmp_name);

						list($width_orig, $height_orig) = getimagesize('assets/images/anuncios/'.$tmp_name);

						$ratio = $width_orig / $height_orig;

						$final_width = 348;
						$final_height = 500;

						if($final_width / $final_height > $ratio){ 
							$final_width = $final_height * $ratio;
						} else {
							$final_height = $final_width / $ratio;
						}

						$img = imagecreatetruecolor($final_width, $final_height);

						if ($tipo == 'image/jpeg') {
							$img_origin = imagecreatefromjpeg('assets/images/anuncios/'.$tmp_name);
						}elseif ($tipo == 'image/png') {
							$img_origin = imagecreatefrompng('assets/images/anuncios/'.$tmp_name);
						}

						imagecopyresampled($img, $img_origin, 0, 0, 0, 0, $final_width, $final_height, $width_orig, $height_orig);

						imagejpeg($img, 'assets/images/anuncios/'.$tmp_name, 80);

						$sql = $pdo->prepare("INSERT INTO anuncios_imagens SET id_anuncio = :id, url = :url");
						$sql->bindValue(":id", $id);
						$sql->bindValue(":url", $tmp_name);
						$sql->execute();
					}
				}
			} else {
				echo "Não tem fotos!!";
			}
		}

		function excluirAnuncio($id){
			global $pdo;
			$sql = "DELETE FROM anuncios_imagens WHERE id_anuncio = :id";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":id", $id);
			$sql->execute();

			$sql = "DELETE FROM anuncios WHERE id = :id";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":id", $id);
			$sql->execute();
		}

		function excluirFoto($id){

			global $pdo;

			$sql = "SELECT id_anuncio FROM anuncios_imagens WHERE id = :id";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":id", $id);
			$sql->execute();

			if ($sql->rowCount() > 0) {
				$row = $sql->fetch();
				$id_anuncio = $row['id_anuncio'];
			}

			$sql = "DELETE FROM anuncios_imagens WHERE id = :id";
			$sql = $pdo->prepare($sql);
			$sql->bindValue(":id", $id);
			$sql->execute();

			return $id_anuncio;
		}

	}
 ?>