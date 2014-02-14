<?php

class Tbancaria extends Model{
	public $id;
	public $id_centro_custo;
	public $id_conta_corrente;
	public $id_conta_contabil;
	public $id_conta_contabil_sub;
	public $data;
	public $valor;

	function __construct(){
		$this->tabela = 'transacao_bancaria';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_centro_custo'=>array('select', 'Centro de Custo', array('class'=>'validate[required]'), Conexao::selectBanco('centro_custo'), $this->id_centro_custo),
			'id_conta_corrente'=>array('select', 'Conta Corrente', array('class'=>'validate[required]'), Conexao::selectBanco('conta_corrente'), $this->id_conta_corrente),
			'id_conta_contabil'=>array('select', 'Conta Contábil', array('class'=>'validate[required]'), Conexao::selectBanco('conta_contabil'), $this->id_conta_contabil),
			'id_conta_contabil_sub'=>array('select', 'Sub Conta Contábil', array( 'disabled'=>'disabled', 'class'=>'validate[required]'), Conexao::selectBanco('conta_contabil_sub'), $this->id_conta_contabil_sub),
			'data'=>array('data', 'Data', array('class'=>'validate[required]', 'value'=>DMA($this->data))),
			'valor'=>array('money', 'Valor', array('class'=>'validate[required]', 'value'=>Util::moedaEdit($this->valor)))
		);
	}

	function listar($where = false){
		$sql = 'SELECT tb.*, cc.nome centro_de_custo, conta.nome as conta, contac.nome as contac, contasub.nome as contas
				FROM transacao_bancaria tb
				INNER JOIN centro_custo cc ON cc.id = tb.id_centro_custo
				INNER JOIN conta_corrente conta ON conta.id = tb.id_conta_corrente
				INNER JOIN conta_contabil contac ON contac.id = tb.id_conta_contabil
				INNER JOIN conta_contabil_sub contasub ON contasub.id = tb.id_conta_contabil_sub';

		return Conexao::listarSql($sql);
	}

}