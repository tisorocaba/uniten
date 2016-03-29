<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Resultados extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('local_model');
    }

    public function index($offset = 0)
    {
        if (!is_numeric($offset)) {
            redirect('home');
        }
        $this->load->library('Slug');
        $this->load->library('pagination');
        $data['resultados'] = AgendaCursoModel::resultados($offset);
        $data['total'] = AgendaCursoModel::resultadosTotal();
        $_SESSION['RESULTADOS'] = 'TRUE';
        $this->layout->view('resultados/index', $data);
    }


    public function detalhe($id=false) {



        if($id===false || !is_numeric($id)){
            redirect('home');
        }
        $cod = filter_var($id);
        $data['agenda'] = AgendaCursoModel::getInstance()->get($cod);
        if ($data['agenda']['id'] == null) {
            redirect('resultados');
        }
        $aprovados = $this->local_model->aprovados($cod, $data['agenda']['vagas']);
        $suplentes = $this->local_model->suplentes($cod, $data['agenda']['vagas']);

        $data['aprovados'] = $aprovados;
        $data['suplentes'] = $suplentes;
        $this->layout->view('resultados/detalhe', $data);
    }





}
