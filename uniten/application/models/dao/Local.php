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

class Local extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'local';
    protected $_package   = 'application.models.dao';
    
    
    public $id;
    public $projeto;
    public $local;
    public $endereco;
    public $numero;
    public $cep;
    public $bairro;
    public $telefone;
    public $responsavel;
    public $dataCadastro;
    public $ativo;
    public $cursos = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->_addField('id', 'id', 'int', 5, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('projeto', 'projeto_id', 'int', 5, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Projeto'));
        $this->_addField('local', 'local', 'varchar', 120, array());
        $this->_addField('endereco', 'endereco', 'varchar', 100, array());
        $this->_addField('numero', 'numero', 'varchar', 6, array());
        $this->_addField('cep', 'cep', 'varchar', 9, array());
        $this->_addField('bairro', 'bairro', 'varchar', 50, array());
        $this->_addField('telefone', 'telefone', 'varchar', 10, array());
        $this->_addField('responsavel', 'responsavel', 'varchar', 80, array());
        $this->_addField('ativo', 'ativo', 'int', 1, array('default' =>'1'));
        $this->_addField('dataCadastro', 'data_cadastro', 'datetime', null, array('default' => '_function:CURRENT_TIMESTAMP'));

        
        $this->_addForeignRelation('cursos', self::MANY_TO_MANY, 'Curso', 'id', 'local_curso', 'local_id', null);
    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return Local
     */
    public static function staticGet($pk, $pkValue = null)
    {
        $obj = new Local;
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
