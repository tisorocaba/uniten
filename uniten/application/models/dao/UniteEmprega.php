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
 * Classe generada para a tabela "unite_emprega"
 * in 2012-06-19
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package application.models.dao
 *
 */

class UniteEmprega extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'unite_emprega';
    protected $_package   = 'application.models.dao';
    
    
    public $id;
    public $razao;
    public $fantasia;
    public $atividade;
    public $cnpj;
    
    public $porte;
    public $cep;
    public $endereco;
    public $numero;
    public $complemento;
    public $bairro;
    public $cidade;
    public $responsavel;
    public $email;
    public $ddd;
    public $telefone;
    public $dataCadastro;
    public $status;
    public $senha;
    
    
    
    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize()
    {
        
        
        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
        
        $this->_addField('id', 'id', 'int', 5, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('razao', 'razao', 'varchar', 80, array());
        $this->_addField('fantasia', 'fantasia', 'varchar', 40, array());
        $this->_addField('cnpj', 'cnpj', 'varchar', 14, array());
        $this->_addField('porte', 'porte', 'int', 1, array());
        $this->_addField('atividade', 'atividade', 'int', 1, array());
        $this->_addField('cep', 'cep', 'varchar', 9, array());
        $this->_addField('endereco', 'endereco', 'varchar', 80, array());
        $this->_addField('numero', 'numero', 'varchar', 5, array());
        $this->_addField('complemento', 'complemento', 'varchar', 40, array());
        $this->_addField('bairro', 'bairro', 'varchar', 50, array());
        $this->_addField('cidade', 'cidade', 'varchar', 50, array());
        $this->_addField('responsavel', 'responsavel', 'varchar', 80, array());
        $this->_addField('email', 'email', 'varchar', 100, array());
        $this->_addField('ddd', 'ddd', 'int', 2, array());
        $this->_addField('telefone', 'telefone', 'varchar', 8, array());
        $this->_addField('dataCadastro', 'data_cadastro', 'datetime', null, array('default' => '_function:CURRENT_TIMESTAMP'));
        $this->_addField('status', 'status', 'int', 1, array('default' => '0'));
        $this->_addField('senha', 'senha', 'varchar', 30, array());

        
    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return UniteEmprega
     */
    public static function staticGet($pk, $pkValue = null)
    {
        $obj = new UniteEmprega;
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
