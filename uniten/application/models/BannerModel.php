<?php 

class BannerModel extends Lumine_Model {
	
	/**
	 * 
	 * @var CursoModel
	 */
	private static $instance;
	
	
	function __construct(){
		if(!$this->obj){
			$this->obj = new Banner;
		}
		parent::__construct();
	}
	
	
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new BannerModel();
		}
		
		return self::$instance;
	}
	
	

	
}