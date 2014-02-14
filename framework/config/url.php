<?php
function url_amigavel(){
	if(isset($_GET['url'])){
		$url = explode('/', $_GET['url']);
		$_SESSION['url'] = $url;
		
		if($url[0]){
			$_GET['mod'] = str_replace('-', '', $url[0]);
		}else{
			$_GET['mod'] = 'site';
		}
		
		if(isset($url[1]) && $url[1] != ''){
			$_GET['acao'] = str_replace('-', '', $url[1]);
		}else{
			$_GET['acao'] = 'home';
		}
		
		if(isset($url[2])){
			$_GET['id'] = $url[2];
		}
	}else{
		$_GET['mod'] = 'site';
		$_GET['acao'] = 'home';
	}
}

function definir_url($servidor){
	$pasta = substr($_SERVER['SCRIPT_NAME'], 0, -10);
	$url = 'http://'.$_SERVER['HTTP_HOST'];
		
	$baseUrl = $url.$pasta;
	
	define('BASEURL', $baseUrl);
}

definir_url($_SERVER['HTTP_HOST']);
url_amigavel();
