<?php

class Contrato extends Model{
	public $id;
	public $id_lancamento;
	public $gerado_por;
	public $data_contrato;
	public $gerente_contrato;
	public $data_assinatura;
	public $data_gerente;
	public $data_banco;

	function __construct(){
		$this->tabela = 'contrato';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_lancamento'=>array('id', $this->id_lancamento),
			'gerado_por'=>array('input', 'Gerado por', array('class'=>'', 'value'=>$this->gerado_por)),
			'data_contrato'=>array('data', 'Data do Contrato', array('class'=>'', 'value'=>DMA($this->data_contrato))),
			'data_gerente'=>array('data', 'Data de Entrega Gerente', array('class'=>'', 'value'=>DMA($this->data_gerente))),
			'data_assinatura'=>array('data', 'Data da Assinatura', array('class'=>'', 'value'=>DMA($this->data_assinatura))),
			'data_banco'=>array('data', 'Data de Assinatura com Banco', array('class'=>'', 'value'=>DMA($this->data_banco))),
			'gerente_contrato'=>array('input', 'Gerente do Contrato', array('class'=>'', 'value'=>$this->gerente_contrato)),
			'anexo'=>array('file', 'Anexo', array('class'=>''))

		);
	}
}