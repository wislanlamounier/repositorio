<?php

class Resultado extends Model {
	public $mensagem;
	public $css;
	public $id_usuario;
	public $status;

	function __construct() {
		$this -> tabela = 'resultado';
	}

	function exibirResultado() {
		$codSessao = $_SESSION['cod_sessao'];
		
		$where = (isset($_SESSION['admin']['id'])) ? 'cod_sessao = "'.$codSessao.'" AND status = 0 AND id_usuario = ' . $_SESSION['admin']['id'] . ' LIMIT 1' : 'cod_sessao = "'.$codSessao.'" status = 0 LIMIT 1';
		$sql = Persistencia::tabelaSQL('', $this -> tabela, $where);
		$dados = Conexao::listarSql($sql);
		
		$this -> deletaResultado();

		return $dados;
	}

	function deletaResultado() {
		$sql = Persistencia::excluir($this -> tabela, 1, 1);
		return Conexao::execSql($sql);
	}

	function inserirResultado($dados) {
		$cod_sessao = $_SESSION['cod_sessao'];
		
		$id_usuario = ($_SESSION['admin']['id']) ? $_SESSION['admin']['id'] : 0;
		$sql = 'INSERT INTO ' . $this -> tabela . ' (mensagem, css, status, id_usuario, cod_sessao) VALUES ("' . $dados['mensagem'] . '", "' . $dados['css'] . '", 0, ' . $id_usuario . ', "'.$cod_sessao.'")';
		return Conexao::execSql($sql);
	}

	static function getResultado() {
		$resultado = (isset($_SESSION['resultado'])) ? $_SESSION['resultado'] : false;
		
		
		$html = '';
		if ($resultado) {
			//Se o retorno for um array
			if(is_array($_SESSION['resultado'])) { $resultado = new Colecao($_SESSION['resultado']); };

		$html = ' 
			<div class="alert '.$resultado->css.'">
            	<a data-dismiss="alert" class="close">×</a>
            	' . $resultado->mensagem . '
            </div>';
		}
		
		echo $html;
	}

	static function limpaResultado() {
		unset($_SESSION['resultado']);
		unset($_SESSION['result']);
	}

}
