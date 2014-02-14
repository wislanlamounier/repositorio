<?php 

class construtoraController extends DefaultController{

	function cadastro(){
		$this->initTemplatePadrao('cadastro');
		parent::cadastro();
	}

	function empreendimento(){
		/// Verifica se existe registro na url
		if(!$_GET['id'])
			$this->error('Registro de Construtora não encontrado!');

		$this->carregarModulo('empreendimento');

		$this->view->lista = $this->empreendimento->listar('id_construtora = '.$_GET['id']);
		
		if(isset($_SESSION['url'][3]))
			$this->empreendimento->ler($_SESSION['url'][3]);

		$this->empreendimento->id_construtora = $_GET['id'];

		$this->view->form = Form::create($this->empreendimento->mapeador(), 'construtora/salvarempreendimento');
	}

	function salvarempreendimento(){
		$this->carregarModulo('empreendimento');

		if($this->empreendimento->salvar($_POST)){
			$this->resultado('Dados do Empreendimento Salvos!', 'sucesso');
		}else{
			$this->resultado('Erro ao processar!', 'erro');
		};

		$this->redirect('construtora/empreendimento/'.$_POST['id_construtora']);
	}

	function empreendimentoexcluir (){
		$this->carregarModulo('empreendimento');
		$conta = $this->empreendimento->retornarObjeto($_GET['id']);

		if($this->empreendimento->excluir($_GET['id'])){
			$this->resultado('Empreendimento Excluído com Sucesso!', 'sucesso');
		}else{
			$this->resultado('Erro ao processar!', 'erro');
		};

		$this->redirect('construtora/empreendimento/'.$conta->id_construtora);	
	}

	private function error($mensagem){
		$this->resultado($mensagem, 'erro');
		$this->redirect('construtora/listar');
	}
}