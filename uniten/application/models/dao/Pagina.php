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
 * Classe generada para a tabela "banner"
 * in 2010-06-07
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package entidades
 *
 */

class Pagina extends Lumine_Base {
	
	// sobrecarga
	protected $_tablename = 'pagina';
	protected $_package = 'application.models.dao';
	
	public $id;
	public $titulo;
	public $texto;
	public $secao;

	
	/**
	 * Inicia os valores da classe
	 * @author Hugo Ferreira da Silva
	 * @return void
	 */
	protected function _initialize() {
		
		# nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes
		

		$this->_addField ( 'id', 'id', 'int', 4, array ('primary' => true, 'notnull' => true, 'autoincrement' => true ) );
		$this->_addField ( 'titulo', 'titulo', 'varchar', 100, array ('notnull' => true, 'default' => '' ) );
		$this->_addField ( 'texto', 'texto', 'text', 98888, array () );
		$this->_addField ( 'secao', 'secao', 'int', 1, array () );
	
	}
	
	/**
	 * Recupera um objeto estaticamente
	 * @author Hugo Ferreira da Silva
	 * @return Banner
	 */
	public static function staticGet($pk, $pkValue = null) {
		$obj = new Pagina ( );
		$obj->get ( $pk, $pkValue );
		return $obj;
	}
	
	/**
	 * chama o destrutor pai
	 *
	 */
	function __destruct() {
		parent::__destruct ();
	}
	
	#------------------------------------------------------#
	# Coloque todos os metodos personalizados abaixo de    #
	# END AUTOCODE                                         #
	#------------------------------------------------------#
	#### END AUTOCODE
	

	
}
