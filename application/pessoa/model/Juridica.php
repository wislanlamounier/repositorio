<?php

class Juridica extends Model
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
		$this->tabela = 'pessoa_juridica';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_pessoa'=>array('id', $this->id_pessoa),
			'razao_social'=>array('input', 'Razão Social', array('class'=>'validate[required]', 'value'=>$this->razao_social)),
			'cnpj'=>array('cnpj', 'CNPJ', array('class'=>'validate[required]', 'value'=>$this->cnpj)),
			'inscricao_estadual'=>array('input', 'Inscrição Estadual', array('class'=>'validate[required]', 'value'=>$this->inscricao_estadual))		);
	}
}