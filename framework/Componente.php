<?php 

/*
 * Classe que retorna as strings de componentes 
 * por métodos estaticos
 * 
 * 
 */

class Componente {
	
	/// Função que monta os inputs
	static function montarInput($nome, $atributos, $value, $tipo){
		if(!is_array($atributos))
			$atributos = array();
		
		$stringAttr = '';
		foreach($atributos as $nome_atributo => $atributo){
			if($atributo != ''){
				$stringAttr .= $nome_atributo.'="'.$atributo.'"';
			}
		}
		
		$checked = '';
		if($tipo == 'checkbox'){
			$checked = ($value) ? 'checked="checked"' : '';
		}
		
		return '<input '.$checked.' type="'.$tipo.'" name="'.$nome.'" id="'.$nome.'" '.$stringAttr.' value="'.$value.'"/>';
	}
	
	static function input($nome, $atributos, $value){
		return self::montarInput($nome, $atributos, $value, 'text');
	}
	
	static function hidden($nome, $atributos, $value){
		return self::montarInput($nome, $atributos, $value, 'hidden');
	}
	
	static function file($nome, $atributos, $value){
		$atributos['multiple'] = 'multiple';
		$atributos['style'] = 'display:none';
		
		$input = self::montarInput($nome, $atributos, $value, 'file');

		$nome_re = str_replace('[]', '', $nome);
		
		if($value){
			$input_antigo = '<input type="hidden" name="old_'.$nome.'" value="'.$value.'" />';
		}
		
		$stringMaquiada = '<div class="input-append">
								<input id="'.$nome_re.'_cover" type="text"/>
								<a class="btn input_cover_btn add-on" data-input="'.$nome.'" />Selecionar</a>
							</div>';
		
		return $input.$stringMaquiada.$input_antigo; //self::montarInput($nome, $atributos, $value, 'file');
	}
	
	static function password($nome, $atributos, $value){
		return self::montarInput($nome, $atributos, $value, 'password');
	}
	
	static function radio($nome, $atributos, $value){
		return self::montarInput($nome, $atributos, $value, 'radio');
	}
	
	static function checkbox($nome, $atributos, $value){
		return self::montarInput($nome, $atributos, $value, 'checkbox');
	}
	
	static function select($nome, $atributos, $valores, $value){
		if(!is_array($atributos))
			$atributos = array();
		
		$stringAttr = '';
		foreach($atributos as $nome_atributo => $atributo){
			$stringAttr .= $nome_atributo.'="'.$atributo.'"';
		}

		$stringSelect = '<select name="'.$nome.'" id="'.$nome.'" '.$stringAttr.'>';
		$stringSelect .= '<option>Selecione...</option>';
			foreach($valores as $chave => $valor){
				$selected = ($chave == $value) ? 'selected="selected"' : '';
				$stringSelect .= '<option value="'.$chave.'" '.$selected.' >'.$valor.'</option>';
			}
		$stringSelect .= '</select>';
		
		return $stringSelect;
	}
	
	static function textarea($nome, $atributos, $value){
		if(!is_array($atributos))
			$atributos = array();
		
		$stringAttr = '';
		foreach($atributos as $nome_atributo => $atributo){
			$stringAttr .= $nome_atributo.'="'.$atributo.'"';
		}
		
		return '<textarea '.$stringAttr.' name="'.$nome.'" id="'.$nome.'">'.$value.'</textarea>';
	}
	
	static function editor($nome, $atributos, $value){
		if(!is_array($atributos))
			$atributos = array();
		
		/// Para evitar conflitos remove o indice class do editor
		if(isset($atributos['class']))
			$atributos['class'] = $atributos['class'] .= ' ckeditor';
		
		$stringAttr = '';
		foreach($atributos as $nome_atributo => $atributo){
			$stringAttr .= $nome_atributo.'="'.$atributo.'"';
		}
		
		return '<textarea '.$stringAttr.' name="'.$nome.'" id="'.$nome.'">'.$value.'</textarea>';
	}
	
	static function submit($label, $atributos){
		if(!is_array($atributos))
			$atributos = array();
		
		$stringAttr = '';
		foreach($atributos as $nome_atributo => $atributo){
			$stringAttr .= $nome_atributo.'="'.$atributo.'"';
		}
	
		return '<input type="submit" value="'.$label.'" />';
	}
	
	static function button($label, $atributos){
		if(!is_array($atributos))
			$atributos = array();
		
		$stringAttr = '';
		foreach($atributos as $nome_atributo => $atributo){
			$stringAttr .= $nome_atributo.'="'.$atributo.'"';
		}
		
		return '<button '.$stringAttr.'>'.$label.'</button>';
	}
	
	static function autocomplete($nome, $tabela, $atributos, $valor, $campo){
		if(!is_array($atributos))
			$atributos = array();
		
		if($valor){
			$sql = Persistencia::tabelaSQL('', $tabela, 'id='.$valor);
			$cadastro = Conexao::lerSql($sql);
			$value = $cadastro->$campo;
		}
		
		$stringAttr = '';
		foreach($atributos as $nome_atributo => $atributo){
			$stringAttr .= $nome_atributo.'="'.$atributo.'"';
		}
		
		return '<input type="text" value="'.$value.'" class="auto-complete" data-campo="'.$nome.'" data-filtro="'.$campo.'" data-tabela="'.$tabela.'">
			    <input type="hidden" name="'.$nome.'" value="'.$valor.'" />';
	}
	
	static function categoria(){
		
	}
}