<?php
class Util {
	
	static function local($array){

			if(isset($array[0])){
				$localArray[$array[0]] = 'index.php';
			}
			if(isset($array[1])){
				$localArray[$array[1]] = BASEURL.'/'.$_GET['mod'].'/home';
			}
			if(isset($array[2])){
				$localArray[$array[2]] = BASEURL.'/'.$_GET['mod'].'/'.$_GET['acao'];	
			}
			
		if(isset($localArray)){
			$_SESSION['local'] = $localArray;
		}else{
			$_SESSION['local'] = false;
		}
	}
	
	static function redirect($url){
		$string = BASEURL.'/'.$url;
		header("Location: $string");
	}
	
	static function removerCaracteresEspeciais($str){
		return strtr(utf8_decode($str),utf8_decode('ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ~´'),'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy  ');
	}
	
	static function transformarEmUrl($string){
		$semCaracteres = self::removerCaracteresEspeciais($string);
		$semEspaco = str_replace(' ', '-', $semCaracteres);
		return strtolower($semEspaco);
	}
	
	static function aleatorio($qnt, $min, $max, $repeat = false, $sort = true, $sort_order = 0) {
		if ((($max - $min) + 1) >= $qnt) {
			$numbers = array();
	
			while (count($numbers) < $qnt) {
				$number = mt_rand($min, $max);
				if ($repeat) {
					$numbers[] = $number;
				} elseif (!in_array($number, $numbers)) {
					$numbers[] = $number;
				}
			}
			if ($sort) {
				switch ($sort_order) {
					case 0 :
						sort($numbers);
						break;
					case 1 :
						rsort($numbers);
						break;
				}
			}
			return $numbers;
		} else {
			return 'A faixa de valores entre $min e $max deve ser igual ou superior à ' . 'quantidade de números requisitados';
		}
	}

	static function moedaVisao($valor, $exibir=true){
        if($exibir){
            echo 'R$ '.number_format($valor, 2, ',', '.');
        }else{
            return 'R$ '.number_format($valor, 2, ',', '.');
        }
	}

	static function moedaEdit($valor){
		return number_format($valor, 2, ',', '.');
	}
	
	static function moedaBanco($valor){
		$valor = str_replace('R$ ', '', $valor); 
		$valor = str_replace('.', '', $valor); 
		$valor = str_replace(',', '.', $valor); 

		return number_format($valor, 2, '.', '');
	}
	
	static function diffDate($ultima_data, $primeira_data){
		 $d1  = explode('-', $primeira_data);
		 $d2     = explode('-', $ultima_data);
		 
		 $data = mktime(0,0,0,$d1[1],$d1[2] ,$d1[0]);
		 $data2 = mktime(0,0,0,$d2[1],$d2[2],$d2[0]);
		 
		 $dias = ($data - $data2)/86400;
		 
		 return $dias;
	}

	static function converterMoney($valor){
		$valor = str_replace('.', '', $valor);
		$valor = str_replace(',', '.', $valor);

		return $valor;
	}
}