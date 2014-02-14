<?php
class Persistencia {
	static function incluir($tabela, $campos, $camposValores){
		$campos = implode(', ', $campos);
		for ($i=0; $i<count($camposValores); $i++) {
			if (!is_int($camposValores[$i])&&!is_double($camposValores[$i])&&!is_null($camposValores[$i])) {
				$camposValores[$i] = "'".addslashes($camposValores[$i])."'";
			} else if (is_null($camposValores[$i])) {
				$camposValores[$i] = 'null';
			}
		}
			
		$camposValores = implode(', ', $camposValores);

		$query = 'INSERT INTO '.$tabela.' ('.$campos.') VALUES ('.$camposValores.')';
		return $query;
	}

	static function alterar($tabela, $campos, $camposValores, $campoFiltro, $valorFiltro){
		if ($tabela && $campos && $camposValores && $campoFiltro && $valorFiltro) {
			if (is_array($campos)) {
				for ($i=0; $i < count($campos); $i++) {
					// Tipando os valores
					if (is_string($camposValores[$i])) {
						$camposValores[$i] = "'".addslashes($camposValores[$i])."'";
					} else {
						if (is_null($camposValores[$i])) {
							$camposValores[$i] = 'null';
						}
					}

					// Construindo o array
					$array[$i] = $campos[$i]." = ".$camposValores[$i];
				}
				$nomeCampos = implode(", ", $array);
			} else {
				if (is_string($camposValores)) {
					$camposValores = "'".$camposValores."'";
				} else {
					if (is_null($camposValores[$i])) {
						$camposValores[$i] = 'null';
					}
				}
				$nomeCampos = $campos." = ".$camposValores;
			}
			if (is_string($valorFiltro)) {
				$valorFiltro = "'".$valorFiltro."'";
			}
			$query = "UPDATE ".$tabela." SET ".$nomeCampos." WHERE ".$campoFiltro." = ".$valorFiltro;
			return $query;
		} else {
			return false;
		}
	}

	static function excluir($tabela, $campo, $campoValor){
		$campoValor = is_string($campoValor) ? "'".$campoValor."'" : $campoValor;
		$sSql = "DELETE FROM ".$tabela." WHERE ".$campo." = ".$campoValor;
		return $sSql;
	}

	static function truncate($tabela){
		$sql = 'TRUNCATE TABLE '.$tabela;
		return $sql;
	}

	/***/

	static function tabelaSQL($campos, $tabela, $where){
		if(!$campos){
			$campos = "*";
		}else{
			if( is_array($campos) ){
				$campos = implode(", ", $campos);
			}
		}

		if($where != NULL && count($where) > 0 ) {
			$sql = "SELECT ".$campos." FROM ".$tabela." WHERE ". $where;
		}
		else {
			$sql = "SELECT ".$campos." FROM ".$tabela;
		}
		return $sql;
	}
	
	static function sqlRelacionamento($form, $tabela, $return=true){
		$stringRelacionado = '';
		
		foreach($form as $nome=>$value){
			if(preg_match('/id_/', $nome)){
				$tabela_relacionada = str_replace('id_', '', $nome).'_'.$tabela;
				$stringRelacionado .= ' ALTER TABLE '.$tabela.' ADD CONSTRAINT FK_'.$tabela_relacionada.' FOREIGN KEY ('.$nome.') REFERENCES '.$tabela_relacionada.' (id); <br />';
			}
		}
		
		if($return){
			return $stringRelacionado;
		}else{
			echo $stringRelacionado;die;
		}
	}
	
	static function sqlCreate($form, $tabela, $return=true){
		$stringCampos = '';
		
		foreach($form as $nome=>$value){
			$obrigatorio = false;
			
			if(isset($value[2]['class'])){
				$obrigatorio = (preg_match('/required/', $value[2]['class'])) ? ' NOT NULL' : ' NULL';
			}
			
			switch ($value[0]) {
					case 'input':
						$stringCampos .= $nome.' varchar(255)';
					break;
					case 'id':
						if($nome != 'id'){
							$stringCampos .= $nome.' int';
						}else{
							$stringCampos .= $nome.' int AUTO_INCREMENT';
						}
					break;
					case 'textarea':
						$stringCampos .= $nome.' text';
					break;
					case 'data':
						$stringCampos .= $nome.' date';
					break;
					case 'cpf':
						$stringCampos .= $nome.' varchar(14)';
					break;
					case 'select':
						$stringCampos .= $nome.' int(10)';
					break;
					case 'file':
						$stringCampos .= $nome.' varchar(255)';
					break;
					case 'checkbox':
						$stringCampos .= $nome." TINYINT NULL DEFAULT '0'";
						break;
					case 'hidden':
						$stringCampos .= $nome.' int';
					break;
					case 'autocomplete':
						$stringCampos .= $nome.' int';
						break;
					case 'telefone':
						$stringCampos .= $nome.' varchar(15)';
					break;
					case 'imagem':
						$obrigatorio = '';
						$stringCampos .= '';
					break;
					default:
						$stringCampos .= $nome.' varchar(255)';
					break;
			}
			if($value[0] != 'imagem'){
				$stringCampos.= $obrigatorio.', ';
			}
		}
		
		//$sqlTratada = substr($stringCampos, 0, -1);
		$primary = 'PRIMARY KEY (id)';
		
		$stringSql = "CREATE TABLE $tabela ($stringCampos $primary)";
		if(!$return){
			echo $stringSql;die;
		}else{
			return $stringSql;
		}
	}
	
	static function __sql($campos='', $tabela, $where=''){
		$sql = Persistencia::tabelaSQL($campos, $this->tabela, '1=1 LIMIT 0,1');
		return $this->lerSql($sql);
	}
} 