<?php 

class contratoController extends DefaultController{
	function listar(){
		if(!$_GET['id'])
			Util::redirect('lancamento/listar');

		$_SESSION['id_lancamento'] = $_GET['id'];

		$this->carregarModulo('contrato');
		$this->view->lista = $this->contrato->listar('id_lancamento = '.$_GET['id']);
	}

	function cadastro(){
		$this->initTemplatePadrao('cadastro');
		$this->contrato->id_lancamento = $_SESSION['id'];
		parent::cadastro();
	}

	function salvar(){
		$_POST['id_lancamento'] = $_SESSION['id_lancamento'];
		parent::salvar();
	}

	function depoisSalvar(){
		Util::redirect('contrato/listar/'.$_SESSION['id_lancamento']);
		die;
	}

}