<?php

class Baixa extends Model{
	public $id;
	public $id_parcela;
	public $id_conta_corrente;
	public $valor_pago;
	public $data_pagamento;
	public $juros;
	public $desconto;


	function __construct(){
		$this->tabela = 'conta_pagar_baixa';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_parcela'=>array('id', $this->id_parcela), 
			'id_conta_corrente'=>array('id', $this->id_conta_corrente),
			'valor_pago'=>array('money', 'Valor Pago', array('value'=>$this->valor_pago, 'class'=>'validate[required]')), 
			'data_pagamento'=>array('data', 'Data Pagamento', array('value'=>$this->data_pagamento, 'class'=>'validate[required]')), 
			'juros'=>array('money', 'Juros', array('value'=>$this->juros, 'class'=>'validate[required]')),
			'desconto'=>array('money', 'desconto', array('value'=>$this->desconto, 'class'=>'validate[required]'))

		);
	}
}