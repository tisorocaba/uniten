<?php 

class NoticiaModel extends Lumine_Model {
	
	/**
	 * 
	 * @var GaleriaModel
	 */
	private static $instance;
	
	
	function __construct(){
		if(!$this->obj){
			$this->obj = new Noticia;
		}
		parent::__construct();
	}
	
	
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new NoticiaModel();
		}
		return self::$instance;
	}

    public static  function ultimas($limit=2){
        return self::getInstance()->find(array(),'data DESC LIMIT '.$limit,'','',array());
    }

    public static function todas($offset){
        return self::getInstance()->find(array(), 'data DESC', $offset, LIMIT, array());
    }











}