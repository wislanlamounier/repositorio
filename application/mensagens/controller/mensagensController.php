<?php 
class mensagensController extends Controller{
	
	function __construct(){
		parent::__construct();
		
		$objetos = array('mensagens');
		$this->carregarModulo($objetos);
	}
	
	function listar(){
		$this->initTemplate();
		$this->template->titulo_pagina = 'Mensagens';
		$this->view->lista = $this->mensagens->listar();
		$this->view->objMensagem = $this->mensagens;
	}
	
	function responder(){
		$obj = $this->mensagens->retornarObjeto($_POST['id']);
		
		if($obj->status != 3){
			$this->mensagens->updateStatus($_POST['id'], 2);
		}

		$obj = $this->mensagens->retornarObjeto($_POST['id']);
		$this->mensagens->setValores($obj);
		$form = Form::create($this->mensagens->formResposta(), 'mensagens/enviarResposta');	
			
		$html = '<div class="w-box">
		<div class="w-box-header">
			<img class="titleIcon" src="'.BASEURL.'/layout/admin/images/icons/dark/dialog.png">
				<h3>Resposta</h3>
			 <div style="display:block" class="direito"></div>
		</div>
		<div class="w-box-content">
			<div class="span3">
				<label>Mensagem:</label>
				<div class="formRight">
					<textarea id="mensagem" name="mensagem" readonly="readonly">'.utf8_encode($this->mensagens->mensagem).'</textarea>
				</div>
			</div>
			'.$form.'
		</div>
	</div>';
		
		echo $html;die;
	}
	
	function enviarResposta(){
		$obj = $this->mensagens->retornarObjeto($_POST['id_mensagem']);
		$status = $obj->status;
		$obj->resposta = $_POST['resposta'];
		$obj->id_usuario = $_SESSION['admin']['id'];
		$obj->status = 3;

		Email::sendEmail($obj->email, 'Resposta do Contato - '.NOME_SISTEMA, $_POST['resposta']);

		if($status != 3){
			$this->mensagens->salvar($obj);
			$this->resultado('Alterado com Sucesso', 'sucesso');
		}else{
			$this->resultado('Não é possivel alterar a Mensagem. Motivo: Mensagem já foi enviada', 'info');
		}
		
		Util::redirect('mensagens/listar');
	}
}
