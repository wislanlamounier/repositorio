<?php

class Executer{
	public static function executar($modulo, $acao) {
		try{
			if (method_exists($modulo, $acao)) {
				/// Se o modulo solicitar autenticação
				if($modulo->autenticacao){
					/// Verifica a permissção para o modulo -> se negar direciona para a home
					if(!Acl::isAllowed()){
						$modulo->resultado('Você não possui permissão!','erro');
						Util::redirect('admin/home');	
					}
				}
				
				/// Executa o Ação do Modulo
				$modulo->$acao();
				
				/// Verifica se o Template esta Ativo e o Exibe
				if($modulo->template){
					$modulo->exibirTemplate();
				} else if($_GET['mod'] == 'site' && file_exists('application/site/view/'.$_GET['acao'].'.php')){
					$modulo->initTemplate();	
					$modulo->exibirTemplate();
				}
				
				if($modulo->cache){
					if(Cache::isCache($_SERVER['REQUEST_URI'])){
						$html = ob_get_contents();
						Cache::write($_SERVER['REQUEST_URI'], $html);
					}
					
					ob_clean();
				
					Cache::read($_SERVER['REQUEST_URI']);
				}
				
			}else{
				//$modulo->resultado('<strong>Modulo</strong> em Construção!', 'erro');
				//$modulo->redirect('admin/home');
				throw new Exception('<strong>Modulo</strong> em Construção!');
			}
		} catch (Exception $e){
			debug($e);
			die;
		}
	}
}
