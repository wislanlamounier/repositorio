<div class="row-fluid">
	<div class="span12">
		<div class="w-box">
			<div class="w-box-header">
				<h4>Extrato da Conta <?=$colecao->conta->nome;?></h4>
			</div>
			<div class="w-box-content">
				<table class="table table-striped dataTables_full table table-striped">
					<thead>
						<tr>
							<th>Transação</th>
							<th>Data</th>
                            <th>Tipo</th>
							<th>Valor</th>
                            <th>Saldo Anterior</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($colecao->extrato as $item){ ?>
							<tr>
								<td><?php echo $item->transacao; ?></td>
                                <td><?php echo DMA($item->data); ?></td>
								<td><?php echo $item->tipo; ?></td>
								<td><?php @Util::moedaVisao($item->valor); ?></td>
                                <th><?php @Util::moedaVisao($item->saldo_anterior); ?></th>
							</tr>
						<?php }; ?>
					</tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4">Saldo Atual</td>
                            <td><?=Util::moedaVisao($colecao->conta->saldo)?></td>
                        </tr>
                    </tfoot>
				</table>

			</div>
		</div>
	</div>
</div>