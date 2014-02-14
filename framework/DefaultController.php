<?php
/*
 * Classe responsável pelo CRUD padrao do sistema
 * 
 */
class DefaultController extends Controller{
	public static $model;
	
	function __construct(){
		parent::__construct();
		self::$model = $_GET['mod'];
		
		$this->initTemplate();
		$this->carregarModulo(self::$model);
	}
	
	function home(){
		Util::redirect(self::$model."/listar");
	}
	
	function listar(){
		$this->view->lista = $this->{self::$model}->listar();
		$this->template->titulo_pagina = 'Lista';
	}
	
	function cadastro(){
		$this->template->titulo_pagina = 'Cadastro';
		
		if(isset($_GET['id']) && $_GET['id'] != ''){
			$this->{self::$model}->carregarObjeto($_GET['id']);
		}
		
		$this->view->form = Form::create($this->{self::$model}->mapeador(), self::$model."/salvar");
	}

	function alteracao(){
		$this->template->setPagina('cadastro');
		$this->cadastro();	
	}
	
	function salvar(){
		
		if(isset($_FILES['imagem']) || isset($_POST['old_imagem'])){
			$_POST['imagem'] = uploadResize($_FILES['imagem']);
			
			if(!$_POST['imagem']){
				$_POST['imagem'] = $_POST['old_imagem'];	
			}
		}
		
		if(isset($_POST['url'])){
			$_POST['url'] = Util::transformarEmUrl($_POST['nome']);
		}
		
		$this->antesSalvar();

		if($this->{self::$model}->salvar($_POST)){
			$this->depoisSalvar($this->{self::$model}->id);
			$this->resultado('Salvo com Sucesso!', 'sucesso');
		}else{
			$this->resultado('Houve um erro ao executar a operação!!', 'erro');
		}
		
		Util::redirect(self::$model."/listar");
	}

	function antesSalvar(){}

	function depoisSalvar($id){
		if($_POST['id'] == '')
			$_POST['id'] = $id;
	}
	
	function ver(){
		/// implementar depois
	}
	
	function excluir(){
		$this->{self::$model}->excluir($_GET['id']);
		$this->resultado('Excluido com Sucesso!', 'sucesso');
		
		if(isset($_GET['redirect'])){
			Util::redirect(self::$model."/listar");
		}
		die;
	}
}
