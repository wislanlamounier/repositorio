<?php 

class Html{
	function link($texto, $local, $atributos=array()){
		foreach($atributos as $chave => $item){
			$string .= "$chave='".$item.'"';
		}
		return "<a href='".$local."' $string ><span>$texto</span></a>";
	}
	
	function url($url, $return=false){
		$url = BASEURL.'/'.$url;
		if($return){
			return $url;
		}else{
			echo $url;
		}		
	}
	
	function dirLayout(){
		echo BASEURL.'/layout/'.$this->layout.'/';
	}
	
	function css($arquivo){
		if(is_array($arquivo)){
			foreach($arquivo as $css){
				echo "<link rel='stylesheet' href='".BASEURL."/layout/".$this->layout."/css/".$css.".css' type='text/css' media='screen' />";
			}
		}else{
			echo "<link rel='stylesheet' href='".BASEURL."/layout/".$this->layout."/css/".$arquivo.".css' type='text/css' media='screen' />";
		}
	}
	
	function js($arquivo){
		if(is_array($arquivo)){
			foreach($arquivo as $js){
				echo "<script src='".BASEURL."/layout/".$this->layout."/js/".$js.".js' type='text/javascript'></script>";
			}
		}else{
			echo "<script src='".BASEURL."/layout/".$this->layout."/js/".$arquivo.".js' type='text/javascript'></script>";
		}
	}
	
	function layout($arquivo, $tipo){
		if($tipo=='css'){
			echo "<link rel='stylesheet' href='".BASEURL."/layout/".$this->layout."/".$arquivo.".css' type='text/css' media='screen' />";
		}else if($tipo=='js'){
			echo "<script src='".BASEURL."/layout/".$this->layout."/".$arquivo.".js' type='text/javascript'></script>";
		}else{
			echo BASEURL."/layout/".$this->layout."/$arquivo.$tipo";
		}
	}
	
	function img($arquivo, $atributos=array()){

		$string='';
		if($atributos){
			foreach($atributos as $chave => $item){
				$string .= "$chave='".$item.'"';
			}
		}

		echo "<img src='".BASEURL."/layout/".$this->layout."/img/".$arquivo."' $string />";
	}
	
	function urlArquivo($arquivo){
		echo BASEURL."/arquivos/".$arquivo;
	}
	
	function images($arquivo, $atributos=array()){
		$string='';
		foreach($atributos as $chave => $item){
			$string .= $chave.'="'.$item.'"';
		}

		$string = '<img src="'.BASEURL."/layout/".$this->layout."/images/".$arquivo.'" '.$string.' />';
		echo $string;
	}
	
	
	function arquivo($arquivo, $parametros=array()){
		$valores = '';
		foreach($parametros as $key=>$value){
			$valores .= "$key=\"$value\"";
		}
		
		echo "<img src='".BASEURL."/arquivos/".$arquivo."' $valores />";
	}
	 
	function meta($nome, $conteudo){
		echo "<meta name='".$nome."' content='".$conteudo."' />";
	}
	
	
	/*** WORK WITH BOOTSTRAP ***/
	
	function botaoCadastro($value='Cadastro'){
		if(Acl::isAllowed($_GET['mod'],'cadastro')){
			echo '<a class="btn pull-right" style="margin-top:5px" href="'.BASEURL.'/'.$_GET['mod'].'/cadastro">'.$value.'</a>';
		}
	}
	
	function botaoAlterar($id){
		if(Acl::isAllowed($_GET['mod'],'alteracao')){
			echo '<a class="btn" href="'.BASEURL.'/'.$_GET['mod'].'/alteracao/'.$id.'"><i class="icon-pencil"></i></a>';
		}
	}
	
	function botaoAjaxRemover($id, $status=false){
		if(Acl::isAllowed($_GET['mod'],'excluir')){
			$status = ($status) ? 'status' : '';
			echo '<a class="btn excluir-item '.$status.'" data-href="'.BASEURL.'/'.$_GET['mod'].'/excluir/'.$id.'"><i class="icon-remove"></i></a>';
		}
	}
	
	function botaoIcone($link, $icone, $alt='',$campos='', $class=''){
		echo '<a class="btn '.$class.'" href="'.BASEURL.'/'.$link.'" title="'.$alt.'" '.$campos.'><i class="'.$icone.'"></i></a>';
	}
	
	function botaoLink($label, $link, $class=''){
		echo '<a class="btn '.$class.'" href="'.BASEURL.'/'.$link.'">'.$label.'</a>';
	}
	
	function botaoAjax($class, $icone, $atributos=array()){
		$str = '';	
		foreach($atributos as $key=>$value){
			$str .= $key."=\"$value\"";
		}
		echo '<a class="btn '.$class.'" href="javascript:void(0)" '.$str.'><i class="'.$icone.'"></i></a>';
	}
}
