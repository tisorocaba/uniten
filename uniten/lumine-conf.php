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
 * Created by Lumine_Reverse
 * in 2011-06-03
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 *
 * Arquivo de configuração para "unite2"
 */

$lumineConfig = array(


    'dialect' => 'MySQL',
    'database' => 'portal_uniten',
    'user' => 'usuário_aqui',     // <<<< ALTERE AQUI
    'password' => 'senha_aqui', // <<<< ALTERE AQUI
    'port' => '3306',
    'host' => 'localhost',          // <<<< ALTERE AQUI
    'class_path' => 'e:/Default/uniten',  // <<<< ALTERE AQUI




    'package' => 'application.models.dao',
    'addons_path' => '',
    'acao' => 'gerar', 

	
    'options' => array(
        'configID' => 'ci',
        'charset' =>'utf8',
        'tipo_geracao' => '1', 
        'remove_prefix' => '', 
        'remove_count_chars_start' => '0', 
        'remove_count_chars_end' => '0', 
        'format_classname' => '', 
        'schema_name' => '', 
        'many_to_many_style' => '%s_%s', 
        'plural' => '', 
        'create_controls' => 'White', 
        'class_sufix' => '', 
        'keep_foreign_column_name' => '1', 
        'camel_case' => '1', 
        'usar_dicionario' => '1', 
        'create_paths' => '1', 
        'dto_format' => '%sDTO', 
        'dto_package' => 'entidades', 
        'create_models' => '1', 
        'model_path' => 'application/models', 
        'model_format' => '%sModel', 
        'model_context' => '1', 
        'model_context_path' => 'application/libraries', 
        'overwrite' => '0', 
        'create_dtos' => '', 
        'generateAccessors' => '', 
        'create_entities_for_many_to_many' => '', 
        'generate_files' => '1', 
        'generate_zip' => '0'
    )
);



?>