<?php

class Contaspagar extends Model{
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
		$this->tabela = 'conta_pagar';
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

	function listar($where=''){
		$sql =  'select 
				(select count(sub.id_conta_pagar) from conta_pagar_parcela sub where sub.id_conta_pagar = conta.id) as quantidade, 
				(select count(sub.id_conta_pagar) from conta_pagar_parcela sub where sub.id_conta_pagar = conta.id AND sub.id IN (
				select pag.id_parcela from conta_pagar_pagamento pag
				inner join conta_pagar_parcela par on par.id = pag.id_parcela
				where par.id_conta_pagar = conta.id)) as pagas, 
				conta.*, pes.nome
				from conta_pagar conta
				inner join pessoa pes on pes.id = conta.id_pessoa';
				
		return Conexao::listarSql($sql);
	}

    function relatorio($dataInicial,$dataFinal,$fornecedor,$baixados){
        $dataInicial = \DateTime::createFromFormat('d/m/Y',$dataInicial)->format('Y-m-d');
        $dataFinal = \DateTime::createFromFormat('d/m/Y',$dataFinal)->format('Y-m-d');

        $where = "where cp.data_conta_pagar between '".$dataInicial."' AND '".$dataFinal."'";

        if($fornecedor)
            $where .= 'and id_pessoa = '.$fornecedor;

        $sql = 'select pessoa.nome fornecedor, centro_custo.nome,cp.*,
                (select count(id) from conta_pagar_parcela cpp where cpp.id_conta_pagar = cp.id and cpp.id not in(select id_parcela from conta_pagar_baixa)) as parcelas
                from conta_pagar cp
                INNER JOIN pessoa ON cp.id_pessoa = pessoa.id
                INNER JOIN centro_custo ON cp.id_centro_custo_final = centro_custo.id '.$where;

        $dados = Conexao::listarSql($sql);

        $tratado = array();
        if($baixados == 1){ /// somente baixados
            foreach($dados as $item){
                if($item->parcelas == 0) $tratado[] = $item;
            }
        }else{
            $tratado = $dados;
        }

        return $tratado;
    }
}