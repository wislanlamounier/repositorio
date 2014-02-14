<div class="w-box">
<div class="w-box-header"><h4>Relatório Geral</h4></div>
<div class="w-box-content cnt_a">
<div class="row">
    <div class="span11">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td colspan="5" class="alert-info">Contas Correntes</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Conta Corrente</td>
                <?php foreach($colecao->dados['meses'] as $mes){ ?>
                    <td><?=$mes?></td>
                <?php }; ?>

            </tr>
            <?php foreach($colecao->dados['finalSaldoContasCorrentes'] as $conta => $item){ ?>
            <tr>
                <td><?=$colecao->mapaLegenda['contaCorrente'][$conta]?></td>
                <?php foreach($item as $proItem){?>
                    <td><?=Util::moedaVisao($proItem['dados'])?></td>
                <?php }; ?>
            </tr>
            <?php }; ?>
            </tbody>
        </table>
    </div>
</div>
<br />
<div class="row">
    <div class="span11">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td colspan="5" class="alert-success">Receitas</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Conta Corrente</td>
                <?php $totalReceitaPeriodo = 0; foreach($colecao->dados['meses'] as $mes){ ?>
                    <td><?=$mes?></td>
                <?php }; ?>
            </tr>
            <?php foreach($colecao->dados['finalCreditosContasCorrentes'] as $conta => $item){ ?>
                <tr>
                    <td><?=$colecao->mapaLegenda['contaCorrente'][$conta]?></td>
                    <?php foreach($item as $proItem){?>
                        <td><?php $totalReceitaPeriodo += $proItem['dados']; Util::moedaVisao($proItem['dados'])?></td>
                    <?php }; ?>
                </tr>
            <?php }; ?>
            </tbody>
        </table>
    </div>
</div>
<br />
<div class="row">
    <div class="span11">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td colspan="5" class="alert-danger">Despesas</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Conta Corrente</td>
                <?php $totalDespesasPeriodo = 0; foreach($colecao->dados['meses'] as $mes){ ?>
                    <td><?=$mes?></td>
                <?php }; ?>
            </tr>
            <?php foreach($colecao->dados['finalDebitosContasCorrentes'] as $conta => $item){ ?>
                <tr>
                    <td><?=$colecao->mapaLegenda['contaCorrente'][$conta]?></td>
                    <?php foreach($item as $proItem){?>
                        <td><?php $totalDespesasPeriodo += $proItem['dados']; Util::moedaVisao($proItem['dados'])?></td>
                    <?php }; ?>
                </tr>
            <?php }; ?>
            </tbody>
        </table>
    </div>
</div>
<br />
<div class="row">
    <div class="span11">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td colspan="5" class="alert-success">Conta Contábil (Receita)</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Conta Contábil</td>
                <?php foreach($colecao->dados['meses'] as $mes){ ?>
                    <td><?=$mes?></td>
                <?php }; ?>
            </tr>
            <?php
            $totalContabil = array();
            $totalGeral = array();
            foreach($colecao->dados['contaContabilReceita'] as $contaContabil => $subConta){ ?>
                    <tr>
                        <td><?=$colecao->mapaLegenda['contaContabil'][$contaContabil]?></td>
                        <?php foreach($colecao->dados['meses'] as $indice => $mes){ ?>
                            <td class="receita-mes<?=$indice?>conta<?=$contaContabil?>"> <?=Util::moedaVisao(0)?> </td>
                        <?php }; ?>
                    </tr>
                    <?php foreach($subConta as $codConta => $sConta){?>
                        <tr>
                            <td>-- <?=$colecao->mapaLegenda['subconta'][$codConta]?></td>
                            <?php foreach($colecao->dados['meses'] as $indice => $mes){ ?>
                                <td><?php
                                    $valor = (isset($sConta[$indice])) ? $sConta[$indice]['dados'] : '0';
                                    @$totalGeral[$indice] += $valor;
                                    @$totalContabil[$contaContabil][$indice] += $valor;
                                    echo Util::moedaVisao($valor);
                                    ?></td>
                            <?php }; ?>
                        </tr>
                    <?php }; ?>
                <?php }; ?>
            <tr class="alert-warning">
                <td><strong>Total</strong></td>
                <?php foreach($colecao->dados['meses'] as $indice => $mes){ ?>
                    <td><?=Util::moedaVisao($totalGeral[$indice])?></td>
                <?php }; ?>
            </tr>
            </tbody>
        </table>
        <?php foreach($totalContabil as $conta => $mesesPro){
                foreach($mesesPro as $mes => $valor){ ?>
                     <input type="hidden" class="dadosContabilReceita" data-conta="<?=$conta?>" data-mes="<?=$mes?>" value="<?php Util::moedaVisao($valor); ?> "/>
                <?php };
        }; ?>
    </div>
