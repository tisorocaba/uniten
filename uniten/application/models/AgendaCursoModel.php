<?php 

class AgendaCursoModel extends Lumine_Model {
	
	/**
	 * 
	 * @var LocalModel
	 */
	private static $instance;
	
	
	function __construct(){
		if(!$this->obj){
			$this->obj = new AgendaCurso;
		}
		parent::__construct();
	}
	
	
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new AgendaCursoModel();
		}
		return self::$instance;
	}


    public static  function cursosPorProjeto($projeto,$offset){

        $prefs = array('whereExtra' => 'data_termino_inscricao >= CURRENT_DATE
                                       and ativo = 1
                                       and status = 1
                                       and publicar = 1
                                       and local_id in (select id from local where projeto_id = ' . $projeto . ') ');
       return  self::getInstance()->find(array(), 'dataCadastro DESC', $offset, LIMIT, $prefs);
    }

    public static  function cursosPorProjetoTotal($projeto){

        $prefs = array('whereExtra' => 'data_termino_inscricao >= CURRENT_DATE
                                       and ativo = 1
                                       and status = 1
                                       and publicar = 1
                                       and local_id in (select id from local where projeto_id = ' . $projeto . ') ');
        return  self::getInstance()->find(array(), 'dataCadastro DESC', '', LIMIT, $prefs);
    }

    public static  function ultimosResultados($limite=3){
        $prefs = array('whereExtra' => 'resultado = 1 and ativo = 1 and status = 1 ');
        return  self::getInstance()->find(array(), 'dataCadastro DESC LIMIT '.$limite, '', '', $prefs);

    }

    public static function resultados($offset){
        $prefs = array('whereExtra' => 'resultado = 1 and ativo = 1 and status = 1 ');
        return self::getInstance()->find(array(), 'data_inicio DESC', $offset, LIMIT, $prefs);
    }

    public static function resultadosTotal(){
        $prefs = array('whereExtra' => 'resultado = 1 and ativo = 1 and status = 1 ');
        return count(self::getInstance()->find(array(), '', '', '', $prefs));
    }

    public static  function cursosAbertos($offset){

        $prefs = array('whereExtra' => 'data_termino_inscricao >= CURRENT_DATE
                                       and ativo = 1
                                       and status = 1
                                       and publicar = 1');
        return  self::getInstance()->find(array(), 'dataCadastro DESC', $offset, LIMIT, $prefs);
    }

    public static  function cursosAbertosTotal(){

        $prefs = array('whereExtra' => 'data_termino_inscricao >= CURRENT_DATE
                                       and ativo = 1
                                       and status = 1
                                       and publicar = 1');
        return  self::getInstance()->find(array(), 'dataCadastro DESC', '', LIMIT, $prefs);
    }


	
	

	
}