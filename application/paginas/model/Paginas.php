<?php

class Paginas extends Model{
	public $id;
	public $nome;
	public $url;
	public $conteudo;
	
	function __construct(){
		$this->tabela = 'paginas';
	}
	
	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Nome', array('class'=>'validate[required] span8', 'value'=>$this->nome)),
			'url'=>array('url', $this->url, array()),
			'conteudo'=>array('editor', '', array('class'=>'validate[required] editor span8','style'=>'height:400px;'), $this->conteudo)
		);
	}
	
	function lerUrl($url){
		$sql = Persistencia::tabelaSQL('', $this->tabela, 'url = "'.$url.'"');
		$item = Conexao::lerSql($sql);		
		$this->ler($item->id);
	}
}
