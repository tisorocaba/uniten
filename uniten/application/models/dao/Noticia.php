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
 * Classe generada para a tabela "noticia"
 * in 2012-05-14
 * @author Hugo Ferreira da Silva
 * @link http://www.hufersil.com.br/lumine
 * @package application.models.dao
 *
 */

class Noticia extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'noticia';
    protected $_package = 'application.models.dao';
    public $id;
    public $titulo;
    public $data;
    public $descricao;
    public $foto1;
    public $foto2;
    public $foto3;
    public $foto4;

    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize() {


        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes

        $this->_addField('id', 'id', 'int', 4, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('titulo', 'titulo', 'varchar', 80, array());
        $this->_addField('data', 'data', 'date', null, array());
        $this->_addField('descricao', 'descricao', 'text', 65535, array());
        $this->_addField('foto1', 'foto1', 'varchar', 30, array());
        $this->_addField('foto2', 'foto2', 'varchar', 30, array());
        $this->_addField('foto3', 'foto3', 'varchar', 30, array());
        $this->_addField('foto4', 'foto4', 'varchar', 30, array());
    }

    /**
     * Recupera um objeto estaticamente
     * @author Hugo Ferreira da Silva
     * @return Noticia
     */
    public static function staticGet($pk, $pkValue = null) {
        $obj = new Noticia;
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
