<?php

class Contacorrente extends Model{
	public $id;
	public $nome;
	public $agencia;
	public $conta_corrente;
	public $saldo;

	function __construct(){
		$this->tabela = 'conta_corrente';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Banco', array('class'=>'validate[required]', 'value'=>$this->nome)),
			'agencia'=>array('input', 'Agencia', array('class'=>'validate[required]', 'value'=>$this->agencia)),
			'conta_corrente'=>array('input', 'Conta Corrente', array('class'=>'validate[required]', 'value'=> $this->conta_corrente)),
			'saldo'=>array('money', 'Saldo', array('class'=>'validate[required]', 'value'=> $this->saldo))
		);
	}

	function credito($id_conta_corrente, $valor, $conciliacao='Crédito', $ext,$transacao='C', $contaContabil='', $contaContabilSub='',$data=false){
		$conta = $this->retornarObjeto($id_conta_corrente);
		$valor_atualizado = $conta->saldo + $valor;

		if(!$conta->id)
			return false;

        /// Adiciona na tabela extrato
        $extrato['transacao'] = $conciliacao;
        $extrato['id_conta_corrente'] = $id_conta_corrente;
        $extrato['tipo'] = $transacao;
        $extrato['saldo_anterior'] = $conta->saldo;
        $extrato['valor'] = $valor;
        $extrato['data'] = (!$data) ? date('d/m/Y H:m:i') : $data; 
        $extrato['id_conta_contabil'] = $contaContabil;
        $extrato['id_conta_contabil_sub'] = $contaContabilSub;

        $this->salvar(array('id'=>$conta->id, 'saldo'=>$valor_atualizado));
        $ext->salvar($extrato);
	}

	function debito($id_conta_corrente, $valor, $conciliacao='Débito', $ext, $transacao='D', $contaContabil='', $contaContabilSub='',$data=false){
        $conta = $this->retornarObjeto($id_conta_corrente);
        $valor_atualizado = $conta->saldo - $valor;

        if(!$conta->id)
            return false;

        /// Adiciona na tabela extrato
        $extrato['transacao'] = $conciliacao;
        $extrato['id_conta_corrente'] = $id_conta_corrente;
        $extrato['tipo'] = $transacao;
        $extrato['saldo_anterior'] = $conta->saldo;
        $extrato['valor'] = $valor;
        $extrato['data'] = (!$data) ? date('d/m/Y H:m:i') : $data; 
        $extrato['id_conta_contabil'] = $contaContabil;
        $extrato['id_conta_contabil_sub'] = $contaContabilSub;

        $this->salvar(array('id'=>$conta->id, 'saldo'=>$valor_atualizado));
        $ext->salvar($extrato);

	}

	function extrato($id_conta_corrente){
        $ext = new Extrato();
        return $ext->extrato($id_conta_corrente);
	}
}