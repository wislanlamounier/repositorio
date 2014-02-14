<?php

class categoriasController extends Controller{
	function __construct(){
		parent::__construct();
		
		$this->carregarModulo('categorias');
	
		$this->categorias->tabela = 'categoria_'.$_GET['acao'];
		$this->pagina = 'listar';
	}

	function pessoa(){
		$this->exibirTela();
	}
	
	function usuarios(){
		$this->exibirTela();
	}
	
	function cadastrar(){
		$this->categorias->tabela = 'categoria_'.$_GET['id'];
		$_POST['url'] = Util::transformarEmUrl($_POST['nome']);
		$this->categorias->salvar($_POST);
		$this->resultado('Efetuado com Sucesso', 'sucesso');
		Util::redirect('categorias/'.$_GET['id']);
	}
	
	function excluir(){
		$this->categorias->tabela = 'categoria_'.$_GET['id'];
		$id = $_SESSION['url'][3];
		
		$this->categorias->excluir($id);
		$this->resultado('Excluido com Sucesso!', 'sucesso');
		die;
	}
	
	function listar(){
		Util::redirect('categorias/'.$_GET['id'].'/'.$_SESSION['url']['3']);
	}
	
	function exibirTela(){
		$this->initTemplate('listar');
		$id = (isset($_GET['id'])) ? $_GET['id'] : false;
		$this->retornaListagem($id);
	}
	
	function retornaListagem($id = false){
		if(isset($id) && $id != ''){
			$obj = $this->categorias->carregarObjeto($id);
		}
		
		$lista = $this->categorias->listar();
		
		$this->view->form  = Form::create($this->categorias->form, "categorias/cadastrar/".$_GET['acao']);
		$this->view->lista = $this->categorias->listar();
	}
}
