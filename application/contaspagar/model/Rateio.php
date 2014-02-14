<?php

class Rateio extends Model{
	public $id;
	public $id_conta_pagar;
	public $id_centro_custo;
	
	function __construct(){
		$this->tabela = 'conta_pagar_rateio';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_conta_pagar'=>array('id', $this->id_conta_pagar),
			'id_centro_custo'=>array('id', $this->id_centro_custo)
		);
	}
}