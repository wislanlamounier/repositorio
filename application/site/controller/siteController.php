<?php

class siteController extends publicController {

    function __construct() {
        $this->redirect('acesso/login');
        parent::__construct();
        $this->initTemplate();
        $this->template->layout = 'site';

        if (!isset($_SESSION['sessao_site'])) {
            $this->carregarSessaoSite();
        }
    }
    
    function jsonevents(){
    	$this->carregarModulo('marker');
    	
    	$lista = $this->marker->listar();
    	
    	$tradado = array();
    	foreach($lista as $item){
    		$html = $this->htmlMarker($item->nome, $item->descricao, $item->imagem, $item->id);
    		
	    	$tratado[] = array('lat'=>$item->latitude,
	    					   'lon'=>$item->longitude,
	    					   'title'=>$html,
	    					   'icon'=>BASEURL.'/layout/site/img/icon-construction.png',
	    			           'group'=>'1');	
    	}
/*    	
    	$array = array(
    		array('lat'=>'-15.782508','lon'=>'-47.928815','title'=>$this->htmlMarker('teste', 'Teste de Descrição'),'icon'=>BASEURL.'/layout/site/img/icon-construction.png','group'=>'1'),		
    		array('lat'=>'-15.786885','lon'=>'-47.932677','title'=>'Teste 2','icon'=>BASEURL.'/layout/site/img/icon-construction.png','group'=>'1'),		
    		array('lat'=>'-15.779369','lon'=>'-47.921433','title'=>'Teste 3','icon'=>BASEURL.'/layout/site/img/icon-construction.png','group'=>'2')		
    	);
  */  	
    	echo json_encode($tratado);
    	die;
    }
    
   function cadastro(){
    	$this->template->titulo_pagina = 'Cadastre-se no Site';
    	$validacao = Util::aleatorio(1, 0, 1000);
    	$this->view->validacao = $validacao[0];
    }
    
    private function htmlMarker($titulo, $descricao, $imagem, $id){
    	return '<div class="boxMarker">
    				<div class="imagem">
    					<img src="'.BASEURL.'/arquivos/'.$imagem.'" width="150px"/>
    				</div>
    				<div class="descricao">
	   					<h1>'.$titulo.'</h1>
	   					'.$descricao.'
    				</div>
  					<div class="clear"></div>
	   				<a class="btn" href="'.BASEURL.'/site/ver/'.$id.'">Ver Detalhes</a>
    			</div>';
    }
    
    function ver(){
    	$this->carregarModulo('marker');
    	$marker = $this->marker->retornarObjeto($_GET['id']);
    	
    	if(!$marker)
    		$this->redirect('site/mapa');
    	
    	$this->view->marker = $marker;
    }
    
    function salvarcadastro(){
    	$_POST['termo_uso'] = (isset($_POST['termo_uso'])) ? 1 : 0;
    	$_POST['newsletter'] = (isset($_POST['newsletter'])) ? 1 : 0;
    	$_POST['status'] = 0;

    	$this->carregarModulo('cliente');
    
    	try{
    		$this->cliente->salvar($_POST, false);
    		
    		/// Envia o Email para o Usuário
    		$modelo_email = $this->cliente->modeloEmail($_POST['nome'], $_POST['login'], $_POST['senha']);
    		Email::sendEmail($_POST['email'], 'Bem Vindo a FacilitandoWeb', $modelo_email);
    		
    		$this->redirect('site/obrigado-por-cadastrar');
    	}catch (Exception $e){
    		Email::sendEmail('brunotlove@gmail.com', 'Erro no Sistema FacilitaWeb', $e->getMessage());
    		$this->redirect('site/erro');
    	}
    }
    
   function home() {
    	$this->template->titulo_pagina = 'Fábrica de Sites';
    }

    function contato() {
        $this->titulo_pagina = 'Contato';
        $validacao = Util::aleatorio(1, 0, 1000);
        $this->view->validacao = $validacao[0];
    }

    function enviarContato() {
        $this->carregarModulo('mensagens');
        $_POST['status'] = 1;
        $_POST['data'] = date('Y-m-d');

        $this->mensagens->salvar($_POST, false);

        Util::redirect('site/contato/enviado');
    }

    function carregarSessaoSite() {
        return true;
    }
    
    function salvarfoto(){
    	$this->carregarModulo('marker');
    	$_POST['imagem'] = uploadArquivo($_FILES['imagem']);
    	
    	Conexao::debug();
    	
    	if($this->marker->salvar($_POST, false)){
    		$this->resultado('Sua imagem foi salva com sucesso!','sucesso');
    	}else{
    		$this->resultado('Erro ao processar sua imagem!','erro');
    	}
    	
    	$this->redirect('site/retorno');
    }
    
    function retorno(){
    	
    }
    
    function paginas() {
        /*$this->carregarModulo('paginas');
        $this->paginas->lerUrl($_GET['id']);
        $this->template->titulo_pagina = $this->paginas->nome;
        $this->view->pagina = $this->paginas->conteudo;*/
    	$this->template->titulo_pagina = $_GET['id'];
    	$this->template->setPagina('paginas/'.$_GET['id']);
    }
    
    function quemsomos(){
    	$this->template->titulo_pagina = 'Olá, Somos a FacilitandoWeb e Somos Diferentes!';
    	$this->template->setPagina('paginas/'.$_GET['acao']);
    }
    
}
