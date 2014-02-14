
<?php 
class Construtora extends Model{
	public $id;
	public $nome;
	public $cnpj;
	public $endereco;
	public $uf;
	public $cidade;
	public $isencao;
	public $observacao;	

	function __construct(){
		$this->tabela = 'construtora';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Nome', array('class'=>'validate[required]', 'value'=>$this->nome)),
			'cnpj'=>array('input', 'CNPJ', array('class'=>'validate[required]', 'value'=>$this->cnpj)),
			'endereco'=>array('input', 'Endereço', array('class'=>'validate[required]', 'value'=>$this->endereco)),
			'uf'=>array('select', 'UF', array('class'=>'validate[required]'), $this->getEstado(), $this->uf),
			'cidade'=>array('input', 'Cidade', array('class'=>'validate[required]', 'value'=>$this->cidade)),
			'isencao'=>array('input', 'IE (isento)', array('class'=>'validate[required]', 'value'=>$this->isencao)),
			'observacao'=>array('input', 'Observação4', array('class'=>'validate[required]', 'value'=>$this->observacao))
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