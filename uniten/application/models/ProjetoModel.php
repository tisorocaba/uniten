<?php 

class ProjetoModel extends Lumine_Model {
	

	private static $instance;
	
	function __construct(){
		if(!$this->obj){
			$this->obj = new Projeto;
		}
		parent::__construct();
	}
	
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new ProjetoModel();
		}
		
		return self::$instance;
	}
	
    public static function todos(){
        $prefs = array('whereExtra' => 'publicar = 1  and id in(SELECT projeto_id FROM local_curso LC, local L
                                         WHERE data_inicio_inscricao <= CURRENT_DATE
                                         AND data_termino_inscricao >= CURRENT_DATE
                                         AND status = 1
                                         AND local_id = L.id
                                         AND LC.ativo = 1 and LC.status = 1 and LC.publicar = 1
                                         AND projeto_id <> 5
                                         GROUP BY projeto_id)');
        return self::getInstance()->find(array(),'dataCadastro DESC','','',$prefs);
    }

    public static function ultimos($limit=3){
        $prefs = array('whereExtra' => 'publicar = 1  and id in(SELECT projeto_id FROM local_curso LC, local L
                                         WHERE data_inicio_inscricao <= CURRENT_DATE
                                         AND data_termino_inscricao >= CURRENT_DATE
                                         AND status = 1
                                         AND local_id = L.id
                                         AND LC.ativo = 1 and LC.status = 1 and LC.publicar = 1
                                         AND projeto_id <> 5
                                         GROUP BY projeto_id) ');
        return self::getInstance()->find(array(),'dataCadastro DESC LIMIT '.$limit,'','',$prefs);
    }

    public static  function getInfo(){
        $orderBy = 'rand() LIMIT 5';
        $prefs = array('whereExtra' => 'publicar = 1 and ativo=1');
        return self::getInstance()->find(array(),$orderBy,'','',$prefs);
    }



	
}