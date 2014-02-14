<?php 

class TbancariaController extends DefaultController{
	function salvar(){
		$_POST['valor'] = Util::moedaBanco($_POST['valor']);
		parent::salvar();
	}
}