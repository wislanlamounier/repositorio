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
							<th style="width: 170px">Ações</th>
							<th>Nome Cliente</th>
							<th>Data Venda</th>
							<th>Valor Venda</th>
							<th>Empreendimento</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($colecao->lista as $item){ ?>
						<?php //debug($item); ?>
							<tr>
								<td>
									<?php echo $this->botaoAlterar($item->id_lancamento);?> 
									<?php echo $this->botaoAjaxRemover($item->id_lancamento); ?>
									<?php echo $this->botaoIcone('comissao/lancamento/'.$item->id_lancamento,'icon-edit'); ?>
									<?php echo $this->botaoIcone('contrato/listar/'.$item->id_lancamento,'icon-file'); ?>
								</td>
								<td><?php echo $item->nome; ?></td>
								<td><?php echo DMA($item->data_venda); ?></td>
								<td><?php echo @Util::moedaVisao($item->valor_venda); ?></td>
								<td><?php echo $item->empreendimento; ?></td>
							</tr>
						<?php }; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php $this->botaoCadastro('Cadastrar'); ?>