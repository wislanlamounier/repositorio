<div class="w-box">
	<div class="w-box-header"><h4>Cadastro</h4></div>
	<div class="w-box-content cnt_a">
			<form enctype="multipart/form-data" method="post" action="http://localhost/sismobx/contaspagar/salvar" name="form" id="validate">
				<fieldset>
					<input type="hidden" value="<?php echo $colecao->conta->id; ?>" id="id" name="id"><div class="formSep"><div class="control-group">
	                        <div class="control-label"><label>Fornecedor: <span class="f_req">*</span></label></div>
	                        <div class="controls">
	                        	<select class="validate[required]" id="id_pessoa" name="id_pessoa">
	                        		<?php foreach(Conexao::selectBanco('pessoa') as $key => $item){
	                        			$selected = ($key == $colecao->conta->id_pessoa) ? 'selected="selected"' : '';
	                        			echo '<option '.$selected.' value="'.$key.'">'.$item.'</option>';
	                        		}; ?>	
	                        	</select>
	                        </div>
	                  <div class="clear"></div>
	                  </div></div><div class="formSep"><div class="control-group">
	                        <div class="control-label"><label>Conta Contábil: <span class="f_req">*</span></label></div>
	                        <div class="controls">
	                        	<select class="validate[required]" id="id_conta_contabil" name="id_conta_contabil">
	                        		<?php foreach(Conexao::selectBanco('conta_contabil') as $key => $item){
	                        			$selected = ($key == $colecao->conta->id_conta_contabil) ? 'selected="selected"' : '';
	                        			echo '<option '.$selected.' value="'.$key.'">'.$item.'</option>';
	                        		}; ?>
	                        	</select>
	                        </div>
	                  <div class="clear"></div>
	                  </div></div><div class="formSep"><div class="control-group">
	                        <div class="control-label"><label>Sub Conta Contábil: <span class="f_req">*</span></label></div>
	                        <div class="controls">
	                        	<select class="validate[required]" disabled="disabled" id="id_conta_contabil_sub" name="id_conta_contabil_sub">
	                        		<?php foreach(Conexao::selectBanco('conta_contabil_sub') as $key => $item){
	                        			$selected = ($key == $colecao->conta->id_conta_contabil_sub) ? 'selected="selected"' : '';
	                        			echo '<option '.$selected.' value="'.$key.'">'.$item.'</option>';
	                        		}; ?>
	                        	</select>
	                        </div>
	                  <div class="clear"></div>
	                  </div></div><div class="formSep"><div class="control-group">
	                        <div class="control-label"><label>Tipo de Documento: <span class="f_req">*</span></label></div>
	                        <div class="controls">
	                        	<select class="validate[required]" id="id_tipo_documento" name="id_tipo_documento">
	                        		<?php foreach(Conexao::selectBanco('tipo_documento') as $key => $item){
	                        			$selected = ($key == $colecao->conta->id_tipo_documento) ? 'selected="selected"' : '';
	                        			echo '<option '.$selected.' value="'.$key.'">'.$item.'</option>';
	                        		}; ?>
	                        	</select>
	                        </div>
	                  <div class="clear"></div>
	                  </div></div><div class="formSep"><div class="control-group">
	                        <div class="control-label"><label>Número do Documento: <span class="f_req">*</span></label></div>
	                        <div class="controls">
	                        	<input type="text" value="<?php echo $colecao->conta->numero_documento; ?>" class="validate[required]" id="numero_documento" name="numero_documento">
	                        </div>
	                  <div class="clear"></div>
	                  </div></div><div class="formSep"><div class="control-group">
	                        <div class="control-label"><label>Data de Emissão: <span class="f_req">*</span></label></div>
	                        <div class="controls">
	                        	<input type="text" value="<?php echo DMA($colecao->conta->data_emissao); ?>" class="validate[required] maskData" id="data_emissao" name="data_emissao" maxlength="20">
	                        </div>
	                  <div class="clear"></div>
	                  </div></div><div class="formSep"><div class="control-group">
	                        <div class="control-label"><label>Valor Total: <span class="f_req">*</span></label></div>
	                        <div class="controls">
	                        	<input type="text" value="<?php echo Util::moedaEdit($colecao->conta->valor_total); ?>" class="validate[required] maskMoney" id="valor_total" name="valor_total">
	                        </div>
	                  <div class="clear"></div>
	                  </div></div><div class="formSep"><div class="control-group">
	                        <div class="control-label"><label>Rateio:</label></div>
	                        <div class="controls">
	                        	<input type="checkbox" checked value="" id="rateio" name="rateio">
	                        </div>
	                  <div class="clear"></div>
	                  </div></div>

	                  <div class="formSep numero_custo">
	                  	<div class="control-group">
		                  	<div class="control-label"><label>Numero de Centro de Custos: <span class="f_req">*</span></label>
		                  	</div>
		                  	<div class="controls"><input type="text" name="numero_custo" id="numero_custo" class="validate[required]" value="<?php echo $colecao->conta->numero_custo; ?>"></div>
		                  	<div class="clear"></div>
	                  	</div>
	                 </div>

	                 <?php $i = 1; foreach($colecao->lista_rateio as $rateio){ ?>

		                 <div class="formSep numero_custo_select"><div class="control-group">
			                 <div class="control-label">
			                 	<label>Centro de Custos <?php echo $i; ?>: <span class="f_req">*</span></label>
			                 </div>
			                 <div class="controls">
				              <select name="id_centro_custo[]">
									<?php foreach(Conexao::selectBanco('centro_custo') as $key => $item){
	                        			$selected = ($key == $rateio->id_centro_custo) ? 'selected="selected"' : '';
	                        			echo '<option '.$selected.' value="'.$key.'">'.$item.'</option>';
	                        		}; ?>
							  </select>
							  <input type="text" style="margin-left:15px" class="money rateioinput" placeholder="Valor" name="valor_rateio[]" value="<?php echo Util::moedaEdit($rateio->valor); ?>">
							</div>
							<div class="clear"></div>
							</div>
						</div>

					<?php $i++; }; ?>

					<div class="formSep"><div class="control-group">
	                        <div class="control-label"><label>Data da Conta a pagar: <span class="f_req">*</span></label></div>
	                        <div class="controls">
	                        	<input type="text" value="<?php echo DMA($colecao->conta->data_conta_pagar); ?>" class="validate[required] maskData" id="data_conta_pagar" name="data_conta_pagar" maxlength="20">
	                        </div>
	                  <div class="clear"></div>
	                  </div></div>

		<div class="formSep"><div class="control-group">
	                        <div class="control-label"><label>Total de Parcelas: <span class="f_req">*</span></label></div>
	                        <div class="controls">
	                        	<input type="text" value="<?php echo $colecao->conta->total_parcelas; ?>" class="validate[required]" id="total_parcelas" name="total_parcelas" style="">
	                        </div>
	                  <div class="clear"></div>
	                  </div></div><div class="formSep"><div class="control-group">
	                        <div class="control-label"><label>Ordem de Compra:</label></div>
	                        <div class="controls">
	                        	<input type="text" value="<?php echo $colecao->conta->ordem_de_compra; ?>" id="ordem_de_compra" name="ordem_de_compra">
	                        </div>
	                  <div class="clear"></div>
	                  </div></div>
				</fieldset>
				<div class="form-actions">
					<input type="submit" class="btn btn-success" value="Salvar">
					<a onclick="javascript:window.history.go(-1);" class="btn botao-voltar-form">Voltar</a><a>
				</a></div><a>
			
		</a></form></div><a>
</a></div>


<script type="text/javascript">
$('input[type="submit"]').click(function(){
		if($('#rateio').attr("checked") == 'checked'){
			var total = converterEmMoeda($('#valor_total').val());
			var soma = 0;
			$('.rateioinput').each(function(){
				soma += converterEmMoeda($(this).val());
			})

			if(soma != total){
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
	                        	+'<input type="text" name="valor_rateio[]" placeholder="Valor" class="money" style="margin-left:15px"/>'
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