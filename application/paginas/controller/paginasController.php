<?php

class paginasController extends DefaultController{
	
	function __construct(){
		parent::__construct();
	}
	
	function listar(){
		parent::listar();
		$this->initTemplatePadrao('listar');
		
		$this->template->titulo_pagina = 'Lista de Páginas';
	}
	
	function cadastro(){
		parent::cadastro();
		$this->initTemplatePadrao('cadastro');
		
		$mod = (isset($_GET['id'])) ? 'Alteração' : 'Cadastro'; 
		
		$this->template->titulo_pagina = $mod.' de Página';
	}
}
