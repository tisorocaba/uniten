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
 * Classe generada para a tabela "usuario"
 * in 2011-06-03
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package application.models.dao
 *
 */

class Usuario extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'usuario';
    protected $_package   = 'application.models.dao';
    
    
    public $id;
    public $empresa;
    public $nome;
    public $email;
    public $senha;
    public $login;
    public $ativo;
    public $dataCadastro;
    public $tipo;
    public $professor;
    public $tipoLogin;
    public $menus = array();
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->_addField('id', 'id', 'int', 10, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('empresa', 'empresa_id', 'int', 5, array('notnull' => true, 'foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Empresa','lazy'=>true));
        $this->_addField('nome', 'nome', 'varchar', 85, array());
        $this->_addField('email', 'email', 'varchar', 110, array());
        $this->_addField('login', 'login', 'varchar', 20, array());
        $this->_addField('senha', 'senha', 'varchar', 50, array());
        $this->_addField('ativo', 'ativo', 'int', 1, array());
        $this->_addField('dataCadastro', 'data_cadastro', 'datetime', null, array());
        $this->_addField('tipo', 'tipo', 'char', 1, array());
        $this->_addField('local', 'local_id', 'int', 1, array());
        $this->_addField('professor', 'professor', 'int', 5, array());
        $this->_addField('tipoLogin', 'tipo_login', 'int', 1, array());

        //$this->_addForeignRelation('usuariopermissoes', self::ONE_TO_MANY, 'UsuarioPermissao', 'usuario', null, null, null);
        $this->_addForeignRelation('menus', self::MANY_TO_MANY, 'Menu', 'id', 'usuario_permissao', 'usuario_id', null);
    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return Usuario
     */
    public static function staticGet($pk, $pkValue = null)
    {
        $obj = new Usuario;
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
