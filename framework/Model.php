<?php
class Model{
	public $campos;
	public $tabela;
	public $form;
	public $log;
	public $id;

	/** GLOBAL CRUD **/
	
	function salvar($postDados, $log=true){
		$this->log = $log;	
	
		if(is_object($postDados)){
			$tratado = array();
			foreach($postDados as $key => $value){
				$tratado[$key] = $value;
			}
			$postDados = $tratado;
		}	
		
		$id = isset($postDados['id']) ? $postDados['id'] : '';
		
		if(count($_FILES)){
			foreach ($_FILES as $indice => $file){
				if($file['error'] != 4){
					$postDados[$indice] = uploadArquivo($file);
				}
			}
		}
		
		
		if(isset($postDados['old_imagem']))
			unset($postDados['old_imagem']);
		
		if(isset($postDados['imagem_old']))
			unset($postDados['imagem_old']);
		
		if(isset($postDados['url']))
			$postDados['url'] = Util::transformarEmUrl($postDados['nome']);
		
		foreach($postDados as $chave => $post){
			if(preg_match('/old_/', $chave)){
				$item = str_replace('old_', '', $chave);
				if(!$postDados[$item]){
					$postDados[$item] = $post;
				}
				unset($postDados[$chave]);
			}
			
			if(preg_match('/data/', $chave)){
				$postDados[$chave] = AMD($post);
			}
		}
		
		if($id == ''){
			$this->incluir($postDados, $this->tabela);
		}else{
			$this->alterar($postDados, $this->tabela, $id);
		}

		return true;
	}
	
	public function contador($where=''){
		$sql = Persistencia::tabelaSQL('', $this->tabela, $where);
		return Conexao::rowCount($sql);
	}
	
	public function incluir($dados, $tabela){

		foreach ($dados as $key=>$value){
			$campos[] = $key;
			$valores[] = $value;
		}
		
		
		$query = Persistencia::incluir($tabela, $campos, $valores);
        $execucao = Conexao::execSql($query);
		$id = Conexao::lastId();
		$this->id = $id;
		
		if($this->log){
			Log::inserir($query, $id, $tabela);
		}
		
		return $execucao;
	}
	
	public function alterar($dados, $tabela, $id){
		$stringCampos = '';
		$stringValores = '';
		foreach ($dados as $key=>$value){
			$chaves[] = $key;
			$valores[] = $value;
		}
		
		$query = Persistencia::alterar($tabela, $chaves, $valores, 'id', $id);
		
		if($this->log){
			Log::inserir($query, $id, $tabela);
		}
			
		$status = Conexao::execSql($query);

		return $status;
	}
	
	public function excluir($id, $log=true){
		$query = Persistencia::excluir($this->tabela, 'id', $id);
		
		if($log){
			Log::inserir($query, $id, $this->tabela);
		}
		return Conexao::execSql($query);
	}
	
	public function excluirBy($campo, $valor, $log=true){
		$query = Persistencia::excluir($this->tabela, $campo, $valor);
	
		if($log){
			Log::inserir($query, $id, $this->tabela);
		}
		
		return Conexao::execSql($query);
	}
	
	public function retornarObjeto($id){
		$sql = Persistencia::tabelaSQL('', $this->tabela, 'id = '.$id);
		return Conexao::lerSql($sql);
	}
	
	public function carregarObjeto($id){
		$sql = Persistencia::tabelaSQL('', $this->tabela, 'id = '.$id);
		$obj = Conexao::lerSql($sql);
		if($obj){
			$this->setValores($obj);
			return true;
		}else{
			return false;
		}
	}

	function carregarObjetoWhere($where){
		$sql = Persistencia::tabelaSQL('', $this->tabela, $where);
		$obj = Conexao::lerSql($sql);
		if($obj){
			$this->setValores($obj);
			return true;
		}else{
			return false;
		}
	}
	
	function ler($id){
		return $this->carregarObjeto($id);
	}
	
	function lerWhere($where){
		return Conexao::lerSql('SELECT * FROM '.$this->tabela.' WHERE '.$where);
	}

	function updateStatus($id, $status){
		$sql = 'UPDATE '.$this->tabela.' SET status = '.$status.' WHERE id = '.$id;
		
		Log::inserir($sql, $id, $this->tabela);
		return Conexao::execSql($sql);
	}
	
	public function listar($where=''){
		$sql = Persistencia::tabelaSQL('', $this->tabela, $where);
		return Conexao::listarSql($sql);
	}
	
	public function setValores($postDados){
		foreach($postDados as $key=>$value){
			$this->$key = $value;
		}
		$this->form = $this->mapeador();
	}
	
	public function listarLimit($limit, $rand=false){
		$where_rand = ($rand) ? 'ORDER BY rand() ' : '';
		return $this->listar('1=1 '.$where_rand.' LIMIT '.$limit);
	}
	
	public function carregaUrl($url){
		return $this->listar('url = "'.$url.'"');
	}

	public function lastInsertId(){
		$sql = 'select LAST_INSERT_ID(id) as id from '.$this->tabela.' order by id desc limit 1';
		$dados = Conexao::lerSql($sql);
		return $dados->id;
	}

}

