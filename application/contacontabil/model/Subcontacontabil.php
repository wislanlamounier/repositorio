<?php

class Subcontacontabil extends Model{
	public $id;
	public $id_conta;
	public $nome;

	function __construct(){
		$this->tabela = 'conta_contabil_sub';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Nome', array('class'=>'validate[required]', 'value'=>$this->nome)),
			'id_conta'=>array('select', 'Conta Contabil', array('class'=>'validate[required]'), Conexao::selectBanco('conta_contabil'), $this->id_conta),
		);
	}
}