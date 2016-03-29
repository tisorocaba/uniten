<?php
require_once 'util/config.php';
require_once 'dao/agendaCursoDao.php';
Security::admSecurity();

$obj = new Aluno();

$cpf = limpaCPF($_POST ['cpf']);

 if ( $obj->get('cpf',$cpf) == 1) {
     $cursoDao = new AgendaCursoDao();
     if($cursoDao->getAgendaAluno($_SESSION['CODAGENDA'], $obj->id)!==false){
         msg('Este aluno já está cadastrado nesse curso!');
         gotox("candidatoCadastro.php");
         
     }
     
 }
 gotox("candidatoFormulario.php?id=".$obj->id."&cpf=".$cpf."&acao=insert");
 
 
