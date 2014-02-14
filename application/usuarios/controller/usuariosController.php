<?php

class usuariosController extends Controller{

	function __construct(){
		parent::__construct();
		
		$this->carregarModulo('usuarios');
	}


	function senha(){
		$this->initTemplate('senha');
		
		$this->usuarios->carregarObjeto($_SESSION['admin']['id']);
		
		$this->view->form = Form::create($this->usuarios->formSenha(), 'usuarios/alterar-senha');
	}
	
	function alterarSenha(){
		$dados = $this->usuarios->retornarObjeto($_POST['id']);
		
		$dados->senha = addslashes(md5($_POST['nova_senha']));
		
		$this->usuarios->salvar($dados);
		
		$this->resultado('Senha Alterada com sucesso', 'sucesso');
		Util::redirect('admin/home');
	}
	
	function dados(){
		$this->initTemplate();
		
		$this->usuarios->carregarObjeto($_SESSION['admin']['id']);
		$this->view->form = Form::create($this->usuarios->formDados(), 'usuarios/alterar-dados-sessao');
	}
	
	function cadastro(){
		$this->initTemplate('dados');
		
		if(isset($_GET['id']) && $_GET['id'] != ''){
			$this->usuarios->carregarObjeto($_GET['id']);
			$this->view->form = Form::create($this->usuarios->formDados(), 'usuarios/alterar-dados-cadastro');
		}else{
			$this->view->form = Form::create($this->usuarios->form, 'usuarios/novo-usuario');
		}
	}
	
	function novousuario(){
		$_POST['senha'] = addslashes(md5($_POST['senha']));
		$this->usuarios->salvar($_POST);
		
		$this->resultado('Usuário Cadastrado com sucesso!', 'sucesso');
		Util::redirect('usuarios/listar');
	}
	
	function alterardadoscadastro(){
		$this->alterardados(false);
	}
	
	function alterardadossessao(){
		$this->alterarDados(true);
	}
	
	function alterardados($home){
		$dados = $this->usuarios->retornarObjeto($_POST['id']);
		
		$dados->nome = $_POST['nome'];
		$dados->login = $_POST['login'];
		$dados->email = $_POST['email'];
		$dados->status = $_POST['status'];
		
		if($home){
			$_SESSION['admin']['nome'] = $_POST['nome'];
		}
		
		$this->usuarios->salvar($dados);
		
		$this->resultado('Dados Atualizados com sucesso', 'sucesso');
		
		$url = ($home) ? 'admin/home' : 'usuarios/listar';
		
		Util::redirect($url);
	}

	function listar(){
		$this->initTemplate();
		
		$this->view->lista = $this->usuarios->listar();
	}

	function home(){
		$this->redirect("usuarios/listar");
	}
	
	function grupos(){
		$this->initTemplate();
		
		$this->carregarModulo('usuarios');
		$this->carregarSubModulo('usuarios', 'grupos');
		
		if(isset($_GET['id']) && $_GET['id']){
			$this->grupos->ler($_GET['id']);
		}
		
		$this->view->form = Form::create($this->grupos->mapeador(), 'usuarios/salvar-grupos');
		$this->view->lista = $this->grupos->listar();
	}
	
	function salvargrupos(){
		$_POST['isAdmin'] = (isset($_POST['isAdmin'])) ? 1 : 0;
		
		$this->carregarModulo('grupos');
		$this->grupos->salvar($_POST);
		Util::redirect('usuarios/grupos');
	}
	
	function salvarpermissoes(){
		debug($_POST);die;
	}
	
	function log(){
		$logs = Log::listarLog();
		
		$this->initTemplate();
		$this->view->lista = $logs;
	}
	
	function logreverter(){
		$log = Log::ler($_POST['codigo']);
		
		$novoLog = array(
				'tabela'=>$log->tabela,
				'tipo_operacao'=>'REVERTER Cod. '.$log->id, 
				'id_usuario'=>$_SESSION['admin']['id'],
				'sql_executado'=>$log->sql_revert,
				'sql_revert'=>$log->sql_executado,
				'data'=>date('Y-m-d'),
				'hora'=>date('H:i:s'));
		
		foreach($novoLog as $chave => $value){
			$chaves[] = $chave;
			$values[] = $value;
		}
		
		/// Salva o Log
		$sql = Persistencia::incluir('log', $chaves, $values);
		Conexao::execSql($sql);
		
		/// Executa o Revert
		Conexao::execSql($log->sql_revert);
	}
	
	function acessos(){
		$this->initTemplate();
		
		$this->carregarModulo('acesso');
		
		$lista = $this->acesso->listar('logado = 1');
		
		$this->view->lista = $lista;
	}
}
