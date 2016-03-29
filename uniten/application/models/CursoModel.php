<?php 


class CursoModel extends Lumine_Model {
	
	/**
	 * 
	 * @var CursoModel
	 */
	private static $instance;
	

	function __construct(){
		if(!$this->obj){
			$this->obj = new Curso;
		}
		parent::__construct();
	}
	

	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new CursoModel();
		}
		
		return self::$instance;
	}

	public static function cursos($ativo = 1,$offset=0){
		$prefs = array('whereExtra' => ' ativo = '.$ativo.' and destaque = 1');
		return  self::getInstance()->find(array(), 'nome ASC', $offset, LIMIT, $prefs);
	}

	public static function cursosTotal($ativo=1){
		$prefs = array('whereExtra' => ' destaque = 1  and ativo = '.$ativo);
		return count(self::getInstance()->find(array(), '', '', '', $prefs));
	}

    public static function cursosRand(){
        $prefs = array('whereExtra' => ' ativo = 1 and destaque = 1');
        return  self::getInstance()->find(array(), 'rand()', '', 4, $prefs);
    }

	
}