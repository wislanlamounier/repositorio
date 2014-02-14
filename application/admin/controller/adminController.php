<?php
class adminController extends Controller {
	function __construct(){
		parent::__construct();
		$this->carregarModulo('mensagens');
		$_SESSION['mensagens'] = $this->mensagens->contador('status not in (3)');
	}
	
	function sistema(){
		$this->initTemplate();
		$this->view->sistema = Form::create($this->sistema->form, 'admin/salvarSistema');	
	}
	
	function salvarSistema(){
		$this->sistema->salvar($_POST);
		$this->resultado('Sistema Atualizado com Sucesso!', 'sucesso');
		Util::redirect('admin/sistema');		
	}
	
	function home(){
		$this->initTemplate();
	}
	
	function suporte(){
		$assunto = $_POST['assunto'];
		$mensagem = $_POST['conteudo'];
	
		Email::sendEmail('brunotlove@gmail.com', 'Email de Suporte | '.NOME_SISTEMA.' - '.$assunto, $mensagem);
		$this->resultado('Email de Suporte Enviado com sucesso!', 'sucesso');
		
		Util::redirect('admin/home');
	}
	
	function sqlcreate(){
		if(preg_match('/>/', $_GET['id'])){
			$estrutura = explode('>', $_GET['id']);
			$folder = $estrutura[0];
			$class = $estrutura[1];
			
			$this->carregarSubModulo($folder, $class);
		}else{
			$class = $_GET['id'];
			$this->carregarModulo($class);
		};
		
		Persistencia::sqlCreate($this->$class->mapeador(), $this->$class->tabela);
		die;
	}
}

?>