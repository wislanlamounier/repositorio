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
						</tr>
					</thead>
					<tbody>
						<?php foreach($colecao->lista as $item){ ?>
							<tr>
								<td>
									<?php echo $this->botaoAlterar($item->id);?> 
									<?php echo $this->botaoAjaxRemover($item->id); ?>
									<?php echo $this->botaoIcone('pessoa/dadosfisica/'.$item->id,'icon-user'); ?> 
									<?php echo $this->botaoIcone('pessoa/dadosjuridica/'.$item->id,'icon-briefcase'); ?> 
									<?php echo $this->botaoIcone('pessoa/dadoscliente/'.$item->id,'icon-shopping-cart'); ?> 
								</td>
								<td><?php echo $item->nome; ?></td>
							</tr>
						<?php }; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php $this->botaoCadastro('Cadastrar'); ?>