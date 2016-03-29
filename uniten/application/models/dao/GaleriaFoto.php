<?php



class GaleriaFoto extends Lumine_Base {

    // sobrecarga
    protected $_tablename = 'galeria_foto';
    protected $_package = 'application.models.dao';
    public $id;
    public $foto;
    public $comentario;
    public $capa;
    public $galeria;

    /**
     * Inicia os valores da classe
     * @author Hugo Ferreira da Silva
     * @return void
     */
    protected function _initialize() {


        # nome_do_membro, nome_da_coluna, tipo, comprimento, opcoes

        $this->_addField('id', 'id', 'int', 11, array('primary' => true, 'notnull' => true, 'autoincrement' => true));
        $this->_addField('foto', 'foto', 'varchar', 30, array());
        $this->_addField('comentario', 'comentario', 'varchar', 255, array());
        $this->_addField('capa', 'capa', 'char', 1, array('default' => '1'));
        $this->_addField('galeria', 'galeria_id', 'int', 11, array('foreign' => '1', 'onUpdate' => 'RESTRICT', 'onDelete' => 'RESTRICT', 'linkOn' => 'id', 'class' => 'Galeria'));
    }


    public static function staticGet($pk, $pkValue = null) {
        $obj = new GaleriaFoto;
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
            $aData = explode('.', $target);
            switch (strtolower(array_pop($aData))) {
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
