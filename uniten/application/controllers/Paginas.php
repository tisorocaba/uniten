<?php


class Paginas extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function index($offset = 0)
    {
        if (!is_numeric($offset)) {
            redirect('home');
        }
        $this->load->library('Slug');
        $this->load->library('pagination');
        $data['eventos'] = GaleriaModel::getInstance()->todas($offset);
        $data['total'] = (int)GaleriaModel::getInstance()->rows();
        $this->layout->view('eventos/index', $data);
    }

    public function detalhe($id = false)
    {
        if ($id === false || !is_numeric($id)) {
            redirect('home');
        }

        $cod = filter_var($id);
        $data['pagina'] = PaginaModel::getInstance()->get($cod);

        if ($data['pagina'] == null) {
            redirect('paginas');
        }
        $this->layout->view('paginas/detalhe', $data);
    }

    public function manualaluno($id = false)
    {
        $data['pagina'] = PaginaModel::getInstance()->get(4);

        if ($data['pagina'] == null) {
            redirect('paginas');
        }
        $this->load->view('paginas/manualaluno', $data);
    }

}