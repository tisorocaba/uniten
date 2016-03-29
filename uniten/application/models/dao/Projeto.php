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
 * Classe generada para a tabela "projeto"
 * in 2011-06-03
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package application.models.dao
 *
 */

class Projeto extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'projeto';
    protected $_package   = 'application.models.dao';
    
    
    public $id;
    public $nome;
    public $ativo;
    public $dataCadastro;
    public $publicar;
    public $imagem;
    public $descricao;
    public $locais = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->_addField('id', 'id', 'int', 5, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('nome', 'nome', 'varchar', 120, array());
        $this->_addField('descricao', 'descricao', 'varchar', 65535, array());
        $this->_addField('imagem', 'imagem', 'varchar', 30, array());
        $this->_addField('publicar', 'publicar', 'int', 1, array('default' => '1'));
        $this->_addField('ativo', 'ativo', 'int', 1, array('default' =>'1'));
        $this->_addField('dataCadastro', 'data_cadastro', 'datetime', null, array('default' => '_function:CURRENT_TIMESTAMP'));

        
        $this->_addForeignRelation('locais', self::ONE_TO_MANY, 'Local', 'projeto', null, null, null);
    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return Projeto
     */
    public static function staticGet($pk, $pkValue = null)
    {
        $obj = new Projeto;
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
