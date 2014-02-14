<?php

class Sistema extends Model{
	public $nome;
	public $charset;
	public $email;
	public $description;
	public $keywords;
	public $status;
	
	function __construct(){
		$this->tabela = 'sistema';
		
		$this->defineSistema();
		$this->verificaAtivo(STATUS_SITE);
		
		$this->form = $this->mapeador();
	}
	
	function mapeador(){
		return array(
			'nome'=>array('input', 'Nome', array('class'=>'validate[required]', 'type'=>"text",'value'=>$this->nome)),
			'charset'=>array('input', 'Charset', array('class'=>'validate[required]', 'readonly'=>'readonly','type'=>"text",'value'=>$this->charset)),
			'email'=>array('input', 'Email', array('class'=>'validate[required]', 'type'=>"text",'value'=>$this->email)),
			'description'=>array('input', 'Descrição do Site', array('class'=>'validate[required]', 'type'=>"text",'value'=>$this->description)),
			'keywords'=>array('input', 'Palavas Chave', array('class'=>'validate[required]', 'type'=>"text",'value'=>$this->keywords)),
			'status'=>array('select', 'Status', array('class'=>'validate[required]'), array('1'=>'Ativo', '0'=>'Inativo'), $this->status),
		);
	}
	
	public function defineSistema(){
		$dados = $this->capituraDados();
		
		// Sistema
		define('NOME_SISTEMA', $dados->nome);
		define('CHARSET', "text/html; $dados->charset");
		define('EMAIL_SISTEMA', $dados->email);
		define('DESCRIPTION', $dados->description);
		define('KEYWORDS', $dados->keywords);
		define('STATUS_SITE', $dados->status);
	}
	
	public function salvar($post, $false=false){
		foreach($post as $key=>$value){
			$campos[] = $key;
			$valores[] = $value;
		}
		$sql = Persistencia::alterar($this->tabela, $campos, $valores, 1, 1);
		return Conexao::execSql($sql);
	}
	
	private function capituraDados(){
		$sql = Persistencia::tabelaSQL('', $this->tabela, '1=1 LIMIT 0,1');
		$obj = Conexao::lerSql($sql);
		$this->setValores($obj);
		
		return $obj;
	}
	
	private function verificaAtivo($status){
		if(!$status && $_GET['mod'] == 'site'){
			Util::redirect('admin/acesso');
			//echo 'Site em Desenvolvimento!';
			die;
		}		
	}

	function emailAcesso($obj){
		$html = '
			Aviso de acesso ao Sistema<br />
			Caro Bruno,<br />
			O Usuário '.$obj->nome.', efetuou login no sistema.<br /><br />
			Dados de Acesso:<br />
			Data: '.date('d/m/Y').' às '.date('H:i:s').'.
		';
		
		return $html;
	}
}

