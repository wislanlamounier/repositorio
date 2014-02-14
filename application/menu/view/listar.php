<div class="row-fluid">
	<div class="w-box">
		<div class="w-box-header">
			<h4><?php echo $this->titulo_pagina; ?></h4>
		</div>
		<div class="w-box-content">
			<table class="table table-striped dataTables_full table table-striped" id="dt_gal">
			<thead>
				<tr>
					<th style="width: 10%">Ações</th>
					<th>Name</th>
					<th>Url</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($colecao->lista as $menu){ ?>
					<tr>
						<td>
							<?php echo $this->botaoAlterar($menu->id);?>
							<?php echo $this->botaoAjaxRemover($menu->id); ?>
						</td>
						<td>
							<?php if($menu->id_pai){
								 echo $menu->pai. ' / ';  
							}; ?>
							<?php echo $menu->nome; ?>
						</td>
						<td><?php echo BASEURL, '/', $menu->controller, '/', $menu->acao; ?></td>
					</tr>
			    <?php }; ?>	
			</tbody>
		</table>
	</div>
  </div>
</div>

<?php $this->botaoCadastro('Cadastrar Menu'); ?>
