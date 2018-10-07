<?php 

	class Categorias{
		function getCategorias(){
			global $pdo;

			$array = array();

			$sql = "SELECT * FROM categorias";
			$sql = $pdo->query($sql);

			if ($sql->rowCount() > 0) {
				$array = $sql->fetchAll();
			}

			return $array;
		}
	}
 ?>