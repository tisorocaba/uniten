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
 * Model generada para a tabela "UniteEmprega"
 * in 2012-06-19 11:06:33
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package Lumine
 *
 */
class UniteEmpregaModel extends Lumine_Model {
	
	/**
	 * 
	 * @var UniteEmpregaModel
	 */
	private static $instance;
	
	/**
	 * Construtor
	 * 
	 * @author Hugo Ferreira da Silva
	 * @link http://www.hufersil.com.br/lumine
	 */
	function __construct(){
		if(!$this->obj){
			$this->obj = new UniteEmprega;
		}
		parent::__construct();
	}
	
	/**
	 * Retorna uma instancia da model
	 * 
	 * @author Hugo Ferreira da Silva
	 * @link http://www.hufersil.com.br/lumine
	 * @return UniteEmpregaModel
	 */
	public static function getInstance(){
		if(!self::$instance){
			self::$instance = new UniteEmpregaModel();
		}
		
		return self::$instance;
	}
	
	//////////////////////////////////////////////////////////////////
	// Coloque seus metodos personalizados abaixo de END AUTOCODE
	//////////////////////////////////////////////////////////////////
	### END AUTOCODE

	
}