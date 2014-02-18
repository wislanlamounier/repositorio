<?php

class Fisica extends Model
{
	public $id;
	public $id_pessoa;
	public $cpf;
	public $rg;
	public $data_nascimento;
	public $estado_civil;
	public $nome_conjuge;
	public $cpf_conjuge;
	public $email_conjuge;

	function __construct(){
		$this->tabela = 'pessoa_fisica';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_pessoa'=>array('id', $this->id_pessoa),
			'cpf'=>array('cpf', 'CPF', array('class'=>'validate[required]', 'value'=>$this->cpf)),
			'rg'=>array('input', 'RG', array('class'=>'validate[required]', 'value'=>$this->rg)),
			'data_nascimento'=>array('data', 'Data de Nascimento', array('class'=>'validate[required]', 'value'=>DMA($this->data_nascimento))),
			'estado_civil'=>array('select', 'Estado Civil', array('class'=>'validate[required]'), array('Solteiro', 'Casado', 'Divorciado', 'Outros'), $this->estado_civil),
			'nome_conjuge'=>array('input', 'Nome Conjuge', array('class'=>'', 'value'=>$this->nome_conjuge)),
			'cpf_conjuge'=>array('cpf', 'CPF Conjuge', array('class'=>'', 'value'=>$this->cpf_conjuge)),
			'email_conjuge'=>array('input', 'Email Conjuge', array('class'=>'', 'value'=>$this->email_conjuge)),
		);
	}
}