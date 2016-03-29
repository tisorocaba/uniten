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
 * Classe generada para a tabela "curso"
 * in 2011-06-03
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package application.models.dao
 *
 */

class Curso extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'curso';
    protected $_package   = 'application.models.dao';
    
    
    public $id;
    public $nome;
    public $requisitos;
    public $ativo;
    public $dataCadastro;
    public $dataAlteracao;
    public $disciplinas = array();
    public $locais = array();
    public $destaque;
    
    
    
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
        $this->_addField('requisitos', 'requisitos', 'varchar', 155, array());
        $this->_addField('ativo', 'ativo', 'int', 1, array('default' => 1));
        $this->_addField('destaque', 'destaque', 'int', 1, array('default' => 1));
        $this->_addField('dataCadastro', 'data_cadastro', 'datetime', null, array('default' => '_function:CURRENT_TIMESTAMP'));
        $this->_addField('dataAlteracao', 'data_alteracao', 'datetime', null, array());
        $this->_addField('segmento', 'segmento_id', 'int', 5, array('foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Segmento'));
        $this->_addForeignRelation('disciplinas', self::MANY_TO_MANY, 'Disciplina', 'id', 'curso_disciplina', 'curso_id', true);
        $this->_addForeignRelation('locais', self::MANY_TO_MANY, 'Local', 'id', 'local_curso', 'curso_id', null);
    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return Curso
     */
    public static function staticGet($pk, $pkValue = null)
    {
        $obj = new Curso;
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
	
        function cargaHorariaTotal(){
            $tmp = new Curso;
            $sql = "SELECT sum(carga_horaria) as total FROM curso C, curso_disciplina CP, disciplina D WHERE C.id = ".$this->id." and curso_id = C.id and D.id = disciplina_id";
            $rs = $tmp->_getConnection()->executeSQL($sql);        
            $row = mysql_fetch_array($rs);
            unset($rs);
            return $row['total'];
        }


}
