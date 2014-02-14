var baseurl = $('#baseurl').html();

$.fn.validarCPF = function() {
    cpf = $(this).val().replace(/[^\d]+/g,'');
 
    if(cpf == '') return false;
 
    // Elimina CPFs invalidos conhecidos
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
     
    // Valida 1o digito
    add = 0;
    for (i=0; i < 9; i ++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
     
    // Valida 2o digito
    add = 0;
    for (i = 0; i < 10; i ++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
         
    return true;
    
}

$.fn.validarCNPJ = function() {

	cnpj = $(this).val().replace(/[^\d]+/g,'');

	if(cnpj == '') return false;
	
	if (cnpj.length != 14)
		return false;

	// Elimina CNPJs invalidos conhecidos
	if (cnpj == "00000000000000" || 
		cnpj == "11111111111111" || 
		cnpj == "22222222222222" || 
		cnpj == "33333333333333" || 
		cnpj == "44444444444444" || 
		cnpj == "55555555555555" || 
		cnpj == "66666666666666" || 
		cnpj == "77777777777777" || 
		cnpj == "88888888888888" || 
		cnpj == "99999999999999")
		return false;
		
	// Valida DVs
	tamanho = cnpj.length - 2
	numeros = cnpj.substring(0,tamanho);
	digitos = cnpj.substring(tamanho);
	soma = 0;
	pos = tamanho - 7;
	for (i = tamanho; i >= 1; i--) {
	  soma += numeros.charAt(tamanho - i) * pos--;
	  if (pos < 2)
			pos = 9;
	}
	resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	if (resultado != digitos.charAt(0))
		return false;
		
	tamanho = tamanho + 1;
	numeros = cnpj.substring(0,tamanho);
	soma = 0;
	pos = tamanho - 7;
	for (i = tamanho; i >= 1; i--) {
	  soma += numeros.charAt(tamanho - i) * pos--;
	  if (pos < 2)
			pos = 9;
	}
	resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
	if (resultado != digitos.charAt(1))
		  return false;
		  
	return true;
   
}

$.fn.validarData = function() 
{
	var bissexto = 0;
	var data = $(this).val(); 
	var tam = data.length;
	if (tam == 10) 
	{
		var dia = data.substr(0,2)
		var mes = data.substr(3,2)
		var ano = data.substr(6,4)
		if ((ano > 1900)||(ano < 2100))
		{
			switch (mes) 
			{
				case '01':
				case '03':
				case '05':
				case '07':
				case '08':
				case '10':
				case '12':
					if  (dia <= 31) 
					{
						return true;
					}
					break
				
				case '04':		
				case '06':
				case '09':
				case '11':
					if  (dia <= 30) 
					{
						return true;
					}
					break
				case '02':
					/* Validando ano Bissexto / fevereiro / dia */ 
					if ((ano % 4 == 0) || (ano % 100 == 0) || (ano % 400 == 0)) 
					{ 
						bissexto = 1; 
					} 
					if ((bissexto == 1) && (dia <= 29)) 
					{ 
						return true;				 
					} 
					if ((bissexto != 1) && (dia <= 28)) 
					{ 
						return true; 
					}			
					break						
			}
		}
	}	
	return false;
}

$.fn.somenteNumeros = function(){
	$(this).keydown(function(e) {
		   if(e.shiftKey) e.preventDefault();
		   if (!((e.keyCode==46) || (e.keyCode==8) 		//DEL e Backspace
			   || ((e.keyCode>=35) && (e.keyCode<=40)) 	//HOME, END, Setas
			   || ((e.keyCode>=96) && (e.keyCode<=105)) //Númerod Pad
			   || ((e.keyCode>=48) && (e.keyCode<=57)))) e.preventDefault(); //Números
	});
}

 $.fn.validaremaildns = function(){
		var $email = $(this).val();
		if(!$email){
			$('#myModal').abrirModal('Digite o email');
			return false;
		}
		
		$.ajax({
			url:Url('sistema/validar-email-dns'),
			data:{'email':$email},
			type:'get',
			dataType:'json',
			success:function(res){
				if(res.resultado != 'ok'){													
					$('#myModal').abrirModal('Seu email não responde.');
                                        return false;
				}
			}
		})
	}
	
