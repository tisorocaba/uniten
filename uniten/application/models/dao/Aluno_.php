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
 * Classe generada para a tabela "aluno"
 * in 2011-06-03
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package application.models.dao
 *
 */

class Aluno extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'aluno';
    protected $_package = 'application.models.dao';
    public $id;
    public $nome;
    public $cpf;
    public $rg;
    public $endereco;
    public $numero;
    public $complemento;
    public $bairro;
    public $cidade;
    public $cep;
    public $ctps;
    public $serie;
    public $dataNascimento;
    public $sexo;
    public $desempregado;
    public $autonomo;
    public $estadoCivil;
    public $possuiImovel;
    public $situacaoHabitacional;
    public $valorAluguel;
    public $email;
    public $escolaridade;
    public $dataCadastro;
    public $bolsaFamilia;
    public $dataUltimaAlteracao;
    public $poscursos = array();
    public $diarioclasses = array();
    public $agendacursos = array();

    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize() {


        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes

        $this->_addField('id', 'id', 'int', 10, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('nome', 'nome', 'varchar', 95, array('notnull' => true, 'default' => ''));
        $this->_addField('cpf', 'cpf', 'varchar', 12, array('notnull' => true, 'default' => ''));
        $this->_addField('rg', 'rg', 'varchar', 45, array('notnull' => true));
        $this->_addField('endereco', 'endereco', 'varchar', 120, array());
        $this->_addField('numero', 'numero', 'varchar', 6, array());
        $this->_addField('complemento', 'complemento', 'varchar', 45, array());
        $this->_addField('bairro', 'bairro', 'varchar', 50, array());
        $this->_addField('cidade', 'cidade', 'varchar', 50, array());
        $this->_addField('cep', 'cep', 'varchar', 9, array());
        $this->_addField('ctps', 'ctps', 'varchar', 25, array());
        $this->_addField('serie', 'serie', 'varchar', 25, array());
        
        $this->_addField('dataNascimento', 'data_nascimento', 'date', null, array());
        $this->_addField('desempregado', 'desempregado', 'boolean', 1, array());
        $this->_addField('autonomo', 'autonomo', 'boolean', 1, array());
        $this->_addField('estadoCivil', 'estado_civil', 'char', 1, array());
        $this->_addField('sexo', 'sexo', 'char', 1, array());
        $this->_addField('possuiImovel', 'possui_imovel', 'boolean', 1, array());
        $this->_addField('situacaoHabitacional', 'situacao_habitacional', 'varchar', 45, array());
        $this->_addField('valorAluguel', 'valor_aluguel', 'float', null, array());
        $this->_addField('email', 'email', 'varchar', 110, array());
        $this->_addField('escolaridade', 'escolaridade', 'varchar', 100, array());
        $this->_addField('dataCadastro', 'data_cadastro', 'datetime', null, array('default' => '_function:CURRENT_TIMESTAMP'));
        $this->_addField('dataUltimaAlteracao', 'data_ultima_alteracao', 'datetime', null, array());
        $this->_addField('ddd', 'ddd', 'int', 2, array());
        $this->_addField('telefone', 'telefone', 'varchar', 9, array());
        $this->_addField('bolsaFamilia', 'bolsa_familia', 'varchar', 50, array());
        $this->_addField('desempregadoTempo', 'desempregado_tempo', 'varchar', 50, array());
        $this->_addField('divulgacao', 'divulgacao', 'char', 1, array());

        $this->_addForeignRelation('poscursos', self::ONE_TO_MANY, 'Poscurso', 'aluno', null, null, null);
        $this->_addForeignRelation('diarioclasses', self::MANY_TO_MANY, 'DiarioClasse', 'id', 'diario_classe_aluno', 'aluno_id', null);
        $this->_addForeignRelation('agendacursos', self::MANY_TO_MANY, 'AgendaCurso', 'id', 'local_curso_aluno', 'aluno_id', null);
    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return Aluno
     */
    public static function staticGet($pk, $pkValue = null) {
        $obj = new Aluno;
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
