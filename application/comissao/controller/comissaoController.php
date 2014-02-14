<?php 

class comissaoController extends DefaultController{

	function listar(){
		Util::redirect('lancamento/listar');
		$this->initTemplatePadrao('listar');
		parent::listar();
	}

	function lancamento(){

		if (!isset($_GET['id']))
			Util::redirect('lancamento/listar');

		$this->initTemplate();

		$this->carregarModulo('lancamento');
		
		$lancamento = $this->lancamento->listar(' lan.id = '.$_GET['id']);
		$this->view->lancamento = $lancamento[0];

		$this->view->lista = $this->comissao->listarComissoesLancamento($_GET['id']);

		$this->comissao->id_lancamento = $_GET['id'];
		$this->view->comissao = $this->comissao;
		$this->view->form = Form::create($this->comissao->mapeador(), 'comissao/salvar');

		$this->view->baixa = Form::create($this->comissao->mapeadorBaixa(), 'comissao/baixa');
	}

	function baixa(){
		$comissaoObjeto = $this->comissao->retornarObjeto($_POST['id']);
		$id_lancamento = $_POST['id_lancamento'];
		unset($_POST['id_lancamento']);
        $devolvido = 0;
        $juros = Util::moedaBanco($_POST['juros']);
        $descontos = Util::moedaBanco($_POST['descontos']);

       	$_POST['valor'] = $comissaoObjeto->valor + $juros - $descontos;

        $_POST['status'] = 2;

        if($_POST['devolvido'] == 1){
            $_POST['status'] = 1;
            $devolvido = 1;
        }elseif($_POST['devolvido'] == 'Selecione...'){
            unset($_POST['devolvido']);
        }

        if($_POST['data_segunda_devolucao']){

            $dados['data_segunda_devolucao'] = $_POST['data_segunda_devolucao'];
            $dados['motivo_segunda_devolucao'] = $_POST['motivo_segunda_devolucao'];
            $dados['status'] = 3;
            $dados['id'] = $_POST['id'];
            $dados['valor'] = $_POST['valor'];
            if($_POST['id_conta_corrente'])
            $dados['id_conta_corrente'] = $_POST['id_conta_corrente'];

            $_POST = $dados;
            $devolvido = 1;
        }

        foreach($_POST as $key => $item){
            if($item == '' || $item == 'Selecione...'){
                unset($_POST[$key]);
            }
        }

        //$_POST['valor'] = Util::moedaBanco($_POST['valor']);
      //  debug($_POST);

		if($this->comissao->salvar($_POST)){

            $mensagem = 'Baixa Efetuada com Sucesso!';

            if($_POST['status'] == 1){
                $mensagem = 'O cheque foi devolvido pela primeira vez!';
            }elseif($_POST['status'] == 3){
                $mensagem = 'O cheque foi devolvido pela segunda vez!';
                $devolvido = 1;
            }


            if($_POST['id_conta_corrente'] != '' && $_POST['id_conta_corrente'] != 'Selecione...'){
//                $this->carregarModulo(array('contaCorrente'));
                $this->carregarSubModulo('contacorrente','extrato');
                $this->carregarSubModulo('contacorrente','contacorrente');

                if($devolvido == 1){
                    $devolucao = ($_POST['status'] == 3) ? 'Segunda Devolução' : '';
                    $data_devolucao = ($_POST['status'] == 3) ? $_POST['data_segunda_devolucao'] :  $_POST['data_recebimento'];
                    $this->contacorrente->debito($_POST['id_conta_corrente'], $_POST['valor'], 'Devolução de Cheque '.$devolucao, $this->extrato, 'D','0','0',  $data_devolucao);
                }else{
                	$this->contacorrente->credito($_POST['id_conta_corrente'], $_POST['valor'], 'Recebimento de Comissão', $this->extrato,'C','0','0',$_POST['data_recebimento']);
                }
			}

			$this->resultado($mensagem, 'sucesso');
		}else{
			$this->resultado('Houve um erro ao executar a operação!!', 'erro');
		}

		Util::redirect(self::$model."/lancamento/".$id_lancamento);
	}

	function salvar(){

		$_POST['pj'] = (isset($_POST['pj'])) ? 1 : 0;
		$_POST['valor'] = Util::moedaBanco($_POST['valor']);
		$_POST['id_banco'] = ($_POST['id_banco'] == 'Selecione...' ) ? null : $_POST['id_banco'];

		if($this->comissao->salvar($_POST)){
			$this->depoisSalvar($this->comissao->id);
			$this->resultado('Salvo com Sucesso!', 'sucesso');
		}else{
			$this->resultado('Houve um erro ao executar a operação!!', 'erro');
		}
		
		Util::redirect(self::$model."/lancamento/".$_POST['id_lancamento']);
	}

	function getLancamento(){
		$this->carregarModulo('lancamento');

		$lista = $this->lancamento->getFiltro($_POST['id_cliente']);

		if(!count($lista))
			echo '<option value="">Sem Lancamentos</option>';

		debug($lista);

		$string = '';
		foreach($lista as $item){
			$string .= "<option value=\"$item->id\">$item->empreendimento - R$ ".Util::moedaEdit($item->valor_venda) ." - ". DMA($item->data_venda) ."</option>";
 		}

 		echo $string;
		die;
	}

	function efetuar(){
		$comissao = $this->comissao->retornarObjeto($_GET['id']);

		if(!$comissao->id){
			$this->resultado('Comissão não encontrada', 'erro'); 
			$this->redirect('comissao/listar');
		}

		if($comissao->status == 3){
			$this->resultado('Essa comissão já foi Paga', 'erro'); 
			$this->redirect('comissao/listar');
		}

		/// Verifica se existe conta corrente e inclui o saldo
		if($comissao->id_conta_corrente){
			$this->carregarModulo('contacorrente');
			if($this->contacorrente->credito($comissao->id_conta_corrente, $comissao->valor)){
				$this->resultado('Conta Corrente não encontrada', 'erro'); 
				$this->redirect('comissao/listar');				
			};
		}

		$this->comissao->salvar(array('id'=>$comissao->id, 'status'=>3), false);

		$this->resultado('Comissão Paga com Sucesso', 'sucesso'); 
		$this->redirect('comissao/listar');	
	}
}