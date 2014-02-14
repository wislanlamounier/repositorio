<?php

class Relatorio extends Model{
    public function gerarRelatorioConciliacao($dataInicial, $dataFinal, $conta){
        $sql = "SELECT cb.*, con.nome FROM conciliacao_bancaria cb
                inner join conta_corrente con ON con.id = cb.id_conta_corrente
                where data between '".AMD($dataInicial)."' AND '".AMD($dataFinal)."' AND id_conta_corrente = ".$conta." ORDER BY data, id ASC";
	//debug ($sql);
        $resultado = Conexao::listarSql($sql);

        return $resultado;

    }

    public function gerarRelatorioGeral($mes, $ano, $contas, $subContasContabeis){

        $saldoContasCorrentes = array();
        $creditosContaCorrente = array();
        $debitosContaCorrente = array();
        $mapaContas = array();

        foreach($contas as $item){
            $mapaContas[$item->id] = $item->nome;
            $saldoContasCorrentes[$item->id] = $this->getSaldoContaCorrentePeriodo($this->getDataInicial($mes, $ano), $item->id);
            $creditosContaCorrente[$item->id] = $this->getRelatorioContaCorrentePeriodo($this->getDataInicial($mes, $ano), $item->id, 'C');
            $debitosContaCorrente[$item->id] = $this->getRelatorioContaCorrentePeriodo($this->getDataInicial($mes, $ano), $item->id, 'D');
        }

        $totalContaReceita = array();
        $totalContaDespesas = array();

        foreach($subContasContabeis as $subConta){
            $total = $this->getTotalSubConta($this->getDataInicial($mes, $ano), $subConta->id);
            if(count($total))
                $totalContaReceita[$subConta->id_conta][$subConta->id] = $total;


            $total = $this->getTotalSubConta($this->getDataInicial($mes, $ano), $subConta->id,'D');
            if(count($total)){
                    $totalContaDespesas[$subConta->id_conta][$subConta->id] = $total;
                }
        }

        $totalGeralDespesas = 0;
        $totalGeralReceita = 0;

        foreach($totalContaDespesas as $conta => $dados){
            foreach($dados as $subConta => $dadosSub){
                foreach($dadosSub as $chave => $dSub){
                    $totalGeralDespesas += $dSub['dados'];
                }
            }
        }

        foreach($totalContaReceita as $conta => $dados){
            foreach($dados as $subConta => $dadosSub){
                foreach($dadosSub as $chave => $dSub){
                    $totalGeralReceita += $dSub['dados'];
                }
            }
        }

        $dataInicial = $this->getDataInicial($mes, $ano);
        $intervalo = DateInterval::createFromDateString('- 4 month');
        $dataFinal = $this->getDataInicial($mes, $ano)->add($intervalo);

        $chequesDevolvidos = $this->getDadosChequePeriodo('D', $dataInicial, $dataFinal);
        $chequesCompensado = $this->getDadosChequePeriodo('C', $dataInicial, $dataFinal);

        $comissoes = $this->getComissoesPeriodo($dataInicial, $dataFinal);

        $tratado = array(
            'finalSaldoContasCorrentes'=>$saldoContasCorrentes,
            'finalCreditosContasCorrentes'=>$creditosContaCorrente,
            'finalDebitosContasCorrentes'=>$debitosContaCorrente,
            'finalSubContaDespesas'=>$totalGeralDespesas,
            'dataInicialContaCorrente'=>$dataInicial,
            'dataFinalContaCorrente'=>$dataFinal,
            'contaContabilDespesas'=>$totalContaDespesas,
            'contaContabilReceita'=>$totalContaReceita,
            'finalmapaContas'=>'',
            'comissoes'=>$comissoes,
            'meses'=>$this->getMesesPeriodo( $this->getDataInicial($mes, $ano)),
            'cheques'=>array('devolvidos'=>$chequesDevolvidos,'compensados'=>$chequesCompensado)

        );

        return $tratado;
    }

    public function getTotalSubConta($dataInicial, $subConta,$tipo='C'){
        $filtro = ($tipo == 'C') ? "'TC','C'" : "'TD','D','TX'";
        $intervalo = DateInterval::createFromDateString( '0 month' );

        $dados = array();
        for($i=0;$i<4;$i++){
            $dataFinal = $dataInicial->add($intervalo);
            $mes = $dataFinal->format('m');
            $sql = "SELECT sum(valor) as total, cb.* FROM conciliacao_bancaria cb where data like '%".$dataFinal->format('Y-m')."-%' AND id_conta_contabil_sub = {$subConta} AND tipo IN ({$filtro})";

            $dadosConta = Conexao::lerSql($sql);

            if($dadosConta->total){
                $dados[$mes] = array('dados'=>$dadosConta->total, 'mes'=>$this->pegarNomeMes($mes));
            }

            $intervalo = DateInterval::createFromDateString( '-1 month' );
        }

        return $dados;
    }


