<?php
require_once '../util/config.php';
require_once '../dao/agendaCursoDao.php';
Security::cursoSecurity();

$agendaDao = new AgendaCursoDao();
if(!empty($_REQUEST['agenda'])){
	$_SESSION['CODAGENDA'] = $_REQUEST['agenda'];
}

$alunos = $agendaDao->listaAlunoAgenda($_SESSION['CODAGENDA']);

$agenda = new AgendaCurso();
$agenda->get($_SESSION['CODAGENDA']);

$user = unserialize($_SESSION['USER']);
logDao::gravaLog($user->login, 'alunosAvaliacaoFinal', 'Acessou: avaliacao final',$_REQUEST,'', 'Agenda: '.$_SESSION['CODAGENDA']);


?>



<script src="scripts/relatoriosClassesProfessor.js"></script>
<section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Cursos :: Avaliação Final</h3>
                                  
                               
                              </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <tr>
                                          <th colspan="5">Curso: <?php echo $agenda->curso->nome?></th>
                                        </tr>
                                        <tr>
                                                <th width="205">Nome</th>
                                                <th width="90">Presença</th>
                                                <th width="70">Nota final</th>
                                                <th width="46">Status</th>
                                                <th width="183">Ação</th>
                                            </tr>
                                        <tbody>
                                        <?php  foreach($alunos as $aluno) { ?>
                                            <tr>
                                                <td><?php echo $aluno->aluno?></td>
                                                <td><?php echo number_format($aluno->percentual,0)?>%</td>
                                                <td><?php echo $aluno->nota?></td>
                                                <td><?php echo statusAluno($aluno->status)?></td>
                                                <td>
                                                 
                                                
												   <?php if($aluno->status != 4){ ?>   
												   <input name="btVoltar" type="button" value="Incluir / Alterar" class="btn  btn-primary"  onclick="self.location='principal.php?acao=alunoCadastroAvaliacao&cod=<?php echo $aluno->id?>'" />
												   <?php } ?>
                                                 
                                                </td>
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
                                    <p>&nbsp;</p>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                             <div class="box-footer">
                    
                     
                        <input name="btVoltar" type="button" value="voltar" class="btn  btn-primary"  onclick="self.location='principal.php'" />
               			 </div>
                            
                         
                        </div>
                    </div>

              </section>
