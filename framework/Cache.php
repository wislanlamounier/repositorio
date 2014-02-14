<?php 

class Cache {
	public static $dir = 'cache/';
	public static $timeout = '10';
	public static $file = '';
	
	static function nomeDoArquivo($chave){
		return self::$dir.base64_encode($chave).'.html';
	}
	
	static function isCache($chave){
		self::$file = self::nomeDoArquivo($chave);
		
		/// Verifica se existe arquivo de cache
		if(!file_exists(self::$file)){
			return true;
		}
		
		/// Verifica o tempo do cache
		$filetime = filemtime(self::$file);
		if(time() > ($filetime + (self::$timeout * 60))){
			return true;
		}
		return false;
	}
	
	static function write($chave, $valor){
		$arquivo = self::nomeDoArquivo($chave);
		if(!file_put_contents($arquivo, $valor)){
			echo 'erro 1';
			die;
		}
	}
	
	static function init($chave){
		self::$file = self::nomeDoArquivo($chave);
		/// Verifica se existe arquivo de cache
		if(!file_exists(self::$file)){
			return true;
		}
		
		/// Verifica o tempo do cache
		$filetime = filemtime(self::$file);
		if(time() > ($filetime + (self::$timeout * 60))){
			return true;
		}
		
		self::read($chave);
	}
	
	static function read($chave){
		$arquivo = self::nomeDoArquivo($chave);
		if(file_exists($arquivo)){
			if(!$result = file_get_contents($arquivo)){
				echo 'erro 2';
				die;
			}
			echo $result;
			die;
		}
	}
	
}