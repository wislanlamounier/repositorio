<?php

class menuController extends DefaultController{
	function __construct(){
		parent::__construct();
		$this->carregarModulo('menu');
	}

	function home(){
		Util::redirect("menu/listar");
	}

	function cadastrar(){
		$_POST['icone'] = uploadResize($_FILES['icone'], 14);
		
		if($_POST['icone'] == '0'){
			$_POST['icone'] = $_POST['old_imagem'];
		}
		unset($_POST['old_imagem']);

		$this->menu->salvar($_POST);
		
		$this->resultado('Realizado com Sucesso!', 'sucesso');
		Util::redirect('menu/listar');
	}
	
	function excluir(){
		$this->menu->excluir($_GET['id']);
		$this->resultado('Excluido com Sucesso!', 'sucesso');
		die;
		Util::redirect('menu/listar');
	}
	
	function cadastro(){
		$this->initTemplate('cadastro');
		$this->template->titulo_pagina = 'Cadastro de Menu';
		
		if(isset($_GET['id']) && $_GET['id'] != ''){
			$obj = $this->menu->retornarObjeto($_GET['id']);
			$this->menu->setValores($obj);
		}
		
		$this->view->form = Form::create($this->menu->form, 'menu/cadastrar');
	}
	
	function listar(){
		$this->initTemplate();
		$this->template->titulo_pagina = 'Lista de Menu';
		
		if(isset($_GET['id']) && $_GET['id'] != ''){
			$obj = $this->menu->carregar($_GET['id']);
			$this->menu->setValores($obj);
		}
		
		$lista = $this->menu->listar();
		
		$dados =$this->menu->listar();
		
		$this->view->form = Form::create($this->menu->form, 'menu/cadastrar');
		$this->view->lista = $this->menu->listar();
	}
}