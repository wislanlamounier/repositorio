<?php

class Template extends Html{
	public $layout;
	public $fullPage = false;
	public $description = '';
	public $keywords = '';
	public $pagina;
	public $titulo_pagina = '';
	
	public $dados;
	
	function __construct(){
		/// Seta a Variavel que ira conter os dados
		$this->dados = new Colecao();
		
		/// Seta as Variaveis para SEO
		$this->keywords = KEYWORDS;
		$this->description = DESCRIPTION;
	}
	
	function exibirTemplate(){
		$colecao = $this->dados;
		$pagina = $this->pagina;
		
		$template = 'layout/'.$this->layout.'/template.php';
		
		if($this->fullPage){
			include_once($pagina);
		}else{
			include_once($template);
		}
	}
	
	function setPagina($pagina){
		$this->pagina = VIEW.$pagina.'.php';
	}
	
	function layoutPatch(){
		echo BASEURL.'/layout/'.$this->layout;
	}
	
	function breadcrumbs(){
		$mod = ucfirst($_GET['mod']);
		$acao = ucfirst($_GET['acao']);
		
		$string = '<li><a href="'.$this->url('admin/home', true).'"><i class="icon-home"></i></a></li>
                    <li><a href="'.$this->url($_GET['mod'].'/home', true).'">'.$mod.'</a></li>
                    <li><a href="'.$this->url($_GET['mod'].'/'.$_GET['acao'], true).'">'.$acao.'</a></li>';
		
		echo $string;
	}
}
