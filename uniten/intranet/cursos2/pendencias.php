<?php
require_once '../dao/pendenciaDao.php';
Security::cursoSecurity();


logDao::gravaLog($user->login, 'pendencias', 'Acessou: lista de pendencias','','','');

$pendenciaDao = new PendenciaDao();
$diarios = $pendenciaDao->agendasSemDiariosPorEmpresa($user->empresa->id);

?>





                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Pendências :: Diários sem registro de presenças</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="126">Código</th>
                                                <th width="126">Curso</th>
                                                <th width="126">Professor</th>
                                                <th width="126">Data</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                         <?php
                                        if($diarios!=null){


                                        foreach($diarios as $diario) { ?>
                                            <tr>
                                                <td width="6%" class="normal"><?php echo $diario['cod']?></td>
                                                <td width="27%" class="normal"><?php echo $diario['curso']?></td>
                                                <td width="56%" class="normal"><?php echo $diario['monitor']?></td>
                                                <td width="11%" class="normal"><?php echo $diario['data_do_diario']?></td>
                                              </tr>
                                           <?php } ?>  
                                       <?php }else{  ?>  
                                            <tr>
                                              <td colspan="4"><p class="text-red">Nenhuma registrada</p></td>
                                            </tr>
                                            <?php } ?>
                                         
                                        </tbody>
                                      
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                            
                         
                        </div>
                    </div>

        
