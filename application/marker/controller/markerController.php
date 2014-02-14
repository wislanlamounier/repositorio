<?php 

class markerController extends DefaultController{
	
	function listar(){
		$this->initTemplatePadrao('listar');
		parent::listar();
	}

	function cadastro(){
		$this->initTemplatePadrao('cadastro');
		parent::cadastro();
	}
}