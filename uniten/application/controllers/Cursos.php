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
class Cursos extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('Local_model',TRUE);

    }



    public function index($offset=0) {

        if(!is_numeric($offset)){
            redirect('home');
        }

        $this->load->library('pagination');
        $data['cursos'] = CursoModel::getInstance()->cursos(1,$offset);
        $data['total'] = CursoModel::getInstance()->cursosTotal(1);
        $this->layout->view('/cursos/index', $data);
    }

    public function descricao($id=false,$offset=0) {
        if($id===false || !is_numeric($id)){
            redirect('home');
        }
        $data['curso'] = CursoModel::getInstance()->get($id);
        if ($data['curso']['dataCadastro'] == null) {
            redirect('cursos');
        }
        $data['offset'] = $offset;
        $this->layout->view('/cursos/descricao', $data);
    }

    public function cursos_abertos($offset=0) {
        if (!is_numeric($offset)) {
            redirect('home');
        }

        if (!empty($offset)) {
            $data['offset'] = $offset;
        } else {
            $data['offset'] = 0;
        }
        $data['offset'] = $offset;
        $data['cursos'] = AgendaCursoModel::getInstance()->cursosAbertos($offset);
        $data['total'] = AgendaCursoModel::cursosAbertosTotal();
        $this->layout->view('/cursos/cursos_abertos', $data);
    }



    public function projeto($id=false,$slug='',$offset=0) {
        if ($id === false || !is_numeric($id) || !is_numeric($offset)) {
            redirect('home');
        }

        if (!empty($offset)) {
            $data['offset'] = $offset;
        } else {
            $data['offset'] = 0;
        }
        $this->session->set_userdata('back', 'cursos/cursos/cod/' . $id . '/offset/' . $offset);
        $data['cursos'] = AgendaCursoModel::getInstance()->cursosPorProjeto($id,$offset);
        $data['projeto'] = ProjetoModel::getInstance()->get($id);

        /*         * ** para paginacao **** */
        //$total = count(AgendaCursoModel::getInstance()->cursosPorProjetoTotal($id));
        //$data['total'] = (int) $total;

        /*         * ********************** */

        $this->layout->view('/cursos/projeto', $data);
    }

    public function listacursos() {


        $this->load->library('utilmanager');

        if (is_numeric($this->uri->segment(4))) {
            $cod = (int) $this->uri->segment(4);
        } else {
            redirect('home');
        }


        $segmento = SegmentoModel::getInstance()->get($cod);



        $offset = (int) $this->uri->segment(6);

        if (!empty($offset)) {
            $data['offset'] = $offset;
        } else {
            $data['offset'] = 0;
        }


        //Lumine_Log::setLevel(3);

        $orderBy = 'nome ASC';


        $prefs = array('whereExtra' => 'ativo = 1 and destaque = 1 and segmento_id = ' . $cod);




        $cursos = CursoModel::getInstance()->find(array(), $orderBy, $offset, LIMIT, $prefs);
        $data['cursos'] = $cursos;
        $data['segmento'] = $segmento;

        /*         * ** para paginacao **** */
        $data['total'] = (int) CursoModel::getInstance()->rows();
        $data['limit'] = LIMIT;
        /*         * ********************** */




        $this->layout->view('/cursos/listacursos', $data);
    }

    public function resultados() {
        $this->load->library('utilmanager');
        $offset = (int) $this->uri->segment(4);
        if (!empty($offset)) {
            $data['offset'] = $offset;
        } else {
            $data['offset'] = 0;
        }

        $orderBy = 'dataCadastro DESC';
        $prefs = array('whereExtra' => 'resultado = 1 and ativo = 1 and status = 1 ');
        $filtros = array();



        $cursos = AgendaCursoModel::getInstance()->find($filtros, $orderBy, $offset, LIMIT, $prefs);
        $data['cursos'] = $cursos;



        /*         * ** para paginacao **** */
        $total = AgendaCursoModel::getInstance()->rows();
        $data['total'] = (int) $total;
        $data['limit'] = LIMIT;
        /*         * ********************** */

        $this->layout->view('/cursos/resultados', $data);
    }

    public function detalhe() {
        $this->load->library('utilmanager');

        if (is_numeric($this->uri->segment(4))) {
            $cod = (int) $this->uri->segment(4);
        } else {
            redirect('home');
        }
       


        $curso = CursoModel::getInstance()->get($cod);

        if ($curso['dataCadastro'] == null) {
            redirect('cursos');
        }

        //Lumine_Log::setLevel(3);

        $orderBy = 'dataCadastro DESC';
        $prefs = array('whereExtra' => ' ativo = 1  and publicar = 1 and data_cadastro > DATE_SUB(curdate(), INTERVAL 6 MONTH)  and curso_id=' . $cod);
        $agendas = AgendaCursoModel::getInstance()->find(array(), $orderBy, '', '', $prefs);


        $data['agendas'] = $agendas;
        $data['curso'] = $curso;
        $data['segmento'] = SegmentoModel::getInstance()->get($curso['segmento']);

        $this->layout->view('/cursos/detalhea', $data);
    }

    public function resultado() {
        $this->load->library('utilmanager');
        $cod = (int) $this->uri->segment(4);

        $agenda = AgendaCursoModel::getInstance()->get($cod);

        $aprovados = $this->local_model->aprovados($cod, $agenda['vagas']);
        $suplentes = $this->local_model->suplentes($cod, $agenda['vagas']);

        $data['agenda'] = $agenda;
        $data['aprovados'] = $aprovados;
        $data['suplentes'] = $suplentes;

        $this->layout->view('/cursos/resultado', $data);
    }

    public function mapa() {
        $agenda = AgendaCursoModel::getInstance()->get($this->session->userdata('agenda'));
        $data['agenda'] = $agenda;
        $this->load->view('/cursos/mapa', $data);
    }

}

?>
