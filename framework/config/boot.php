<?php
require_once('framework/config/functions.php'); 	/// INCLUI O ARQUIVO DE FUNÇÕES
require_once('framework/config/url.php');           /// GERENCIA AS URLS SETANDO O BASEURL
require_once('framework/config/acl.php');           /// INCLUI O ARQUIVO DE PERMISSAO
require_once('framework/config/globals.php');   	/// INCLUI O ARQUIVO GLABAL (CONSTANTES)

function __autoload($classe){
	/// Verifica se Existe na pasta Models do Modulo
	if(file_exists(MODEL."{$classe}.php")){
        include_once(MODEL."{$classe}.php");
	}else 
	
	/// Verifica se Existe na pasta Controller do Modulo
	if(file_exists(CONTROLLER."{$classe}.php")){
		include_once(CONTROLLER."{$classe}.php");
	}else 
	
	/// Verifica se Existe na Pasta Framework
	if(file_exists(FRAMEWORK."{$classe}.php")){
		include_once(FRAMEWORK."{$classe}.php");
	}else 
	
	/// Verifica se Existe na pasta LIB
	if(file_exists(LIB."{$classe}.php")){
		include_once(LIB."{$classe}.php");
	}else
		
	/// Encontra a Model dentro da pasta APP nome da Classe	
	if(file_exists('application/'.strtolower($classe).'/model/'.$classe.'.php')){
		include_once('application/'.strtolower($classe).'/model/'.$classe.'.php');
	}else{
        $class = str_replace(".","/",$classe);
        $class = strtolower($class.'.php');
        include_once($class);
    }

}