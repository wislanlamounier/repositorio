<?php

class pessoaController extends DefaultController
{
	function dadosFisica(){
		/// Verifica se existe registro na url
		if(!$_GET['id'])
			$this->error('Registro de pessoa não encontrado!');

		$this->initTemplatePadrao('cadastro');
		$this->carregarModulo('fisica');

		$this->fisica->carregarObjetoWhere('id_pessoa = '.$_GET['id']);
		$this->fisica->id_pessoa = $_GET['id'];

		$this->view->form = Form::create($this->fisica->mapeador(), 'pessoa/salvarfisica');
	}

	function getGerente(){
		$id_diretor = $_POST['id_diretor'];
		$lista = Conexao::selectBanco('pessoa', ' id_grupo = 2 AND id_diretor = '.$id_diretor);
		
		if(!count($lista)){
			echo '<option>Sem Registros</option>';
			die;
		}

		$string = '<option value="">Selecione...</option>';
		foreach($lista as $key => $item){
			$string.='<option value="'.$key.'">'.$item.'</option>';
		}

		echo $string;
		die;
	}

	function getCorretor(){
		$id_gerente = $_POST['id_gerente'];
		$lista = Conexao::selectBanco('pessoa', 'id_gerente = '.$id_gerente);
		
		if(!count($lista)){
			echo '<option>Sem Registros</option>';
			die;
		}

		$string = '<option value="">Selecione...</option>';
		foreach($lista as $key => $item){
			$string.='<option value="'.$key.'">'.$item.'</option>';
		}

		echo $string;
		die;
	}


	function salvarFisica(){
		$this->carregarModulo('fisica');

		if($this->fisica->salvar($_POST)){
			$this->resultado('Dados da Pessoa Física Salvo com Sucesso!', 'sucesso');
		}else{
			$this->resultado('Erro ao processar!', 'erro');
		};

		$this->redirect('pessoa/listar');
	}

	function dadosJuridica(){
		/// Verifica se existe registro na url
		if(!$_GET['id'])
			$this->error('Registro de pessoa não encontrado!');

		$this->initTemplatePadrao('cadastro');
		$this->carregarModulo('juridica');

		$this->juridica->carregarObjetoWhere('id_pessoa = '.$_GET['id']);
		$this->juridica->id_pessoa = $_GET['id'];

		$this->view->form = Form::create($this->juridica->mapeador(), 'pessoa/salvarjuridica');
	}

	function salvarJuridica(){
		$this->carregarModulo('juridica');

		if($this->juridica->salvar($_POST)){
			$this->resultado('Dados da Pessoa Juridica Salvo com Sucesso!', 'sucesso');
		}else{
			$this->resultado('Erro ao processar!', 'erro');
		};

		$this->redirect('pessoa/listar');
	}

	function dadosCliente(){
		/// Verifica se existe registro na url
		if(!$_GET['id'])
			$this->error('Registro de pessoa não encontrado!');

		$this->initTemplatePadrao('cadastro');
		$this->carregarModulo('cliente');

		$this->cliente->carregarObjetoWhere('id_pessoa = '.$_GET['id']);
		$this->cliente->id_pessoa = $_GET['id'];

		$this->view->form = Form::create($this->cliente->mapeador(), 'pessoa/salvarcliente');
	}

	function salvarCliente(){
		$this->carregarModulo('cliente');

		if($this->cliente->salvar($_POST)){
			$this->resultado('Dados do Cliente Salvo com Sucesso!', 'sucesso');
		}else{
			$this->resultado('Erro ao processar!', 'erro');
		};

		$this->redirect('pessoa/listar');
	}

	private function error($mensagem){
		$this->resultado($mensagem, 'erro');
		$this->redirect('pessoa/listar');
	}
}