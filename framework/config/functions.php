<?php

require_once('lib/upload.class.php');

function print_b($array, $exit=false){
	echo '<pre>', print_r($array, true),'</pre>';
	if($exit){
		exit(0);
	}
}

function debug($array){
	x($array);
    die;
}

function x($array){
	echo '<pre>', print_r($array, true),'</pre>';
}

function AMD($data){
	$dia = substr($data, 0, 2);
	$mes = substr($data, 3, 2);
	$ano = substr($data, 6, 4);

	$newDate = $ano.'-'.$mes.'-'.$dia;
	return $newDate;
}

function DMA($data){
	$dia = substr($data, 8, 2);
	$mes = substr($data, 5, 2);
	$ano = substr($data, 0, 4);

	$newDate = $dia.'/'.$mes.'/'.$ano;
	return $newDate;
}

function uploadArquivo($file){
		$upload = new upload($file);
		$nome = '0';
		if($upload->uploaded){
			$upload->process('arquivos/');
			if($upload->processed){
				$nome = $upload->file_dst_name;
			}
		}
		return $nome;
}

function uploadResize($file, $width=500, $height=false){
	$upload = new upload($file);
	$nome = false;

	if($upload->uploaded){
		
		$upload->image_resize          = true;
		$upload->image_ratio_y         = true;
		$upload->image_x               = $width;
		
		if($height){
			$upload->image_ratio_y     = false;
			$upload->image_y		   = $height; 
		}
		
		$upload->process('arquivos/');
		if($upload->processed){
			$nome = $upload->file_dst_name;
		}

	}
	
	return $nome;
}

