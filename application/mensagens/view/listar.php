<div class="responder"></div>
<br />
<div class="row-fluid">
	<div class="span12">
		<div class="w-box">
			<div class="w-box-header">
				<h4>
					<?php echo $this->titulo_pagina; ?>
				</h4>
			</div>
			<div class="w-box-content">
				<table
					class="table table-striped dataTables_full table table-striped"
					id="dt_gal">
					<thead>
						<tr>
							<th width="100">#</th>
							<th width="50">Envio</th>
							<th>Nome</th>
							<th>Email</th>
							<th>Telefone</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($colecao->lista as $key=>$value) { ?>
						<tr>
							<td><?php $this->botaoAjax('responderMensagem', 'icon-pencil', array('data-id'=>$value->id)); ?>
								<?php $this->botaoAjaxRemover($value->id); ?></td>
							<td><?php echo DMA($value->data); ?></td>
							<td><strong><?php echo $value->nome; ?> </strong></td>
							<td><?php echo $value->email; ?></td>
							<td><?php echo $value->telefone; ?></td>
							<td><?php echo $colecao->objMensagem->arrStatus($value->status); ?>
							</td>
						</tr>
						<?php }; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script defer type="text/javascript">
	$('body').on('click', '.responderMensagem', function(){
		var id = $(this).attr('data-id');
		
		
		$.ajax({
		   url: Url('mensagens/responder'),
		   type: 'POST',
		   data: {'id':id},
		   success:function(res){
			   $('.loadingPro').hide();
			   $('.responder').html(res);
		   },
		   beforeSend: function(){
				$('.loadingPro').show();
				$('.responder').html('');
		   }
		});	
		
		return false;
	}).on('submit', '.form', function(){
		if($('#resposta').val() == ''){
			$.jGrowl('Digite a Resposta!');
			$('#resposta').css('border-color', 'rgb(137, 63, 63)').focus();
			return false;
		}
	}).on('focus', '.readonly', function(){
		$.alertError('N&atilde;o &eacute; Possivel Alterar a Resposta');
		$(this).blur();
	});

</script>
