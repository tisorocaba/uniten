<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contato
 *
 * @author rogerio
 */
class Noticias extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

    }

    public function index($offset=0) {
        if(!is_numeric($offset)){
            redirect('home');
        }
        $this->load->library('Slug');
        $this->load->library('pagination');
        $data['noticias'] = NoticiaModel::getInstance()->todas($offset);
        $data['total'] = (int)NoticiaModel::getInstance()->rows();
        $data['limit'] = LIMIT;
        $this->layout->view('/noticias/index', $data);
    }

    public function detalhe($id=false) {
        if($id===false || !is_numeric($id)){
            redirect('home');
        }
        $cod = filter_var($id);
        $data['noticia'] = NoticiaModel::getInstance()->get($cod);
        if ($data['noticia']['data'] == null) {
            redirect('noticias');
        }
        $this->layout->view('noticias/detalhe', $data);
    }

}

?>
