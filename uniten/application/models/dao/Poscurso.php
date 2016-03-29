<?php
#### START AUTOCODE
################################################################################
#  Lumine - Database Mapping for PHP
#  Copyright (C) 2005  Hugo Ferreira da Silva
#  
#  This program is free software: you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation, either version 3 of the License, or
#  (at your option) any later version.
#  
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#  
#  You should have received a copy of the GNU General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>
################################################################################
/**
 * Classe generada para a tabela "poscurso"
 * in 2011-06-03
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package application.models.dao
 *
 */

class Poscurso extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'poscurso';
    protected $_package   = 'application.models.dao';
    
    
    public $id;
    public $agenda;
    public $aluno;
    public $trabalhando;
    public $registrado;
    public $empresa;
    public $funcao;
    public $dataCadastro;
    public $autonomo;
    public $estavaEmpregado;
    public $eraArea;
    public $cursoAjudou;
    public $atendimento;
 
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->_addField('id', 'id', 'int', 10, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('agenda', 'local_curso_id', 'int', 10, array('primary' => true, 'notnull' => true));
        $this->_addField('aluno', 'aluno_id', 'int', 10, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Aluno'));
        $this->_addField('trabalhando', 'trabalhando', 'boolean', 1, array());
        $this->_addField('registrado', 'registrado', 'boolean', 1, array());
        $this->_addField('empresa', 'empresa', 'varchar', 85, array());
        $this->_addField('funcao', 'funcao', 'varchar', 85, array());
        $this->_addField('autonomo', 'autonomo', 'boolean', 1, array());
        
        $this->_addField('estavaEmpregado', 'estava_empregado', 'boolean', 1, array());
        $this->_addField('eraArea', 'era_area', 'boolean', 1, array());
        $this->_addField('cursoAjudou', 'curso_ajudou', 'boolean', 1, array());
        $this->_addField('atendimento', 'atendimento', 'int', 1, array());
        
        
        
        $this->_addField ( 'obs', 'obs', 'text', 98888, array () );
        
        
        $this->_addField('dataCadastro', 'data_cadastro', 'datetime', null, array('default' => '_function:CURRENT_TIMESTAMP'));
      

        
    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return Poscurso
     */
    public static function staticGet($pk, $pkValue = null)
    {
        $obj = new Poscurso;
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
