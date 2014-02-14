<?php 

class Marker extends Model{
	public $id;
	public $nome;
	public $email;
	public $imagem;
	public $descricao;
	public $latitude;
	public $longitude;
	
	function __construct(){
		$this->tabela = 'marker';
	}
	
	function mapeador(){
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Titulo', array('class'=>'validate[required]', 'value'=>$this->nome)),		
			'email'=>array('input', 'Email', array('class'=>'validate[required]', 'value'=>$this->email)),
			'descricao'=>array('textarea', 'Descricao', array(''),$this->descricao),		
			'imagem'=>array('file', 'Imagem', array()),
			'imagem_old'=>array('imagem','', $this->imagem),
			'latitude'=>array('input', 'Latitude', array('class'=>'validate[required]', 'value'=>$this->latitude)),		
			'longitude'=>array('input', 'Longitude', array('class'=>'validate[required]', 'value'=>$this->longitude)),		
		);
	}
}