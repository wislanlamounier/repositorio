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
							<th style="width: 210px">Ações</th>
							<th>Nome</th>
							<th>CNPJ</th>
							<th>Cidade</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($colecao->lista as $item){ ?>
							<tr>
								<td>
									<?php echo $this->botaoAlterar($item->id);?> 
									<?php echo $this->botaoAjaxRemover($item->id); ?>
									<?php echo $this->botaoIcone('construtora/empreendimento/'.$item->id,'icon-th-list'); ?> 
								</td>
								<td><?php echo $item->nome; ?></td>
								<td><?php echo $item->cnpj; ?></td>
								<td><?php echo $item->cidade; ?></td>
							</tr>
						<?php }; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php $this->botaoCadastro('Cadastrar'); ?>

