<?php

class Cliente extends Model
{
	public $id;
	public $id_pessoa;
	public $empregador;
	public $profissao;
	public $observacao;

	function __construct(){
		$this->tabela = 'pessoa_cliente';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_pessoa'=>array('id', $this->id_pessoa),
			'empregador'=>array('input', 'Empregador', array('class'=>'validate[required]', 'value'=>$this->empregador)),
			'profissao'=>array('input', 'Profissao', array('class'=>'validate[required]', 'value'=>$this->profissao)),
			'observacao'=>array('editor', 'Observação', array('class'=>'validate[required]'), $this->observacao)
		);
	}
}