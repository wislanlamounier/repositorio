<?php 

class Acao extends Model{
	public $id;
	public $id_modulo;
	public $nome;
	public $descricao;
	
	function __construct(){
		$this->tabela = 'permissoes_acao';
	}
	
	function mapeador(){
		return array(
				'id'=>array('id', $this->id),
				'nome'=>array('input', 'Nome da Função', array('value'=>$this->nome, 'class'=>'validate[required]')),
				'id_modulo'=>array('hidden', $this->id_modulo),
				'descricao'=>array('input', 'Descrição', array('value'=>$this->descricao))
		);
	}
}