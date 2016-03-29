<?php

require_once '../util/config.php';
require_once '../dao/diarioClasseDao.php';
require_once '../dao/agendaCursoDao.php';
Security::cursoSecurity();
$obj = new DiarioClasse();
$user = unserialize($_SESSION['USER']);

validaCampos($_POST);


if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :
            if ($obj->get(@$_POST ['id']) == 0) {
                unset($_POST ['id']);

                $obj->alias('d')->where('d.agenda=? and d.data = ?', $_SESSION['CODAGENDA'], data_us($_POST['data']))->find();

                if ($obj->count() > 0) {
                    msg("ERRO: Já existe um diário de classe cadastrado nesse dia!");
                    logDao::gravaLog($user->login, 'diarioLogic', 'ERRO: Já existe um diário de classe cadastrado nesse dia',$_REQUEST,'','Data: '.$_POST['data']);
                    gotox("principal.php?acao=diarioCadastro");
                    die;
                }



                $agenda = new AgendaCurso();
                $agenda->get($_SESSION['CODAGENDA']);
                $inicio = strtotime($agenda->dataInicio);
                $termino = strtotime($agenda->dataTermino);
                $informada = strtotime(data_us($_POST['data']));
                
                
                

                if ($inicio > $informada || $termino < $informada) {
                    msg("ERRO: A data da aula informada está fora do período de aula desse  curso!");
                    logDao::gravaLog($user->login, 'diarios', 'ERRO: A data da aula informada está fora do período de aula desse  curso',$_REQUEST,'','Data: '.$_POST['data']);
                    gotox("principal.php?acao=diarioCadastroProfessor");
                    die;
                }
              $_REQUEST ['acao'] = 'Gravou'; 
                
            } else {
                $_REQUEST ['acao'] = 'Alterou';
            }


            $obj->_setFrom($_POST);
            $obj->agenda = $_SESSION['CODAGENDA'];
            $obj->save();

            
             
            
            $cod = $_SESSION['CODAGENDA'];
            $diario = $obj->id;
            
            /**** inserindo as presencas ****/
            // removendo varias que nao sao nescessarias
             unset($_POST['acao']);
             unset($_POST['disciplina']);
             unset($_POST['id']);
             unset($_POST['datahoje']);
             unset($_POST['professor']);
             unset($_POST['data']);
             unset($_POST['horas']);
             unset($_POST['conteudo']);
             
             foreach ($_POST as $key => $value) {

                $aDado = explode('-', $key);
                if (!empty($aDado[1])) {



                    $diarioDao = new DiarioClasseDao();
                    $aluno = $aDado[1];
                    $diarioDao->alteraPresenca($diario, $aluno, $value);
                    
                    
                    if ((int) $value === 1) {
                        $agendaDao = new AgendaCursoDao();
                        $vale = $agendaDao->getPasse($_SESSION['CODAGENDA'], $aluno);
                    
                        if ($vale == NULL) {
                            $vale = 0;
                        }
                        

                        $diarioDao->alteraVale($diario, $aluno, $vale);
                    } else {
                        $diarioDao->alteraVale($diario, $aluno, 0);
                    }
                }
                //var_dump($aDado[1]);
            }
             
            
            
           logDao::gravaLog($user->login, 'diarioLogic', $_REQUEST ['acao'].': diario de classe',$_REQUEST,'','Diario: '.$obj->id);
          
           msg("OK: Diário de classe gravado com sucesso!");
           gotox("principal.php?acao=diarioVisualizar&id=".$diario);


            break;

            // nao esta sendo utilizado
            case 'gravapresenca' :
           
            $cod = @$_SESSION['CODAGENDA'];
            $diario = $_REQUEST['diario'];

            foreach ($_POST as $key => $value) {

                $aDado = explode('-', $key);
                if (!empty($aDado[1])) {



                    $diarioDao = new DiarioClasseDao();
                    $aluno = $aDado[1];
                    $diarioDao->alteraPresenca($diario, $aluno, $value);
                    
                    
                    if ((int) $value === 1) {
                        $agendaDao = new AgendaCursoDao();
                        $vale = $agendaDao->getPasse($_SESSION['CODAGENDA'], $aluno);
                    
                        if ($vale == NULL) {
                            $vale = 0;
                        }
                        

                        $diarioDao->alteraVale($diario, $aluno, $vale);
                    } else {
                        $diarioDao->alteraVale($diario, $aluno, 0);
                    }
                }
                //var_dump($aDado[1]);
            }
            $_SESSION['CODDIARIO'] = $obj->id;
            logDao::gravaLog($user->login, 'diarioLogic', $_REQUEST ['acao'], $_REQUEST);
            
            msg("OK: Diário de classe gravado com sucesso!");
            gotox("principal.php?acao=diarioVisualizar&id=".$diario);
            break;

       
    }
}

function validaCampos($post){
    
    if(empty($post['disciplina'])){
        msg('ERRO:  Disciplina não informada');
        die('<script>history.go(-1);</script>');
    }
    
    
    if(empty($post['data'])){
        msg('ERRO:  Informe a data');
        die('<script>history.go(-1);</script>');
    }
     
    list($dia,$mes,$ano) = explode('/', $post['data']);
    
    if(checkdate($mes,$dia,$ano)===false){
        msg('ERRO:  Data informada invalida');
        die('<script>history.go(-1);</script>');
    }
    
    if(empty($post['horas'])){
        msg('ERRO:  Horas utilizadas não informada');
        die('<script>history.go(-1);</script>');
    }
    
    if(empty($post['conteudo'])){
        msg('ERRO:  Conteudo não informada');
        die('<script>history.go(-1);</script>');
    }
    

    $total = (int)$post['totalAlunos'];
    
    unset($post['id']);
    unset($post['acao']);
    unset($post['totalAlunos']);
    unset($post['professor']);
    unset($post['disciplina']);
    unset($post['data']);
    unset($post['horas']);
    unset($post['conteudo']);
    unset($post['Continuar']);

    if($total !== count($post)){
        $txt = 'ERRO:  '. ($total - count($post)).' aluno(s) sem presença';
        msg($txt);
        die('<script>history.go(-1);</script>');
        
    }
    
    
    
    
}