<div class="row-fluid">
	<div class="span12">
		<div class="w-box">
			<div class="w-box-header">
				<h4><?php echo $this->titulo_pagina; ?></h4>
			</div>
			<div class="w-box-content">
				<table class="table table-striped dataTables_full table table-striped" id="dt_gal">
					<thead>
						<tr>
							<th style="width: 120px">Ações</th>
							<th>Nº do Documento</th>
<!--							<th>Data da Conta</th>-->
							<th>Valor Total</th>
							<th>Parcelas</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($colecao->lista as $item){ ?>
							<tr>
								<td>
									<?php echo $this->botaoAlterar($item->id);?> 
									<?php echo $this->botaoAjaxRemover($item->id); ?>
									<?php echo $this->botaoIcone('contasreceberimoveis/parcelas/'.$item->id,'icon-edit'); ?>
								</td>
								<td><?php echo $item->numero_documento; ?></td>
<!--								<td>--><?php //echo DMA($item->data_conta_pagar); ?><!--</td>-->
								<td><?php echo Util::moedaVisao($item->valor_total); ?></td>
								<td><?php echo round( $item->pagas / $item->quantidade * 100).'%'; ?></td>
							</tr>
						<?php }; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php $this->botaoCadastro('Cadastrar'); ?>