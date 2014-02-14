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
							<th style="width: 10%">Ações</th>
							<th>Centro de Custo</th>
							<th>Conta Corrente</th>
							<th>Conta Contábil</th>
							<th>Sub Conta Contábil</th>
							<th>Data</th>
							<th>Valor</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($colecao->lista as $item){ ?>
							<tr>
								<td>
									<?php echo $this->botaoAlterar($item->id);?> 
									<?php echo $this->botaoAjaxRemover($item->id); ?>
								</td>
								<td><?php echo $item->centro_de_custo; ?></td>
								<td><?php echo $item->conta; ?></td>
								<td><?php echo $item->contac; ?></td>
								<td><?php echo $item->contas; ?></td>
								<td><?php echo DMA($item->data); ?></td>
								<td><?php echo Util::moedaVisao($item->valor); ?></td>
							</tr>
						<?php }; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php $this->botaoCadastro('Cadastrar'); ?>