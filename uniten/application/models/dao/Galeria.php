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
 * Classe generada para a tabela "galeria"
 * in 2011-06-06
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package application.models.dao
 *
 */

class Galeria extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'galeria';
    protected $_package = 'application.models.dao';
    public $id;
    public $titulo;
    public $data;
    public $descricao;
    public $secao;
    public $foto;
    public $fotos = array();

    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize() {


        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes

        $this->_addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('titulo', 'titulo', 'varchar', 80, array());
        $this->_addField('data', 'data', 'date', null, array());
        $this->_addField('descricao', 'descricao', 'varchar', 65535, array());
        $this->_addField('secao', 'secao', 'varchar', 60, array());
        $this->_addField('foto', 'foto', 'varchar', 30, array());


        $this->_addForeignRelation('fotos', self::ONE_TO_MANY, 'GaleriaFoto', 'galeria', null, null, true);
    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return Galeria
     */
    public static function staticGet($pk, $pkValue = null) {
        $obj = new Galeria;
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

    public function redimensionar($file, $width = null, $height = null, $target = null) {
        if (!file_exists($file)) {
            return false;
        }

        if (is_null($width) && is_null($height)) {
            return false;
        }

        $img = imagecreatefromstring(file_get_contents($file));
        $tamanhoOriginal = getimagesize($file);


        if (!is_null($width)) {
            $zoom = $width / $tamanhoOriginal [0];
            $height = $tamanhoOriginal [1] * $zoom;
        } else if (!is_null($height)) {

            $zoom = $height / $tamanhoOriginal [1];
            $width = $tamanhoOriginal [0] * $zoom;
        }

        $newimage = imagecreatetruecolor($width, $height);
        imagecopyresampled($newimage, $img, 0, 0, 0, 0, $width, $height, $tamanhoOriginal [0], $tamanhoOriginal [1]);



        if (is_null($target)) {
            imagejpeg($newimage, '', 90);
        } else {
            switch (strtolower(array_pop(explode('.', $target)))) {
                case 'jpg' :
                case 'jpeg' :
                    imagejpeg($newimage, $target, 90);
                    break;

                case 'gif' :
                    imagegif($newimage, $target);
                    break;

                case 'png' :
                    imagepng($newimage, $target, 8);
                    break;
            }
        }
    }

}
