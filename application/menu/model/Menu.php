<?php 
class Menu extends Model{
	public $id;
	public $nome;
	public $controller;
	public $acao;
	public $id_pai;
	public $status;
	public $ordem;
	
	function __construct(){
		$this->tabela = 'menu';
		
		$this->form = $this->mapeador();
	}
	
	function mapeador(){
		$arrStatus = $this->arrStatus();
		$arrPais = Conexao::selectBanco($this->tabela);
		
		return array(
			'id'=>array('id', $this->id),
			'nome'=>array('input', 'Nome', array('class'=>'validate[required]', 'type'=>"text",'value'=>$this->nome)),
			'controller'=>array('input', 'Controller', array('class'=>'validate[required]', 'type'=>"text",'value'=>$this->controller)),
			'acao'=>array('input', 'Acão', array('class'=>'validate[required]', 'type'=>"text",'value'=>$this->acao)),
			'id_pai'=>array('select', 'Pai', array('class'=>''), $arrPais, $this->id_pai),
			'status'=>array('select', 'Status', array('class'=>'validate[required]'), $arrStatus, $this->status),
			'ordem'=>array('input', 'Ordem', array('class'=>'valite[required]', 'value'=>$this->ordem))
		);
	}
	
	function arrStatus($id = false){
		$status = array(
			'0'=>'Inativo',
			'1'=>'Ativo'
		);
		
		return $status;
	}

    static function montarMenuResponsivo(){
        $sql = 'SELECT * FROM menu WHERE id_pai = 0 ORDER BY ordem asc';
        $pais = Conexao::listarSql($sql);
        $stringMenu = '';
        foreach($pais as $pai){
            $stringMenu .= '<option value="'.BASEURL.'/'.$pai->controller.'/'.$pai->acao.'">'.$pai->nome.'</option>';
            $sql = 'SELECT * FROM menu WHERE id_pai = '.$pai->id.' ORDER BY ordem asc';
            $filhos = Conexao::listarSql($sql);

            if(count($filhos)){
                foreach($filhos as $filho){
                    $stringMenu .= '<option value="'.BASEURL.'/'.$filho->controller.'/'.$filho->acao.'">--'.$filho->nome.'</option>';
                }
            }
        }

        echo $stringMenu;
    }

	static function montarMenu(){
		$campos = '*,(SELECT nome FROM menu WHERE id = m.id_pai) pai';
		$sql = Persistencia::tabelaSQL($campos, 'menu m', '1=1 ORDER BY ordem asc');
		$lista = Conexao::listarSql($sql);
		
		$menuItens = array();
		foreach($lista as $row){
			if(Acl::isAllowed($row->controller, $row->acao)){
				$menuItens[$row->id_pai][$row->id] = array('link' => BASEURL.'/'.$row->controller.'/'.$row->acao,'name' => $row->nome);
			}
		}
		
		self::imprimirMenu($menuItens);
	}
	
	function listarFilho($id_pai){
		$sql = 'SELECT 
					*,
					(SELECT nome FROM '.$this->tabela.' WHERE id = '.$id_pai.') pai 
				FROM 
					'.$this->tabela.' 
				WHERE 
					id_pai = '.$id_pai;
					
		return Conexao::listarSql($sql);			
	}
	
	function listar($where = ''){
		$campos = '*,(SELECT nome FROM '.$this->tabela.' WHERE id = m.id_pai) pai';
		$sql = Persistencia::tabelaSQL($campos, $this->tabela.' m', $where);
		return Conexao::listarSql($sql);
	}
	
	/**
	 * Função imprimirMenu - Função recursiva utilizada para imprimir
	 * menu com submenus em níveis infinitos.
	 *
	 * @param array $menuTotal - Array do menu a ser impresso
	 * @param $idPai - Id da categoria pai
	 */
	static function imprimirMenu( array $menuTotal , $idPai = 0, $nivel = 0 )
	{
		// abrimos a ul do menu principal
		echo str_repeat( "\t" , $nivel ),'<ul >',PHP_EOL;
		// itera o array de acordo com o idPai passado como parâmetro na função
		foreach( $menuTotal[$idPai] as $idMenu => $menuItem)
		{
			// imprime o item do menu
			echo str_repeat( "\t" , $nivel + 1 ),'<li><a href="',$menuItem['link'],'">',$menuItem['name'],'</a>',PHP_EOL;
			// se o menu desta iteração tiver submenus, chama novamente a função
			if( isset( $menuTotal[$idMenu] ) ) self::imprimirMenu( $menuTotal , $idMenu , $nivel + 2);
			// fecha o li do item do menu
			echo str_repeat( "\t" , $nivel + 1 ),'</li>',PHP_EOL;
		}
		// fecha o ul do menu principal
		echo str_repeat( "\t" , $nivel ),'</ul>',PHP_EOL;
	}
	
}

