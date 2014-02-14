/* Base URl do Sistema */
var BASEURL = $("#baseurl").html();

var Url = function(url) {
	var baseurl = $('#baseurl').html();
	return baseurl + '/' + url;
};

$('.selectnav').change(function(){
    var url = $(this).val();
    location.href=url;
})

$('input[type="submit"]').click(function(){	
	setTimeout(function(){
		$('.datepicker').hide('fast');
	}, 1);
})

$(function(){
	/* Ocultar o Alerta do Resultado */
		setTimeout(function() {
			$('.alert').each(function(){
				if(!$(this).hasClass('fixo')){
					$(this).fadeOut();
				}
			})
		
		}, 2000);
		
	/* coloca as mascaras nos campos */
		$('.maskTelefone').inputmask('(99) 9999-9999');
		$('.maskData').inputmask("99/99/9999");
		$('.maskCep').inputmask('99.999-999');
		$('.maskCpf').inputmask('999.999.999-99');
		$('.maskCnpj').inputmask('99.999.999/9999-99');
		$(".maskMoney").maskMoney({showSymbol:true, symbol:"R$ ", decimal:",", thousands:"."});
		
	/* Coloca o Datepiker no campo Data */
		$('.maskData').datepicker();
		
	/* Colocando o Editor TextArea */
		/* é so adicionar a Classe ckeditor no Textarea */
		
	/* Data Table */
		if($('#dt_gal').length) {
            $('#dt_gal').dataTable({
                "sPaginationType": "bootstrap_full",
    			"oLanguage" : {
    				"sProcessing" : "Aguarde enquanto os dados são carregados ...",
    				"sLengthMenu" : "Mostrar _MENU_",
    				"sZeroRecords" : "Nenhum registro correspondente ao criterio encontrado",
    				"sInfoEmtpy" : "Exibindo 0 a 0 de 0 registros",
    				"sInfo" : "Exibindo de _START_ a _END_ de _TOTAL_ registros",
    				"sInfoFiltered" : "",
    				"sSearch" : "",
    				"oPaginate" : {
    					"sFirst" : "< Primeiro",
    					"sPrevious" : "Anterior",
    					"sNext" : "Próximo",
    					"sLast" : "Último >"
    				}
    			}
            });
        }
		
	/* Alertas */
		$.alertError = function(mensagem){
			$.sticky(mensagem, {autoclose : 3000, position: "top-right", type: "st-error" });
		}
		
		$.alertSuccess = function(mensagem){
			$.sticky(mensagem, {autoclose : 3000, position: "top-right", type: "st-success" });
		}
		
		$.alert = function(mensagem){
			bootbox.alert('<strong>'+mensagem+'</strong>', function() {
				return false;
            });
		}
	/* End Alertas */
		
    /* Auto complete */
		$('.auto-complete').keyup(function(){
			var tabela = $(this).attr('data-tabela'),
				conteudo = $(this).val(),
				campo = $(this).attr('data-campo'),
				filtro = $(this).attr('data-filtro'),
				$this = $(this);
				
			 $( this ).autocomplete({
				 source: function( request, response ) {
					 $.ajax({
						 url: Url('sistema/autocomplete'),
						 type: 'GET',
						 dataType: "json",
						 data: {
							 'tabela': tabela,
							 'conteudo': conteudo,
							 'filtro':filtro
						 },
						 success: function( data ) {
							 response(data);
						 }
					 });
				 },
				 minLength: 0,
				 select: function( event, ui ) {
					 var $id = ui.item.id;
					 
					 if($id != 0){
						 $('input[name="'+campo+'"]').val($id);
					 }else{
						 $this.val('');
						 return false;
					 }
				 }
			 });
		});
			
    /* Validar o Acesso */
		
	verificarAcesso();
		
		setInterval(function(){
			verificarAcesso();
		}, 10000)
		
		
		$('.validar-unico').change(function(){
			var $this = $(this);
			var $tabela = $(this).attr('data-valida');
			var $valor = $(this).val();
			var $campo = $(this).attr('name');
			var $id = $('input[name="id"]').val();
			
			$.ajax({
				url: Url('sistema/validar-unico'),
				type: 'POST',
				data: {'tabela':$tabela,'valor':$valor,'campo':$campo,'id':$id},
				success:function(res){
					if(res == 1){
						$this.css('border-color','rgb(137, 63, 63)');
						$this.val('');
						
						$alertErro('*O valor informado já existe no banco');
					}else{
						$this.css('border-color','#CCCCCC');
					}
				}
			});
		})
})

/* Configuração do imput file personalizado */
$('body').on('change', 'input[type="file"]', function() {
	var name = $(this).attr('name').replace('[]', '');

	$('#' + name + '_cover').val($(this).val());
})

$('body').on('click', '.input_cover_btn', function() {
	var input = $(this).attr('data-input');
	$('input[name="' + input + '"]').click();
})

/* Confirmação de exclusao */
$('body').on('click', '.excluir-item', function(){
	var url = $(this).attr('data-href');
	$this = $(this);
	
	bootbox.confirm('Deseja realmente excluir?', function(e){
		if(e){
			
			var $status = ($this.hasClass('status')) ? '1' : 0;
				
			$.ajax({
				url: url+'/'+$status,
				type: 'GET',
				success:function(res){
					if($.trim(res) == ''){
						location.reload();
					}else{
						$.alertError("Impossível Excluir");
						console.log(res);
					}
				}
			});
		}
	})
})

function converterEmMoeda(numero){
		if(numero == ''){
			return parseFloat('0.00');
		}

		numero = numero.replace('R$ ','');
		numero = numero.replace('.','');
		numero = numero.replace(',', '.'); 
		return parseFloat(numero);
}

function moedaTratada(num) {
   x = 0;
   if(num<0) {
      num = Math.abs(num);
      x = 1;
   }
   if(isNaN(num)) num = "0";
      cents = Math.floor((num*100+0.5)%100);
   num = Math.floor((num*100+0.5)/100).toString();
   if(cents < 10) cents = "0" + cents;
      for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
         num = num.substring(0,num.length-(4*i+3))+'.'
               +num.substring(num.length-(4*i+3));
   ret = num + ',' + cents;
   if (x == 1) ret = ' - ' + ret;return ret;
}

function calculoExato(){

}

function verificarAcesso(){
	$.ajax({
		url: Url('acesso/verificar'),
		success:function(res){
			if(res == 0){
				$('body').append('<div id="dialog-desconectado" title="Desconectado">Você foi desconectado!</div>');
				$('#dialog-desconectado').dialog();
					
				setTimeout(function(){
					location.reload();
				}, 1000);
			}
		}
	})
}
