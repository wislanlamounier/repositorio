
<?php 
class Fechamento extends Model{
	public $id;
	public $nome;

	function __construct(){
		$this->tabela = 'fechamento';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Fechamento', array('class'=>'validate[required]', 'value'=>$this->nome))
		);
	}
}