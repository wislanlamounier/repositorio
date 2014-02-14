<?php

class Categorias extends Model{
	public $id;
	public $nome;
	public $url;
	
	function __construct(){
		$this->tabela = 'categoria_blog';
		
		$this->form = $this->mapeador();
	}
	
	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Nome', array('class'=>'validate[required]', 'type'=>"text",'value'=>$this->nome)),
			'url'=>array('url', '', array('value'=>$this->url)),
		);
	}
	
	static function retornarCategorias($item){
		$sql = Persistencia::tabelaSQL('', 'categorias_'.$item, '');
		return Conexao::listarSql($sql);
	}
}