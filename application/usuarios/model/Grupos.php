<?php
class Grupos extends Model{
	public $id;
	public $nome;
	public $isAdmin;

	function __construct(){
		$this->tabela = 'grupos_usuarios';
	}
	
	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Nome', array('class'=>'validate[required]', 'value'=>$this->nome)),
			'isAdmin'=>array('checkbox', 'Super Administrador', array('value'=>$this->isAdmin))
		);
	}
}