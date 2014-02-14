$(function(){
	$('.tipo-cartao').click(function(){
		$('.tipo-cartao').removeClass('ativo');
		$(this).addClass('ativo');
		
		$('input[name="tipo_cartao"]').val($(this).attr('data-id'));
		$('.label_cartao').html($(this).attr('data-label'));
	})
	
	$('#uf').change(function(){
		var $uf = $(this).val(); 
		
		if($uf == ''){
			$('#myModal').abrirModal('Selecione um Estado Válido');
			return false;
		}
		
		$.ajax({
			url: Url('sistema/buscar-cidades'),
			type: 'post',
			data: {'uf': $uf},
			success:function(res){
				$('#cidade').html(res);
				$('#cidade').removeAttr('disabled');
			}
		})
	});
	
	/// busca pelo código
	if($('.cod-indicacao').val() != ''){
		buscarIndicacao();
	}
	
	/// Validacoes
	$('.maskCpf').blur(function(){
		if(!$(this).validarCPF()){
			$(this).val('');
			$(this).parents('.control-group').addClass('error');
		}else{
			$(this).parents('.control-group').removeClass('error');
		};
	})
	
	$('.maskCnpj').blur(function(){
		if(!$(this).validarCNPJ()){
			$(this).val('');
			$(this).parents('.control-group').addClass('error');
		}else{
			$(this).parents('.control-group').removeClass('error');
		};
	})
	
	$('.maskData').blur(function(){
		if(!$(this).validarData()){
			$(this).val('');
			$(this).parents('.control-group').addClass('error');
		}else{
			$(this).parents('.control-group').removeClass('error');
		};
	})
	
	$('.maskNumeros').somenteNumeros();
        
        $('.validar-email-dns').change(function(){
		$(this).validaremaildns();
	})

        $('.validar-email').change(function(){
		var $email = $(this).val();
                var $email_igual = $('.email').val();
                
                if($email != $email_igual){
                        $('#myModal').abrirModal('Os emails informados devem ser iguais.');
			return false;
                }
                
	})
        
      $('.validar-senha').change(function(){
		var $senha = $(this).val();
                var $senha_igual = $('#senha').val();
                
                if($senha != $senha_igual){
                        $('#myModal').abrirModal('As senhas informadas devem ser iguais.');
			return false;
                }
                
	})
        
        $('.limpar-senha').change(function(){
		$('#senha-validar').val('');
	})

	$('.validar-unico').change(function(){
		var $this = $(this);
		var $tabela = $(this).attr('data-valida');
		var $valor = $(this).val();
		var $campo = ($(this).attr('data-campo')) ? $(this).attr('data-campo') : $(this).attr('name');
		var $id = $('input[name="id"]').val();
		
		$.ajax({
			url: Url('sistema/validar-unico'),
			type: 'POST',
			data: {'tabela':$tabela,'valor':$valor,'campo':$campo,'id':$id},
			success:function(res){
				if(res == 1){
					$this.val('');
					$this.parents('.control-group').addClass('error');
					
					$('#myModal').abrirModal('O valor informado já esta cadastrado');
				}else{
					$this.parents('.control-group').removeClass('error');
				}
			}
		});
	})
	
	$('.buscar-indicacao').click(function(){
		buscarIndicacao();
	})
	
	$('select[name="tipo_cadastro"]').change(function(){
		if(!$(this).val()){
			$('#myModal').abrirModal('Selecione o Tipo de Cadastro');
			return false;
		}
		
		var tipo = ($(this).val() == 1) ? 'fisica' : 'juridica'; 
		
		$('.pessoa_juridica, .pessoa_fisica').hide();
		$('.pessoa_'+tipo).show();
	})
	
	$('form[name="form-cadastro"]').submit(function(event){
		if($('.tipo_cadastro').val() == 1){
			if($('input[name="cpf"]').val().length == 0){
				$('#myModal').abrirModal('Digite o CPF');
				return false;
			}
			if($('input[name="rg"]').val().length == 0){
				$('#myModal').abrirModal('Digite o RG');
				return false;
			}
			if($('input[name="orgao_rg"]').val().length == 0){
				$('#myModal').abrirModal('Digite o Orgão Emissor do RG');
				return false;
			}
			if(!$('#termo_uso').attr("checked")){
				$('#myModal').abrirModal('É necessário aceitar os termos de uso.');
				return false;
			}
		}else{
			if($('input[name="cnpj"]').val().length == 0){   
				$('#myModal').abrirModal('Digite o CNPJ');
				return false;
			}
			if($('input[name="inscricao_estadual"]').val().length == 0){
				$('#myModal').abrirModal('Digite a Inscrição estadual');
				return false;
			}
		}
		if($('.valicao-codigo').val() != $('.valicao').val()){
			$('#myModal').abrirModal('A Captcha não confere.');
			return false;
		}
		
		$('.submitbtn').attr('disabled','disabled');
	})
})

function Url(url){
	return $('#baseurl').html()+'/'+url;
}

$.fn.abrirModal = function(texto){
	$('.modal-body').html(texto);
	$(this).modal();
}

function buscarIndicacao(){
	var $codigo = $('.cod-indicacao').val();
	if(!$codigo){
		$('#myModal').abrirModal('Digite o Codigo de indicação ');
		return false;
	}
	
	$.ajax({
		url:Url('site/buscar-codigo'),
		data:{'codigo':$codigo},
		type:'get',
		dataType:'json',
		success:function(res){
			if(res.resultado == 'ok'){
				$('.nome_indicado').html(res.nome);
				$('input[name="codigo_indicacao"]').val(res.codigo);
				$('.form-oculto').slideDown('slow');
			}else{
				$('.nome_indicado').html(res.nome);
				$('.form-oculto').slideUp('slow');
				$('input[name="codigo_indicacao"]').val('');
			}
		}
	})
}