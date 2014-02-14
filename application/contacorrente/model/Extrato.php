<?php

class Extrato extends Model{
    public $id;
    public $transacao;
    public $id_conta_corrente;
    public $data;
    public $tipo;
    public $valor;
    public $saldo_anterior;
    public $id_conta_contabil;
    public $id_conta_contabil_sub;

    function __construct(){
        $this->tabela = 'conciliacao_bancaria';
    }

    function mapeador(){
        return array(
            'id'=>array('id', $this->id),
            'transacao'=>array('input', 'Transcao', array('class'=>'validate[required]', 'value'=>$this->transacao0)),
            'id_conta_corrente'=>array('id', $this->id_conta_corrente),
            'tipo'=>array('select', array('class'=>'validate[required]'), array('C'=>'Crédito', 'D'=>'Débito'), $this->tipo),
            'valor'=>array('money', 'Valor', array('class'=>'validate[required]', 'value'=> $this->valor)),
            'data'=>array('data', 'Data', array('class'=>'validate[required]', 'value'=> $this->data)),
            'saldo_anterior'=>array('money', 'Saldo Anterior', array('class'=>'validate[required]', 'value'=> $this->saldo_anterior)),
            'id_conta_contabil'=>array('id',$this->id_conta_contabil),
            'id_conta_contabil_sub'=>array('id',$this->id_conta_contabil_sub)
        );
    }

    function extrato($id_conta_corrente){
        return $this->listar('id_conta_corrente = '.$id_conta_corrente.' ORDER BY id ASC');
//        $lista = $this->listar('id_conta_correte = '.$id_conta_corrente);
//        return $lista;
    }
}