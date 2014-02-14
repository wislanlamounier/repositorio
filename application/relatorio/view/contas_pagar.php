<div class="w-box">
    <div class="w-box-header"><h4>Contas a Pagar</h4></div>

    <div class="w-box-content cnt_a">
        <div class="row">
            <div class="span11">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>Vencimento</td>
                        <td>Fornecedor</td>
                        <td>Data</td>
                        <td>Valor</td>
                    </tr>
                       <?php foreach ($colecao->dados as $item) { ?>
                            <tr>
                                <td><?php echo DMA($item->data_conta_pagar);?></td>
                                <td><?php echo $item->fornecedor;?></td>
                                <td><?php echo DMA($item->data_emissao);?></td>
                                <td><?php Util::moedaVisao($item->valor_total);?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br />
    </div>
</div>