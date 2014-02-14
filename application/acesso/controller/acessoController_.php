<?php

class acessoController extends publicController{
	
	function verificar(){
		if(!Acesso::verificarAcesso($_SESSION['admin']['id_acesso'])){
			unset($_SESSION['admin']);
			echo 0;
		}else{
			echo 1;
		}
	}
	
	function login(){
		if(isset($_SESSION['admin']))
			Util::redirect('admin/home');
		
		$this->initTemplate();
		$this->template->fullPage = true;
	}
	
	function acessar(){
		$this->carregarModulo('usuarios');
		
		$this->usuarios->login = addslashes($_POST['login']);
		$this->usuarios->senha = md5(addslashes($_POST['senha']));
		
		if($obj = $this->usuarios->acessar()){
			
			/// Verifica se o usuário esta ativo no sistema
			if($obj->status == '0'){
				$this->resultado('Usuário Inativo', 'erro');
				Util::redirect('admin/acesso');
				die;
			}
			
			/// Verifica se o usuário já esta logado no sistema
			if(Acesso::usuarioLogado($obj->id)){
				$msgAcesso = '<br /> Usuário estava conectado em outra estação.';
				Acesso::cancelar(Acesso::$id_acesso);
			};
			
			/// Inclui o registro de acesso
			$id_acesso = Acesso::login($obj->id);
			
			/// Envia um email notificando o administrador do sistema
			Email::sendEmail('brunotlove@gmail.com', 'Acesso no Sistema - '.NOME_SISTEMA, $this->sistema->emailAcesso($obj));

			$_SESSION['admin'] = array('nome'=>$obj->nome, 'id'=>$obj->id,'id_grupo'=>$obj->id_grupo,'id_acesso'=>$id_acesso);
			
			$this->resultado('Bem vindo ao Sistema <strong>'.$_SESSION['admin']['nome'].'</strong>'.$msgAcesso, 'sucesso');
			Util::redirect('admin/home/');
		}else{
			$this->resultado('Dados Inválidos!', 'erro');
			Util::redirect('admin/acesso');
		};

		exit;
	}
	
	function sair(){

		Acesso::logout();
		
		$this->resultado('Usuário Deslogado', 'sucesso');
		Util::redirect('admin/acesso');
	}
	
	function lembrarsenha(){
		$this->carregarModulo('usuarios');	
		$email = addslashes($_POST['email']);
		
		$resultado = $this->usuarios->listar('email = "'.$email.'"');
		
		if(count($resultado) > 0){
			$usuario = $resultado[0];
			
			$novaSenha = Util::aleatorio(1, 100000, 100000000);
			$novaSenhaMD5 = md5($novaSenha[0]);

			$usuario->senha = $novaSenhaMD5;
			
			$mensagem = 'A senha gerada para o sistema '.NOME_SISTEMA.' <br />é '.$novaSenha[0].' para o usuário '.$usuario->login;
			
			Email::sendEmail($_POST['email'], 'Senha de Acesso ao Sistema '.NOME_SISTEMA, $mensagem);
			
			$this->usuarios->salvar($usuario, false);
			
			$msg = preg_match('/localhost/', BASEURL) ? 'Nova Senha: '.$novaSenha[0]: 'Nova Senha gerada e enviada para o email '.$_POST['email'];
			
			$this->resultado($msg, 'sucesso');
			Util::redirect('acesso/login');
		}else{
			$this->resultado('Email não Cadastrado', 'erro');
			Util::redirect('acesso/login');
		}
	}
	
	function cancelar(){
		$this->resultado('Usuário desconectado com sucesso!', 'sucesso');
		Acesso::cancelar($_POST['id_acesso']);
	}
}
