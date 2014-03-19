<?php

class relatorioController extends DefaultController{

    public function listar(){
        //$this->carregarModulo('contaCorrente');
		$this->carregarSubModulo('contacorrente','contacorrente');
        $this->carregarSubModulo('centrocusto','centrocusto');
        $centroscusto = $this->centrocusto->listar();
        $contas = $this->contacorrente->listar();

        $this->view->centrosCusto = $centroscusto;        
        $this->view->contasCorrente = $contas;
<<<<<<< HEAD
        $this->view->centrosCusto = $centroscusto; 
=======
>>>>>>> FETCH_HEAD

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

    public function gerarRelatorioConciliacao($post){        
        $dataInicial = $post['conciliacao']['dataInicial'];
        $dataFinal = $post['conciliacao']['dataFinal'];
        $contaCorrente = $post['contaCorrente'];
        $jurosDesconto = $this->relatorio->getJurosDesconto($contaCorrente);

        $this->carregarModulo(array('relatorio'));
		$this->carregarSubModulo('contacorrente','contacorrente');
        
        
        $dados = $this->relatorio->gerarRelatorioConciliacao($dataInicial, $dataFinal, $contaCorrente, $jurosDesconto);

        
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
    public function gerarRelatorioCentroCusto($post){
        
        $centroCusto = $post['centroCusto'];

        $this->carregarModulo(array('relatorio'));
        $this->carregarSubModulo('centrocusto','centrocusto');
        
        
        $dados = $this->relatorio->gerarRelatorioCentroCusto($centroCusto);

        
        $this->view->dados = $dados;
        debug($this->view->dados);

        $this->view->centroCusto = $this->contacorrente->retornarObjeto($centroCusto);

        // $this->template->setPagina('centrocusto');
    }

    public function gerarRelatorioCentroCusto($post){
        
        $dataInicial    = $post['dataCusto']['dataInicial'];
        $dataFinal      = $post['dataCusto']['dataFinal'];
        $centroCusto    = $post['centroCusto'];

        $this->carregarModulo(array('relatorio'));
        $this->carregarSubModulo('centrocusto','centrocusto');
        
        $dados = $this->relatorio->gerarRelatorioCentroCusto($dataInicial, $dataFinal, $centroCusto);
        $this->view->dados = $dados;
        
        $this->view->centroCusto = $this->centrocusto->retornarObjeto($centroCusto);
        
        $this->template->setPagina('centro_custo');
    }

    public function gerarRelatorioPeriodo($post){
        debug('desenvolvimento');
    }
}
