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
 * Classe generada para a tabela "diario_classe"
 * in 2011-06-03
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package application.models.dao
 *
 */

class DiarioClasse extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'diario_classe';
    protected $_package   = 'application.models.dao';
    
    
    public $id;
    public $professor;
    public $disciplina;
    public $agenda;
    public $horas;
    public $data;
    public $conteudo;
   
    public $alunos = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->_addField('id', 'id', 'int', 10, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('agenda', 'local_curso_id', 'int', 5, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'AgendaCurso'));
        $this->_addField('data', 'data_aula', 'date', null, array());
        $this->_addField('horas', 'horas', 'varchar', 4, array());
        $this->_addField('professor', 'professor_id', 'int', 4, array());
        $this->_addField('disciplina', 'disciplina_id', 'int', 4, array());
        $this->_addField('aprovado', 'aprovado', 'int', 4, array());
        $this->_addField('conteudo', 'conteudo', 'varchar', 150, array());
        $this->_addForeignRelation('alunos', self::MANY_TO_MANY, 'Aluno', 'id', 'diario_classe_aluno', 'diario_classe_id', null);
    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return DiarioClasse
     */
    public static function staticGet($pk, $pkValue = null)
    {
        $obj = new DiarioClasse;
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
        
       
        function presencasFaltas($presenca=1){
            $obj = new DiarioClasse();
            $sql = "select count(aluno_id) as total from diario_classe_aluno where diario_classe_id = {$this->id} and presenca = {$presenca}";
            $rs = $obj->_getConnection()->executeSQL($sql);
            $row = mysql_fetch_array($rs);
            unset($rs);
            return (int)$row['total'];
        }
        
         function pegaProfessor(){
            $obj = new DiarioClasse();
            $sql = "select P.nome from diario_classe DC, professor P where DC.id = {$this->id} and P.id = professor_id ";
           
            $rs = $obj->_getConnection()->executeSQL($sql);
            $row = mysql_fetch_array($rs);
            unset($rs);
            return $row['nome'];
        }
        
         function pegaDisciplina(){
            $obj = new DiarioClasse();
            $sql = "select D.nome from diario_classe DC, disciplina D where DC.id = {$this->id} and D.id = disciplina_id ";
            $rs = $obj->_getConnection()->executeSQL($sql);
            $row = mysql_fetch_array($rs);
            unset($rs);
            return $row['nome'];
        }
        
       
        
        
        
        


}
