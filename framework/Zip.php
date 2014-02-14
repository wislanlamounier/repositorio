<?php 

/**
 * Classe para Administrar os arquivos Zip do sistema
 */

class Zip{
	
	static function extract($arquivo, $folder, $absoluto=false){
		try{
			$file = ($absoluto) ? $arquivo : 'arquivos/'.$arquivo;
			
			if(!file_exists($file)){
				throw new Exception('O arquivo solicitado não existe');
			};
			
			$zip = new ZipArchive();
			if($zip->open($file) === true){
				$zip->extractTo($folder."/");
				$zip->close();
			}else{
				throw new Exception('Erro ao abrir o arquivo:'.$file);
			}
		}catch (Exception $e){
			debug($e);
			die;			
		}
	}
	
	static function create($nome, $folder, $arquivos=array()){
		try{
			$zip = new ZipArchive();
			
			if( $zip->open( 'arquivos/'.$nome.'.zip' , ZipArchive::CREATE )  === true){

				if(!count($arquivos))
					$arquivos = self::getFiles($folder);
					
				/// Pega os arquivos da pasta 
				$arquivos = self::getFiles($folder);
	
				foreach($arquivos as $arquivo){
					$zip->addFile($arquivo);		
				}
			}else{
				throw new Exception('Erro ao Criar o Arquivo: '.$nome.'.zip');
			}
			
			$zip->close();
		
		}catch (Exception $e){
			debug($e);
			die;
		}
	}
	
	static function getFiles($directory,$exempt = array('.','..','.ds_store','.svn'),&$files = array()) {
		$directory .= '/';
        $handle = opendir($directory);
        while(false !== ($resource = readdir($handle))) {
            if(!in_array(strtolower($resource),$exempt)) {
                if(is_dir($directory.$resource.'/'))
                    array_merge($files,
                        self::getFiles($directory.$resource.'',$exempt,$files));
                else
                    $files[] = $directory.$resource;
            }
        }
        closedir($handle);
        
        return $files;
    } 
}