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
class Cadastro extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('local_model');
    }

    public function index()
    {
        $this->load->library('utilmanager');
        $curso = $this->session->userdata('agenda');

        $data = array();

        if (empty($curso)) {
            redirect('cursos');
        }

        $agenda = AgendaCursoModel::getInstance()->get($curso);
        $inicioInscri = strtotime($agenda['dataInicioInscricao']);
        $termininoInscri = strtotime($agenda['dataFinalInscricao']);
        $dataatual = strtotime(date("Y-m-d"));
        if ($agenda['inscricaoweb'] == 0 || !($inicioInscri <= $dataatual && $dataatual <= $termininoInscri)) {
            redirect('cursos');
        }
        unset($data['agenda']);
        $data['agenda'] = $agenda;
        $this->layout->view('/cadastro/index', $data);
    }

    public function consulta()
    {
        $this->load->library('utilmanager');


        // aplicando os validadores do CI
        if ($this->session->userdata('agenda') == null) {
            redirect('/cursos/index');
        } else {
            $data['agenda'] = AgendaCursoModel::getInstance()->get($this->session->userdata('agenda'));
        }

        $datastart = strtotime("-80 years", strtotime(date('Y-m-d')));
        $datacandidato = strtotime($this->utilmanager->dataUS($_POST['dataNascimento']));


        if ($datacandidato < $datastart || $datacandidato === false) {
            $this->session->set_flashdata('erroData', 'Data de nascimento inválida');
            redirect('/cadastro');
        }


        $this->form_validation->set_rules('dataNascimento', 'Data de Nascimento', 'required');
        $this->form_validation->set_rules('cpf', 'CPF', 'required|callback_cpf_check');
        $this->form_validation->set_rules('termo', 'Termo de acordo', 'required');



        // fim dos validadores
        // verificando se deu problema com os validadores
        if ($this->form_validation->run() == FALSE) {
            // deu problema jogar o usurio para a pagina de cadastro
            $this->layout->view('/cadastro/index', $data);
        } else {

            // tudo ok com as validacoes            
            //verificando se o aluno já é cadastro
            $aluno = AlunoModel::getInstance()->get('cpf', $_POST['cpf']);


            if ($aluno['id'] !== null) {
                // ja eh um aluno cadastrado
                // verificando se ele jah nao esta cadastrado nesse curso



                $aDados = $this->local_model->verificaInscricao($this->session->userdata('agenda'), $aluno['id']);

                $_REQUEST['dataNascimento'] = $this->utilmanager->dataBR($aluno['dataNascimento']);

                if (!empty($aDados)) {
                    $this->session->set_flashdata('dataCadastro', $aDados[0]);
                    redirect('/cadastro/inscricaojarealizada');
                    exit;
                }

                // verificando se o aluno possui registro de desistencia
                $oDesistencia = $this->local_model->verificaDesistencia($aluno['id']);


                // verificando se eh desistente justificada
                if (count((array)$oDesistencia) > 0) {
                    // existe  desistencia
                    // verificando se foi justificada 
                    if (empty($oDesistencia->desistencia)) {
                        //se jah passou o tempo de penalizacao
                        if ($oDesistencia->contador <= 360) {
                            $this->session->set_flashdata('liberacao', $oDesistencia->liberacao);
                            redirect('/cadastro/penalizacao');
                            exit;
                        }
                    }
                }

                /*                 * **** Verificando se o aluno ja e cadastrado em algum curso dentro do periodo ****** */
                $oDado = $this->local_model->ultimoCurso($aluno['id']);


                // verificando se o ultimo curso nao esta finalizado
                if (count((array)$oDado) > 0) {

                    if ($oDado->status >= '0') {

                        // verificando se o local do curso e eden ou unite central


                        if (((int)$oDado->local == 1 || (int)$oDado->local == 31) && (int)$oDado->prova === 1) {
                            $dataprova = strtotime($oDado->prova_data . " " . $oDado->prova_horario);
                            $datahoje = strtotime('now');


                            // verifica se a prova já passou
                            if ($datahoje <= $dataprova) {
                                $this->session->set_flashdata('nomecurso', $oDado->nome);
                                redirect('/cadastro/execessodeinscricao');
                                exit;
                            }
                        }
                    } else {
                        $dataInicioAula = strtotime($data['agenda']['dataInicio']);
                        $dataTerminoUltimoCurso = @strtotime($oDado->data_final);


                        if ($dataTerminoUltimoCurso >= $dataInicioAula) {

                            // dados do curso atual
                            $timeAtualIni = strtotime($oDado->horario_inicial);
                            $timeAtualFinal = strtotime($oDado->horario_final);

                            // dados do curso pretendido
                            $timePretendidoIni = strtotime($data['agenda']['horarioInicial']);
                            $timePretendidoFim = strtotime($data['agenda']['horarioFinal']);

                            // verificando a horario de inicio
                            if (($timePretendidoIni >= $timeAtualIni && $timePretendidoIni <= $timeAtualFinal) || ($timePretendidoFim >= $timeAtualIni && $timePretendidoFim <= $timeAtualFinal)) {
                                $this->session->set_flashdata('datafinal', $oDado->data_final);
                                $this->session->set_flashdata('curso', $oDado->nome);
                                redirect('/cadastro/coincidenciadedatas');
                            }
                        }
                    }
                }
            }


            //***************************************************** 
            //************** verificando a idade minima ***********
            $idadeCandidato = $this->utilmanager->calculaIdade($_POST['dataNascimento']);
            $idadeMinimaAgenda = AgendaCurso::staticGet($this->session->userdata('agenda'))->idade;


            if ($idadeCandidato < $idadeMinimaAgenda) {
                $this->session->set_flashdata('idade', $idadeMinimaAgenda);
                redirect('/cadastro/abaixodaidademinima');
                die;
            }
            //******************************************************


            $data['aluno'] = $aluno;
            if (empty($data['aluno']['dataNascimento'])) {
                $data['aluno']['dataNascimento'] = $_REQUEST['dataNascimento'];
            } else {
                $data['aluno']['dataNascimento'] = $this->utilmanager->dataBR($data['aluno']['dataNascimento']);
            }


            $data['tempoDesempregos'] = TempoDesempregoModel::getInstance()->find();


            $this->layout->view('/cadastro/formulario', $data);
        }
    }

    function inscricaojarealizada()
    {
        $this->load->library('utilmanager');
        $agenda = AgendaCursoModel::getInstance()->get($this->session->userdata('agenda'));
        $data['agenda'] = $agenda;
        $this->layout->view('/cadastro/inscricao_realizada', $data);
    }

    public function formulario()
    {

        $aluno = AlunoModel::getInstance()->get('cpf', $_POST['cpf']);
        $data['aluno'] = $aluno;
        $this->layout->view('/cadastro/formulario', $data);
    }

    public function reformulario()
    {
        $data['aluno'] = $_POST;
        $this->layout->view('/cadastro/formulario', $data);
    }

    public function grava()
    {

        if ($this->session->userdata('agenda') == null) {
            redirect('/cursos/index');
        }

        $this->load->library('utilmanager');
        $this->load->library('emailmanager');
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        $this->form_validation->set_rules('rg', 'RG', 'required');
        $this->form_validation->set_rules('dataNascimento', 'Data de Nascimento', 'required');
        $this->form_validation->set_rules('estadoCivil', 'Estado Cívil', 'required');
        //$this->form_validation->set_rules('ctps', 'CTPS', 'required');
        //$this->form_validation->set_rules('serie', 'Serie', 'required');
        $this->form_validation->set_rules('desempregado', 'Desempregado', 'required');
        $this->form_validation->set_rules('possuiImovel', 'Possui Imóvel', 'required');
        //$this->form_validation->set_rules('situacaoHabitacional', 'Situação Habitacional', 'required');
        $this->form_validation->set_rules('escolaridade', 'Escolaridade', 'required');
        //$this->form_validation->set_rules('idade', 'idade', 'required');
        $this->form_validation->set_rules('endereco', 'Endereco', 'required');
        $this->form_validation->set_rules('numero', 'Numero', 'required|numeric');
        $this->form_validation->set_rules('bairro', 'Bairro', 'required');
        $this->form_validation->set_rules('cidade', 'Cidade', 'required');
        $this->form_validation->set_rules('ddd', 'DDD', 'required|numeric');
        $this->form_validation->set_rules('telefone', 'Telefone', 'required|numeric');
        $this->form_validation->set_message('required', '%s é campo obrigatório');
        $this->form_validation->set_message('numeric', '%s tem que ser campo numérico');

        if ($this->form_validation->run() == FALSE) {
            $this->reformulario();
        } else {
            //Lumine_Log::setLevel(3);

            $_POST['agendacursos'] = array('0' => $this->session->userdata('agenda'));
            $_POST['dataNascimento'] = $this->utilmanager->dataUS($_POST['dataNascimento']);
            $_POST['renda'] = $this->utilmanager->moedaToBanco($_POST['renda']);

            // verificando se o aluno já está cadastrado
            $alunoTemp = AlunoModel::getInstance()->get('cpf', $_POST['cpf']);
            if ($alunoTemp['id'] !== null) {
                $aDados = $this->local_model->verificaInscricao($this->session->userdata('agenda'), $alunoTemp['id']);
                if (!empty($aDados)) {
                    $this->session->set_flashdata('dataCadastro', $aDados[0]);
                    redirect('/cadastro/inscricaojarealizada');
                    exit;
                }
            }

            $this->load->model('aluno_model');
            $aluno = $this->aluno_model->gravar($_POST);
            //$aluno = AlunoModel::getInstance()->save($_POST);
            $this->session->set_userdata('codAluno', $aluno);

            redirect('/cadastro/confirmacao');
        }
    }

    function confirmacao()
    {
        $this->load->library('utilmanager');
        $this->load->library('emailmanager');
        $data['aluno'] = AlunoModel::getInstance()->get($this->session->userdata('codAluno'));
        $agenda = AgendaCursoModel::getInstance()->get($this->session->userdata('agenda'));
        $agenda['provaData'] = $this->utilmanager->dataBR($agenda['provaData']);
        $agenda['dataInicio'] = $this->utilmanager->dataBR($agenda['dataInicio']);
        $agenda['dataTermino'] = $this->utilmanager->dataBR($agenda['dataTermino']);
        $data['agenda'] = $agenda;

        if ((int)$agenda['prova'] === 1) {

            if (!empty($data['aluno']['email'])) {
                $this->emailmanager->enviaEmailInscricaoProva($agenda, $data['aluno']);
            }
            $this->layout->view('/cadastro/confirmacao_com_prova', $data);
        } else {

            $data['classificacao'] = $this->local_model->insereClassificacao($agenda['id'], $data['aluno']['id']);
            $this->layout->view('/cadastro/confirmacao_sem_prova', $data);
        }
    }

    public function ajaxbuscacep()
    {
        $this->load->library('utilmanager');
        return $this->utilmanager->buscaCEP($_REQUEST['cep']);
    }

    public function penalizacao()
    {
        $this->layout->view('/cadastro/penalizacao');
    }

    public function execessodeinscricao()
    {
        $this->load->library('utilmanager');
        $this->layout->view('/cadastro/execessodeinscricao', array());
    }

    public function coincidenciadedatas()
    {
        $this->load->library('utilmanager');
        $this->layout->view('/cadastro/coincidenciadedatas', array());
    }

    public function abaixodaidademinima()
    {
        $this->layout->view('/cadastro/abaixodaidademinima', array());
    }


    public function agenda()
    {
        $this->load->library('utilmanager');
        if (!is_numeric($this->uri->segment(4))) {
            redirect('home');
        }
        $cod = (int)$this->uri->segment(4);

        $agenda = AgendaCursoModel::getInstance()->get($cod);

        if ($agenda['dataCadastro'] == null) {
            redirect('cursos');
        }
        // rearmazenando
        $this->session->set_userdata('agenda', $cod);
        $data['agenda'] = $agenda;
        $this->layout->view('/cadastro/agenda', $data);
    }


    function cpf_check($cpf)
    {

// Verifica se um número foi informado
        if (empty($cpf)) {
            $this->form_validation->set_message('cpf_check', 'Por favor, informe um CPF válido"');
            return false;
        }

// Elimina possivel mascara
        $cpf = str_replace('.', '', $cpf);
        $cpf = str_replace('-', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);


// Verifica se o numero de digitos informados é igual a 11
        if (strlen($cpf) != 11) {
            $this->form_validation->set_message('cpf_check', 'Por favor, informe um CPF válido"');
            return false;
        }
// Verifica se nenhuma das sequências invalidas abaixo
// foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999'
        ) {
            $this->form_validation->set_message('cpf_check', 'Por favor, informe um CPF válido"');
            return false;
            // Calcula os digitos verificadores para verificar se o
            // CPF é válido
        } else {

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    $this->form_validation->set_message('cpf_check', 'Por favor, informe um CPF válido"');
                    return false;
                }
            }

            return true;
        }
    }


}


