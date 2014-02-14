<?php 
class Mensagens extends Model{
	public $id;
	public $nome;
	public $email;
	public $telefone;
	public $data;
	public $mensagem;
	public $resposta;
	public $id_usuario;
	public $status;
	
	
	function __construct(){
		$this->tabela = 'mensagens';
		$this->campos = array('id', 'nome', 'email', 'telefone','data', 'mensagem', 'resposta', 'id_usuario','status');
		
		$this->form = $this->mapeador();
	}
	
	function mapeador(){
		$arrStatus = $this->arrStatus();
		$data = ($this->data == '') ? date('d/m/Y') : $this->data;
		return array(
			'nome'=>array('input', 'Nome', array('class'=>'validate[required]', 'type'=>"text",'value'=>$this->nome)),
			'email'=>array('input', 'Email', array('class'=>'validate[required]', 'type'=>"text",'value'=>$this->email)),
			'telefone'=>array('input', 'Telefone', array('class'=>'validate[required] maskPhone', 'type'=>"text",'value'=>$this->telefone)),
			'mensagem'=>array('textarea', '', array('class'=>'validate[required]'), $this->mensagem),
		);
	}
	
	function formResposta(){
		$readyOnly = ($this->resposta != '') ? 'readonly' : '';
		return array(
			'resposta'=>array('textarea', 'Resposta', array('class'=>"validate[required] $readyOnly"), $this->resposta),
			'id_usuario'=>array('hidden', '', array('value'=>$_SESSION['admin']['id'])),
			'id_mensagem'=>array('hidden', '', array('value'=>$this->id))
		);
	}
	
	function count(){
		$count = count($this->listar('status = 1'));
		
		if($count == 0){
		  	$retorno = '';
		}else{
		  	$retorno = "<span class='numberMiddle'>$count</span>";
		};
		
		return $retorno;
	}
	
	function arrStatus($id = false){
		$status = array(
			'1'=>'Nova',
			'2'=>'Lida',
			'3'=>'Respondida'
		);
		
		if($id){
			foreach($status as $key => $value){
				if($key == $id){
					return $value;
				}
			}
		}else{
			return $status;
		}
		
	}
}

