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
 * Classe generada para a tabela "local"
 * in 2011-06-03
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package application.models.dao
 *
 */

class AgendaCurso extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'local_curso';
    protected $_package = 'application.models.dao';
    public $id;
    public $curso;
    public $local;
    public $horarioInicial;
    public $horarioFinal;
    public $dataInicio;
    public $dataTermino;
    public $vagas;
    public $prova;
    public $inscricaoweb;
    public $valor;
    public $dataInicioInscricao;
    public $dataFinalInscricao;
    public $dataCadastro;
    public $ativo;
    public $provaData;
    public $provaLocal;
    public $provaHorario;
    public $localInscricao;
    public $valorVale;
    public $resultado;
    public $idade;
    public $empresaProva;
    public $sala;
    

    protected function _initialize() {


        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes

        $this->_addField('id', 'id', 'int', 5, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('curso', 'curso_id', 'int', 5, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Curso', 'lazy' => true));
        $this->_addField('local', 'local_id', 'int', 5, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Local', 'lazy' => true));
        $this->_addField('empresaProva', 'empresa_prova_id', 'int', 5, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Empresa'));
        $this->_addField('empresaCurso', 'empresa_curso_id', 'int', 5, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Empresa'));
        $this->_addField('horarioInicial', 'horario_inicial', 'varchar', 5, array());
        $this->_addField('horarioFinal', 'horario_final', 'varchar', 5, array());
        $this->_addField('dataInicio', 'data_inicio', 'date', null, array());
        $this->_addField('dataTermino', 'data_termino', 'date', null, array());
        $this->_addField('prova', 'prova', 'int', 1, array());
        $this->_addField('provaData', 'prova_data', 'date', null, array());
        $this->_addField('provaLocal', 'prova_local', 'varchar', 150, array());
        $this->_addField('provaHorario', 'prova_horario', 'varchar', 5, array());
        $this->_addField('localInscricao', 'local_inscricao', 'varchar', 170, array());
        $this->_addField('idade', 'idade', 'int', 3, array());

        $this->_addField('periodo', 'periodo', 'char', 1, array());
        $this->_addField('sala', 'sala', 'varchar', 20, array());
        
        $this->_addField('inscricaoweb', 'inscricaoweb', 'int', 1, array());
        $this->_addField('vagas', 'vagas', 'int', 4, array());
        $this->_addField('valor', 'valor', 'float', null, array());
        $this->_addField('valorVale', 'valor_vale', 'float', null, array());
        $this->_addField('dataInicioInscricao', 'data_inicio_inscricao', 'date', null, array());
        $this->_addField('dataFinalInscricao', 'data_termino_inscricao', 'date', null, array());
        $this->_addField('status', 'status', 'int', 1, array('default' => '1'));
        
        //$this->_addField('uniteemprega', 'uniteemprega', 'int', 1, array('default' => '0'));
        
        $this->_addField('obs', 'obs', 'varchar', 255, array());
        $this->_addField('ativo', 'ativo', 'int', 1, array('default' => '1'));
        $this->_addField('resultado', 'resultado', 'int', 1, array('default' => '0'));
        $this->_addField('publicar', 'publicar', 'int', 1, array('default' => '1'));
        $this->_addField('dataCadastro', 'data_cadastro', 'datetime', null, array('default' => '_function:CURRENT_TIMESTAMP'));
        $this->_addForeignRelation('alunos', self::MANY_TO_MANY, 'Aluno', 'id', 'local_curso_aluno', 'local_curso_id', null);
        $this->_addForeignRelation('professores', self::MANY_TO_MANY, 'Professor', 'id', 'agenda_professor_disciplina', 'local_curso_id', null);
    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return Local
     */
    public static function staticGet($pk, $pkValue = null) {
        $obj = new AgendaCurso();
        $obj->get($pk, $pkValue);
        return $obj;
    }

    /**
     * chama o destrutor pai
     *
     */
    function __destruct() {
        parent::__destruct();
    }

    #------------------------------------------------------#
    # Coloque todos os metodos personalizados abaixo de    #
    # END AUTOCODE                                         #
    #------------------------------------------------------#
    #### END AUTOCODE
}
