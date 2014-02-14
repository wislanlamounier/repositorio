<?php

class Pagamento extends Model{
	public $id;
	public $id_parcela;
	public $id_conta_corrente;
	public $valor_parcela;
	public $data_pagamento;
	public $juros;
	public $desconto;
	public $valor_total;
	public $id_forma_pagamento;
	public $numero_cheque;

	public $data_vencimento;


	function __construct(){
		$this->tabela = 'conta_pagar_pagamento';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_parcela'=>array('id', $this->id_parcela),
			'id_conta_corrente'=>array('select', 'Conta Corrente', array('class'=>'validate[required]'), Conexao::selectBanco('conta_corrente'), $this->id_conta_corrente),
			'id_forma_pagamento'=>array('select', 'Forma de Pagamento', array('class'=>'validate[required]'), Conexao::selectBanco('forma_pagamento'), $this->id_forma_pagamento),
			'numero_cheque'=>array('input', 'Número do Cheque', array('value'=>$this->numero_cheque, 'readonly'=>'readonly')),
			'data_vencimento'=>array('data', 'Data de Vencimento', array('value'=>$this->data_vencimento)),
			'data_pagamento'=>array('data', 'Data de Pagamento', array('value'=>$this->data_pagamento)),
			'juros'=>array('money', 'Juros', array('value'=>$this->juros,'class'=>'juros')),
			'desconto'=>array('money', 'Desconto', array('value'=>$this->desconto,'class'=>'desconto')),
			'valor_parcela'=>array('input', 'Valor da Parcela', array('value'=>$this->valor_parcela,'class'=>'parcela')),
			'valor_total'=>array('input', 'Valor Total', array('value'=> (!$this->valor_total) ? $this->valor_parcela : $this->valor_total  ,'readonly'=>'readonly','class'=>'pagamento'))
			
		);
	}

	static function efetuar($valor, $id_conta){
		$sql = 'select * from conta_corrente where id = '.$id_conta;
		$conta = Conexao::lerSql($sql);

		if(!$conta->id){
			return false;
		}

		$valorAtualizado = $conta->saldo - $valor;
		$sql = 'UPDATE conta_corrente SET saldo = '.$valorAtualizado.' WHERE id = '.$conta->id;
		return Conexao::execSql($sql);
	}

	function carregarView($id_pagamento){
		$sql = 'select (select count(sub.id_conta_pagar) from conta_pagar_parcela sub where sub.id_conta_pagar = parcela.id_conta_pagar) as quantidade,
			   		    pagamento.*, corrente.*, f.nome nome_forma_pagamento, pes.nome nome_conta, parcela.numero_parcela from conta_pagar_pagamento pagamento
				inner join conta_pagar_parcela parcela on parcela.id = pagamento.id_parcela
				inner join conta_pagar conta on conta.id = parcela.id_conta_pagar
				inner join conta_corrente corrente on pagamento.id_conta_corrente = corrente.id
				inner join pessoa pes on pes.id = conta.id_pessoa
				inner join forma_pagamento f on f.id = id_forma_pagamento
				where pagamento.id = '.$id_pagamento;

		return Conexao::lerSql($sql);
	}
}