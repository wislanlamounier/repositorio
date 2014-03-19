
<div class="w-box">
    <div class="w-box-header"><h4>Centro de Custos</h4></div>

    <div class="w-box-content cnt_a">
        <div class="row">
            <div class="span4">
                <span><strong>Centro de Custo:</strong> <?=$colecao->dados[0]->nome?> </span><br />
                <!-- <span><strong>Saldo Inicial em <?=DMA($colecao->dados[0]->data)?>: </strong> <?=Util::moedaVisao($colecao->dados[0]->saldo_anterior) ?></span> -->
            </div>
        </div>
        <br />
        <div class="row">
            <div class="span11">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td colspan="5" class="alert-info">Extrato Contas a Pagar</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Conta Contábil</td>
                        <td>Sub-Conta Contábil</td>
                        <td>Data da Conta a Pagar</td>
                        <td>Valor da Conta a Pagar</td>
                    </tr>
                       <?php foreach ($colecao->dados as $item) { ?>
                    <tr>
                            <td><?=$item->conta_contabil_nome?> </td>
                            <td><?=$item->sub_conta_nome?> </td>
                            <td> <?=DMA($item->data_conta_pagar)?> </td>
                            <td> <?=Util::moedaVisao($item->valor_total_pagar)?> </td>
<!--                             <td>
                            <?php
                                // $soma = array('TC','C');
                                // $valorTotal = (in_array($item->tipo, $soma)) ? $item->valor + $item->saldo_anterior : $item->saldo_anterior - $item->valor;
                                // echo Util::moedaVisao($valorTotal);
                            ?>
                            </td> -->
                    </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="span4">
                <span><strong>Saldo Final: </strong><?= Util::moedaVisao($valorTotal) ?></span>
            </div>
        </div>
        <br />
    </div>
</div>
</div>