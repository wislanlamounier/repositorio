<div class="row-fluid">
	<div class="span12">
		<div class="w-box">
			<div class="w-box-header">
				<h4>Parcelas</h4>
			</div>
			<div class="w-box-content">
				<table class="table table-striped dataTables_full table table-striped" id="dt_gal">
					<thead>
						<tr>
							<th style="width: 100px">Ações</th>
							<th style="width: 30px">Parcela</th>
							<th>Valor</th>
							<th>Vencimento</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($colecao->lista as $item){ ?>
							<tr>
								<td>
									<?php
                                        /** @var $this Html */

										if($item->status){
											echo $this->botaoIcone('contaspagar/verpagamento/'.$item->id_pagamento, 'icon-search');
                                        }else{
											echo $this->botaoIcone('contaspagar/pagarparcela/'.$item->id, 'icon-thumbs-up');
                                            echo $this->botaoAjax('excluir-parcela','icon-remove',array('data-id'=>$item->id));
										}


									?>
								</td>
								<td><?php echo $item->numero_parcela; ?></td>
								<td>R$ <?php echo number_format($item->valor, 2, ',', '.'); ?></td>
								<td><?php echo DMA($item->data_vencimento); ?></td>
								<td><?php echo Parcela::getStatus($item->status); ?></td>
							</tr>
						<?php }; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<br />
<div class="row">
		<a class="btn pull-right" href="<?php $this->url('contaspagar/listar'); ?>" >Voltar</a>
</div>

<script type="text/javascript">
    $(function(){
        $('body').on('click','.excluir-parcela', function(){
            var id = $(this).attr('data-id');
            if(!confirm('Deseja realmente excluir?')){
                return false;
            }

            $.ajax({
                url: Url('contaspagar/excluir-parcela/'+id),
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
    })
</script>
