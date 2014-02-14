<div class="row-fluid">
	<div class="span6">
		<div class="w-box">
			<div class="w-box-header">
				<h4>Ações do Modulo</h4>
			</div>
			<div class="w-box-content">
				<table class="table table-striped dataTables_full table table-striped" id="dt_gal">
					<thead>
						<tr>
							<th style="width: 20%">Ações</th>
							<th>Descrição</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($colecao->lista as $item){ ?>
							<tr>
								<td>
									<?php echo $this->botaoIcone('permissoes/acoes/'.$_GET['id'].'/'.$item->id, 'icon-pencil'); ?>
									<?php echo $this->botaoAjax('excluir-item', 'icon-remove', array('data-href'=>BASEURL.'/permissoes/excluir-acao/'.$item->id)); ?>
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
	<div class="span6">
		<div class="w-box">
			<div class="w-box-header"><h4>Cadastro de Ação</h4></div>
			<div class="w-box-content cnt_a"><?php echo $colecao->form; ?></div>
		</div>
	</div>
</div>
