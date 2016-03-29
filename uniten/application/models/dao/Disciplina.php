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
 * Classe generada para a tabela "disciplina"
 * in 2011-06-03
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package application.models.dao
 *
 */

class Disciplina extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'disciplina';
    protected $_package   = 'application.models.dao';
    
    
    public $id;
    public $curso;
    public $nome;
    public $cargaHoraria;
    public $dataCadastro;
    public $dataAlteracao;
    public $conhecimento;
    public $professores = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->_addField('id', 'id', 'int', 5, array('primary' => true, 'notnull' => true,'autoincrement' => true));
        //$this->_addField('curso', 'curso_id', 'int', 10, array('notnull' => true,'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Curso','lazy'=>true));
        $this->_addField('nome', 'nome', 'varchar', 75, array());
        $this->_addField('conhecimento', 'conhecimento', 'varchar', 65535, array());
        $this->_addField('cargaHoraria', 'carga_horaria', 'int', 4, array());
        $this->_addField('ativo', 'ativo', 'int', 1, array('default' => 1));
        $this->_addField('dataCadastro', 'data_cadastro', 'datetime', null, array('default' => '_function:CURRENT_TIMESTAMP'));
        $this->_addField('dataAlteracao', 'data_alteracao', 'datetime', null, array());

        
        //$this->_addForeignRelation('professores', self::ONE_TO_MANY, 'Professor', 'disciplina', null, null, null);
        $this->_addForeignRelation('professores', self::MANY_TO_MANY, 'Professor', 'id', 'professor_disciplina', 'disciplina_id', null);
        $this->_addForeignRelation('cursos', self::MANY_TO_MANY, 'Curso', 'id', 'curso_disciplina', 'disciplina_id', null);

    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return Disciplina
     */
    public static function staticGet($pk, $pkValue = null)
    {
        $obj = new Disciplina;
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
