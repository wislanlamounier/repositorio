<?php 

class midiaController extends DefaultController{

	function cadastro(){
		$this->initTemplatePadrao('cadastro');
		parent::cadastro();
	}
	
	function listar(){
		$this->initTemplatePadrao('listar');
		parent::listar();
	}

}