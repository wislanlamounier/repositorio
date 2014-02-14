<div class="row-fluid">
	<div class="w-box">
		<div class="w-box-header"><h4>Listagem</h4></div>
		<div class="w-box-content">
			<table class="table table-striped dataTables_full table table-striped" id="dt_gal">
			<thead>
				<tr>
					<th style="width: 5%">Ações</th>
					<th>Codigo</th>
					<th>Usuario</th>
					<th>Tabela</th>
					<th>Tipo de Operação</th>
					<th>Data/Hora</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($colecao->lista as $log){ ?>
					<tr>
						<td>
							<?php
								echo $this->botaoAjax('reverter-atualizacao','icon-refresh', array('title'=>'Reverter Ação'));
							?>
							<div class="comando" style="display: none">
								<?php echo $log->sql_revert; ?>
							</div>
							<div class="codigo" style="display: none">
								<?php echo $log->id; ?>
							</div>
						</td>
						<td><?php echo $log->id; ?></td>
						<td><?php echo $log->usuario; ?></td>
						<td><?php echo $log->tabela; ?></td>
						<td><?php echo $log->tipo_operacao; ?></td>
						<td><?php echo DMA($log->data),' - ',$log->hora; ?></td>
					</tr>
			    <?php }; ?>	
			</tbody>
		</table>
		</div>
	</div>
</div>
<hr />
<?php // echo $this->botaoCadastro('Cadastrar Usuário'); ?>

<script type="text/javascript">
	$('.reverter-atualizacao').click(function(){
		var i = $('.reverter-atualizacao').index(this);
		var sql = $('.comando').eq(i).html();
		var codigo = $('.codigo').eq(i).html();

		bootbox.confirm('Deseja realmente executar essa operação?', function(e){
			if(e){
				$.ajax({
					url: Url('usuarios/log-reverter'),
					type: 'POST',
					data:{'codigo':codigo},
					success:function(res){
						if($.trim(res) == ''){
							location.reload();
						}else{
							$.alertError("Impossível Executar");
							console.log(res);
						}
					}
				});
			}
		});
	})
</script>