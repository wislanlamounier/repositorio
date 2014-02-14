<div class="row-fluid">
	<div class="span6">
		<div class="w-box">
			<div class="w-box-header"><h4>Controle de Acesso</h4></div>
			<div class="w-box-content cnt_a">
				<div class="alert alert-info fixo"><strong>Selecione o Grupo e o Modulo para gerenciar as ações</strong></div>
				<select class="span6" id="grupo">
					<option value="0">Selecione...</option>
					<?php foreach($colecao->grupos as $item){ ?>
						<option value="<?php echo $item->id; ?>"><?php echo $item->nome; ?></option>
					<?php }; ?>
				</select>
				<select class="span6" id="modulo">
					<option value="0">Selecione..</option>
					<?php foreach($colecao->modulos as $item){ ?>
						<option value="<?php echo $item->id; ?>"><?php echo $item->descricao; ?></option>
					<?php }; ?>
				</select>
				<br />
				<a class="btn buscar-itens">Buscar</a>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="w-box">
			<div class="w-box-header"><h4>Permissões do Grupo</h4></div>
			<div class="w-box-content cnt_a">
				<div class="acoes-lista"><strong>Selecione o Filtro.</strong></div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" defer>
	$('.buscar-itens').click(function(){
		var grupo = $('#grupo').val(),
			modulo = $('#modulo').val();

		if(grupo == 0 || modulo == 0){
			$.alert('É necessário selecionar o modulo e o grupo');
		}

		$.ajax({
			url: Url('permissoes/listar-acoes'),
			type: 'GET',
			data:{'id_grupo':grupo,'id_modulo':modulo},
			success:function(res){
				$('.acoes-lista').html(res);
			}
		});
	});

	$('body').on('click', '.check-acao', function(){
		var id_grupo = $('.id_grupo').val(),
			id_modulo = $(this).attr('data-modulo'),
			id_acao  = $(this).val();

		$.ajax({
			url: Url('permissoes/sessao-acao'),
			type: 'GET',
			data:{'id_grupo':id_grupo,'id_acao':id_acao,'id_modulo':id_modulo},
			success:function(res){
				console.log(res);
			}
		});
	})
</script>