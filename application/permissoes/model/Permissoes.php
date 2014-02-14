<?php 

class Permissoes extends Model{
	public $id;
	public $id_permissao;
	public $id_grupo;
	public $id_modulo;
	
	function __construct(){
		$this->tabela = 'permissoes';
	}
	
	function mapeador(){
		return array(
				'id'=>array('id', $this->id),
				'id_grupo'=>array('id', $this->id_permissao),
				'id_permissao'=>array('id', $this->id_grupo),
				'id_modulo'=>array('id', $this->id_modulo)
		);
	}
	
	static function verificarRelacao($id_grupo, $id_permissao){
		$sql = Persistencia::tabelaSQL('', 'permissoes', 'id_grupo = '.$id_grupo.' AND id_permissao = '.$id_permissao.'');
		return (Conexao::rowCount($sql)) ? true : false;
	}
	
	function deletarRelacao($id_modulo, $id_grupo){
		$sql = 'DELETE FROM permissoes WHERE id_modulo = '.$id_modulo.' AND id_grupo = '.$id_grupo.'';
		return Conexao::execSql($sql);
	}
	
	static function verificarControle($modulo,$acao){
		$sql = 'select pm.nome modulo, pa.nome acao, pa.id id_permissao from permissoes_acao pa 
				inner join permissoes_modulo pm on pm.id = pa.id_modulo 
				where pm.nome = "'.$modulo.'" AND pa.nome = "'.$acao.'"';
		
		$item = Conexao::lerSql($sql);
		
		if($item){
			return $item->id_permissao;
		}else{
			return false;
		}
	}
}