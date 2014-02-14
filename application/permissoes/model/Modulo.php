<?php 

class Modulo extends Model{
	public $id;
	public $nome;
	public $descricao;
	
	function __construct(){
		$this->tabela = 'permissoes_modulo';
	}
	
	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Nome', array('value'=>$this->nome, 'class'=>'validate[required] validar-unico','data-valida'=>$this->tabela)),
			'descricao'=>array('input', 'Descrição', array('value'=>$this->descricao))			
		);
	}
}