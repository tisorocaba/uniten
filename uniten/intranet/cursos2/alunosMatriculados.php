<?php
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
require_once '../dao/agendaDisciplinaProfessorDao.php';
Security::cursoSecurity();
$agendaDao = new AgendaCursoDao();
$codAgenda = $agendaDao->escape((int) $_REQUEST['agenda']);
$alunos = $agendaDao->listaAlunoAgenda($codAgenda);
$agenda = new AgendaCurso();
$agenda->get($codAgenda);

$user = unserialize($_SESSION['USER']);

if ((int) $user->tipoLogin === 2) {

    $professorAgendaDao = new AgendaDisciplinaProfessorDao();

    if ($professorAgendaDao->getDisciplinaPorAgendaProfessor($codAgenda, $user->professor) === false) {
        $_REQUEST['ERRO'] = 'ACESSO NEGADO';
        logDao::gravaLog($user->login, 'alunosMatriculados', 'ERRO(1058) :: Agenda de outro professor', $_REQUEST,'','Agenda: '.$_REQUEST['agenda']);
        die('ERRO(1058) :: ACESSO NEGADO');
    }
}else{
  
    if((int)$user->empresa->id !== (int)$agenda->empresaCurso){
        $_REQUEST['ERRO'] = 'ACESSO NEGADO - COODENADOR';
        logDao::gravaLog($user->login, 'alunosMatriculados', 'ERRO(1058) :: Agenda de outra empresa', $_REQUEST,'','Agenda: '.$_REQUEST['agenda']);
        die('ERRO(1058) :: ACESSO NEGADO'); 
    }
}

logDao::gravaLog($user->login, 'alunosMatriculados', 'Acessou: lista de alunos ', $_REQUEST,'','Agenda: '.$_REQUEST['agenda']);
?>




<script src="scripts/relatoriosClassesProfessor.js"></script>
<section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Cursos :: Alunos</h3>
                                  
                               
                              </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <tr>
                                          <th colspan="6">
                                          <?php if (count($alunos) > 0) { ?>
                                          <button class="btn btn-info btn-sm" onclick="window.location.href='xls_relatorio-classe.php?agenda=<?php echo $_REQUEST['agenda'] ?>'">Emitir relatório de frequência</button>
                           
                        <?php } ?>
                                          
                                          </th>
                                        </tr>
                                        <tr>
                                          <th colspan="6">Curso: <?php echo $agenda->curso->nome?></th>
                                        </tr>
                                        <tr>
                                                <th width="47">Nome</th>
                                                <th width="20">Telefone</th>
                                                <th width="30">Endereço</th>
                                                <th width="30">Bairro</th>
                                                <th width="30">Cidade</th>
                                            </tr>
                                        <tbody>
                                        <?php  foreach($alunos as $aluno) { ?>
                                            <tr>
                                                <td><?php echo $aluno->aluno ?></td>
                                                <td><?php echo $aluno->telefone ?></td>
                                                <td><?php echo $aluno->endereco ?> <?php echo $aluno->numero ?></td>
                                                <td><?php echo $aluno->bairro ?></td>
                                                <td><?php echo $aluno->cidade ?></td>
                                            </tr>
                                         <?php } ?>   
                                        </tbody>
                                        <!-- <tfoot>
                                            <tr>
                                                <th>Rendering engine</th>
                                                <th>Browser</th>
                                                <th>Platform(s)</th>
                                                <th>Engine version</th>
                                                <th>CSS grade</th>
                                            </tr>
                                        </tfoot> 
                                        -->
                                    </table>
                                    <br />
                                    <p align="center">
                                     <input name="btVoltar" type="button" value="voltar" class="btn  btn-primary"  onclick="self.location='principal.php'" />
                                    <button class="btn btn-default" onclick="print();">imprimir</button>
                                    </p>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                         
                        </div>
                    </div>

              </section>
