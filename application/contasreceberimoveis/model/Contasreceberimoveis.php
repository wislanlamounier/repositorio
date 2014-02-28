<?php

class Contasreceberimoveis extends Model{
	public $id;
	public $id_pessoa;
	public $id_conta_contabil;
	public $id_conta_contabil_sub;
	public $id_tipo_documento;
	public $numero_documento;
	public $data_emissao;
	public $valor_total;
	public $numero_custo;
	public $id_centro_custo_final;
	public $data_conta_pagar;
	public $total_parcelas;
	public $ordem_de_compra;
	public $rateio;
	
	function __construct(){
		$this->tabela = 'conta_receber_imoveis';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_pessoa'=>array('select', 'Fornecedor', array('class'=>'validate[required]'), Conexao::selectBanco('pessoa'), $this->id_pessoa),
			'id_conta_contabil'=>array('select', 'Conta Contábil', array('class'=>'validate[required]'), Conexao::selectBanco('conta_contabil'), $this->id_conta_contabil),
			'id_conta_contabil_sub'=>array('select', 'Sub Conta Contábil', array( 'disabled'=>'disabled', 'class'=>'validate[required]'), Conexao::selectBanco('conta_contabil_sub'), $this->id_conta_contabil_sub),
			'id_tipo_documento'=>array('select', 'Tipo de Documento', array('class'=>'validate[required]'), Conexao::selectBanco('tipo_documento'), $this->id_tipo_documento),
			'numero_documento'=>array('input', 'Número do Documento', array('class'=>'validate[required]', 'value'=>$this->numero_documento)),
			'data_emissao'=>array('data', 'Data de Emissão', array('class'=>'validate[required]', 'value'=>DMA($this->data_emissao))),
			'valor_total'=>array('money', 'Valor Total', array('class'=>'validate[required]', 'value'=>$this->valor_total)),
			'rateio'=>array('checkbox', 'Rateio', array('class'=>'', 'value'=>$this->rateio)),
			'id_centro_custo_final'=>array('select', 'Centro de Custo', array('class'=>''), Conexao::selectBanco('centro_custo'), $this->id_centro_custo_final),
			'data_conta_pagar'=>array('data', 'Data da Conta a pagar', array('class'=>'validate[required]', 'value'=>DMA($this->data_conta_pagar))),
			'total_parcelas'=>array('input', 'Total de Parcelas', array('class'=>'validate[required]', 'value'=>$this->total_parcelas)),
			'ordem_de_compra'=>array('input', 'Ordem de Compra', array('class'=>'', 'value'=>$this->ordem_de_compra)),
			'anexo'=>array('file','Anexo',array())
		);
	}

	function listar(){
		$sql =  'select 
				(select count(sub.id_conta_pagar) from conta_receber_parcela_imoveis sub where sub.id_conta_pagar = conta.id) as quantidade,
				(select count(sub.id_conta_pagar) from conta_receber_parcela_imoveis sub where sub.id_conta_pagar = conta.id AND sub.id IN (
				select pag.id_parcela from conta_receber_pagamento_imoveis pag
				inner join conta_receber_parcela_imoveis par on par.id = pag.id_parcela
				where par.id_conta_pagar = conta.id)) as pagas, 
				conta.*, pes.nome
				from conta_receber_imoveis conta
				inner join pessoa pes on pes.id = conta.id_pessoa';
		//debug($sql);
				
		return Conexao::listarSql($sql);
	}
}