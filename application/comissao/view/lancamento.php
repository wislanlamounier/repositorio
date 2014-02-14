<div class="row-fluid">
	<div class="span12">
		<div class="w-box">
			<div class="w-box-header">
				<h4>Dados do Lançamento</h4>
			</div>
			<div class="w-box-content">
				<table class="table table-striped dataTables_full table table-striped">
					<thead>
						<tr>
							<th>Cliente</th>
							<th>Empreendimento</th>
							<th>Número</th>
							<th>Bloco</th>
							<th>QD</th>
						</tr>
					</thead>
					<tbody>
							<tr>
								<td><?php echo $colecao->lancamento->nome; ?></td>
								<td><?php echo $colecao->lancamento->empreendimento; ?></td>
								<td><?php echo $colecao->lancamento->empreendimento_numero; ?></td>
								<td><?php echo $colecao->lancamento->empreendimento_bloco; ?></td>
								<td><?php echo $colecao->lancamento->empreendimento_quadra; ?></td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="w-box">
			<div class="w-box-header">
				<h4>Comissões</h4>
			</div>
			<div class="w-box-content">
				<table class="table  dataTables_full " id="dt_gal">
					<thead>
						<tr>
							<th style="width: 50px">Ações</th>
							<th>PJ</th>
							<th>Nota Fiscal</th>
							<th>Tipo de Comissão</th>
							<th>Valor Comissão</th>
							<th>Forma de Pagamento</th>
							<th>Vencimento</th>
							<th>Nº Cheque</th>
							<th>Banco</th>
							<th>Titular do Cheque</th>
							<th>Situação</th>
						</tr>
					</thead>
					<tbody>
						<?php  foreach($colecao->lista as $item){ ?>
							<tr class="<?=($item->devolvido == 1 && $item->status != 2) ? 'warning' : ''?>">
								<td>
									<?php
										if($item->status == 2)
                                        {
											echo 'Pago em: '.DMA($item->data_recebimento);

                                            if($item->id_forma_pagamento == 5){
                                                echo $this->botaoIcone('#modalBaixa', 'icon-asterisk', '', ' role="button" data-toggle="modal"
                                                data-id="'.$item->id.'"
                                                data-valor="'.@Util::moedaVisao($item->valor, false).'"
                                                data-nota="'.$item->nota_fiscal.'"
                                                data-pagamento="'.$item->id_tipo_comissao.'"
                                                data-forma-pagamento="'.$item->id_forma_pagamento.'"
                                                data-devolvido="'.$item->devolvido.'"
                                                data-status="'.$item->status.'"','dar-baixa');
                                            }
										}
                                        else
                                        {
						if ($item->status != 3){
						echo $this->botaoIcone('#modalBaixa', 'icon-asterisk', '', ' role="button" data-toggle="modal"
                                                data-id="'.$item->id.'"
                                                data-valor="'.@Util::moedaVisao($item->valor, false).'"
                                                data-nota="'.$item->nota_fiscal.'"
                                                data-pagamento="'.$item->id_tipo_comissao.'"
                                                data-forma-pagamento="'.$item->id_forma_pagamento.'"
                                                data-devolvido="'.$item->devolvido.'"
                                                data-status="'.$item->status.'"','dar-baixa');
                                                }

                                            echo $this->botaoAjax('excluir-comissao','icon-remove',array('data-id'=>$item->id));
										}
									?>
								</td>
								<td><?php echo ($item->pj) ? 'Sim' : 'Não'; ?></td>
								<td><?php echo $item->nota_fiscal; ?></td>
								<td><?php echo $item->tipo_comissao; ?></td>
								<td><?php echo @Util::moedaVisao($item->valor); ?></td>
								<td><?php echo $item->forma_pagamento; ?></td>
								<td><?php echo DMA($item->data_vencimento); ?></td>
								<td><?php echo $item->numero_cheque; ?></td>
								<td><?php echo $item->banco; ?></td>
								<td><?php echo $item->titular_cheque; ?></td>
								<td><?php echo $colecao->comissao->getStatus($item->status); ?></td>
							</tr>
						<?php };  ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<br />
    <!-- Button to trigger modal -->
    <a href="#myModal" role="button" class="btn pull-right" data-toggle="modal">Inserir Comissão</a>

    <!-- Modal -->
    <div id="modalBaixa" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Dados da Baixa</h3>
    </div>
    <div class="modal-body">
        <div class="baixa">
    	    <?php echo $colecao->baixa; ?>
        </div>
    </div>
    </div>
</a>
    <!-- Modal -->
    <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Dados da Comissão</h3>
    </div>
    <div class="modal-body">
    	<?php echo $colecao->form; ?>
    </div>
    </div>

<script type="text/javascript">
	$(function(){
        var cheque = 5;
        var tipo_comissao_imobiliaria = 5;
        var comissao_imob = 10;

        $('body').on('click','.excluir-comissao',function(){
            var id = $(this).attr('data-id');
            if(!confirm('Deseja realmente excluir?')){
                return false;
            }

            $.ajax({
                url: Url('comissao/excluir/'+id),
                type: 'get',
                success:function(res){
                    if(res == ''){
                        location.reload();
                    }else{
                        alert('houve um erro');
                        console.log(res);
                    }
                }
            })

        })

        $('.devolvido').parents('.formSep').hide()
        $('.segunda_devolucao').parents('.formSep').hide();

        $('#devolvido').change(function(){
            if($(this).val() == '1'){
                $('.devolvido').parents('.formSep').show();
            }else{
                $('.devolvido').parents('.formSep').hide();
            }
        })

		$('.dar-baixa').click(function(){
            if($(this).attr('data-forma-pagamento') != cheque || $(this).attr('data-devolvido') == 1){
                $('#devolvido').parents('.formSep').hide();
            }else{
                $('#devolvido').parents('.formSep').show();
            }

            if($(this).attr('data-devolvido') == 1){
                $('.segunda_devolucao').parents('.formSep').show();
            }else{
                $('.segunda_devolucao').parents('.formSep').hide();
            }

            if($(this).attr('data-status') == 3){
                $('.devolvido').parents('.formSep').hide()
                $('.segunda_devolucao').parents('.formSep').hide();
            }

			var id = $(this).attr('data-id');
			var tipo = $(this).attr('data-pagamento');

			$('#id').val(id);

			if(tipo != comissao_imob){
				$('#id_conta_corrente').parents('.formSep').hide();
			}else{
				$('#id_conta_corrente').parents('.formSep').show();
			}

            $('.baixa form #valor').val( $(this).attr('data-valor') );
            $('.baixa form #nota_fiscal').val( $(this).attr('data-nota') );
		})

        $('#juros, #descontos, #valor').blur(function(){
            var valor = atualizarValor();

            $('#valor').val( 'R$ '+ moedaTratada(valor) );
        })

        function atualizarValor(){
            var juros = converterEmMoeda($('#juros').val());
            var valor_parcela = converterEmMoeda($('#valor').val());
            var desconto = converterEmMoeda($('#descontos').val());

            return valor_parcela + juros - desconto;
        }
	})
</script>
