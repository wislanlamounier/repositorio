<?php

class taxasController extends DefaultController
{
    public function listar(){
        Util::redirect('taxas/cadastro');
    }

    public function cadastro(){
        parent::cadastro();
    }

    public function salvar(){
        //$this->carregarModulo('contaCorrente');
       	$this->carregarSubModulo('contacorrente', 'contacorrente');
        $this->carregarSubModulo('contacorrente', 'extrato');

        $contaContabil = $_POST['id_conta_contabil'];
        $contaContabilSub = $_POST['id_conta_contabil_sub'];

        if($_POST['id_conta_corrente_de'] != 'Selecione...'){
            $this->contacorrente->credito($_POST['id_conta_corrente_de'], Util::moedaBanco($_POST['valor']), 'Transferência', $this->extrato, 'TC', $contaContabil, $contaContabilSub, $_POST['data']);
            $this->contacorrente->debito($_POST['id_conta_corrente_para'], Util::moedaBanco($_POST['valor']), 'Taxa/Transferência', $this->extrato, 'TD', $contaContabil, $contaContabilSub, $_POST['data']);
            $tipo = 'TC';
        }else{
            $this->contacorrente->debito($_POST['id_conta_corrente_para'], Util::moedaBanco($_POST['valor']), 'Taxa/Transferência', $this->extrato, 'TX', $contaContabil, $contaContabilSub, $_POST['data']);
            unset($_POST['id_conta_corrente_de']);
        }

        $this->taxas->salvar($_POST);

        $this->resultado('Efetuado com sucesso!','sucesso');
        Util::redirect('taxas/listar');
    }
}
