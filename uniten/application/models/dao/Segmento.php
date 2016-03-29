<?php

class Segmento extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'segmento';
    protected $_package   = 'application.models.dao';
    
    
    public $id;
    public $nome;
    public $ativo;
    public $dataCadastro;
   
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->_addField('id', 'id', 'int', 10, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('nome', 'nome', 'varchar', 85, array());
        $this->_addField('ativo', 'ativo', 'int', 1, array('default' => 1));
        $this->_addField('dataCadastro', 'data_cadastro', 'datetime', null, array('default' => '_function:CURRENT_TIMESTAMP'));
         $this->_addForeignRelation('cursos', self::ONE_TO_MANY, 'Curso', 'segmento', null, null, true);
         }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return Curso
     */
    public static function staticGet($pk, $pkValue = null)
    {
        $obj = new Segmento;
        $obj->get($pk, $pkValue);
        return $obj;
    }

	/**
	 * chama o destrutor pai
	 *
	 */
	function __destruct()
	{
		parent::__destruct();
	}
	
    #------------------------------------------------------#
    # Coloque todos os metodos personalizados abaixo de    #
    # END AUTOCODE                                         #
    #------------------------------------------------------#
    #### END AUTOCODE


}
