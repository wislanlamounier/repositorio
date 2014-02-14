<?php

class Taxas extends Model
{
    public $id;
    public $id_conta_corrente_de;
    public $id_conta_corrente_para;
    public $id_conta_contabil;
    public $id_conta_contabil_sub;
    public $valor;
    public $data;

    function __construct(){
        $this->tabela = 'taxas';
    }

    function mapeador(){
        return array(
            'id'=>array('id', $this->id),
            'data'=>array('data', 'Data', array('class'=>'validate[required]', 'value'=>DMA($this->data))),
            'id_conta_corrente_para'=>array('select', 'Conta Corrente', array('class'=>'validate[required]'), Conexao::selectBanco('conta_corrente'), $this->id_conta_corrente_para),
            'id_conta_contabil'=>array('select', 'Conta Contábil', array('class'=>'validate[required]'), Conexao::selectBanco('conta_contabil'), $this->id_conta_contabil),
            'id_conta_contabil_sub'=>array('select', 'Sub Conta Contábil', array( 'disabled'=>'disabled', 'class'=>'validate[required]'), Conexao::selectBanco('conta_contabil_sub'), $this->id_conta_contabil_sub),
            'valor'=>array('money', 'Valor', array('class'=>'validate[required]', 'value'=>$this->valor_total)),
            'id_conta_corrente_de'=>array('select', 'Conta Corrente (Transferência)', array('class'=>''), Conexao::selectBanco('conta_corrente'), $this->id_conta_corrente_de)
        );
    }
}