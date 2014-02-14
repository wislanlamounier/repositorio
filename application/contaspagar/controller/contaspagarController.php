<?php 

class contaspagarController extends DefaultController{

	function antesSalvar(){
		$this->carregarModulo('parcela');
		$this->verificarContaPaga();
	}

	function alteracao(){
		parent::cadastro();

		if($this->contaspagar->rateio == 1){
			$this->initTemplate();
			$this->view->conta = $this->contaspagar;

			$this->carregarModulo('rateio');

			$this->view->lista_rateio = $this->rateio->listar('id_conta_pagar = '.$this->contaspagar->id);
		}else{
			parent::alteracao();
		}
	}

	function excluir(){
		$this->carregarModulo('parcela');
		if($this->parcela->verificarContaPaga($_GET['id'])){
			echo 1;
			die;
		}else{
			parent::excluir();
		}
	}

	function salvar(){
		if(isset($_POST['rateio'])){
			$_SESSION['rateio']['ids'] = $_POST['id_centro_custo'];
			$_SESSION['rateio']['valor'] = $_POST['valor_rateio'];

			unset($_POST['id_centro_custo']);
			unset($_POST['valor_rateio']);
		}

		$_POST['valor_total'] = Util::moedaBanco($_POST['valor_total']);
		$_POST['rateio'] = isset($_POST['rateio']) ? 1 : 0;	

		if($_FILES['anexo']['error'] != 4){
			$_POST['anexo'] = uploadArquivo($_FILES['anexo']);
		}

		parent::salvar();
	}

	function depoisSalvar($id){
		parent::depoisSalvar($id);
		$this->verificarContaPaga();

		$this->parcela->removerParcelas($_POST['id']);
		$valorParcela = $_POST['valor_total'] / $_POST['total_parcelas'];
		$valorParcela = number_format($valorParcela, 2, '.', '');

		$dataObj = new DateTime(AMD($_POST['data_conta_pagar']));
		
		for($i = 1; $i <= $_POST['total_parcelas']; $i++){
		
			/// Intervalo das Parcelas
			$interval = DateInterval::createFromDateString('1 month');
			$dataObj->add($interval);
			$dados = array('id'=>'', 'id_conta_pagar'=>$_POST['id'], 'numero_parcela'=>$i, 'data_vencimento'=>$dataObj->format('d/m/Y'), 'valor'=>$valorParcela, 'status'=>0);
			$this->parcela->salvar($dados);
		}

		$this->carregarModulo('rateio');

		$this->rateio->excluirBy('id_conta_pagar', $_POST['id'], false);

		if(isset($_SESSION['rateio'])){
			for($i=0; $i<count($_SESSION['rateio']);$i++){
				$id_centro_custo = $_SESSION['rateio']['ids'][$i];
				$valor = $_SESSION['rateio']['valor'][$i];

				$this->rateio->salvar(array('id_conta_pagar'=> $_POST['id'], 'id_centro_custo'=>$id_centro_custo, 'valor'=>Util::moedaBanco($valor)), false);	
			}
		}else{
			$this->rateio->salvar(array('id_conta_pagar'=> $_POST['id'], 'id_centro_custo'=>$_POST['id_centro_custo_final'],'valor'=>$_POST['valor_total']), false);
		}
	}

	function parcelas(){
		if(!$_GET['id']){
			$this->resultado('É necesário informar uma conta', 'erro');	
			$this->redirect('contapagar/listar');
		}

		$this->carregarModulo('parcela');
		$this->view->lista = $this->parcela->listar('id_conta_pagar = '.$_GET['id']);

	}

    public function excluirParcela(){
        $this->carregarModulo('parcela');
        $this->parcela->excluir($_GET['id']);
        die;
    }

