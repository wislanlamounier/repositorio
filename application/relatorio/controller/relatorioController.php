<?php

class relatorioController extends DefaultController{
    public function listar(){
        $this->carregarModulo(array('pessoa','tipocomissao'));
		$this->carregarSubModulo('contacorrente','contacorrente');
        $contas = $this->contacorrente->listar();
        $this->view->fornecedor = $this->pessoa->listar();
        $this->view->tipoComissao = $this->tipocomissao->listar();
        $this->view->contasCorrente = $contas;
    }

    public function dados(){
        try{
           $tipoRelatorio = $_POST['tipoRelatorio'];
           $this->{'gerarRelatorio'.$tipoRelatorio}($_POST);

        }catch (Exception $e){
            $this->resultado($e->getMessage(), 'erro');
            Util::redirect('relatorio/listar');
        }
    }

    public function gerarRelatoriocontas_pagar($post){
        $dataInicial = $post['contas_pagar']['dataInicial'];
        $dataFinal = $post['contas_pagar']['dataFinal'];

        if(!$dataInicial || !$dataFinal)
            throw new Exception('Digite as datas');

        $this->carregarModulo('contaspagar');
        $dados = $this->contaspagar->relatorio($dataInicial, $dataFinal, $post['contas_pagar']['fornecedor'],$post['contas_pagar']['baixados']);

        $this->view->dados = $dados;
        $this->template->setPagina('contas_pagar');
    }

    public function gerarRelatoriocontas_receber($post){
        $dataInicial = $post['contas_receber']['dataInicial'];
        $dataFinal = $post['contas_receber']['dataFinal'];

        if(!$dataInicial || !$dataFinal)
            throw new Exception('Digite as datas');

        $this->carregarModulo('comissao');
        $dados = $this->comissao->relatorioContaReceber($dataInicial, $dataFinal, $post['contas_receber']['cliente'],$post['contas_receber']['tipo_comissao']);

        $this->view->dados = $dados;
        $this->template->setPagina('contas_receber');
    }

    public function gerarRelatorioConciliacao($post){
        $dataInicial = $post['conciliacao']['dataInicial'];
        $dataFinal = $post['conciliacao']['dataFinal'];
        $contaCorrente = $post['contaCorrente'];

        $this->carregarModulo(array('relatorio'));
		$this->carregarSubModulo('contacorrente','contacorrente');
        $dados = $this->relatorio->gerarRelatorioConciliacao($dataInicial, $dataFinal, $contaCorrente);
		
        $this->view->dados = $dados;
        $this->view->contaCorrente = $this->contacorrente->retornarObjeto($contaCorrente);

        $this->template->setPagina('conciliacao');
    }

    public function gerarRelatorioGeral($post){
        $mapaLabelContas = array();
        $this->carregarModulo(array('relatorio','contacontabil'));
        $this->carregarSubModulo('contacontabil','subcontacontabil');
		$this->carregarSubModulo('contacorrente','contacorrente');

        $contasCorrentes = $this->contacorrente->listar();
        foreach($contasCorrentes as $item){
            $mapaLabelContas['contaCorrente'][$item->id] = $item->nome;
        }

        $contasContabeis = $this->contacontabil->listar();
        foreach($contasContabeis as $item){
            $mapaLabelContas['contaContabil'][$item->id] = $item->nome;
        }

        $subContasContabeis = $this->subcontacontabil->listar();
        foreach($subContasContabeis as $item){
            $mapaLabelContas['subconta'][$item->id] = $item->nome;
        }

        $dados = $this->relatorio->gerarRelatorioGeral($post['mes'],$post['ano'], $contasCorrentes, $subContasContabeis);
        $this->view->dados = $dados;

        $this->view->mapaLegenda = $mapaLabelContas;

        $this->template->setPagina('geral');

    }

    public function gerarRelatorioPeriodo($post){
        debug('desenvolvimento');
    }
}