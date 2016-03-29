<?php

require_once 'util/config.php';
Security::admSecurity();
require_once 'dao/agendaCursoDao.php';
$agendaDao = new AgendaCursoDao();

if (!empty($_REQUEST ['acao'])) {
    switch ($_REQUEST ['acao']) {
        case 'gravar' :


            $obj = new Aluno();
          
            if ($obj->get('cpf',@$_POST ['cpf']) == 0) {
                unset($_POST ['id']);
                      }
            $obj->_setFrom($_POST);
            $obj->save();
            
            $user = unserialize($_SESSION['USER']);
            logDao::gravaLog($user->id, 'Alteração da ficha do aluno', 'gravar',$_REQUEST);
            msg('Aluno alterado com sucesso!');
            gotox('principal.php?acao=alunoFicha&cod=' . $obj->id);

            break;

       
    }
}
?>
