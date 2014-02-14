<?php 

class contacorrenteController extends DefaultController{

	function cadastro(){
		$this->initTemplatePadrao('cadastro');
		parent::cadastro();
	}

	function salvar(){
		$_POST['saldo'] = Util::moedaBanco($_POST['saldo']);
		parent::salvar();
	}

    function extrato(){
        $extrato = new Extrato();
        $this->view->extrato = $extrato->extrato($_GET['id']);

        $conta = new Contacorrente();
        $this->view->conta = $conta->retornarObjeto($_GET['id']);
    }

}