<div class="row-fluid">
	<div class="span6">
		<div class="w-box">
			<div class="w-box-header"><h4>Categorias</h4></div>
			<div class="w-box-content">
				<table class="table table-bordered table-striped table_vam" id="dt_gal">
					<thead>
						<tr>
							<th style="width: 20%">Ações</th>
							<th>Nome</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($colecao->lista as $item){ ?>
							<tr>
								<td>
									<?php echo $this->botaoIcone('usuarios/grupos/'.$item->id, 'icon-pencil');?>
									<?php echo $this->botaoAjaxRemover('usuarios/excluir-grupo/'.$item->id); ?>
								</td>
								<td>
									<?php echo $item->nome; ?>
								</td>
							</tr>
					    <?php }; ?>	
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div class="span6">
		<div class="w-box">
			<div class="w-box-header"><h4>Cadastro de Grupos</h4></div>
			<div class="w-box-content cnt_a"><?php echo $colecao->form; ?></div>
		</div>
	</div>
</div>