    /**
     * @param $mes
     * @param $ano
     * @return DateTime
     */
    public function getDataInicial($mes, $ano){
        return DateTime::createFromFormat('Y-m-d',$ano.'-'.$mes.'-01');
    }

    public function getSaldoContaCorrentePeriodo($dataInicial, $contaCorrente){
        $intervalo = DateInterval::createFromDateString( '0 month' );

        $dados = array();
        for($i=0;$i<4;$i++){
            $dataFinal = $dataInicial->add($intervalo);
            $mes = $dataFinal->format('m');
            $sql = "SELECT * FROM conciliacao_bancaria cb where data like '%".$dataFinal->format('Y-m')."-%' AND id_conta_corrente = {$contaCorrente} order by id desc limit 1";

            $dados[$mes] = array('dados'=>$this->calcularValorFinal(Conexao::lerSql($sql)), $this->pegarNomeMes($mes));


            $intervalo = DateInterval::createFromDateString( '-1 month' );
        }

        return $dados;
    }

    public function getRelatorioContaCorrentePeriodo($dataInicial, $contaCorrente, $tipo='C'){
        $filtro = ($tipo == 'C') ? "'TC','C'" : "'TD','D','TX'";
        $intervalo = DateInterval::createFromDateString( '0 month' );

        $dados = array();
        for($i=0;$i<4;$i++){
            $dataFinal = $dataInicial->add($intervalo);
            $mes = $dataFinal->format('m');
            $sql = "SELECT sum(valor) as total, cb.* FROM conciliacao_bancaria cb where data like '%".$dataFinal->format('Y-m')."-%' AND id_conta_corrente = {$contaCorrente} AND tipo IN ({$filtro})";

            $dadosConta = Conexao::lerSql($sql);

            $dados[$mes] = array('dados'=>$dadosConta->total, 'mes'=>$this->pegarNomeMes($mes));

            $intervalo = DateInterval::createFromDateString( '-1 month' );
        }
        return $dados;
    }

    public function calcularValorFinal($dados){
        if($dados){
            $credito = array('TC','C');
            if(in_array($dados->tipo, $credito)){
                $valorFinal = $dados->saldo_anterior + $dados->valor;
            }else{
                $valorFinal = $dados->saldo_anterior - $dados->valor;
            }
        }else{
            $valorFinal = 0;
        }


        return $valorFinal;
    }

    public function pegarNomeMes($mes){
        switch ($mes) {
            case "01": $mes = 'Janeiro'; break;
            case "02": $mes = 'Fevereiro'; break;
            case "03": $mes = 'Março'; break;
            case "04": $mes = 'Abril'; break;
            case "05": $mes = 'Maio'; break;
            case "06": $mes = 'Junho'; break;
            case "07": $mes = 'Julho'; break;
            case "08": $mes = 'Agosto'; break;
            case "09": $mes = 'Setembro'; break;
            case "10": $mes = 'Outubro'; break;
            case "11": $mes = 'Novembro'; break;
            case "12": $mes = 'Dezembro'; break;
        }

        return $mes;
    }

    public function getDadosChequePeriodo($tipo, $dataInicial, $dataFinal)
    {
        $filtro = ($tipo == 'D') ? "status = '3'" : "id_forma_pagamento = 5 AND status = 2";
        $sql = "select count(id) as total from comissao where $filtro AND data_vencimento between '".$dataFinal->format('Y-m-d')."' AND '".$dataInicial->format('Y-m-d')."'";
        $item = Conexao::lerSql($sql);
        return $item->total;
    }

    public function getComissoesPeriodo($dataInicial, $dataFinal){
	$intervalo = DateInterval::createFromDateString( '+1 month' );
	$dataInicial = $dataInicial->add($intervalo);
        $sql ="select sum(valor) as valor, quem_recebeu
               from comissao
               where data_recebimento between '".$dataFinal->format('Y-m-d')."' AND '".$dataInicial->format('Y-m-d')."' AND status = 2 group by quem_recebeu";
     	return Conexao::listarSql($sql);
    }

    public function getMesesPeriodo($dataInicial)
    {
        $intervalo = DateInterval::createFromDateString( '0 month' );

        $dados = array();
        for($i=0;$i<4;$i++){
            $dataFinal = $dataInicial->add($intervalo);
            $mes = $dataFinal->format('m');
            $dados[$mes] = $this->pegarNomeMes($mes).'/'.$dataFinal->format('Y');

            $intervalo = DateInterval::createFromDateString( '-1 month' );
        }

        return $dados;
    }
}