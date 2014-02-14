<div class="row-fluid">
	<div class="w-box">
		<div class="w-box-header">
			<h4><?php echo $this->titulo_pagina; ?></h4>
		</div>
		<div class="w-box-content">
			<table class="table table-striped dataTables_full table table-striped" id="dt_gal">
			<thead>
				<tr>
					<th style="width: 15%">Ações</th>
					<th>Nome</th>
					<th>Descrição</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($colecao->lista as $item){ ?>
					<tr>
						<td>
							<?php echo $this->botaoIcone('permissoes/acoes/'.$item->id,'icon-th-list');?>
							<?php echo $this->botaoAlterar($item->id);?>
							<?php echo $this->botaoAjaxRemover($item->id); ?>
						</td>
						<td>
							<?php echo $item->nome; ?>
						</td>
						<td>
							<?php echo $item->descricao; ?>
						</td>
					</tr>
			    <?php }; ?>	
			</tbody>
		</table>
	</div>
  </div>
</div>

<?php $this->botaoCadastro('Cadastrar'); ?>