<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Servicos extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));

    }

    function detalhe($id=false){
        if ($id === false || !is_numeric($id)) {
            redirect('home');
        }

        $cod = filter_var($id);
        $data['servico'] = PaginaModel::getInstance()->get($cod);

        $this->layout->view('servicos/detalhe',$data);
    }



}

