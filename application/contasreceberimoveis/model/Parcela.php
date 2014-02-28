<?php

class Parcela extends Model{
	public $id;
	public $id_conta_pagar;
	public $numero_parcela;
	public $data_vencimento;
	public $valor;
	public $status;
	public $valor_total;


	function __construct(){
		$this->tabela = 'conta_receber_parcela_imoveis';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_conta_pagar'=>array('id', $this->id_conta_pagar),
			'numero_parcela'=>array('input', 'Número da Parcela', array('value'=>$this->numero_parcela)),
			'data_vencimento'=>array('data', 'Data Vencimento', array('value'=>$this->data_vencimento)),
			'valor'=>array('money', 'Valor', array('value'=>$this->valor)),
			'status'=>array('select','Status', array(''), $this->getStatus(), $this->status),
			'valor_total'=>array('input', 'Valor Total', array('value'=> (!$this->valor_total) ? $this->valor_parcela : $this->valor_total  ,'readonly'=>'readonly','class'=>'pagamento'))
		);
	}

	static function getStatus($status=false){
		$array = array('Em Aberto', 'Pago');

		if($status !== false){
			return $array[$status];
		}

		return $array;
	}

	function verificarContaPaga($id_conta){
		$sql = Persistencia::tabelaSql('', $this->tabela, 'status = 1 AND id_conta_pagar = '.$id_conta);
		return (count(Conexao::listarSql($sql)) == 0) ? false : true;
	}

	function removerParcelas($id_conta){
		$sql = Persistencia::excluir($this->tabela, 'id_conta_pagar', $id_conta);
		return Conexao::execSql($sql);
	}

	function listar($where){
		$sql = 'select parcela.*, pagamento.valor_total, pagamento.id as id_pagamento from conta_receber_parcela_imoveis parcela
				LEFT JOIN conta_receber_pagamento_imoveis pagamento on parcela.id = pagamento.id_parcela
				where '.$where;

		return Conexao::listarSql($sql);
	}
}

