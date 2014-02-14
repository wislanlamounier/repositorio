<?php

    //debug($colecao->dados);

//dataInicialContaCorrente
?>

<div class="w-box">
    <div class="w-box-header"><h4>Conciliação Bancária</h4></div>

    <div class="w-box-content cnt_a">
        <div class="row">
            <div class="span4">
                <span><strong>Conta Corrente:</strong> <?=$colecao->dados[0]->nome?> </span><br />
                <span><strong>Saldo Inicial em <?=DMA($colecao->dados[0]->data)?>: </strong> <?=Util::moedaVisao($colecao->dados[0]->saldo_anterior) ?></span>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="span11">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td colspan="5" class="alert-info">Extrato</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>TP</td>
                        <td>Data Movimentação</td>
                        <td>Descrição</td>
                        <td>Valor</td>
                        <td>Saldo</td>
                    </tr>
                       <?php foreach ($colecao->dados as $item) { ?>
                    <tr>
                            <td> <?=$item->tipo?> </td>
                            <td> <?=DMA($item->data)?> </td>
                            <td> <?=$item->transacao?> </td>
                            <td> <?=Util::moedaVisao($item->valor)?> </td>
                            <td>
                            <?php

                                //$valorTotal = array($item->valor,$item->saldo_anterior );

                                $soma = array('TC','C');
                                $valorTotal = (in_array($item->tipo, $soma)) ? $item->valor + $item->saldo_anterior : $item->saldo_anterior - $item->valor;
                                echo Util::moedaVisao($valorTotal);
                            ?>
                            </td>
                    </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br />
        <div class="row">
            <div class="span4">
                <span><strong>Saldo no dia 23/11/2013:</strong><?= Util::moedaVisao($colecao->contaCorrente->saldo) ?></span>
            </div>
        </div>
        <br />
    </div>
</div>
</div>