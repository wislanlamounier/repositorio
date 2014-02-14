
<?php 
class Tipocomissao extends Model{
	public $id;
	public $nome;

	function __construct(){
		$this->tabela = 'tipo_comissao';
	}

	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Tipo de Comissão', array('class'=>'validate[required]', 'value'=>$this->nome))
		);
	}
}