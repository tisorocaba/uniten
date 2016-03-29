<?php 

class DisciplinaModel extends Lumine_Model {
	
	/**
	 * 
	 * @var DisciplinaModel
	 */
	private static $instance;
	
	/**
	 * Construtor
	 * 

	 */
	function __construct(){
		if(!$this->obj){
			$this->obj = new Disciplina;
		}
		parent::__construct();
	}
	
	/**
	 * Retorna uma instancia da model
	 * 

	 */
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new DisciplinaModel();

		}
		
		return self::$instance;
	}


	
}