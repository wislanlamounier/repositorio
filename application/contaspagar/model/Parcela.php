<?php

class Parcela extends Model{
	public $id;
	public $id_pessoa;
	public $id_conta_pagar;
	public $numero_documento;
	public $valor_total;
	public $numero_parcela;
	public $data_vencimento;
	public $valor;
	public $status;


	function __construct(){
		$this->tabela = 'conta_pagar_parcela';
		
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_pessoa'=>array('select', 'Fornecedor', array('class'=>'validate[required]'), Conexao::selectBanco('id_pessoa'), $this->id_pessoa),
			'numero_documento'=>array('input', 'Número do Documento', array('class'=>'validate[required]', 'value'=>$this->numero_documento)),
			'valor_total'=>array('money', 'Valor Total', array('class'=>'validate[required]', 'value'=>$this->valor_total)),
			'id_conta_pagar'=>array('id', $this->id_conta_pagar),
			'numero_parcela'=>array('input', 'Número da Parcela', array('value'=>$this->numero_parcela)),
			'data_vencimento'=>array('data', 'Data Vencimento', array('value'=>$this->data_vencimento)),
			'valor'=>array('money', 'Valor', array('value'=>$this->valor)),
			'status'=>array('select','Status', array(''), $this->getStatus(), $this->status)
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
		$sql = 'select conta.valor_total, conta.numero_documento, pes.nome, conta.id, parcela. * , pagamento.id AS id_pagamento, pagamento.valor_total
				FROM conta_pagar_parcela parcela
				LEFT JOIN conta_pagar_pagamento pagamento ON parcela.id = pagamento.id_parcela
				INNER JOIN conta_pagar AS conta ON conta.id = id_conta_pagar
				INNER JOIN pessoa AS pes ON pes.id = conta.id_pessoa
				WHERE '.$where;
			//debug($sql);

		//$sql = 'select parcela.*, pagamento.id as id_pagamento from conta_pagar_parcela parcela
		//		LEFT JOIN conta_pagar_pagamento pagamento on parcela.id = pagamento.id_parcela
		//		where '.$where;


		return Conexao::listarSql($sql);
	}
}

