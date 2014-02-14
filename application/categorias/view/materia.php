<div class="row-fluid">
	<div class="span12">
		<div class="span6">
			<div class="w-box">
				<div class="w-box-header">
					<h4>Categorias</h4>
				</div>
				<div class="w-box-content">
					<table
						class="table table-striped dataTables_full table table-striped"
						id="dt_gal">
						<thead>
							<tr>
								<th style="width: 15%">Ações</th>
								<th>Nome</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($colecao->lista as $item){ ?>
							<tr>
								<td><?php echo $this->botaoIcone('categorias/'.$_GET['acao'].'/'.$item->id, 'icon-pencil');?>
									<?php echo $this->botaoAjaxRemover($_GET['acao'].'/'.$item->id); ?>
								</td>
								<td><?php echo $item->nome; ?>
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
				<div class="w-box-header">
					<h4>Cadastro de Categoria</h4>
				</div>
				<div class="w-box-content">
					<?php echo $colecao->form; ?>
				</div>
			</div>
		</div>
	</div>
</div>