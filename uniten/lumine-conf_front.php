<?php


$lumineConfig = array(
    'dialect' => 'MySQL',
    'database' => 'portal_uniten',
    'user' => 'usuário_aqui',      // <<<< ALTERE AQUI
    'password' => 'senha_aqui',  // <<<< ALTERE AQUI
    'port' => '3306',
    'host' => 'localhost',           // <<<< ALTERE AQUI
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