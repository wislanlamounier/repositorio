<?php
class Form {
	
	static function create($form, $action='', $metodo='post', $name=''){
		$string = '';
		foreach($form as $key=>$value){
		$obrigatorio = false;
		$value_input = '';
		
			/**
			 * value[0] = tipo input
			 * value[1] = label
			 * value[2] = atributos
			 * key = nome campo
			 */
		
			$nome = $key;
			$tipo_input = $value[0];
			$label = $value[1];

			if (isset($value[2])){
				$atributos = is_array($value[2]) ? $value[2] : array();
			}else{
				$atributos = array();
			}
			
			$arrayInputs = array(
				'input',
				'checkbox',
				'password',
				'radio',
				'file',
				'submit'
			);
			
			switch (true) {
				case in_array($tipo_input, $arrayInputs):
					
					/// Pega o Value do Input
					if(isset($atributos['value'])){
						$value_input = $atributos['value'];
						unset($atributos['value']);
					}else{
						$value_input = '';
					}
					
					/// Monta o Input
					$input = Componente::$tipo_input($nome, $atributos, $value_input);
					
					/// Verifica se é obrigatorio
					$obrigatorio = (preg_match('/required/', $input)) ? true : false;
				
					if($nome == 'id' || $tipo_input == 'hidden'){
						$string .= $input;
					}else{
						$string .= self::formRow($label, $input, $obrigatorio);
					}
				break;
				case $tipo_input == 'hidden':
					$input = Componente::hidden($nome, $atributos, $value[1]);// '<input name="'.$key.'" id="'.$key.'" type="hidden" value="'.$value[1].'" />';
					$string .= $input;
				break;
				case $tipo_input == 'url':
					$value_input = $value[1];
					if(count($atributos)){
						/// Pega o Value do Input
						if(isset($atributos['value'])){
							$value_input = $atributos['value'];
							unset($atributos['value']);
						}else{
							$value_input = '';
						}
					}
				
					$input = Componente::hidden($nome, $atributos, $value_input);
					$string .= $input;
				break;
				case $tipo_input == 'id':
					$input = Componente::hidden($nome, $atributos, $value[1]);// '<input name="'.$key.'" id="'.$key.'" type="hidden" value="'.$value[1].'" />';
					$string .= $input;
				break;
				case $tipo_input == 'data':
					/// Pega o Value do Input
					if(isset($atributos['value'])){
						$value_input = $atributos['value'];
						unset($atributos['value']);
					}else{
						$value_input = '';
					}
					
					/// Adiciona a Classe do maskDate
					$atributos['class'] = (isset($atributos['class'])) ? $atributos['class'].' maskData' : 'maskData';
					
					$input = Componente::input($nome, $atributos, $value_input); // '<input '.$atributos.' name="'.$key.'" id="'.$key.'" type="text" />';
				
					/// Verifica se é obrigatorio
					$obrigatorio = (preg_match('/required/', $input)) ? true : false;
					
					if($nome == 'id'){
						$string .= $input;
					}else{
						$string .= self::formRow($value[1], $input, $obrigatorio);
					}
				break;
				case $tipo_input == 'money':
					/// Pega o Value do Input
					if(isset($atributos['value'])){
						$value_input = $atributos['value'];
						unset($atributos['value']);
					}else{
						$value_input = '';
					}
					
					/// Adiciona a Classe do maskDate
					$atributos['class'] = (isset($atributos['class'])) ? $atributos['class'].' maskMoney' : 'maskMoney';
					
					$input = Componente::input($nome, $atributos, $value_input); // '<input '.$atributos.' name="'.$key.'" id="'.$key.'" type="text" />';
				
					/// Verifica se é obrigatorio
					$obrigatorio = (preg_match('/required/', $input)) ? true : false;
					
					if($nome == 'id'){
						$string .= $input;
					}else{
						$string .= self::formRow($value[1], $input, $obrigatorio);
					}
				break;				
				case $tipo_input == 'cpf':
					/// Pega o Value do Input
					if(isset($atributos['value'])){
						$value_input = $atributos['value'];
						unset($atributos['value']);
					}else{
						$value_input = '';
					}
						
					/// Adiciona a Classe do maskDate
					$atributos['class'] = (isset($atributos['class'])) ? $atributos['class'].' maskCpf' : 'maskCpf';
						
					$input = Componente::input($nome, $atributos, $value_input);
				
					/// Verifica se é obrigatorio
					$obrigatorio = (preg_match('/required/', $input)) ? true : false;
					
					if($nome == 'id'){
						$string .= $input;
					}else{
						$string .= self::formRow($value[1], $input, $obrigatorio);
					}
				break;
				case $tipo_input == 'cnpj':
					/// Pega o Value do Input
					if(isset($atributos['value'])){
						$value_input = $atributos['value'];
						unset($atributos['value']);
					}else{
						$value_input = '';
					}
						
					/// Adiciona a Classe do maskDate
					$atributos['class'] = (isset($atributos['class'])) ? $atributos['class'].' maskCnpj' : 'maskCnpj';
						
					$input = Componente::input($nome, $atributos, $value_input);
				
					/// Verifica se é obrigatorio
					$obrigatorio = (preg_match('/required/', $input)) ? true : false;
					
					if($nome == 'id'){
						$string .= $input;
					}else{
						$string .= self::formRow($value[1], $input, $obrigatorio);
					}
				break;
				case $tipo_input == 'cep':
					/// Pega o Value do Input
					if(isset($atributos['value'])){
						$value_input = $atributos['value'];
						unset($atributos['value']);
					}else{
						$value_input = '';
					}
				
					/// Adiciona a Classe do maskDate
					$atributos['class'] = (isset($atributos['class'])) ? $atributos['class'].' maskCep' : 'maskCep';
				
					$input = Componente::input($nome, $atributos, $value_input);
				
					/// Verifica se é obrigatorio
					$obrigatorio = (preg_match('/required/', $input)) ? true : false;
						
					if($nome == 'id'){
						$string .= $input;
					}else{
						$string .= self::formRow($value[1], $input, $obrigatorio);
					}
					break;
				case $tipo_input == 'telefone':
					/// Pega o Value do Input
					if(isset($atributos['value'])){
						$value_input = $atributos['value'];
						unset($atributos['value']);
					}else{
						$value_input = '';
					}
				
					/// Adiciona a Classe do maskDate
					$atributos['class'] = (isset($atributos['class'])) ? $atributos['class'].' maskTelefone' : 'maskTelefone';
				
					$input = Componente::input($nome, $atributos, $value_input);
				
					/// Verifica se é obrigatorio
					$obrigatorio = (preg_match('/required/', $input)) ? true : false;
						
					if($nome == 'id'){
						$string .= $input;
					}else{
						$string .= self::formRow($value[1], $input, $obrigatorio);
					}
					break;
				case $tipo_input == 'imagem':
					$label  = $value['1'];
					$imagem = $value['2'];
					$atributosString = '';
					
					if(isset($value['3'])){
						foreach($value['3'] as $attr => $valor){
							if($valor != ''){	
								$atributosString .= $attr.'="'.$valor.'"';
							}
						}
					}
					
					$div = '<div class="divImagemForm">
								'.$label.'
								<div class="formRight">
		                        	<img src="'.BASEURL.'/arquivos/'.$imagem.'" class="imagemForm" '.$atributos.'/>
		                        	<input name="old_imagem" value="'.$imagem.'" type="hidden" />
		                        </div>
							</div>';
							
					if($imagem != ''){
						$string .= self::formRow('', $div, false, true);
					}
				break;
				case $tipo_input == 'select':
					/// Monta o Select
					$select = Componente::select($nome, $atributos, $value[3], $value[4]);
					
					/// Verifica se é obrigatorio
					$obrigatorio = (preg_match('/required/', $select)) ? true : false;
					
					$string .= self::formRow($label, $select, $obrigatorio);
				break;
				case $tipo_input == 'textarea':
					if(!isset($value[3])){ $value[3] = ''; };
					
					$input = Componente::textarea($nome, $atributos, $value[3]);
					
					/// Verifica se é obrigatorio
					$obrigatorio = (preg_match('/required/', $input)) ? true : false;
					
					$string .= self::formRow($label, $input, $obrigatorio);
				break;
				case $tipo_input == 'editor':
					if(!isset($value[3])){ $value[3] = ''; };
					
					$input = Componente::editor($nome, $atributos, $value[3]);
					
					/// Verifica se é obrigatorio
					$obrigatorio = (preg_match('/required/', $input)) ? true : false;
					
					$string .= self::formRow($label, $input, $obrigatorio, true);
				break;
				case $tipo_input == 'autocomplete':
					$label = $value[1];
					$tabela = $value[3];
					$name_input = $key;
					$atributos = (is_array($value[2])) ? $value[2] : array();
					$valor = $value[4];
					$campo = (isset($value[5])) ? $value[5] : 'nome';
					
					$input = Componente::autocomplete($nome, $tabela, $atributos, $valor, $campo);

					/// Verifica se é obrigatorio
					$obrigatorio = (preg_match('/required/', $input)) ? true : false;
					
					$string .= self::formRow($label, $input, $obrigatorio);
				break;
			}
		}
		
		$name = ($name == '') ? 'form' : $name;
		$htmlForm = '
			<form id="validate" name="'.$name.'" action="'.BASEURL.'/'.$action.'" method="'.$metodo.'" enctype="multipart/form-data" >
				<fieldset>
					'.$string.'
				</fieldset>
				<div class="form-actions">
					<input type="submit" value="Salvar" class="btn btn-success">
					<a class="btn botao-voltar-form" onclick="javascript:window.history.go(-1);">Voltar<a>
				</div>
			</form>
		';
		return $htmlForm;
	}

	static function formRow($label, $input, $obrigatorio=false, $full=false){
		$rObrigatorio = ($obrigatorio) ? ' <span class="f_req">*</span>' : '';
		$rLabel = ($label != '')? "<label>$label:$rObrigatorio</label>" : '';
		if(!$full){
			$linha = "<div class='control-group'>
	                        <div class='control-label'>$rLabel</div>
	                        <div class='controls'>
	                        	$input
	                        </div>
	                  <div class='clear'></div>
	                  </div>";
		}else{
			$linha = "<div class='control-group'>
	                       <div class='control-label'></div> 
	                       <div class='controls'>$input</div>	
	                  <div class='clear'></div>
	                  </div>";
		}			
		return '<div class="formSep">'.$linha.'</div>';
	}
	
	static function abrir($name_form, $action, $metodo='post'){
		return '<form id="validate" name="'.$name_form.'" action="'.BASEURL.'/'.$action.'" method="'.$metodo.'" enctype="multipart/form-data" >';
	}
}