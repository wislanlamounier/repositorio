<div class="row-fluid">
	<div class="span6">
		<div class="w-box">
			<div class="w-box-header">
				<h4>Lista de Sub Contas</h4>
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
									<?php echo $this->botaoIcone('construtora/empreendimento/'.$item->id_construtora.'/'.$item->id,'icon-pencil'); ?> 
									<?php echo $this->botaoIcone('construtora/mpreendimentoexcluir/'.$item->id,'icon-remove'); ?>
								</td>
								<td><?php echo $item->nome; ?></td>
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
				<h4>Dados do Empreendimento</h4>
			</div>
			<div class="w-box-content">
				<?php echo $colecao->form; ?>
			</div>
		</div>
	</div>
</div>