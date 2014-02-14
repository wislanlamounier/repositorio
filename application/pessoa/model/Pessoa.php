<?php

class Pessoa extends Model
{
	public $id;
	public $nome;
	public $endereco;
	public $uf;
	public $cidade;
	public $cep;
	public $telefone_residencial;
	public $telefone_comercial;
	public $telefone_celular;
	public $email;
	public $fornecedor;
	public $id_grupo; 
	public $id_diretor;
	public $id_gerente;

	/// Variaveis para os Grupos
	public $grupo_diretor = 1;
	public $grupo_gerente = 2;

	function __construct(){
		$this->tabela = 'pessoa';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Nome', array('class'=>'validate[required]', 'value'=>$this->nome)),
			'endereco'=>array('input', 'Endereço', array('class'=>'validate[required]', 'value'=>$this->endereco)),
			'uf'=>array('select', 'UF', array('class'=>'validate[required]'), $this->getEstado(), $this->uf),
			'cidade'=>array('input', 'Cidade', array('class'=>'validate[required]', 'value'=>$this->cidade)),
			'cep'=>array('cep', 'CEP', array('class'=>'validate[required]', 'value'=>$this->cep)),
			'telefone_residencial'=>array('telefone', 'Telefone Residêncial', array('class'=>'validate[required]', 'value'=>$this->telefone_residencial)),
			'telefone_comercial'=>array('telefone', 'Telefone Comercial', array('class'=>'validate[required]', 'value'=>$this->telefone_comercial)),
			'telefone_celular'=>array('telefone', 'Telefone Celular', array('class'=>'validate[required]', 'value'=>$this->telefone_celular)),
			'email'=>array('input', 'Email', array('class'=>'validate[required]', 'value'=>$this->email)),
//			'fornecedor'=>array('input', 'Fornecedor', array('class'=>'', 'value'=>$this->fornecedor)),
			'id_grupo'=>array('select', 'Grupo', array('class'=>'validate[required]'), Conexao::selectBanco('categoria_pessoa'), $this->id_grupo),
			'id_diretor'=>array('select', 'Diretor', array('disabled'=>'disabled'), Conexao::selectBanco('pessoa', 'id_grupo = '.$this->grupo_diretor), $this->id_diretor),
			'id_gerente'=>array('select', 'Gerente', array('disabled'=>'disabled'), Conexao::selectBanco('pessoa', 'id_grupo = '.$this->grupo_gerente), $this->id_gerente)
		);
	}

	function getEstado($uf=false){
		$estados = array( "1"=>"Acre", "2"=>"Alagoas", "3"=>"Amazonas", "4"=>"Amapá", "5"=>"Bahia", "6"=>"Ceará", "7"=>"Distrito Federal", "8"=>"Espírito Santo", "9"=>"Goiás", "10"=>"Maranhão", "11"=>"Mato Grosso", "12"=>"Mato Grosso do Sul", "13"=>"Minas Gerais", "14"=>"Pará", "15"=>"Paraíba", "16"=>"Paraná", "17"=>"Pernambuco", "18"=>"Piauí", "19"=>"Rio de Janeiro", "20"=>"Rio Grande do Norte", "21"=>"Rondônia", "22"=>"Rio Grande do Sul", "23"=>"Roraima", "24"=>"Santa Catarina", "25"=>"Sergipe", "26"=>"São Paulo", "27"=>"Tocantins");

		/// Se tiver setado um estado ele retorna a string com o nome do estado
		if($uf){
			return $estados[$ud];
		}

		return $estados;
	}
}