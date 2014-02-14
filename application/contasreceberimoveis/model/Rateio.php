<?php

class Rateio extends Model{
	public $id;
	public $id_conta_pagar;
	public $id_centro_custo;
	
	function __construct(){
		$this->tabela = 'conta_receber_rateio_imoveis';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_conta_pagar'=>array('id', $this->id_conta_pagar),
			'id_centro_custo'=>array('id', $this->id_centro_custo)
		);
	}
}