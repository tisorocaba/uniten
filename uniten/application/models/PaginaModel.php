<?php 

class PaginaModel extends Lumine_Model {
	
	/**
	 * 
	 * @var CursoModel
	 */
	private static $instance;
	
	
	function __construct(){
		if(!$this->obj){
			$this->obj = new Pagina;
		}
		parent::__construct();
	}
	
	
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new PaginaModel();
		}
		
		return self::$instance;
	}

	public static  function servicos(){
		$prefs = array('whereExtra' => 'secao = 2');
		return self::getInstance()->find(array(),'ordem ASC','','',$prefs);
	}


	public static  function institucional(){
		$prefs = array('whereExtra' => 'secao = 1');
		return self::getInstance()->find(array(),'ordem ASC','','',$prefs);
	}




}