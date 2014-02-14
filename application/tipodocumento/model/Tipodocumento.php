<?php

class Tipodocumento extends Model{
	public $id;
	public $nome;

	function __construct(){
		$this->tabela = 'tipo_documento';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Nome', array('class'=>'validate[required]', 'value'=>$this->nome))

		);
	}
}