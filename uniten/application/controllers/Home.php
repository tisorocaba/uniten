<?php if (!defined('BASEPATH'))   exit('No direct script access allowed');

class Home extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function index() {

         //Lumine_Log::setLevel(3);

         //lista os projetos
         $data['projetos'] = ProjetoModel::ultimos();



        $data['resultados'] = AgendaCursoModel::ultimosResultados();

        // listando os projetos para informações
        //$data['projetosInfo'] = ProjetoModel::getInfo();
       
         // listando os 3 ultimos eventos
         $data['eventos'] =  GaleriaModel::ultimas();
         
          // listando os 3 ultimos noticias
         $data['noticias'] = NoticiaModel::ultimas();

        // listando os servicos (paginas)
        $data['servicos'] = PaginaModel::servicos();


        $data['cursos'] = CursoModel::cursosRand();
         
         $this->layout->view('/home/index',$data);
         
         
    }
    


}

