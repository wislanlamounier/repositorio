
<?php 
class Bancocomissao extends Model{
	public $id;
	public $nome;

	function __construct(){
		$this->tabela = 'banco_comissao';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Banco', array('class'=>'validate[required]', 'value'=>$this->nome))
		);
	}
}