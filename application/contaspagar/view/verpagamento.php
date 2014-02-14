<div class="w-box">
	<div class="w-box-header"><h4>Detalhes do Pagamento</h4></div>
	<div class="w-box-content cnt_a">
		<table class="table table-bordered table-striped">
			<tbody>
				<tr>
					<td>Fornecedor</td>
					<td><?php echo $colecao->pagamento->nome_conta; ?></td>
				</tr>
				<tr>
					<td>Conta Bancária</td>
					<td>
						<?php
							 echo '<strong>Banco:</strong> '.$colecao->pagamento->nome.'<br />',
							 	  '<strong>Agência:</strong> '.$colecao->pagamento->agencia.'<br />',
							 	  '<strong>Conta:</strong> '.$colecao->pagamento->conta_corrente.'<br />';

						?>
					</td>
				</tr>
				<tr>
					<td style="width: 250px">Forma de Pagamento</td>
					<td><?php echo $colecao->pagamento->nome_forma_pagamento ?></td>
				</tr>
				<?php if ($colecao->pagamento->id_forma_pagamento == 1){ ?>

				<tr>
					<td style="width: 250px">Número do Cheque</td>
					<td><?php echo $colecao->pagamento->numero_cheque ?></td>
				</tr>		

				<?php } ?>
				
				<tr>
					<td style="width: 250px">Data do Pagamento</td>
					<td><?php echo DMA($colecao->pagamento->data_pagamento); ?></td>
				</tr>				
				<tr>
					<td style="width: 250px">Parcela</td>
					<td><?php echo $colecao->pagamento->numero_parcela.'/'.$colecao->pagamento->quantidade; ?></td>
				</tr>
				<tr>
					<td style="width: 250px">Valor Parcela</td>
					<td><?php echo Util::moedaVisao($colecao->pagamento->valor_parcela); ?></td>	
				</tr>
				<tr>
					<td style="width: 250px">Juros</td>
					<td><?php echo Util::moedaVisao($colecao->pagamento->juros); ?></td>
				</tr>
				<tr>
					<td style="width: 250px">Desconto</td>
					<td><?php echo Util::moedaVisao($colecao->pagamento->desconto); ?></td>	
				</tr>
				<tr>
					<td style="width: 250px">Total</td>
					<td><?php echo Util::moedaVisao($colecao->pagamento->valor_total); ?></td>	
				</tr>
			</tbody>
		</table>
		<br />
		<div class="row">
			<a class="btn pull-right" href="javascript:window.history.go(-1);" >Voltar</a>
		</div>
	</div>
</div>

