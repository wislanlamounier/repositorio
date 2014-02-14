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
							<th style="width: 150px">Ações</th>
							<th>Favorecido</th>
							<th>Vencimento</th>
							<th>Valor</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($colecao->lista as $item){ ?>
							<tr>
								<td>
									<?php echo $this->botaoAlterar($item->id_comisssao);?> 
									<?php echo $this->botaoAjaxRemover($item->id_comisssao); ?>
									<?php 
										if($item->status != 3){
											echo $this->botaoIcone('comissao/efetuar/'.$item->id_comisssao, 'icon-ok-circle'); 
										}	
									?>
								</td>
								<td><?php echo $item->nome; ?></td>
								<td><?php echo DMA($item->data_vencimento); ?></td>
								<td><?php echo Util::moedaVisao($item->valor); ?></td>
								<td><?php echo Comissao::getStatus($item->status); ?></td>
							</tr>
						<?php }; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php $this->botaoCadastro('Cadastrar'); ?>