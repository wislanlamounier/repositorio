<?php
require_once(FRAMEWORK.'Model.php');
class Usuarios extends Model {
	
	public $id;
	public $nome;
	public $login;
	public $email;
	public $senha;
	public $status;
	public $id_grupo;
	public $id_pessoa;
	
	function __construct(){
		$this->tabela = 'usuarios';
		$this->campos = array(
			 'id',
			 'nome',
			 'login',
			 'senha',
			 'email',
			 'status',
			 'id_grupo'
		);
		
		$this->form = $this->mapeador();
	}
	
	function acessar(){
		$where = $this->campos[2].'="'.$this->login.'" AND '.$this->campos[3].'="'.$this->senha.'"';
		$sql = Persistencia::tabelaSQL('', $this->tabela, $where);
		
		$dados = Conexao::listarSql($sql);
		
		if(count($dados) > 0){
			return $dados[0];
		}else{
			return false;
		}
	}
	
	public function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_pessoa'=>array('select', 'Pessoa',array('class'=>'validate[required]'), Conexao::selectBanco('pessoa'), $this->id_pessoa),	
			'nome'=>array('input', 'Nome', array('class'=>'validate[required]', 'value'=>$this->nome)),
			'login'=>array('input', 'Login', array('class'=>'validate[required] validar-unico', 'data-valida'=>'usuarios','value'=>$this->login)),
			'senha'=>array('password', 'Senha', array('class'=>'validate[required]', 'type'=>"password",'value'=>'')),
			'id_grupo'=>array('select', 'Grupo',array('class'=>'validate[required]'), Conexao::selectBanco('grupos_usuarios'), $this->id_grupo),	
			'email'=>array('input', 'Email', array('class'=>'validade[required] validar-unico', 'data-valida'=>'usuarios','value'=>$this->email)),
			'status'=>array('select', 'Status', array('class'=>'validate[required]', 'type'=>"text",'value'=>$this->status), array('1'=>'Ativo', '0'=>'Inativo'), $this->status)
		);
	}
	
	public function formSenha(){
		return array(
			'id'=>array('id', $this->id),
			'nova_senha'=>array('password', 'Nova Senha', array('class'=>'validate[required]','value'=>'')),
		);
	}
	
	public function formDados(){
		return array(
			'id'=>array('id', $this->id),
			'id_pessoa'=>array('select', 'Pessoa',array('class'=>'validate[required]'), Conexao::selectBanco('pessoa'), $this->id_pessoa),	
			'nome'=>array('input', 'Nome', array('class'=>'validate[required]', 'value'=>$this->nome)),
			'login'=>array('input', 'Login', array('class'=>'validate[required] validar-unico', 'data-valida'=>'usuarios','value'=>$this->login)),
			'email'=>array('input', 'Email', array('class'=>'validade[required] validar-unico', 'data-valida'=>'usuarios', 'value'=>$this->email)),
			'id_grupo'=>array('select', 'Grupo',array('class'=>'validate[required]'), Conexao::selectBanco('grupos_usuarios'), $this->id_grupo),
			'status'=>array('select', 'Status', array('class'=>'validate[required]', 'type'=>"text",'value'=>$this->status), array('1'=>'Ativo', '0'=>'Inativo'), $this->status)
		);
	}
	
	function setLogin($login){
		$this->login = $login;	
	}
	
	function setSenha($senha){
		$this->senha = $senha;	
	}
	
	public static function getNome($id){
		$sql = Persistencia::tabelaSQL(array('nome'), 'usuarios', 'id = '.$id);
		$dados = Conexao::lerSql($sql);
		
		return ($dados->nome) ? $dados->nome : 'Não Cadastrado';
	}
}

 
	

?>