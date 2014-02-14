<?php
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');

ini_set('display_errors', false);
ini_set('display_startup_errors',1);
error_reporting(-1);
session_start();
ob_start();

/// Abre a sessao de request
if(!isset($_SESSION['cod_sessao'])){
	$_SESSION['cod_sessao'] = md5(date('Y-m-d H:i:s'));
}

/// Arquivos do framework
require_once('framework/config/boot.php');

Cache::init($_SERVER['REQUEST_URI']);

try{
	/// Verifica se existe o modulo
	if(file_exists('application/'.$_GET['mod'])){ 
		$mod = $_GET['mod'].'Controller';
	
		/// Verifica se Existe o Controller
		if(file_exists(CONTROLLER.$mod.'.php')){
			$modulo = new $mod();
			Executer::executar($modulo, $_GET['acao']);
		}else{
			throw new Exception('<strong>Erro:</strong> A Controller Nao Existe!');
		};
	}else if(Conexao::rowCount('SELECT * FROM cliente_usuario WHERE login = "'.addslashes($_GET['mod']).'"')){
		header('Location: '.BASEURL.'/site/cadastro/'.$_GET['mod']);
	}else{
		throw new Exception('<strong>Erro:</strong> O Modulo solicitado nao existe!');
	}
}catch(Exception $e){
	debug($e);
	die;
}
