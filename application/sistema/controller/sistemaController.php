<?php

class sistemaController extends publicController {

    /**
     * Função que valida se o dado informado é unico na tabela
     * Usa o componente input com a classe .valida-unico e uma tag data-unico que informa qual a tabela
     * Retorna 1 se tiver registro, retorna false se nao tiver
     */
    function validarunico() {
        $id_valida = ($_POST['id']) ? 'AND id <> ' . $_POST['id'] : '';
        $sql = Persistencia::tabelaSQL('', $_POST['tabela'], $_POST['campo'] . '= "' . $_POST['valor'] . '"' . $id_valida);
        echo (Conexao::rowCount($sql)) ? 1 : 0;
    }

    function autocomplete() {
        $sql = Persistencia::tabelaSQL('*', $_GET['tabela'], $_GET['filtro'] . ' like "%' . $_GET['conteudo'] . '%"');
        $lista = Conexao::listarSql($sql);

        $arrayDados = array();
        if (count($lista)) {
            foreach ($lista as $item) {
                $arrayDados[] = array('label' => $item->nome, 'id' => $item->id);
            }
            echo json_encode($arrayDados);
        } else {
            echo json_encode(array(array('label' => 'Sem Resultados', 'id' => 0)));
        }
    }

    function validaremaildns() {
        if (!filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
            $arrayRes = array('nome' => 'Email Incorreto', 'email' => '', 'resultado' => 'erro');
        } else {
            if ($this->verifyEmail($_GET['email'], true)) {
                $arrayRes = array('email' => $_GET['email'], 'resultado' => 'ok');
            } else {
                $arrayRes = array('nome' => 'Email Não Responde', 'email' => '', 'resultado' => 'erro');
            }
        }
        echo json_encode($arrayRes);
        die;
    }

    function verifyEmail($email, $checkDNS = false) {
        list($user, $domain) = explode("@", $email);
        if ((@ereg("^([0-9,a-z,A-Z]+)([.,_,-]([0-9,a-z,A-Z]+))*[@]([0-9,a-z,A-Z]+)([.,_,-]([0-9,a-z,A-Z]+))*[.]([0-9,a-z,A-Z]){2}([0-9,a-z,A-Z])?$", $email))):
            if ($checkDNS):
                if (@checkdnsrr($domain, 'MX')):
                    return(true);
                endif;
            else:
                return true;
            endif;
        endif;
    }
    
    function buscarCidades(){
    	$uf = $_POST['uf'];
    	$this->carregarModulo('cliente');
    	$cidades = $this->cliente->getCidades($uf);

    	$stringRetorno = '<option value="">Selecione...</option>';
    	foreach($cidades as $codigo => $cidade){
    		$stringRetorno .= '<option value="'.$codigo.'">'.$cidade.'</option>';
    	}
    	
    	echo $stringRetorno;
    	die;
    }

}