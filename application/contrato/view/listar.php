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
							<th>Gerado por</th>
							<th>Data da Assinatura</th>
							<th>Anexo</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($colecao->lista as $item){ ?>
							<tr>
								<td>
									<?php echo $this->botaoAlterar($item->id);?> 
									<?php echo $this->botaoAjaxRemover($item->id); ?>
								</td>
								<td><?php echo $item->gerado_por; ?></td>
								<td><?php echo DMA($item->data_assinatura); ?></td>
								<td>
									<?php if($item->anexo != '') { ?>
										<a href="<?php $this->url('arquivos/'.$item->anexo); ?>" class="btn"><i class="icon-file"></i></a>
									<?php }; ?>
								</td>
							</tr>
						<?php }; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<br />
<a href="<?php $this->url('lancamento/listar'); ?>" class="btn btn-info">Voltar<a>
<?php $this->botaoCadastro('Cadastrar'); ?>