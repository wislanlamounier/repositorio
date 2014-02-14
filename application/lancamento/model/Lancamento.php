<?php

class Lancamento extends Model{
	public $id;
	public $id_pessoa;
	public $id_empreendimento;
	public $empreendimento_numero;
	public $empreendimento_bloco;
	public $empreendimento_quadra;
	public $id_centro_custo_final;
	public $id_gerente;
	public $id_corretor;
	public $id_fechamento;
	public $id_midia;
	public $data_venda;
	public $valor_tabela;
	public $valor_venda;
	public $valor_financiamento;
	public $shf;
	public $direto;
	public $terceiro;
	public $observacao;
	public $id_conta_corrente;
	public $id_banco;


	function __construct(){
		$this->tabela = 'lancamento';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_centro_custo_final'=>array('select', 'Centro de Custo', array('class'=>''), Conexao::selectBanco('centro_custo'), $this->id_centro_custo_final),
			'id_pessoa'=>array('select', 'Cliente', array('class'=>'validate[required]'), Conexao::selectBanco('pessoa'), $this->id_pessoa),
			'id_empreendimento'=>array('select', 'Empreendimento', array('class'=>'validate[required]'), Conexao::selectBanco('empreendimento'), $this->id_empreendimento),
			'empreendimento_numero'=>array('input', 'Número', array('class'=>'', 'value'=>$this->empreendimento_numero)),
			'empreendimento_bloco'=>array('input', 'Bloco', array('class'=>'', 'value'=>$this->empreendimento_bloco)),
			'empreendimento_quadra'=>array('input', 'Quadra', array('class'=>'', 'value'=>$this->empreendimento_quadra)),
			'id_gerente'=>array('select', 'Gerente', array('class'=>'validate[required]'), Conexao::selectBanco('pessoa','id_grupo = 2'), $this->id_gerente),
			'id_corretor'=>array('select', 'Corretor', array('class'=>'validate[required]','disabled'=>'disabled'), Conexao::selectBanco('pessoa','id_grupo = 3'), $this->id_corretor),
			'id_fechamento'=>array('select', 'Fechamento', array('class'=>'validate[required]'), Conexao::selectBanco('fechamento'), $this->id_fechamento),
			'id_midia'=>array('select', 'Mídia', array('class'=>'validate[required]'), Conexao::selectBanco('midia'), $this->id_midia),
			'data_venda'=>array('data', 'Data da Venda', array('class'=>'validate[required]', 'value'=>DMA($this->data_venda))),
			'valor_tabela'=>array('money', 'Valor Tabela', array('class'=>'validate[required]', 'value'=>Util::moedaEdit($this->valor_tabela))),
			'valor_venda'=>array('money', 'Valor Venda', array('class'=>'validate[required]', 'value'=>Util::moedaEdit($this->valor_venda))),
			'valor_financiamento'=>array('money', 'Valor Financiamento', array('class'=>'validate[required]', 'value'=>Util::moedaEdit($this->valor_financiamento))),
			'id_banco'=>array('select', 'Banco', array('class'=>'validate[required]'), Conexao::selectBanco('banco_comissao'), $this->id_banco),
			'shf'=>array('checkbox', 'SHF', array('class'=>'', 'value'=>$this->shf)),
			'direto'=>array('checkbox', 'Direto', array('value'=>$this->direto)),
			'terceiro'=>array('checkbox', 'Terceiro', array('value'=>$this->terceiro)),
			'observacao'=>array('editor', 'Observação', array('class'=>''), $this->observacao),
			'anexo'=>array('file','Anexo',array())
		);
	}

	function listar($where = false){
		if($where)
			$where = 'WHERE '.$where;

		$sql =  'SELECT lan.*, lan.id as id_lancamento, pes.*, emp.nome empreendimento FROM lancamento lan 
				 INNER JOIN pessoa pes ON pes.id = lan.id_pessoa
				 INNER JOIN empreendimento emp ON emp.id = lan.id_empreendimento
				 '.$where;
		
		return Conexao::listarSql($sql);

	}


	function getFiltro($id_cliente){
		$sql =  'SELECT lan.*, pes.*, emp.nome empreendimento FROM lancamento lan
				 INNER JOIN pessoa pes ON pes.id = lan.id_pessoa
				 INNER JOIN empreendimento emp ON emp.id = lan.id_empreendimento
				 WHERE lan.id_pessoa = '.$id_cliente;
		return Conexao::listarSql($sql);
	}
}