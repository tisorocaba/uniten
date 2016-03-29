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
 * Classe generada para a tabela "empresa"
 * in 2011-06-03
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package application.models.dao
 *
 */

class Empresa extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'empresa';
    protected $_package = 'application.models.dao';
    public $id;
    public $nome;
    public $fantasia;
    public $responsavel;
    public $email;
    public $ddd;
    public $telefone;
    public $endereco;
    public $numero;
    public $complemento;
    public $bairro;
    public $cidade;
    public $estado;
    public $ativo;
    public $cep;
    public $dataCadastro;
    public $dataAtualizacao;
    public $professores = array();
    public $usuarios = array();
    public $agendas = array();

    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize() {


        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes

        $this->_addField('id', 'id', 'int', 5, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('nome', 'nome', 'varchar', 85, array('notnull' => true, 'default' => ''));
        $this->_addField('fantasia', 'fantasia', 'varchar', 85, array('notnull' => true, 'default' => ''));
        $this->_addField('responsavel', 'responsavel', 'varchar', 85, array('notnull' => true, 'default' => ''));
        $this->_addField('email', 'email', 'varchar', 125, array());
        $this->_addField('ddd', 'ddd', 'int', 2, array('notnull' => true, 'default' => '0'));
        $this->_addField('telefone', 'telefone', 'varchar', 9, array('notnull' => true, 'default' => ''));
        $this->_addField('endereco', 'endereco', 'varchar', 45, array());
        $this->_addField('numero', 'numero', 'varchar', 6, array());
        $this->_addField('complemento', 'complemento', 'varchar', 45, array());
        $this->_addField('bairro', 'bairro', 'varchar', 50, array());
        $this->_addField('cidade', 'cidade', 'varchar', 50, array());
        $this->_addField('cep', 'cep', 'varchar', 9, array());
        $this->_addField('estado', 'estado', 'varchar', 2, array());
        $this->_addField('ativo', 'ativo', 'int', 1, array('default' => '1'));
        $this->_addField('dataCadastro', 'data_cadastro', 'datetime', null, array('default' => '_function:CURRENT_TIMESTAMP'));
        $this->_addField('dataAtualizacao', 'data_atualizacao', 'datetime', null, array());
        $this->_addField('status', 'status', 'int', 1, array('default' => '1'));

        $this->_addForeignRelation('professores', self::ONE_TO_MANY, 'Professor', 'empresa', null, null, null);
        $this->_addForeignRelation('usuarios', self::ONE_TO_MANY, 'Usuario', 'empresa', null, null, null);
        $this->_addForeignRelation('agendas', self::ONE_TO_MANY, 'AgendaCurso', 'empresaCurso', null, null, null);
    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return Empresa
     */
    public static function staticGet($pk, $pkValue = null) {
        $obj = new Empresa;
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
