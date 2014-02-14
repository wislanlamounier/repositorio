<div class="w-box">
	<div class="w-box-header"><h4><?php echo $this->titulo_pagina; ?></h4></div>
	<div class="w-box-content cnt_a"><?php echo $colecao->form; ?></div>
</div>

<script type="text/javascript">
	$('#id_cliente').change(function(){
		$.ajax({
			url: Url('comissao/getLancamento'),
			data: {'id_cliente': $(this).val()},
			type: 'POST',
			success:function(res){
				$('#id_lancamento').html(res).removeAttr('disabled');
			}
		});
	})
</script>