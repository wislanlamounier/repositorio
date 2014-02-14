<?php

class Comissao extends Model{
	public $id;
	public $id_lancamento;
	public $pj;
	public $nota_fiscal;
	public $id_tipo_comissao;
	public $valor;
	public $id_forma_pagamento;
	public $data_vencimento;
	public $numero_cheque;
	public $id_banco;
	public $titular_cheque;
	public $status;
	public $id_conta_corrente;
	public $quem_recebeu;
	public $data_recebimento;

    public $devolvido;
    public $data_devolucao;
    public $motivo;
    public $data_reapresentacao;

    public $data_segunda_devolucao;
    public $motivo_segunda_devolucao;

    public $juros;
    public $descontos;

	function __construct(){
		$this->tabela = 'comissao';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'id_lancamento'=>array('id', $this->id_lancamento),
			'status'=>array('id', $this->status),
			'pj'=>array('checkbox', 'PJ', array('class'=>'', 'value'=>$this->pj)),
			'nota_fiscal'=>array('input', 'Nota Fiscal', array('class'=>'', 'value'=>$this->nota_fiscal)),
			'id_tipo_comissao'=>array('select', 'Tipo de Comissão', array( 'class'=>'validate[required]'), Conexao::selectBanco('tipo_comissao'), $this->id_tipo_comissao),
			'valor'=>array('money', 'Valor', array('class'=>'validate[required]', 'value'=>Util::moedaEdit($this->valor))),
			'id_forma_pagamento'=>array('select', 'Forma de Pagamento', array('class'=>'validate[required]'), Conexao::selectBanco('forma_pagamento'), $this->id_forma_pagamento),
			'data_vencimento'=>array('data', 'Data de Vencimento', array('class'=>'validate[required]', 'value'=>DMA($this->data_vencimento))),
			'numero_cheque'=>array('input', 'Número do Cheque', array('class'=>'', 'value'=>$this->numero_cheque)),
			'id_banco'=>array('select', 'Banco', array('class'=>''), Conexao::selectBanco('banco_comissao'), $this->id_banco),
			'titular_cheque'=>array('input', 'Titular Cheque', array('class'=>'', 'value'=>$this->titular_cheque))
		);
	}

	function mapeadorBaixa(){
        return array(
			'id'=>array('id', $this->id),
            'nota_fiscal'=>array('input', 'Nota Fiscal', array('class'=>'', 'value'=>$this->nota_fiscal)),
			'id_lancamento'=>array('id', $_GET['id']),
			'data_recebimento'=>array('data', 'Data de Recebimento', array('class'=>'validate[required]', 'value'=>DMA($this->data_recebimento))),
			'quem_recebeu'=>array('input', 'Quem Recebeu', array('class'=>'', 'value'=>$this->quem_recebeu)),
			'id_conta_corrente'=>array('select', 'Conta Corrente', array('class'=>''), Conexao::selectBanco('conta_corrente'), $this->id_conta_corrente),
            'devolvido'=>array('select','Cheque Devolvido',array(),array('1'=>'Sim','2'=>'Não'), ($this->devolvido) ? $this->devolvido : 'N'),
            'data_devolucao'=>array('data', 'Data de Devolução', array('class'=>'devolvido', 'value'=>DMA($this->data_devolucao))),
            'motivo'=>array('input', 'Motivo Devolução', array('class'=>'devolvido', 'value'=>$this->motivo)),
            'data_reapresentacao'=>array('data', 'Data de Reapresentação', array('class'=>'devolvido', 'value'=>DMA($this->data_reapresentacao))),
            'data_segunda_devolucao'=>array('data', 'Data Segunda Devolução', array('class'=>'segunda_devolucao', 'value'=>DMA($this->data_segunda_devolucao))),
            'motivo_segunda_devolucao'=>array('input', 'Motivo Devolução', array('class'=>'segunda_devolucao', 'value'=>$this->motivo_segunda_devolucao)),
            'juros'=>array('money', 'Juros', array('class'=>'', 'value'=>Util::moedaEdit($this->juros))),
            'descontos'=>array('money', 'Descontos', array('class'=>'', 'value'=>Util::moedaEdit($this->descontos))),
            'valor'=>array('money', 'Valor', array('class'=>'validate[required]', 'value'=>Util::moedaEdit($this->valor)))
		);
	}

	function getStatus($status=false){
		$array = array('Em aberto', 'Aguardando Compensação', 'Pago', 'Devolvido');

		if($status !== false)
			return $array[$status];

		return $array;
	}

	function listarComissoesLancamento($id_lancamento){
		$sql = 'SELECT com.*, pag.nome forma_pagamento, tcom.nome tipo_comissao, banco.nome banco 
				FROM '.$this->tabela.' com
				INNER JOIN forma_pagamento pag ON com.id_forma_pagamento = pag.id
				INNER JOIN tipo_comissao tcom ON tcom.id = com.id_tipo_comissao
				LEFT JOIN banco_comissao banco ON banco.id = com.id_banco
				WHERE com.id_lancamento = '.$id_lancamento;

		return Conexao::listarSql($sql);
	}

    public function relatorioContaReceber($dataInicial, $dataFinal, $cliente, $tipoComissao){
        $dataInicial = \DateTime::createFromFormat('d/m/Y',$dataInicial)->format('Y-m-d');
        $dataFinal = \DateTime::createFromFormat('d/m/Y',$dataFinal)->format('Y-m-d');

        $where = "where lan.data_venda between '".$dataInicial."' AND '".$dataFinal."'";

        if($cliente)
            $where .= 'and pe.id = '.$cliente;

        if($tipoComissao)
            $where .= 'and co.id_tipo_comissao = '.$tipoComissao;

        $sql = 'select lan.data_venda, en.nome empreendimento, pe.nome, lan.empreendimento_numero, lan.empreendimento_bloco, lan.empreendimento_quadra, lan.valor_venda, co.*
                from comissao co
                inner join lancamento lan on lan.id = co.id_lancamento
                inner join pessoa pe on pe.id = lan.id_pessoa
                inner join empreendimento en on en.id = lan.id_empreendimento '.$where.' group by lan.id';

        $dados = Conexao::listarSql($sql);
        return $dados;
    }
}