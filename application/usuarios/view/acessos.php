<div class="row-fluid">
	<div class="w-box">
		<div class="w-box-header">Usuários Online</div>
		<div class="w-box-content">
			<table class="table table-striped dataTables_full table table-striped" id="dt_gal">
				<thead>
					<tr>
						<th style="width: 5%">Ações</th>
						<th>Name</th>
						<th>Dados do Login</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($colecao->lista as $acesso){ ?>
						<tr>
							<td>
								<?php echo $this->botaoAjax('cancelar-acesso', 'icon-off',array('title'=>'Desconectar Usuário','data-id'=>$acesso->id_acesso));?>
							</td>
							<td>
								<?php echo $acesso->nome; ?>
							</td>
							<td><?php echo $acesso->dados_login; ?></td>
						</tr>
				    <?php }; ?>	
				</tbody>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('body').on('click','.cancelar-acesso',function(event){
		event.preventDefault();

		var id = $(this).attr('data-id');

		$.ajax({
			url: Url('acesso/cancelar'),
			type:'post',
			data:{'id_acesso':id},
			success:function(res){
				if(res == ''){
					location.reload();
				}else{
					$alertErro('Não foi possivel desconectar o usuário');
					console.log(res);
				}
			}
		});
	})
</script>