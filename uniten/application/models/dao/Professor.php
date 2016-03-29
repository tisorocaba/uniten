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
 * Classe generada para a tabela "professor"
 * in 2011-06-03
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package application.models.dao
 *
 */

class Professor extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'professor';
    protected $_package   = 'application.models.dao';
    
    
    public $id;
    public $empresa;
    public $disciplina;
    public $nome;
    public $email;
    public $dataCadastro;
    public $ativo;
    public $disciplinas = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->_addField('id', 'id', 'int', 5, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('empresa', 'empresa_id', 'int', 5, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Empresa'));
        $this->_addField('nome', 'nome', 'varchar', 85, array());
        $this->_addField('email', 'email', 'varchar', 120, array());
        $this->_addField('cpf', 'cpf', 'varchar', 12, array('notnull' => true, 'default' => ''));
        $this->_addField('dataCadastro', 'data_cadastro', 'datetime', null, array('default' => '_function:CURRENT_TIMESTAMP'));
        $this->_addField('foneDDD', 'fone_ddd', 'int', 2, array('notnull' => true, 'default' => '0'));
        $this->_addField('foneNumero', 'fone_numero', 'varchar', 9, array('notnull' => true, 'default' => ''));
        $this->_addField('celDDD', 'cel_ddd', 'int', 2, array('notnull' => true, 'default' => '0'));
        $this->_addField('celNumero', 'cel_numero', 'varchar', 9, array('notnull' => true, 'default' => ''));
        $this->_addField('ativo', 'ativo', 'int', 1, array('notnull' => true, 'default' => '1'));
        $this->_addForeignRelation('disciplinas', self::MANY_TO_MANY, 'Disciplina', 'id', 'professor_disciplina', 'professor_id', null);
        $this->_addForeignRelation('agendas', self::MANY_TO_MANY, 'AgendaCurso', 'id', 'agenda_professor_disciplina', 'professor_id', null);
  
        
    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return Professor
     */
    public static function staticGet($pk, $pkValue = null)
    {
        $obj = new Professor;
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
	
        public function historico(){
            $tmp = new Professor();
            $rs = $tmp->_getConnection()->executeSQL('select local_curso_id as cod, C.nome as curso,D.nome as disciplina,L.local, date_format(LC.data_inicio,\'%d/%m/%Y\') as inicio, 
date_format(LC.data_termino, \'%d/%m/%Y\') as termino, periodo
from agenda_professor_disciplina APD, local_curso LC, disciplina D, curso C, local L 
where professor_id = '.$this->id.' and local_curso_id = LC.id and disciplina_id = D.id 
and curso_id = C.id
and local_id = L.id order by local_curso_id desc');
            $historico = array();
            while($row = mysql_fetch_array($rs)){
                $historico[] = $row;
            }
            return $historico;
            
        }


}
