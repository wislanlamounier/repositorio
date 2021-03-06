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
							<th>Banco</th>
							<th>Agência</th>
							<th>Conta Corrente</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($colecao->lista as $item){ ?>
							<tr>
								<td>
									<?php echo $this->botaoAlterar($item->id);?> 
									<?php echo $this->botaoAjaxRemover($item->id); ?>
                                    <?php echo $this->botaoIcone('contacorrente/extrato/'.$item->id,'icon-list'); ?>
								</td>
								<td><?php echo $item->nome; ?></td>
								<td><?php echo $item->agencia; ?></td>
								<td><?php echo $item->conta_corrente; ?></td>
							</tr>
						<?php }; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php $this->botaoCadastro('Cadastrar'); ?>