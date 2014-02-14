<div class="w-box">
    <div class="w-box-header"><h4>Contas a Receber</h4></div>

    <div class="w-box-content cnt_a">
        <div class="row">
            <div class="span11">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>Data</td>
                        <td>Cliente</td>
                        <td>Empreendimento</td>
                        <td>Número</td>
                        <td>Bloco</td>
                        <td>Quadra</td>
                        <td>Valor</td>
                    </tr>
                       <?php foreach ($colecao->dados as $item) { ?>
                            <tr>
                                <td><?php echo DMA($item->data_venda);?></td>
                                <td><?php echo $item->nome;?></td>
                                <td><?php echo $item->empreendimento;?></td>
                                <td><?php echo $item->empreendimento_numero;?></td>
                                <td><?php echo $item->empreendimento_bloco;?></td>
                                <td><?php echo $item->empreendimento_quadra;?></td>
                                <td><?php Util::moedaVisao($item->valor_venda);?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br />
    </div>
</div>