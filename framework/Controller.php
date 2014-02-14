<?php
class Controller { 
	
	/// Define o modulo controller como obrigatorio para autenticacao
	public $autenticacao = 'admin';
	public $template = false;
	public $view;
	
	/// Variaveis do Cache
	public $cache = false;
	public $cachetime = 60; ///Tempo em minutos
	
	public function __construct() {
		/// Verifica se o modulo necessida de autenticação
		if($this->autenticacao){
			if(!isset($_SESSION[$this->autenticacao]) && $_GET['mod'] != 'acesso'){
			  	/// Redireciona o Cliente para a página de Acesso
				Util::redirect('acesso/login');
			}
		}
		
		$this->carregarModulo(array('sistema'));
		
		$this->capituraResultado();
		
		$this->view = new Colecao();
	}
	
	/// Redireciona
	function redirect($url){
		Util::redirect($url);
		die;
	}
	
	///Inicia a Classe do Template
	function initTemplate($pagina = false){
		$layout = (isset($this->template->layout)) ? $this->template->layout: false;
		$view_pagina = ($pagina) ? VIEW.$pagina.'.php' : VIEW.$_GET['acao'].'.php';

		/// Verifica se a view existe, se nÃ£o existir joga o padrão
		$pagina_final = (file_exists($view_pagina)) ? $view_pagina : 'layout/404.php';	
			
		$this->template = new Template();
		$this->template->layout = ($layout) ? $layout : 'admin';
		$this->template->pagina = $pagina_final;
	}
	
	///Inicia a Classe do Template
	function initTemplatePadrao($pagina){
		$layout = (isset($this->template->layout)) ? $this->template->layout: false;

		switch ($pagina) {
			case 'cadastro':
				$pFinal = FRAMEWORK.'view_padrao/cadastro.php';
			break;
			case 'listar':
				$pFinal = FRAMEWORK.'view_padrao/listar.php';
			break;
		}
		
		/// Verifica se a view existe, se nÃ£o existir joga o padrÃ£o
		$pagina_final = (file_exists($pFinal)) ? $pFinal : 'layout/404.php';	
			
		$this->template = new Template();
		$this->template->layout = ($layout) ? $layout : 'admin';
		$this->template->pagina = $pagina_final;
	}
	
	function exibirTemplate(){
		$this->template->dados = $this->view;
		$this->template->exibirTemplate();
	}
	
	function resultado($string, $tipo){
		$css = 'confirm';
		switch ($tipo){
			case 'erro':
				$class = 'alert-error';
			break;
			case 'sucesso':
				$class = 'alert-success';
			break;
			case 'aviso':
				$class = '';
			break;
			case 'informacao':
				$class = 'alert-info';
			break;
		};

		$dados = array(
			'mensagem' => $string,
			'css' => $class,
			'status'=>1
		);
		
		$this->carregarModulo('resultado');
		$this->resultado->inserirResultado($dados);
	}
	
	
	function capituraResultado(){
		$this->carregarModulo('resultado');
		$dados =  $this->resultado->exibirResultado();
		
		if(count($dados) > 0){
			$_SESSION['resultado'] = $dados[0];
			return true;
		}else{
			return false;
		}
	}

	public function sqlcreate(){
		$model = $_GET['mod'];
		$this->carregarModulo($model);
		
		Persistencia::sqlCreate($this->$model->mapeador(), $model);
		die;
	}
	
	function criarmodulo(){
		$modulo = $_GET['mod'];
		
		$diretorio = getcwd();
		$ponteiro  = opendir($diretorio.'/application/'.$modulo.'/model');
		
		$arrayExcessoes = array(
				'acesso',
				'admin'
		);
		
		while ($nome_itens = readdir($ponteiro)) {
			if($nome_itens != '.' && $nome_itens != '..'){
				$itens[] = str_replace('.php', '', $nome_itens);
			}
		}
		
		$stringSql = '';
		$stringRel = '';
		foreach($itens as $classe){
			$class = new $classe();
			
			$stringSql .= '#Sql da Tabela '.$class->tabela.', Para a Classe:'.$classe.' <br /> ######################################### <br />';
			$stringSql .= Persistencia::sqlCreate($class->mapeador(), $class->tabela, true).';<br /><br />';
			
			if(Persistencia::sqlRelacionamento($class->mapeador(), $class->tabela, true)){
				$stringRel .= '#Sql do Relacionamento da tabela: '.$class->tabela.', Para a Classe:'.$classe.' <br /> ######################################### <br />';
				$stringRel .= Persistencia::sqlRelacionamento($class->mapeador(), $class->tabela, true).';<br /><br />';
			}
		}
		
		echo $stringSql,
			 $stringRel;
		die;
	}
	
	function carregarSubModulo($pasta, $nome_modulo){
		require_once('application/'.$pasta.'/model/'.ucwords($nome_modulo).'.php');
		$this->$nome_modulo = new $nome_modulo();
	}
	
	function carregarModulo($modulo){
		if(is_array($modulo)){
			foreach($modulo as $key => $class){
				
				if($class != $_GET['mod']){
					if(file_exists('application/'.$_GET['mod'].'/model/'.ucwords($class).'.php')){
						$novo_modulo = 'application/'.$_GET['mod'].'/model/'.ucwords($class).'.php';
					}else{
						$novo_modulo = 'application/'.$class.'/model/'.ucwords($class).'.php';
					}
					
					require_once($novo_modulo);
				}
				
				$obj = ucwords($class);
				$this->$class = new $obj;				
			}
		}else{
			
			if($modulo != $_GET['mod']){
				if(file_exists('application/'.$_GET['mod'].'/model/'.ucwords($modulo).'.php')){
					$novo_modulo = 'application/'.$_GET['mod'].'/model/'.ucwords($modulo).'.php';
				}else{
					$novo_modulo = 'application/'.$modulo.'/model/'.ucwords($modulo).'.php';
				}
				require_once($novo_modulo);
			}
			
			$obj = ucwords($modulo);
			$this->$modulo = new $obj;
		}
	}
	
	function excluir(){
		$modulo = $_GET['mod'];
		$this->carregarModulo($modulo);
		if($_SESSION['url']['3']){
			$this->$modulo->salvar(array('status'=>0,'id'=>$_GET['id']));			
		}else{
			$this->$modulo->excluir($_GET['id']);
		}
	}
	
	function get($get=false){
		if($get){
			if(isset($_GET[$get]) && $_GET[$get] != ''){
				return $_GET[$get];
			}else{
				return false;
			}
		}else{
			return $_GET;
		}
	}
	
	function post($post=false){
		if($post){
			if(isset($_GET[$post]) && $_GET[$post] != ''){
				return $_GET[$post];
			}else{
				return false;
			}
		}else{
			return $_POST;
		}
	}

	function postImagem($width=false, $height=false){
		if(isset($_FILES['imagem']) || isset($_POST['old_imagem'])){
			$_POST['imagem'] = uploadResize($_FILES['imagem'], $width, $height);
			if(!$_POST['imagem']){
				$_POST['imagem'] = $_POST['old_imagem'];	
			}
		}
	}
	
	function alteracao(){
		$this->cadastro();
	}
}