<?php 

class contacontabilController extends DefaultController{

	function cadastro(){
		$this->initTemplatePadrao('cadastro');
		parent::cadastro();
	}

	function getSubContas(){
		$this->carregarModulo('subcontacontabil');
		$lista = $this->subcontacontabil->listar('id_conta = '.$_POST['id_conta']);

		if(!count($lista))
			echo '<option value="">Sem resultados...</option>';

		$string = '<option value="">Selecione...</option>';
		foreach($lista as $item){
			$string .= '<option value="'.$item->id.'">'.$item->nome.'</option>';
		}

		echo $string;
		die;
	}

	function subconta(){
		/// Verifica se existe registro na url
		if(!$_GET['id'])
			$this->error('Registro de Conta Contábil não encontrado!');

		$this->carregarModulo('subcontacontabil');

		$this->view->lista = $this->subcontacontabil->listar('id_conta = '.$_GET['id']);
		
		if(isset($_SESSION['url'][3]))
			$this->subcontacontabil->ler($_SESSION['url'][3]);

		$this->subcontacontabil->id_conta = $_GET['id'];

		$this->view->form = Form::create($this->subcontacontabil->mapeador(), 'contacontabil/salvarsubconta');
	}

	function salvarsubconta(){
		$this->carregarModulo('subcontacontabil');

		if($this->subcontacontabil->salvar($_POST)){
			$this->resultado('Dados Sub Conta Contabil Salvos!', 'sucesso');
		}else{
			$this->resultado('Erro ao processar!', 'erro');
		};

		$this->redirect('contacontabil/subconta/'.$_POST['id_conta']);
	}

	function subcontaexcluir (){
		$this->carregarModulo('subcontacontabil');
		$conta = $this->subcontacontabil->retornarObjeto($_GET['id']);

		if($this->subcontacontabil->excluir($_GET['id'])){
			$this->resultado('Sub Conta Excluida com Sucesso!', 'sucesso');
		}else{
			$this->resultado('Erro ao processar!', 'erro');
		};

		$this->redirect('contacontabil/subconta/'.$conta->id_conta);	
	}

	private function error($mensagem){
		$this->resultado($mensagem, 'erro');
		$this->redirect('contacontabil/listar');
	}
}