</div>
<br />
<div class="row">
    <div class="span11">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td colspan="5" class="alert-danger">Conta Contábil (Despesas)</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Conta Contábil</td>
                <?php foreach($colecao->dados['meses'] as $mes){ ?>
                    <td><?=$mes?></td>
                <?php }; ?>
            </tr>
            <?php
            $totalContabil = array();
            $totalGeral = array();
            foreach($colecao->dados['contaContabilDespesas'] as $contaContabil => $subConta){ ?>
                <tr>
                    <td><?=$colecao->mapaLegenda['contaContabil'][$contaContabil]?></td>
                    <?php foreach($colecao->dados['meses'] as $indice => $mes){ ?>
                        <td class="despesas-mes<?=$indice?>conta<?=$contaContabil?>"> <?=Util::moedaVisao(0)?> </td>
                    <?php }; ?>
                </tr>
                <?php foreach($subConta as $codConta => $sConta){?>
                    <tr>
                        <td>-- <?=$colecao->mapaLegenda['subconta'][$codConta]?></td>
                        <?php foreach($colecao->dados['meses'] as $indice => $mes){ ?>
                            <td><?php
                                $valor = (isset($sConta[$indice])) ? $sConta[$indice]['dados'] : '0';
                                @$totalGeral[$indice] += $valor;
                                @$totalContabil[$contaContabil][$indice] += $valor;
                                echo Util::moedaVisao($valor);
                                ?></td>
                        <?php }; ?>
                    </tr>
                <?php }; ?>
            <?php }; ?>
            <tr class="alert-warning">
                <td><strong>Total</strong></td>
                <?php foreach($colecao->dados['meses'] as $indice => $mes){ ?>
                    <td><?=Util::moedaVisao($totalGeral[$indice])?></td>
                <?php }; ?>
            </tr>
            </tbody>
        </table>
        <?php foreach($totalContabil as $conta => $mesesPro){
            foreach($mesesPro as $mes => $valor){ ?>
                <input type="hidden" class="dadosContabilDespesas" data-conta="<?=$conta?>" data-mes="<?=$mes?>" value="<?php Util::moedaVisao($valor); ?> "/>
            <?php };
        }; ?>
    </div>
</div>
<br />

<div class="row">
    <div class="span6">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td colspan="2" class="alert-info">Balanço</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Lucro</td>
                <td><?=Util::moedaVisao($totalReceitaPeriodo)?></td>
            </tr>
            <tr>
                <td>Prejuizo</td>
                <td><?=Util::moedaVisao($totalDespesasPeriodo)?></td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="span5">
        <table class="table table-bordered">
            <thead>
            <tr>
                <td colspan="2" class="alert-info">Outros</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Destratos</td>
                <td>X</td>
            </tr>
            <tr>
                <td>Cheques devolvidos</td>
                <td><?=$colecao->dados['cheques']['devolvidos']?></td>
            </tr>
            <tr>
                <td>Cheques Recebidos</td>
                <td><?=$colecao->dados['cheques']['compensados']?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<br />
<div class="row">
    <div class="span6">

        <table class="table table-bordered">
            <thead>
            <tr>
                <td colspan="2" class="alert-info">Comissões</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach($colecao->dados['comissoes'] as $comissao){ ?>
            <tr>
                <td><?=$comissao->quem_recebeu;?></td>
                <td><?=Util::moedaVisao($comissao->valor);?></td>
            </tr>
            <?php }; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
    $(function(){
        $('.dadosContabilReceita').each(function(){
            var mes = $(this).attr('data-mes'),
                conta = $(this).attr('data-conta'),
                seletor = "mes"+mes+'conta'+conta;

            $('.receita-'+seletor).html( $(this).val() );
        })

        $('.dadosContabilDespesas').each(function(){
            var mes = $(this).attr('data-mes'),
                conta = $(this).attr('data-conta'),
                seletor = "mes"+mes+'conta'+conta;

            $('.despesas-'+seletor).html( $(this).val() );
        })
    })
</script>