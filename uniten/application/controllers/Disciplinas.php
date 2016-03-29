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
class Disciplinas extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');

    }

    public function detalhe($id=false) {

        if (!is_numeric($id)) {
            redirect('home');
        }

        //$data['agenda'] = AgendaCursoModel::getInstance()->get($this->session->userdata('agenda'));
        $data['disciplina'] = DisciplinaModel::getInstance()->get($id);
        
        if(empty($data['disciplina'])){
           die('ERRO: ACESSO NEGADO');
        }

        $this->load->view('/disciplinas/detalhe', $data);
    }



}

?>
