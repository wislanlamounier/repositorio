<div class="row-fluid">
	<div class="w-box">
		<div class="w-box-header">
			<h4>Listagem dos Usuários</h4>
		</div>
		<div class="w-box-content">
			<table class="table table-striped dataTables_full table table-striped" id="dt_gal">
				<thead>
					<tr>
						<th style="width: 10%">Ações</th>
						<th>Name</th>
						<th>Email</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($colecao->lista as $usuario){ ?>
					<tr>
						<td><?php echo $this->botaoAlterar($usuario->id);?> 
							<?php echo ($usuario->status) ? $this->botaoAjaxRemover($usuario->id, true) : ''; ?>
						</td>
						<td><?php echo $usuario->nome; ?>
						</td>
						<td><?php echo $usuario->email; ?></td>
						<td><?php echo ($usuario->status) ? 'Ativo' : 'Inativo'; ?></td>
					</tr>
					<?php }; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php echo $this->botaoCadastro('Cadastrar Usuário'); ?>