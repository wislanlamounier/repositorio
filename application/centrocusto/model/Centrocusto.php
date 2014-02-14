<?php

class Centrocusto extends Model{
	public $id;
	public $nome;
	public $razao_social;
	public $cnpj;
	public $inscricao_estadual;
	public $isencao;

	function __construct(){
		$this->tabela = 'centro_custo';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Nome', array('class'=>'validate[required]', 'value'=>$this->nome)),
			'razao_social'=>array('input', 'Razão Social', array('class'=>'validate[required]', 'value'=>$this->razao_social)),
			'cnpj'=>array('cnpj', 'CNPJ', array('class'=>'validate[required]', 'value'=>$this->cnpj)),
			'inscricao_estadual'=>array('input', 'Inscrição Estadual', array('class'=>'validate[required]', 'value'=>$this->inscricao_estadual)),
			'isencao'=>array('input', 'Isenção', array('class'=>'validate[required]', 'value'=>$this->isencao))
		);
	}
}