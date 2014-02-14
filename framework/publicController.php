<?php

/// Classe Controller para uso sem Autenticacao
class publicController extends Controller{
	
	function __construct(){
		/// Define a Autenticação como False
		$this->autenticacao = false;
		
		/// Constroi a classe controller
		parent::__construct();
	}
}