	function pagarParcela(){
		if(!$_GET['id']){
			$this->resultado('É necesário informar uma parcela', 'erro');	
			$this->redirect('contapagar/listar');
		}		

		$this->carregarModulo('pagamento');
		$this->carregarModulo('parcela');

		$parcela = $this->parcela->retornarObjeto($_GET['id']);

		$this->pagamento->id_parcela = $_GET['id']; 
		$this->pagamento->valor_parcela = 'R$ '.number_format($parcela->valor, 2, ',', '.');
		$this->pagamento->data_pagamento = date('d/m/Y');

		$this->pagamento->data_vencimento = DMA($parcela->data_vencimento);

		$this->view->form = Form::create($this->pagamento->mapeador(), 'contaspagar/pagaraction');
	}

	function pagaraction(){
		$_POST['valor_total'] = Util::moedaBanco($_POST['valor_total']);
		$_POST['juros'] = Util::moedaBanco($_POST['juros']);
		$_POST['desconto'] = Util::moedaBanco($_POST['desconto']);
		$_POST['valor_parcela'] = Util::moedaBanco($_POST['valor_parcela']);

        $this->carregarSubModulo('contacorrente','extrato');
        /** @var $this->extrato Extrato */

        $this->carregarModulo(array('baixa', 'pagamento', 'parcela','contaspagar','contacorrente'));
        $parcela = $this->parcela->retornarObjeto($_POST['id_parcela']);

        $contaPagar = $this->contaspagar->retornarObjeto($parcela->id_conta_pagar);

        $contaCorrente = $this->contacorrente->retornarObjeto($_POST['id_conta_corrente']);

        /// Adiciona na tabela extrato
        $extrato['transacao'] = 'Pagamento de Parcela';
        $extrato['id_conta_corrente'] = $_POST['id_conta_corrente'];
        $extrato['tipo'] = 'D';
        $extrato['saldo_anterior'] = $contaCorrente->saldo;
        $extrato['valor'] = $parcela->valor;
        $extrato['data'] = $_POST['data_pagamento'];
        $extrato['id_conta_contabil'] = $contaPagar->id_conta_contabil;
        $extrato['id_conta_contabil_sub'] = $contaPagar->id_conta_contabil_sub;

        if(!Pagamento::efetuar($_POST['valor_total'], $_POST['id_conta_corrente'])){
			$this->resultado('A conta corrente seleciona é inválida!', 'erro');
			$this->redirect('contaspagar/pagarparcela/'.$_POST['id_parcela']);
		};

		$dadosBaixa  = array('id_parcela'=>$_POST['id_parcela'], 
							 'valor_pago'=>$_POST['valor_parcela'], 
							 'data_pagamento'=>$_POST['data_pagamento'], 
							 'juros'=>$_POST['juros'], 
							 'desconto'=>$_POST['desconto'], 
							 'id_conta_corrente'=>$_POST['id_conta_corrente']);

		$dadosParcela = array('id'=>$parcela->id, 'status'=>1,'data_vencimento'=>$_POST['data_vencimento']);

		unset($_POST['data_vencimento']);

		$this->baixa->salvar($dadosBaixa);
		$this->pagamento->salvar($_POST);
        $this->extrato->salvar($extrato);

		$this->parcela->salvar($dadosParcela);	

		$this->resultado('Parcela Paga com Sucesso', 'sucesso');
		$this->redirect('contaspagar/parcelas/'.$parcela->id_conta_pagar);
	}

	function verPagamento(){
		if(!$_GET['id']){
			$this->resultado('É necesário informar uma pagamento', 'erro');	
			$this->redirect('contapagar/listar');
		}	

		$this->carregarModulo('pagamento');

		$this->view->pagamento = $this->pagamento->carregarView($_GET['id']);
	}

	private function verificarContaPaga(){
		/// Verifica se tem conta paga
		$this->carregarModulo('parcela');
		if($this->parcela->verificarContaPaga($_POST['id'])){
			$this->resultado('A conta não pode ser alterada pois existe parcelas pagas', 'erro');
			$this->redirect('contaspagar/listar');
		}
	}

}