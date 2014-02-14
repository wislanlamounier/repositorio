<div class="w-box">
	<div class="w-box-header"><h4><?php echo $this->titulo_pagina; ?></h4></div>
	<div class="w-box-content cnt_a"><?php echo $colecao->form; ?></div>
</div>

<script type="text/javascript">
	$('#id_diretor').change(function(){
		$.ajax({
			url: Url('pessoa/getGerente'),
			data: {'id_diretor': $(this).val()},
			type: 'POST',
			success:function(res){
				if($('#id_grupo').val() == 3){
					$('#id_gerente').html(res).removeAttr('disabled');
				}
			}
		});
	})

	$('#id_grupo').change(function(){
	
		if($(this).val() == 2 || $(this).val() == 3){
			$('#id_diretor').removeAttr('disabled');
		}else{
			$('#id_diretor, #id_gerente').attr('disabled','disabled').val('');
		}
	})
</script>