<div class="w-box">
	<div class="w-box-header"><h4>Pagamento da Parcela</h4></div>
	<div class="w-box-content cnt_a"><?php echo $colecao->form; ?></div>
</div>

<script type="text/javascript">
	$('.juros, .desconto, .parcela').blur(function(){
		var valor = atualizarValor();

		$('.pagamento').val( 'R$ '+ moedaTratada(valor) );
	})

	function atualizarValor(){
		var juros = converterEmMoeda($('.juros').val());
		var valor_parcela = converterEmMoeda($('.parcela').val());
		var desconto = converterEmMoeda($('.desconto').val());

		return valor_parcela + juros - desconto;
	}


	$('#id_forma_pagamento').change(function(){
		if ($(this).find('option:selected').text() == 'CHEQUE'){
			$('#numero_cheque').removeAttr("readonly");	
		}else{
			$('#numero_cheque').attr("readonly", true);
		}
		
	})


</script>