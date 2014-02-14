<?php 

class Acesso extends Model{
	public $id;
	public $id_usuario;
	public $dados_login;
	public $dados_logout;
	public $logado;
	public $navegador;
	
	public static $id_acesso;
	function __construct(){
		$this->tabela = 'acesso';
	}
	
	function mapeador(){
		return array(
			'id'=>array('id', 0),
			'id_usuario'=>array('id', 0),
			'dados_login'=>array('input', '', array('value'=>0,'class'=>'validate[required]')),
			'dados_logout'=>array('input', '', array('value'=>0)),
			'logado'=>array('select', '', array('class'=>'validate[required]'),array('Não','Sim'), 0),
			'navegador'=>array('textarea', '', array())
		);
	}
	
	static function login($id_usuario){
		$sql = Persistencia::incluir('acesso', array_keys(self::mapeador()), array('', $id_usuario, date('H:i:s - d/m/Y'),'',1,$_SERVER['HTTP_USER_AGENT']));
		Conexao::execSql($sql);
		
		/// Retorna o Id do Acesso
		return Conexao::lastId();
	}
	
	/*
	 * Efetua logout do acesso e derruba a sessao do usuario
	 */
	static function logout(){
		self::cancelar($_SESSION['admin']['id_acesso']);
		unset($_SESSION['admin']);
	}
	
	/**
	 * Cancela um acesso pelo id
	 * 
	 */
	static function cancelar($id_acesso){
		$postDados = array('dados_logout'=>date('H:i:s - d/m/Y'),'logado'=>0);
		$sql = Persistencia::alterar('acesso', array_keys($postDados), array_values($postDados), 'id', $id_acesso);
		Conexao::execSql($sql);
	}
	
	
	/**
	 * Verifica se o Acesso é valido
	 * 
	 * retorna true se valido e false se invalido
	 */
	static function verificarAcesso($id_acesso){
		$sql = Persistencia::tabelaSQL('', 'acesso', 'id = '.$id_acesso);
		$acesso = Conexao::lerSql($sql);
		
		if($acesso->logado){
			self::$id_acesso = $acesso->id;
			return true;
		}else{
			return false;
		}
	}
	
	
	/*
	 * Verifica se o usuário já esta logado no sistema
	 * 
	 * returna true se conectado
	 * retorna false se nao conectado
	 */
	static function usuarioLogado($id_usuario){
		$sql = Persistencia::tabelaSQL('', 'acesso', 'id_usuario = '.$id_usuario.' AND logado = 1');
		$acesso = Conexao::lerSql($sql);
		
		if($acesso->logado){
			self::$id_acesso = $acesso->id;
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * Verifica se o Navegador é o mesmo acessado anteriormente
	 * 
	 * returna true se o navegador for o mesmo
	 * retorna false se o navegador for diferente
	 */
	static function verificarNavegador($navegador, $id_usuario){
		$sql = Persistencia::tabelaSQL('', 'acesso', 'id_usuario = '.$id_usuario.' AND logado = 1 AND navegador = "'.$navegador.'"');
		
		$dados = Conexao::listarSql($sql);
		if(count($dados)){
			self::$id_acesso = $dados[0]->id;
			return true;
		}else{
			return false;
		}
	}
	
	function listar($where=''){
		$where = ($where) ? 'WHERE '.$where : '';
		
		$sql = 'SELECT *, ac.id id_acesso FROM acesso ac
				INNER JOIN usuarios us ON ac.id_usuario = us.id '.$where;
		
		return Conexao::listarSql($sql);
	}
}