<?php 

class lancamentoController extends DefaultController{

	function salvar(){
		$_POST['valor_venda'] = Util::moedaBanco($_POST['valor_venda']);
		$_POST['valor_tabela'] = Util::moedaBanco($_POST['valor_tabela']);
		$_POST['valor_financiamento'] = Util::moedaBanco($_POST['valor_financiamento']);

		$_POST['shf'] = isseT($_POST['shf']) ? 1 : 0;
		$_POST['direto'] = isseT($_POST['direto']) ? 1 : 0;
		$_POST['terceiro'] = isseT($_POST['terceiro']) ? 1 : 0;

		if($_FILES['anexo']['error'] != 4){
			$_POST['anexo'] = uploadArquivo($_FILES['anexo']);
		}

		parent::salvar();
	}

	function excluir(){
		$this->carregarModulo('comissao');
		$lista = $this->comissao->listar('data_recebimento <> " " AND id_lancamento = '. $_GET['id']);
		
		if(count ($lista)){
			echo "Não pode excluir";
			die();
		}

		parent::excluir();
	}
}