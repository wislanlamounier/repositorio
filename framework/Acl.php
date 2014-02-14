<?php
class Acl{
	
	/*
	 * Função que verifica a permissão do usuario para o modulo / acao
	 * retorna verdadeiro (true) se houver permissão, se não nega o acesso e direciona para a home.
	 */
	static function isAllowed($modulo=false,$acao=false){
		$id_grupo = $_SESSION['admin']['id_grupo'];
		$controller = ($modulo) ? $modulo : $_GET['mod'];
		$acao = ($acao) ? $acao : $_GET['acao'];
		$permissao = false;
		
		/// Array de Excessões que nao verificam ACL
		$arrayExcessoes = array(
			'acessar',
			'acesso',
			'home',
			'sqlcreate'	
		);

		/// Verifica se o Modulo é Controlado
		$controle = Permissoes::verificarControle($controller, $acao);
		
		/// Se a ação não estiver dentro das Excessoes
		if(in_array($acao, $arrayExcessoes) || self::grupoAdmin($id_grupo) || !$controle){
			$permissao = true;
		}else{
			if(Permissoes::verificarRelacao($id_grupo, $controle)){
				$permissao = true;
			}
		}
		
		return $permissao;
	}
	
	/*
	 * Verifica se o grupo do usuário é super administrador e não passa pela ACL
	 */
	static function grupoAdmin($id_grupo){
		$sql = Persistencia::tabelaSQL('', 'grupos_usuarios', 'id = '.$id_grupo);
		$grupo = Conexao::lerSql($sql);

		return ($grupo->isAdmin) ? true : false;
	}
}