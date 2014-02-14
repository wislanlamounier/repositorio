<?php

class Log{
	public $id;
	public $id_usuario;
	public $tabela;
	public $tipo_operacao;
	public $sql_executado;
	public $sql_revert;
	public $data;
	public $hora;
	
	static function mapeador(){
		 return array(
		 	'id'=>array('input', '', array()),
		 	'id_usuario'=>array('input', '', array()),
		 	'tabela'=>array('input', '', array()),
		 	'sql_executado'=>array('input', '', array()),
		 	'data'=>array('input', '', array()),
		 	'hora'=>array('input', '', array()),
		 	'sql_revert'=>array('input', '', array()),
		 	'tipo_operacao'=>array('input', '', array()),
		 );
	}
	
	static function inserir($sql, $id, $tabela){
		$dados['id_usuario'] = $_SESSION['admin']['id'];
		$dados['sql_executado'] = $sql;
		$dados['tabela'] = $tabela;
		$dados['data'] = date('Y-m-d');
		$dados['hora'] = date('H:i:s');
		
		$sqlReverte = '';
		
		switch (true){
			case preg_match('/UPDATE/', $sql): /// Se for Update
				$sqlReverte = 'DELETE FROM '.$tabela.' WHERE id = '.$id.';';
				$dados['sql_revert'] = $sqlReverte.self::montarSqlRevert($tabela, $id);
				$dados['tipo_operacao'] = 'UPDATE';
			break;
			case preg_match('/INSERT/', $sql): /// Se for Insert
				$dados['sql_revert'] = 'DELETE FROM '.$tabela.' WHERE id = '.$id;
				$dados['tipo_operacao'] = 'INSERT';
			break;
			case preg_match('/DELETE/', $sql): /// Se for Insert
				$dados['sql_revert'] = self::montarSqlRevert($tabela, $id);
				$dados['tipo_operacao'] = 'DELETE';
			break;
		}

		foreach($dados as $chave => $valor){
			$campos[] = $chave;
			$camposValores[] = $valor;
		}
		
		$sql = Persistencia::incluir('log', $campos, $camposValores);
		return Conexao::execSql($sql);
	}
	
	static function montarSqlRevert($tabela='permissoes_modulo', $id){
		$sql = Persistencia::tabelaSQL('', $tabela, 'id = '.$id);
		$dados = Conexao::lerSql($sql);

		$into = array();
		$values = array();
		foreach($dados as $indice => $valor){
			$into[] = $indice;
			$values[] = $valor;
		}
		
		$sql = Persistencia::incluir($tabela, $into, $values);
		return $sql;
	}
	
	static function listarLog(){
		$sql = 'SELECT lg.*, us.nome usuario FROM 
				log lg
				INNER JOIN usuarios us ON lg.id_usuario = us.id
				WHERE tabela NOT IN("log") ORDER BY id ASC';
		
		return Conexao::listarSql($sql);
	}
	
	static function ler($id){
		$sql = 'SELECT lg.*, us.nome usuario FROM
				log lg
				INNER JOIN usuarios us ON lg.id_usuario = us.id
				WHERE tabela NOT IN("log") AND lg.id = '.$id;
		
		return Conexao::lerSql($sql);
	}
}