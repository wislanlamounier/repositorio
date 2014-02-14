<?php 

class permissoesController extends Controller{

	function listar(){
		$this->initTemplate();
		$this->titulo_pagina = 'Lista de Modulos';
		
		$this->carregarModulo('modulo');
		
		$this->view->lista = $this->modulo->listar();
	}
	
	function controle(){
		$this->initTemplate();
		
		$this->carregarSubModulo('usuarios', 'grupos');
		$this->carregarSubModulo('permissoes', 'modulo');
		
		$this->view->modulos = $this->modulo->listar();
		$this->view->grupos = $this->grupos->listar();
	}
	
	function listaracoes(){
		$this->carregarSubModulo('usuarios', 'grupos');
		$this->carregarSubModulo('permissoes', 'acao');
		$this->carregarModulo('Permissoes');
		
		$listaAcoes = $this->acao->listar('id_modulo = '.$_GET['id_modulo']);
		
		$stringView = '<input type="hidden" class="id_grupo" value="'.$_GET['id_grupo'].'" />';
		$stringView .= '<table class="table table-striped table-striped">';
			if(count($listaAcoes)){
				$stringView .= '<tr>
									<th style="width:10%">#</th>
									<th>Descrição da Ação</th>
								</tr>';
				foreach($listaAcoes as $acao){
					$checked = '';
					
					if(Permissoes::verificarRelacao($_GET['id_grupo'], $acao->id)){
						$_SESSION['acl'][$_GET['id_grupo']][$acao->id_modulo][$acao->id] = 1;
					}	
					
					if(isset($_SESSION['acl'][$_GET['id_grupo']][$acao->id_modulo][$acao->id])){
						$checked = 'checked="checked"';	
					}
					
				$stringView .= '<tr>
									<td><input type="checkbox" '.$checked.' class="check-acao" data-modulo="'.$acao->id_modulo.'" value="'.$acao->id.'" /></td>
									<td>'.$acao->descricao.'</td>
								</tr>';
				}
			}else{
				$stringView .= '<tr><td><strong>Nenhum Ação Cadastrada para o modulo.</strong></td></tr>';
			}
		$stringView .= '</table>';

		if(count($listaAcoes)){
			$stringView .= '<a href="'.BASEURL.'/permissoes/salvaracl" class="btn pull-right">Salvar</a><div class="clearfix"></div>';
		}
		
		echo $stringView;
	}
	
	function salvaracl(){
		$this->carregarModulo('permissoes');
		
		foreach($_SESSION['acl'] as $id_grupo => $id_modulos){
			if(count($id_modulos)){
				foreach($id_modulos as $id_modulo => $id_permissoes){
					$this->permissoes->deletarRelacao($id_modulo, $id_grupo);
					foreach($id_permissoes as $id_permissao => $null){
						if($id_permissao){
							$this->permissoes->salvar(array('id_grupo'=>$id_grupo,'id_permissao'=>$id_permissao,'id_modulo'=>$id_modulo));
						}
					}
				}
			}
			
		}
		
		unset($_SESSION['acl']);
		$this->resultado('Dados Salvos com Sucesso','sucesso');
		$this->redirect('permissoes/controle');
	}
	
	function sessaoacao(){
		$id_grupo = $_GET['id_grupo'];
		$id_acao = $_GET['id_acao'];
		$id_modulo = $_GET['id_modulo'];
		
		if($_SESSION['acl'][$id_grupo][$id_modulo][$id_acao]){
			unset($_SESSION['acl'][$id_grupo][$id_modulo][$id_acao]);
			var_dump($_SESSION['acl'][$id_grupo][$id_modulo][$id_acao]);
		}else{
			$_SESSION['acl'][$id_grupo][$id_modulo][$id_acao] = 1;
		}
		
		debug($_SESSION['acl']);
	}
	
	function cadastro(){
		$this->initTemplatePadrao('cadastro');
		$this->template->titulo_pagina = 'Cadastro de Modulo';
		
		$this->carregarModulo('modulo');
		
		if(isset($_GET['id']) && $_GET['id'] != ''){
			$this->modulo->carregarObjeto($_GET['id']);
		}
		
		$this->view->form = Form::create($this->modulo->mapeador(), 'permissoes/salvar-modulo');
	}
	
	function salvarmodulo(){
		$this->carregarModulo('modulo');
		$this->modulo->salvar($_POST);
		
		$this->resultado('Modulo cadastrado com sucesso!', 'sucesso');
		$this->redirect('permissoes/listar');
	}
	
	function acoes(){
		$this->carregarModulo('acao');
		
		$this->initTemplate();
		$this->template->titulo_pagina = 'Ações do Modulo';

		if(isset($_SESSION['url']['3']) && $_SESSION['url']['3'] != ''){
			$this->acao->carregarObjeto($_SESSION['url']['3']);
		}
		
		$this->view->lista = $this->acao->listar('id_modulo = '.$_GET['id']);
		
		$this->acao->id_modulo = $_GET['id'];
		$this->view->form  = Form::create($this->acao->mapeador(), 'permissoes/salvar-acao');
	}
	
	function salvaracao(){
		$this->carregarModulo('acao');
		$this->acao->salvar($_POST);
		
		$this->resultado('Efetuado com Sucesso!', 'sucesso');
		$this->redirect('permissoes/acoes/'.$_POST['id_modulo']);
	}
	
	function excluiracao(){
		$this->carregarModulo('acao');
		$this->acao->excluir($_GET['id']);
		
		$this->resultado('Ação excluida com sucesso','sucesso');
	}
}