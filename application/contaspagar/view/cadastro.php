<div class="w-box">
	<div class="w-box-header"><h4><?php echo $this->titulo_pagina; ?></h4></div>
	<div class="w-box-content cnt_a"><?php echo $colecao->form; ?></div>
</div>

<div class="hold" style="display:none">
	<select id="centro_de_custo">
		<option value="">Selecione...</option>
		<?php foreach(Conexao::selectBanco('centro_custo') as $key => $value){
			echo '<option value="'.$key.'">'.$value.'</option>';
		}?>
	</select>
</div>

<script type="text/javascript">
	
	$('input[type="submit"]').click(function(){
		if($('#rateio').attr("checked") == 'checked'){
			var total = converterEmMoeda($('#valor_total').val());
			var soma = 0;
			$('.rateioinput').each(function(){
				soma += converterEmMoeda($(this).val());
			})
console.log(soma.toFixed(2));
			if(soma.toFixed(2) != total){
				$.alertError('*A soma do rateio deve ser igual ao total da conta!');
				return false;
			}

		}
	})

	$('#id_conta_contabil').change(function(){
		$.ajax({
			url: Url('contacontabil/getsubcontas'),
			type: 'POST',
			data: {'id_conta':$(this).val()},
			success: function(res){
				$('#id_conta_contabil_sub').html(res).removeAttr('disabled');
			}
		})
	})

	$('#numero_custo').live('change', function(){
		var select = '<select name="id_centro_custo[]">'+$('#centro_de_custo').html()+'</select>';

		$('.numero_custo_select').remove();

		var loop = parseInt($(this).val()) + 1;
		for(var i = 1; i <= $(this).val(); i++){
		var html = '<div class="formSep numero_custo_select"><div class="control-group">'
	                        +'<div class="control-label"><label>Centro de Custos '+(loop - i)+': <span class="f_req">*</span></label></div>'
	                        +'<div class="controls">'
	                        	+select
	                        	+'<input type="text" name="valor_rateio[]" placeholder="Valor" class="money rateioinput" style="margin-left:15px"/>'
	                        +'</div>'
	                  +'<div class="clear"></div>'
	                  +'</div></div>';
		
			$('.numero_custo').after(html);

			//	loop++;
		}
	})

	$('.money').live('click', function(){
		if(!$(this).hasClass('tratado')){
			$(this).addClass("tratado");
			$(this).maskMoney({showSymbol:true, symbol:"R$ ", decimal:",", thousands:"."});
		}
	})

	$('#rateio').change(function(){
		var ch = $(this).attr('checked'),
			i  = $(this).parents('.formSep');

		/// Checado
		if(ch == 'checked'){
			$('#id_centro_custo_final').parents('.formSep').remove();

			var html = '<div class="formSep numero_custo"><div class="control-group">'
	                        +'<div class="control-label"><label>Numero de Centro de Custos: <span class="f_req">*</span></label></div>'
	                        +'<div class="controls">'
	                        	+'<input type="text" value="" class="validate[required]" id="numero_custo" name="numero_custo" >'
	                        +'</div>'
	                  +'<div class="clear"></div>'
	                  +'</div></div>';

			i.after(html);
		}else{
			$('.numero_custo, .numero_custo_select').remove();

			var select = '<select name="id_centro_custo_final" id="id_centro_custo_final">'+$('#centro_de_custo').html()+'</select>';
			var html = '<div class="formSep numero_custo_select"><div class="control-group">'
	                        +'<div class="control-label"><label>Centro de Custos: <span class="f_req">*</span></label></div>'
	                        +'<div class="controls">'
	                        	+select
	                        +'</div>'
	                  +'<div class="clear"></div>';

	        $('#rateio').parents('.formSep').after(html);
	    }
	
	})
</script>